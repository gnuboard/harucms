<?php
$title = htmlspecialchars($content['title']) . ' - HaruCMS';
ob_start();
?>

<?php use App\Core\Helper; ?>

<!-- 데코레이티브 배경 -->
<div class="fixed inset-0 -z-10">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-emerald-400/20 dark:bg-emerald-500/10 rounded-full blur-3xl"></div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">
    <!-- 컨텐츠 카드 -->
    <article class="bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden">
        <!-- 헤더 -->
        <div class="px-6 py-8 sm:px-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                <?= htmlspecialchars($content['title']) ?>
            </h1>
        </div>

        <!-- 본문 -->
        <div class="px-6 pb-8 sm:px-10">
            <div class="content-body">
                <?php
                // HTML 컨텐츠 그대로 출력 (CKEditor로 작성된 안전한 HTML)
                echo $content['content'];
                ?>
            </div>
        </div>

        <style>
            /* 컨텐츠 본문 스타일 */
            .content-body {
                color: #374151;
                font-size: 1.125rem;
                line-height: 1.75;
            }

            .dark .content-body {
                color: #cbd5e1;
            }

            /* 제목 스타일 */
            .content-body h2 {
                font-size: 1.5rem;
                font-weight: 700;
                margin-top: 2rem;
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid #e5e7eb;
                color: #111827;
            }

            .dark .content-body h2 {
                border-bottom-color: #334155;
                color: #fff;
            }

            .content-body h3 {
                font-size: 1.25rem;
                font-weight: 700;
                margin-top: 1.5rem;
                margin-bottom: 0.75rem;
                color: #111827;
            }

            .dark .content-body h3 {
                color: #fff;
            }

            /* 문단 */
            .content-body p {
                margin-bottom: 1rem;
                color: #374151;
            }

            .dark .content-body p {
                color: #cbd5e1;
            }

            /* 링크 */
            .content-body a {
                color: #2563eb;
                text-decoration: none;
            }

            .content-body a:hover {
                text-decoration: underline;
            }

            .dark .content-body a {
                color: #60a5fa;
            }

            /* 강조 */
            .content-body strong {
                font-weight: 600;
                color: #111827;
            }

            .dark .content-body strong {
                color: #fff;
            }

            /* 코드 */
            .content-body code {
                background: #f3f4f6;
                color: #059669;
                padding: 0.125rem 0.375rem;
                border-radius: 0.25rem;
                font-family: monospace;
                font-size: 0.875rem;
            }

            .dark .content-body code {
                background: #0f172a;
                color: #34d399;
            }

            .content-body pre {
                background: #111827;
                color: #f3f4f6;
                padding: 1rem;
                border-radius: 0.5rem;
                overflow-x: auto;
                margin: 1rem 0;
            }

            .dark .content-body pre {
                background: #020617;
            }

            .content-body pre code {
                background: none;
                color: inherit;
                padding: 0;
            }

            /* 인용구 */
            .content-body blockquote {
                border-left: 4px solid #2563eb;
                background: rgba(37, 99, 235, 0.05);
                padding: 0.5rem 1rem;
                margin: 1rem 0;
                border-radius: 0 0.25rem 0.25rem 0;
            }

            .dark .content-body blockquote {
                border-left-color: #60a5fa;
                background: rgba(96, 165, 250, 0.1);
            }

            /* 리스트 */
            .content-body ul {
                list-style-type: disc;
                padding-left: 2rem;
                margin-bottom: 1rem;
            }

            .content-body ol {
                list-style-type: decimal;
                padding-left: 2rem;
                margin-bottom: 1rem;
            }

            .content-body li {
                color: #374151;
                margin-bottom: 0.5rem;
            }

            .dark .content-body li {
                color: #cbd5e1;
            }

            /* 이미지 */
            .content-body img {
                max-width: 100%;
                height: auto;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin: 1rem 0;
            }

            /* 구분선 */
            .content-body hr {
                border: none;
                border-top: 1px solid #e5e7eb;
                margin: 2rem 0;
            }

            .dark .content-body hr {
                border-top-color: #334155;
            }

            /* 테이블 */
            .content-body table {
                width: 100%;
                border-collapse: collapse;
                margin: 1rem 0;
            }

            .content-body th,
            .content-body td {
                border: 1px solid #e5e7eb;
                padding: 0.5rem 1rem;
                text-align: left;
            }

            .dark .content-body th,
            .dark .content-body td {
                border-color: #334155;
            }

            .content-body th {
                background: #f9fafb;
                font-weight: 600;
            }

            .dark .content-body th {
                background: #1e293b;
            }
        </style>

        <!-- 푸터: 메타 정보 및 관리자 버튼 -->
        <div class="px-6 py-6 sm:px-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- 메타 정보 -->
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-slate-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span><?= Helper::formatDate($content['created_at'], 'Y-m-d H:i') ?></span>
                    </div>
                    <?php if ($content['created_at'] != $content['updated_at']): ?>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                        <span>수정: <?= Helper::formatDate($content['updated_at'], 'Y-m-d H:i') ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- 관리자 버튼 -->
                <?php if (Helper::isAdmin()): ?>
                <a href="/admin/contents" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white text-sm font-semibold rounded-lg shadow-lg shadow-blue-500/40 hover:shadow-xl hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    관리자 페이지
                </a>
                <?php endif; ?>
            </div>
        </div>
    </article>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/default.php';
?>
