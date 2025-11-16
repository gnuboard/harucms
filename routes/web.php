<?php

use App\Controllers\MainController;
use App\Controllers\UserController;
use App\Controllers\BoardController;
use App\Controllers\ContentController;
use App\Controllers\InstallController;
use App\Controllers\Admin\AdminController;

// 설치 라우트 (설치되지 않은 경우에만)
$router->get('/install', [InstallController::class, 'index']);
$router->post('/install', [InstallController::class, 'install']);

// 메인 페이지
$router->get('/', [MainController::class, 'index']);

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
$router->get('/signup', [UserController::class, 'showSignupForm']);
$router->post('/signup', [UserController::class, 'signup']);
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
