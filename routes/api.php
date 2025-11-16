<?php

use App\Controllers\Api\AuthController;

// API 인증 라우트
$router->post('/api/auth/login', [AuthController::class, 'login']);
$router->post('/api/auth/signup', [AuthController::class, 'signup']);
$router->post('/api/auth/logout', [AuthController::class, 'logout']);
$router->get('/api/auth/me', [AuthController::class, 'me']);
$router->post('/api/auth/profile', [AuthController::class, 'updateProfile']);

// 향후 추가될 API 라우트
// $router->get('/api/boards', [Api\BoardController::class, 'index']);
// $router->get('/api/boards/:id', [Api\BoardController::class, 'show']);
// $router->post('/api/boards', [Api\BoardController::class, 'store']);
// $router->put('/api/boards/:id', [Api\BoardController::class, 'update']);
// $router->delete('/api/boards/:id', [Api\BoardController::class, 'destroy']);
