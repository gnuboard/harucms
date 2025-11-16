<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Post;

class HomeController
{
    private User $userModel;
    private Post $postModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->postModel = new Post();
    }

    /**
     * 메인 페이지
     */
    public function index(): string
    {
        // 최근 가입 회원 10명
        $recentUsers = $this->userModel->getRecent(10);

        // 최근 게시글 10개
        $recentPosts = $this->postModel->getRecent(10);

        ob_start();
        require BASE_PATH . '/app/Views/home.php';
        return ob_get_clean();
    }
}
