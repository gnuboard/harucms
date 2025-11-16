<?php

namespace App\Controllers\Api;

use App\Models\User;

class AuthController extends ApiController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * 로그인
     * POST /api/auth/login
     * Body: { "email": "user@example.com", "password": "password" }
     */
    public function login()
    {
        $data = $this->getJsonInput();

        // 입력 검증
        if (empty($data['email']) || empty($data['password'])) {
            return $this->error('이메일과 비밀번호를 입력해주세요.', 400);
        }

        // 로그인 시도
        $user = $this->userModel->login($data['email'], $data['password']);

        if (!$user) {
            return $this->error('이메일 또는 비밀번호가 올바르지 않습니다.', 401);
        }

        // 세션에 사용자 정보 저장
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];

        return $this->success([
            'user' => $user,
            'session_id' => session_id()
        ], '로그인되었습니다.');
    }

    /**
     * 회원가입
     * POST /api/auth/signup
     * Body: { "email": "user@example.com", "password": "password", "nickname": "홍길동" }
     */
    public function signup()
    {
        $data = $this->getJsonInput();

        // 입력 검증
        if (empty($data['email']) || empty($data['password']) || empty($data['nickname'])) {
            return $this->error('이메일, 비밀번호, 닉네임을 입력해주세요.', 400);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->error('올바른 이메일 형식이 아닙니다.', 400);
        }

        if (strlen($data['password']) < 6) {
            return $this->error('비밀번호는 최소 6자 이상이어야 합니다.', 400);
        }

        if (strlen($data['nickname']) < 2 || strlen($data['nickname']) > 20) {
            return $this->error('닉네임은 2자 이상 20자 이하여야 합니다.', 400);
        }

        // 이메일 중복 체크
        if ($this->userModel->findByEmail($data['email'])) {
            return $this->error('이미 사용 중인 이메일입니다.', 400);
        }

        // 닉네임 중복 체크
        if ($this->userModel->findByNickname($data['nickname'])) {
            return $this->error('이미 사용 중인 닉네임입니다.', 400);
        }

        // 사용자 생성
        $result = $this->userModel->create([
            'email' => $data['email'],
            'password' => $data['password'],
            'nickname' => $data['nickname'],
            'name' => $data['name'] ?? null,
            'is_admin' => 0,
            'status' => 1
        ]);

        if (!$result) {
            return $this->error('회원가입에 실패했습니다.', 500);
        }

        // 생성된 사용자 정보 조회
        $user = $this->userModel->findByEmail($data['email']);

        // 자동 로그인
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];

        return $this->success([
            'user' => $user,
            'session_id' => session_id()
        ], '회원가입이 완료되었습니다.', 201);
    }

    /**
     * 로그아웃
     * POST /api/auth/logout
     */
    public function logout()
    {
        // 세션 제거
        session_destroy();

        return $this->success(null, '로그아웃되었습니다.');
    }

    /**
     * 현재 로그인한 사용자 정보
     * GET /api/auth/me
     */
    public function me()
    {
        if (!isset($_SESSION['user_id'])) {
            return $this->error('로그인이 필요합니다.', 401);
        }

        $user = $this->userModel->findById($_SESSION['user_id']);

        if (!$user) {
            return $this->error('사용자를 찾을 수 없습니다.', 404);
        }

        return $this->success([
            'user' => $user
        ]);
    }

    /**
     * 프로필 업데이트
     * PUT /api/auth/profile
     * Body: { "name": "새이름", "password": "newpassword" }
     */
    public function updateProfile()
    {
        $this->requireAuth();

        $data = $this->getJsonInput();
        $userId = $_SESSION['user_id'];

        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['password']) && !empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                return $this->error('비밀번호는 최소 6자 이상이어야 합니다.', 400);
            }
            $updateData['password'] = $data['password'];
        }

        if (empty($updateData)) {
            return $this->error('변경할 정보가 없습니다.', 400);
        }

        $result = $this->userModel->update($userId, $updateData);

        if (!$result) {
            return $this->error('프로필 업데이트에 실패했습니다.', 500);
        }

        // 이름이 변경된 경우 세션 업데이트
        if (isset($updateData['name'])) {
            $_SESSION['user_name'] = $updateData['name'];
        }

        $user = $this->userModel->findById($userId);

        return $this->success([
            'user' => $user
        ], '프로필이 업데이트되었습니다.');
    }
}
