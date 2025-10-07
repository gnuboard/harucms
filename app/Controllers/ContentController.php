<?php

namespace App\Controllers;

use App\Models\Content;
use App\Core\Helper;

class ContentController
{
    private Content $contentModel;

    public function __construct()
    {
        $this->contentModel = new Content();
    }

    /**
     * 컨텐츠 페이지 보기
     */
    public function show(array $params): string
    {
        $slug = $params['slug'] ?? '';
        $content = $this->contentModel->findBySlug($slug);

        if (!$content) {
            http_response_code(404);
            return '페이지를 찾을 수 없습니다.';
        }

        ob_start();
        require BASE_PATH . '/app/Views/content/show.php';
        return ob_get_clean();
    }
}
