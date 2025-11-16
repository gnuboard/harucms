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

// 라우터 및 핵심 클래스 로드
use App\Core\Router;
use App\Core\Plugin;
use App\Core\SessionHandler;

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

// Web 라우트 로드
require BASE_PATH . '/routes/web.php';

// API 라우트 로드
require BASE_PATH . '/routes/api.php';

// 라우터 실행
$router->dispatch();
