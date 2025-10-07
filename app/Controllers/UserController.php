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
            $_SESSION['name'] = $user['name'];
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
    public function showRegisterForm(): string
    {
        if (Helper::isLoggedIn()) {
            Helper::redirect('/');
        }

        ob_start();
        require BASE_PATH . '/app/Views/user/register.php';
        return ob_get_clean();
    }

    /**
     * 회원가입 처리
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('/register');
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $name = trim($_POST['name'] ?? '');

        // 유효성 검사
        if (empty($email) || empty($password)) {
            Helper::flash('error', '필수 항목을 모두 입력해주세요.');
            Helper::redirect('/register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Helper::flash('error', '올바른 이메일 주소를 입력해주세요.');
            Helper::redirect('/register');
        }

        if ($password !== $passwordConfirm) {
            Helper::flash('error', '비밀번호가 일치하지 않습니다.');
            Helper::redirect('/register');
        }

        if (strlen($password) < 6) {
            Helper::flash('error', '비밀번호는 최소 6자 이상이어야 합니다.');
            Helper::redirect('/register');
        }

        // 사용자 생성
        $result = $this->userModel->create([
            'email' => $email,
            'password' => $password,
            'name' => $name,
        ]);

        if ($result) {
            Helper::flash('success', '회원가입이 완료되었습니다. 로그인해주세요.');
            Helper::redirect('/login');
        } else {
            Helper::flash('error', '이미 사용중인 이메일입니다.');
            Helper::redirect('/register');
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

        if (!empty($_POST['email'])) {
            $data['email'] = trim($_POST['email']);
        }

        if (!empty($_POST['name'])) {
            $data['name'] = trim($_POST['name']);
        }

        if (!empty($_POST['password'])) {
            if ($_POST['password'] === $_POST['password_confirm']) {
                $data['password'] = $_POST['password'];
            } else {
                Helper::flash('error', '비밀번호가 일치하지 않습니다.');
                Helper::redirect('/mypage');
            }
        }

        if ($this->userModel->update($userId, $data)) {
            // 세션 정보 업데이트
            if (isset($data['name'])) {
                $_SESSION['name'] = $data['name'];
            }

            Helper::flash('success', '프로필이 수정되었습니다.');
        } else {
            Helper::flash('error', '프로필 수정에 실패했습니다.');
        }

        Helper::redirect('/mypage');
    }
}
