<?php
$title = '관리자 대시보드 - HaruCMS';
ob_start();
?>

<?php use App\Core\Helper; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-8">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </div>
            <div class="flex-grow">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">환영합니다! 👋</h2>
                <p class="text-gray-600 dark:text-slate-400 mb-4">HaruCMS 관리자 페이지입니다. 아래의 통계와 빠른 메뉴를 통해 사이트를 관리하실 수 있습니다.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div class="flex items-center gap-2 text-gray-700 dark:text-slate-300">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span><strong class="font-semibold">이메일:</strong> <?= htmlspecialchars($_SESSION['email'] ?? 'N/A') ?></span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-700 dark:text-slate-300">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span><strong class="font-semibold">관리자 권한:</strong> <?= ($_SESSION['is_admin'] ?? false) ? '예' : '아니오' ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="group bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6 hover:shadow-lg hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-slate-400 mb-1">전체 사용자</h3>
            <p class="text-3xl font-bold bg-clip-text bg-gradient-to-br from-blue-600 to-indigo-600 text-transparent dark:from-blue-400 dark:to-indigo-400"><?= number_format($stats['total_users'] ?? 0) ?></p>
        </div>

        <!-- Total Posts -->
        <div class="group bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6 hover:shadow-lg hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-slate-400 mb-1">전체 게시글</h3>
            <p class="text-3xl font-bold bg-clip-text bg-gradient-to-br from-blue-600 to-emerald-600 text-transparent dark:from-blue-400 dark:to-emerald-400"><?= number_format($stats['total_posts'] ?? 0) ?></p>
        </div>

        <!-- Total Boards -->
        <div class="group bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6 hover:shadow-lg hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-slate-400 mb-1">게시판 수</h3>
            <p class="text-3xl font-bold bg-clip-text bg-gradient-to-br from-emerald-600 to-cyan-600 text-transparent dark:from-emerald-400 dark:to-cyan-400"><?= number_format($stats['total_boards'] ?? 0) ?></p>
        </div>

        <!-- Total Contents -->
        <div class="group bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6 hover:shadow-lg hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
            </div>
            <h3 class="text-sm font-medium text-gray-600 dark:text-slate-400 mb-1">컨텐츠 페이지</h3>
            <p class="text-3xl font-bold bg-clip-text bg-gradient-to-br from-indigo-600 to-blue-600 text-transparent dark:from-indigo-400 dark:to-blue-400"><?= number_format($stats['total_contents'] ?? 0) ?></p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                빠른 메뉴
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <a href="/admin/contents" class="group flex items-center gap-4 p-4 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 hover:from-blue-100 hover:to-indigo-100 dark:hover:from-blue-900/30 dark:hover:to-indigo-900/30 border border-blue-200 dark:border-blue-800 rounded-lg transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">컨텐츠 관리</h3>
                        <p class="text-xs text-gray-600 dark:text-slate-400">페이지 추가/수정</p>
                    </div>
                </a>

                <a href="/admin/users" class="group flex items-center gap-4 p-4 bg-gradient-to-br from-blue-50 to-emerald-50 dark:from-blue-900/20 dark:to-emerald-900/20 hover:from-blue-100 hover:to-emerald-100 dark:hover:from-blue-900/30 dark:hover:to-emerald-900/30 border border-blue-200 dark:border-blue-800 rounded-lg transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">사용자 관리</h3>
                        <p class="text-xs text-gray-600 dark:text-slate-400">회원 정보 관리</p>
                    </div>
                </a>

                <a href="/admin/boards" class="group flex items-center gap-4 p-4 bg-gradient-to-br from-emerald-50 to-cyan-50 dark:from-emerald-900/20 dark:to-cyan-900/20 hover:from-emerald-100 hover:to-cyan-100 dark:hover:from-emerald-900/30 dark:hover:to-cyan-900/30 border border-emerald-200 dark:border-emerald-800 rounded-lg transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-cyan-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">게시판 관리</h3>
                        <p class="text-xs text-gray-600 dark:text-slate-400">게시판 추가/수정</p>
                    </div>
                </a>

                <a href="/admin/sessions" class="group flex items-center gap-4 p-4 bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 hover:from-indigo-100 hover:to-blue-100 dark:hover:from-indigo-900/30 dark:hover:to-blue-900/30 border border-indigo-200 dark:border-indigo-800 rounded-lg transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">세션 관리</h3>
                        <p class="text-xs text-gray-600 dark:text-slate-400">활성 세션 확인</p>
                    </div>
                </a>

                <a href="/" class="group flex items-center gap-4 p-4 bg-gradient-to-br from-gray-50 to-slate-50 dark:from-slate-800/50 dark:to-slate-700/50 hover:from-gray-100 hover:to-slate-100 dark:hover:from-slate-800 dark:hover:to-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg transition-all">
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-slate-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">사이트 보기</h3>
                        <p class="text-xs text-gray-600 dark:text-slate-400">메인 페이지로</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/admin.php';
?>
