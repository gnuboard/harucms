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
    <article class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <!-- 헤더 -->
        <div class="border-b border-gray-200 dark:border-slate-700 bg-gradient-to-r from-blue-50 to-emerald-50 dark:from-slate-900/50 dark:to-slate-800/50 px-6 py-8 sm:px-10">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                <?= htmlspecialchars($content['title']) ?>
            </h1>

            <!-- 메타 정보 -->
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-slate-400">
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
        </div>

        <!-- 본문 -->
        <div class="px-6 py-8 sm:px-10">
            <div class="prose prose-lg dark:prose-invert max-w-none
                prose-headings:font-bold prose-headings:text-gray-900 dark:prose-headings:text-white
                prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-4 prose-h2:pb-2 prose-h2:border-b prose-h2:border-gray-200 dark:prose-h2:border-slate-700
                prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-3
                prose-p:text-gray-700 dark:prose-p:text-slate-300 prose-p:leading-relaxed
                prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                prose-strong:text-gray-900 dark:prose-strong:text-white prose-strong:font-semibold
                prose-code:text-emerald-600 dark:prose-code:text-emerald-400 prose-code:bg-gray-100 dark:prose-code:bg-slate-900 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded prose-code:font-mono prose-code:text-sm prose-code:before:content-none prose-code:after:content-none
                prose-pre:bg-gray-900 dark:prose-pre:bg-slate-950 prose-pre:text-gray-100 prose-pre:rounded-lg prose-pre:border prose-pre:border-gray-700
                prose-blockquote:border-l-4 prose-blockquote:border-blue-600 dark:prose-blockquote:border-blue-400 prose-blockquote:bg-blue-50/50 dark:prose-blockquote:bg-blue-900/20 prose-blockquote:px-4 prose-blockquote:py-2 prose-blockquote:rounded-r
                prose-ul:list-disc prose-ol:list-decimal
                prose-li:text-gray-700 dark:prose-li:text-slate-300
                prose-img:rounded-lg prose-img:shadow-md
                prose-hr:border-gray-200 dark:prose-hr:border-slate-700">
                <?= $content['content'] ?>
            </div>
        </div>

        <!-- 푸터 액션 -->
        <?php if (Helper::isAdmin()): ?>
        <div class="border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 px-6 py-4 sm:px-10">
            <div class="flex justify-end">
                <a href="/admin/contents" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white text-sm font-semibold rounded-lg shadow-lg shadow-blue-500/40 hover:shadow-xl hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    관리자 페이지
                </a>
            </div>
        </div>
        <?php endif; ?>
    </article>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/default.php';
?>
