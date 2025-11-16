<?php

namespace App\Controllers\Api;

class ApiController
{
    public function __construct()
    {
        $this->setCorsHeaders();
    }

    /**
     * CORS 헤더 설정
     */
    protected function setCorsHeaders()
    {
        // 개발 환경에서는 모든 오리진 허용, 프로덕션에서는 특정 도메인만 허용
        $allowedOrigins = ['http://localhost:3000', 'http://localhost:5173', 'https://your-react-app.com'];
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        if (in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: $origin");
        }

        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Allow-Credentials: true');

        // OPTIONS 요청 처리 (preflight)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }
    }

    /**
     * JSON 응답 반환
     */
    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 성공 응답
     */
    protected function success($data = null, $message = 'Success', $statusCode = 200)
    {
        return $this->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * 에러 응답
     */
    protected function error($message = 'Error', $statusCode = 400, $errors = null)
    {
        return $this->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * 요청 본문(JSON) 파싱
     */
    protected function getJsonInput()
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true);
    }

    /**
     * 인증 확인
     */
    protected function requireAuth()
    {
        if (!isset($_SESSION['user_id'])) {
            $this->error('Unauthorized', 401);
        }
    }

    /**
     * 관리자 권한 확인
     */
    protected function requireAdmin()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $this->error('Forbidden', 403);
        }
    }
}
