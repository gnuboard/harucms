<?php
$title = 'HaruCMS - 메인';
ob_start();
?>

<?php use App\Core\Helper; ?>

<!-- Hero Section with Preline -->
<div class="relative overflow-hidden">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24">
        <div class="text-center">
            <h1 class="text-4xl sm:text-6xl font-bold text-gray-800 dark:text-neutral-200">
                HaruCMS
            </h1>

            <p class="mt-3 text-gray-600 dark:text-neutral-400">
                경량, 빠름, 그리고 강력한 PHP CMS 솔루션
            </p>

            <?php if (Helper::isLoggedIn()): ?>
                <div class="mt-7 sm:mt-12 mx-auto max-w-xl relative">
                    <div class="inline-flex items-center gap-x-2 bg-white border border-gray-200 text-xs text-gray-800 p-2 px-3 rounded-full transition dark:bg-neutral-800 dark:border-neutral-700 dark:hover:border-neutral-600 dark:text-neutral-200">
                        <span class="flex items-center gap-x-2">
                            <svg class="shrink-0 size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <strong><?= htmlspecialchars(Helper::userNickname() ?? '사용자') ?></strong>님 환영합니다!
                        </span>
                    </div>
                </div>
            <?php else: ?>
                <div class="mt-7 sm:mt-12 mx-auto max-w-xl relative">
                    <div class="grid gap-4 md:grid-cols-2 md:gap-6">
                        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="/login">
                            로그인
                        </a>
                        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="/signup">
                            회원가입
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Card -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                        오픈소스
                    </p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                        100%
                    </h3>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                        라이선스 비용
                    </p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                        0원
                    </h3>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                        설치 시간
                    </p>
                </div>
                <div class="mt-1 flex items-center gap-x-2">
                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                        5초
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">주요 기능</h2>
        <p class="mt-1 text-gray-600 dark:text-neutral-400">다양한 기능으로 강력한 웹사이트를 구축하세요</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card -->
        <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="/boards/notice">
            <div class="p-4 md:p-6">
                <span class="flex justify-center items-center size-12 bg-blue-600 rounded-lg mb-4">
                    <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                </span>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:group-hover:text-white">
                    공지사항
                </h3>
                <p class="mt-3 text-gray-500 dark:text-neutral-500">
                    중요한 공지사항과 업데이트를 확인하고 커뮤니티 소식을 받아보세요.
                </p>
            </div>
        </a>

        <!-- Card -->
        <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="/boards/free">
            <div class="p-4 md:p-6">
                <span class="flex justify-center items-center size-12 bg-blue-600 rounded-lg mb-4">
                    <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                </span>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:group-hover:text-white">
                    자유게시판
                </h3>
                <p class="mt-3 text-gray-500 dark:text-neutral-500">
                    자유롭게 의견을 나누고 다른 사용자들과 소통할 수 있는 공간입니다.
                </p>
            </div>
        </a>

        <?php if (Helper::isLoggedIn()): ?>
        <!-- Card -->
        <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="/mypage">
            <div class="p-4 md:p-6">
                <span class="flex justify-center items-center size-12 bg-blue-600 rounded-lg mb-4">
                    <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </span>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:group-hover:text-white">
                    마이페이지
                </h3>
                <p class="mt-3 text-gray-500 dark:text-neutral-500">
                    프로필 정보를 관리하고 개인 설정을 변경할 수 있습니다.
                </p>
            </div>
        </a>
        <?php endif; ?>

        <?php if (Helper::isAdmin()): ?>
        <!-- Card -->
        <a class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-none focus:shadow-md transition dark:bg-neutral-900 dark:border-neutral-800" href="/admin">
            <div class="p-4 md:p-6">
                <span class="flex justify-center items-center size-12 bg-blue-600 rounded-lg mb-4">
                    <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                </span>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:group-hover:text-white">
                    관리자
                </h3>
                <p class="mt-3 text-gray-500 dark:text-neutral-500">
                    사이트 전반을 관리하고 컨텐츠를 효율적으로 운영하세요.
                </p>
            </div>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/default.php';
?>
