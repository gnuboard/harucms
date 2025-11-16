<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Helper;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * 로그인 폼 표시
     */
    public function showLoginForm(): string
    {
        if (Helper::isLoggedIn()) {
            Helper::redirect('/');
        }

        ob_start();
        require BASE_PATH . '/app/Views/user/login.php';
        return ob_get_clean();
    }

    /**
     * 로그인 처리
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            Helper::flash('error', '이메일과 비밀번호를 입력해주세요.');
            Helper::redirect('/login');
        }

        $user = $this->userModel->login($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['nickname'] = $user['nickname'];
            $_SESSION['is_admin'] = $user['is_admin'];

            Helper::flash('success', '로그인되었습니다.');
            Helper::redirect('/');
        } else {
            Helper::flash('error', '이메일 또는 비밀번호가 올바르지 않습니다.');
            Helper::redirect('/login');
        }
    }

    /**
     * 로그아웃
     */
    public function logout(): void
    {
        session_destroy();
        Helper::redirect('/');
    }

    /**
     * 회원가입 폼
     */
    public function showSignupForm(): string
    {
        if (Helper::isLoggedIn()) {
            Helper::redirect('/');
        }

        ob_start();
        require BASE_PATH . '/app/Views/user/signup.php';
        return ob_get_clean();
    }

    /**
     * 회원가입 처리
     */
    public function signup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('/signup');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $nickname = trim($_POST['nickname'] ?? '');

        // 유효성 검사
        if (empty($email) || empty($password)) {
            Helper::flash('error', '이메일과 비밀번호를 입력해주세요.');
            Helper::redirect('/signup');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Helper::flash('error', '올바른 이메일 주소를 입력해주세요.');
            Helper::redirect('/signup');
        }

        if ($password !== $passwordConfirm) {
            Helper::flash('error', '비밀번호가 일치하지 않습니다.');
            Helper::redirect('/signup');
        }

        if (strlen($password) < 6) {
            Helper::flash('error', '비밀번호는 최소 6자 이상이어야 합니다.');
            Helper::redirect('/signup');
        }

        // 닉네임 입력 시 유효성 검사
        if (!empty($nickname)) {
            if (strlen($nickname) < 2 || strlen($nickname) > 20) {
                Helper::flash('error', '닉네임은 2자 이상 20자 이하여야 합니다.');
                Helper::redirect('/signup');
            }

            // 닉네임 중복 체크
            if ($this->userModel->findByNickname($nickname)) {
                Helper::flash('error', '이미 사용중인 닉네임입니다.');
                Helper::redirect('/signup');
            }
        }

        // 사용자 생성
        $result = $this->userModel->create([
            'email' => $email,
            'password' => $password,
            'nickname' => $nickname, // 비어있으면 자동 생성됨
        ]);

        if ($result) {
            Helper::flash('success', '회원가입이 완료되었습니다. 로그인해주세요.');
            Helper::redirect('/login');
        } else {
            Helper::flash('error', '이미 사용중인 이메일입니다.');
            Helper::redirect('/signup');
        }
    }

    /**
     * 마이페이지
     */
    public function myPage(): string
    {
        if (!Helper::isLoggedIn()) {
            Helper::redirect('/login');
        }

        $user = $this->userModel->findById(Helper::userId());

        ob_start();
        require BASE_PATH . '/app/Views/user/mypage.php';
        return ob_get_clean();
    }

    /**
     * 프로필 수정
     */
    public function updateProfile(): void
    {
        if (!Helper::isLoggedIn()) {
            Helper::redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('/mypage');
        }

        $userId = Helper::userId();
        $data = [];

        // 이메일 변경 시도 방지 (읽기 전용)
        // if (!empty($_POST['email'])) {
        //     $data['email'] = trim($_POST['email']);
        // }

        // 닉네임 변경
        if (!empty($_POST['nickname'])) {
            $newNickname = trim($_POST['nickname']);
            $currentUser = $this->userModel->findById($userId);

            // 현재 닉네임과 다를 때만 중복 체크
            if ($newNickname !== $currentUser['nickname']) {
                // 닉네임 중복 체크
                $existingUser = $this->userModel->findByNickname($newNickname);
                if ($existingUser) {
                    Helper::flash('error', '이미 사용중인 닉네임입니다.');
                    Helper::redirect('/mypage');
                }

                // 닉네임 길이 체크
                if (strlen($newNickname) < 2 || strlen($newNickname) > 20) {
                    Helper::flash('error', '닉네임은 2자 이상 20자 이하여야 합니다.');
                    Helper::redirect('/mypage');
                }

                $data['nickname'] = $newNickname;
            }
        }

        // 비밀번호 변경
        if (!empty($_POST['password'])) {
            if ($_POST['password'] === $_POST['password_confirm']) {
                if (strlen($_POST['password']) < 6) {
                    Helper::flash('error', '비밀번호는 최소 6자 이상이어야 합니다.');
                    Helper::redirect('/mypage');
                }
                $data['password'] = $_POST['password'];
            } else {
                Helper::flash('error', '비밀번호가 일치하지 않습니다.');
                Helper::redirect('/mypage');
            }
        }

        // 변경할 내용이 없는 경우
        if (empty($data)) {
            Helper::flash('error', '변경할 내용이 없습니다.');
            Helper::redirect('/mypage');
        }

        // 업데이트 실행
        if ($this->userModel->update($userId, $data)) {
            // 세션 정보 업데이트
            if (isset($data['nickname'])) {
                $_SESSION['nickname'] = $data['nickname'];
            }

            Helper::flash('success', '프로필이 수정되었습니다.');
        } else {
            Helper::flash('error', '프로필 수정 중 오류가 발생했습니다. 잠시 후 다시 시도해주세요.');
        }

        Helper::redirect('/mypage');
    }
}
