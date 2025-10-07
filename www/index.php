<?php

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
use App\Core\SessionHandler;
use App\Controllers\UserController;
use App\Controllers\BoardController;
use App\Controllers\ContentController;
use App\Controllers\InstallController;
use App\Controllers\Admin\AdminController;

// 설치 여부 확인
$configPath = BASE_PATH . '/data/config/database.php';
$isInstalled = file_exists($configPath);

// 설치되지 않은 경우 /install로 리다이렉트 (단, /install 경로가 아닌 경우에만)
if (!$isInstalled && $_SERVER['REQUEST_URI'] !== '/install' && !preg_match('#^/install#', $_SERVER['REQUEST_URI'])) {
    header('Location: /install');
    exit;
}

// 설치된 경우에만 세션 핸들러 시작
if ($isInstalled) {
    // DB 기반 세션 핸들러 설정
    $sessionHandler = new SessionHandler();
    session_set_save_handler($sessionHandler, true);

    // 세션 핸들러 에러 억제 (간헐적 DB 연결 문제 방지)
    ini_set('session.use_strict_mode', '0');

    // 세션 핸들러 경고 완전 억제
    error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
}

// 세션 시작
@session_start();

// 에러 보고 복원 (설치된 경우)
if ($isInstalled) {
    error_reporting(E_ALL);

    // 스크립트 종료 시 세션 종료 경고 억제
    register_shutdown_function(function() {
        error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
        @session_write_close();
    });
}

// 플러그인 로드
// Plugin::load();

$router = new Router();

// 설치 라우트 (설치되지 않은 경우에만)
$router->get('/install', [InstallController::class, 'index']);
$router->post('/install', [InstallController::class, 'install']);

// 메인 페이지
$router->get('/', function() {
    header('Location: /boards/free');
    exit;
});

// 관리자 라우트 (가장 먼저 등록 - /:slug 보다 우선)
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

// 관리자 - 세션 관리
$router->get('/admin/sessions', [AdminController::class, 'sessions']);
$router->post('/admin/sessions/delete', [AdminController::class, 'deleteSession']);

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

// 컨텐츠 페이지 라우트 (가장 마지막 - 모든 경로를 잡아버리므로)
$router->get('/page/:slug', [ContentController::class, 'show']);
$router->get('/:slug', [ContentController::class, 'show']);

// 라우터 실행
$router->dispatch();
