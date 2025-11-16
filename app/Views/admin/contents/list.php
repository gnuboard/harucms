<?php
$title = '컨텐츠 관리 - HaruCMS Admin';
ob_start();
?>

<?php use App\Core\Helper; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    컨텐츠 관리
                </h1>
                <p class="text-gray-600 dark:text-slate-400 mt-2">정적 페이지를 생성하고 관리합니다</p>
            </div>
            <a href="/admin/contents/create" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/40 hover:shadow-xl hover:shadow-indigo-500/50 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                컨텐츠 추가
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (Helper::hasFlash('success')): ?>
    <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200">
        <?= Helper::getFlash('success') ?>
    </div>
    <?php endif; ?>

    <?php if (Helper::hasFlash('error')): ?>
    <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200">
        <?= Helper::getFlash('error') ?>
    </div>
    <?php endif; ?>

    <!-- Status Filter Tabs -->
    <?php
    $currentStatus = $_GET['status'] ?? 'all';
    $publishedCount = $stats['published'] ?? 0;
    $draftCount = $stats['draft'] ?? 0;
    ?>
    <div class="mb-6 flex items-center gap-2">
        <a href="/admin/contents?status=all<?= isset($_GET['page']) ? '&page=' . $_GET['page'] : '' ?>"
           class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors <?= $currentStatus === 'all' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-700' ?>">
            전체 <span class="ml-1 text-xs opacity-75">(<?= number_format($totalContents ?? 0) ?>)</span>
        </a>
        <a href="/admin/contents?status=published<?= isset($_GET['page']) ? '&page=' . $_GET['page'] : '' ?>"
           class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors <?= $currentStatus === 'published' ? 'bg-emerald-600 text-white' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-700' ?>">
            공개중 <span class="ml-1 text-xs opacity-75">(<?= number_format($publishedCount) ?>)</span>
        </a>
        <a href="/admin/contents?status=draft<?= isset($_GET['page']) ? '&page=' . $_GET['page'] : '' ?>"
           class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors <?= $currentStatus === 'draft' ? 'bg-amber-600 text-white' : 'bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-700' ?>">
            비공개 <span class="ml-1 text-xs opacity-75">(<?= number_format($draftCount) ?>)</span>
        </a>
    </div>

    <!-- Contents Table -->
    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">URL 슬러그</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">제목</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">상태</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">작성자</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">수정일</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">관리</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    <?php if (empty($contents)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300 dark:text-slate-600 mb-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                <p class="text-gray-500 dark:text-slate-400 text-sm">등록된 컨텐츠가 없습니다</p>
                                <a href="/admin/contents/create" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    첫 컨텐츠 추가하기
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($contents as $content): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-900/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                #<?= $content['id'] ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <code class="px-2 py-1 text-xs font-mono bg-gray-100 dark:bg-slate-900 text-gray-800 dark:text-slate-300 rounded">
                                    /<?= htmlspecialchars($content['slug']) ?>
                                </code>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    <?= htmlspecialchars($content['title']) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($content['status'] === 'published'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    공개
                                </span>
                                <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    비공개
                                </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-slate-400">
                                <?= htmlspecialchars($content['author_name'] ?? $content['email'] ?? '-') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-slate-400">
                                <?= Helper::formatDate($content['updated_at'], 'Y-m-d H:i') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/<?= htmlspecialchars($content['slug']) ?>" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 dark:bg-emerald-900/30 dark:hover:bg-emerald-900/50 text-emerald-700 dark:text-emerald-400 rounded-lg transition-colors text-xs font-medium">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                        보기
                                    </a>
                                    <a href="/admin/contents/<?= $content['id'] ?>/edit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-400 rounded-lg transition-colors text-xs font-medium">
                                        <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        수정
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (!empty($pagination) && $pagination['total_pages'] > 1): ?>
        <div class="border-t border-gray-200 dark:border-slate-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-slate-400">
                    총 <span class="font-medium text-gray-900 dark:text-white"><?= number_format($totalContents) ?></span>개의 컨텐츠
                </div>
                <div class="flex items-center gap-2">
                    <?php
                    $statusParam = isset($_GET['status']) && $_GET['status'] !== 'all' ? '&status=' . $_GET['status'] : '';
                    ?>
                    <?php if ($pagination['current_page'] > 1): ?>
                    <a href="?page=<?= $pagination['current_page'] - 1 ?><?= $statusParam ?>" class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        이전
                    </a>
                    <?php endif; ?>

                    <span class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">
                        <?= $pagination['current_page'] ?> / <?= $pagination['total_pages'] ?>
                    </span>

                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                    <a href="?page=<?= $pagination['current_page'] + 1 ?><?= $statusParam ?>" class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        다음
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
