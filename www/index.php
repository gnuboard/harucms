<?php

// 세션 시작
session_start();

// 오류 보고 설정 (개발 환경)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 기본 경로 설정
define('BASE_PATH', dirname(__DIR__));

// Autoloader 설정
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// 라우터 및 컨트롤러 로드
use App\Core\Router;
use App\Core\Plugin;
use App\Controllers\UserController;
use App\Controllers\BoardController;
use App\Controllers\ContentController;
use App\Controllers\Admin\AdminController;

// 플러그인 로드
// Plugin::load();

$router = new Router();

// 메인 페이지
$router->get('/', function() {
    header('Location: /boards/free');
    exit;
});

// 사용자 라우트
$router->get('/login', [UserController::class, 'showLoginForm']);
$router->post('/login', [UserController::class, 'login']);
$router->get('/logout', [UserController::class, 'logout']);
$router->get('/register', [UserController::class, 'showRegisterForm']);
$router->post('/register', [UserController::class, 'register']);
$router->get('/mypage', [UserController::class, 'myPage']);
$router->post('/mypage', [UserController::class, 'updateProfile']);

// 게시판 라우트
$router->get('/boards/:board_name', [BoardController::class, 'index']);
$router->get('/boards/:board_name/write', [BoardController::class, 'write']);
$router->post('/boards/:board_name/write', [BoardController::class, 'store']);
$router->get('/boards/:board_name/:post_id', [BoardController::class, 'view']);
$router->get('/boards/:board_name/:post_id/edit', [BoardController::class, 'edit']);
$router->post('/boards/:board_name/:post_id/edit', [BoardController::class, 'update']);
$router->get('/boards/:board_name/:post_id/delete', [BoardController::class, 'delete']);
$router->post('/boards/:board_name/:post_id/comments', [BoardController::class, 'addComment']);
$router->post('/comments/:comment_id/delete', [BoardController::class, 'deleteComment']);

// 컨텐츠 페이지 라우트
$router->get('/page/:slug', [ContentController::class, 'show']);

// 관리자 라우트
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->get('/admin/login', [AdminController::class, 'showLoginForm']);
$router->post('/admin/login', [AdminController::class, 'login']);
$router->get('/admin/logout', [AdminController::class, 'logout']);

// 관리자 - 사용자 관리
$router->get('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/users/:id/edit', [AdminController::class, 'editUser']);
$router->post('/admin/users/:id/edit', [AdminController::class, 'updateUser']);

// 관리자 - 게시판 관리
$router->get('/admin/boards', [AdminController::class, 'boards']);
$router->get('/admin/boards/create', [AdminController::class, 'createBoard']);
$router->post('/admin/boards/create', [AdminController::class, 'storeBoard']);
$router->get('/admin/boards/:id/edit', [AdminController::class, 'editBoard']);
$router->post('/admin/boards/:id/edit', [AdminController::class, 'updateBoard']);

// 관리자 - 컨텐츠 관리
$router->get('/admin/contents', [AdminController::class, 'contents']);
$router->get('/admin/contents/create', [AdminController::class, 'createContent']);
$router->post('/admin/contents/create', [AdminController::class, 'storeContent']);
$router->get('/admin/contents/:id/edit', [AdminController::class, 'editContent']);
$router->post('/admin/contents/:id/edit', [AdminController::class, 'updateContent']);
$router->post('/admin/contents/:id/delete', [AdminController::class, 'deleteContent']);

// 라우터 실행
$router->dispatch();
