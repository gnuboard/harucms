<?php

namespace App\Core;

class Helper
{
    /**
     * XSS 방지를 위한 HTML 이스케이프
     */
    public static function e(?string $text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }

    /**
     * 현재 URL 반환
     */
    public static function currentUrl(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * 리다이렉트
     */
    public static function redirect(string $url, int $code = 302): void
    {
        header("Location: $url", true, $code);
        exit;
    }

    /**
     * JSON 응답
     */
    public static function json($data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 세션 플래시 메시지 설정
     */
    public static function flash(string $key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * 세션 플래시 메시지 가져오기
     */
    public static function getFlash(string $key, $default = null)
    {
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    /**
     * 세션에 플래시 메시지가 있는지 확인
     */
    public static function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash'][$key]);
    }

    /**
     * 날짜 포맷팅
     */
    public static function formatDate(?string $date, string $format = 'Y-m-d H:i:s'): string
    {
        if (!$date) return '';
        return date($format, strtotime($date));
    }

    /**
     * 상대적 시간 표시 (예: 1시간 전)
     */
    public static function timeAgo(?string $datetime): string
    {
        if (!$datetime) return '';

        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) {
            return '방금 전';
        } elseif ($diff < 3600) {
            return floor($diff / 60) . '분 전';
        } elseif ($diff < 86400) {
            return floor($diff / 3600) . '시간 전';
        } elseif ($diff < 604800) {
            return floor($diff / 86400) . '일 전';
        } else {
            return date('Y-m-d', $time);
        }
    }

    /**
     * 파일 크기 포맷팅
     */
    public static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * 문자열 자르기 (UTF-8 안전)
     */
    public static function truncate(string $text, int $length = 100, string $suffix = '...'): string
    {
        if (mb_strlen($text, 'UTF-8') <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length, 'UTF-8') . $suffix;
    }

    /**
     * 슬러그 생성 (한글 -> 영문)
     */
    public static function slug(string $text): string
    {
        // 간단한 슬러그 생성 (영문/숫자/하이픈만 허용)
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9가-힣\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }

    /**
     * CSRF 토큰 생성
     */
    public static function generateCsrfToken(): string
    {
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    /**
     * CSRF 토큰 검증
     */
    public static function verifyCsrfToken(?string $token): bool
    {
        return isset($_SESSION['_csrf_token']) && hash_equals($_SESSION['_csrf_token'], $token ?? '');
    }

    /**
     * CSRF 토큰 필드 HTML 생성
     */
    public static function csrfField(): string
    {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="_csrf_token" value="' . $token . '">';
    }

    /**
     * 페이징 정보 생성
     */
    public static function paginate(int $total, int $perPage = 20, int $currentPage = 1): array
    {
        $totalPages = ceil($total / $perPage);
        $currentPage = max(1, min($currentPage, $totalPages));
        $offset = ($currentPage - 1) * $perPage;

        return [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'total_pages' => $totalPages,
            'offset' => $offset,
            'has_prev' => $currentPage > 1,
            'has_next' => $currentPage < $totalPages,
            'prev_page' => $currentPage - 1,
            'next_page' => $currentPage + 1,
        ];
    }

    /**
     * 로그인 여부 확인
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * 관리자 여부 확인
     */
    public static function isAdmin(): bool
    {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
    }

    /**
     * 현재 사용자 ID 반환
     */
    public static function userId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * 환경설정 값 가져오기 (캐싱 지원)
     */
    public static function config(string $key, $default = null)
    {
        static $configs = null;

        if ($configs === null) {
            $db = Database::getInstance();
            $rows = $db->fetchAll("SELECT config_key, config_value FROM configs");
            $configs = [];
            foreach ($rows as $row) {
                $configs[$row['config_key']] = $row['config_value'];
            }
        }

        return $configs[$key] ?? $default;
    }

    /**
     * 업로드된 파일 검증
     */
    public static function validateUpload(array $file, int $maxSize = 20971520, array $allowedTypes = []): ?string
    {
        if (!isset($file['error']) || is_array($file['error'])) {
            return '잘못된 파일 업로드입니다.';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return '파일 업로드 중 오류가 발생했습니다.';
        }

        if ($file['size'] > $maxSize) {
            return '파일 크기가 너무 큽니다. (최대 ' . self::formatBytes($maxSize) . ')';
        }

        if (!empty($allowedTypes)) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($file['tmp_name']);

            if (!in_array($mimeType, $allowedTypes)) {
                return '허용되지 않는 파일 형식입니다.';
            }
        }

        return null; // 검증 통과
    }

    /**
     * 뷰 렌더링
     */
    public static function view(string $view, array $data = []): void
    {
        // 데이터 배열을 변수로 추출
        extract($data);

        // 뷰 파일 경로
        $viewPath = BASE_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            die("View not found: {$view}");
        }

        // 뷰 렌더링
        require $viewPath;
    }
}
