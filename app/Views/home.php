<?php
$title = 'HaruCMS - 메인';
ob_start();
?>

<?php use App\Core\Helper; ?>

<!-- Hero Section with Modern Curved Design -->
<div class="relative overflow-hidden bg-gradient-to-br from-white via-blue-50/30 to-emerald-50/30 dark:bg-gradient-to-br dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-emerald-400/20 dark:bg-emerald-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-10">
        <!-- Title -->
        <div class="max-w-3xl text-center mx-auto">
            <h1 class="block font-bold text-4xl md:text-5xl tracking-tight bg-clip-text bg-gradient-to-r from-blue-600 via-emerald-600 to-blue-600 text-transparent dark:from-blue-400 dark:via-emerald-400 dark:to-blue-400 animate-gradient bg-[length:200%_auto]">
                HaruCMS
            </h1>
        </div>

        <!-- Description -->
        <div class="mt-3 max-w-2xl text-center mx-auto">
            <p class="text-sm md:text-base text-gray-600 dark:text-slate-300 leading-relaxed">경량, 빠름, 그리고 강력한 PHP CMS 솔루션</p>
        </div>

        <!-- Buttons -->
        <?php if (Helper::isLoggedIn()): ?>
            <div class="mt-6 flex justify-center">
                <div class="inline-flex items-center gap-x-3 bg-gradient-to-r from-blue-600 via-emerald-600 to-blue-600 bg-[length:200%_auto] text-white text-base font-semibold rounded-2xl py-4 px-8 shadow-lg shadow-blue-500/40 hover:shadow-2xl hover:shadow-emerald-500/50 transition-all duration-500 hover:bg-right dark:shadow-blue-500/30 dark:hover:shadow-emerald-500/40">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <strong><?= htmlspecialchars(Helper::userNickname() ?? '사용자') ?></strong>님 환영합니다!
                </div>
            </div>
        <?php else: ?>
            <div class="mt-6 gap-4 flex justify-center flex-wrap">
                <a class="group relative py-4 px-8 inline-flex items-center gap-x-2 text-base font-semibold rounded-2xl border-2 border-transparent bg-gradient-to-r from-blue-600 to-emerald-600 text-white hover:from-blue-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-lg shadow-blue-500/40 hover:shadow-2xl hover:shadow-emerald-500/50 hover:-translate-y-0.5 transition-all duration-300 dark:shadow-blue-500/30 dark:hover:shadow-emerald-500/40 dark:focus:ring-offset-slate-900" href="/login">
                    시작하기
                    <svg class="shrink-0 size-5 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <a class="group py-4 px-8 inline-flex items-center gap-x-2 text-base font-semibold rounded-2xl border-2 border-gray-300 dark:border-slate-600 text-gray-800 dark:text-white bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-700 hover:border-blue-400 dark:hover:border-blue-500 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-slate-500 transition-all duration-300" href="/signup">
                    회원가입
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Curved Border Bottom -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="w-full h-16 md:h-24 text-white dark:text-slate-900" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,64 C240,100 480,120 720,100 C960,80 1200,40 1440,64 L1440,120 L0,120 Z" fill="currentColor"/>
        </svg>
    </div>
</div>

<!-- Stats Section with Enhanced Gradient Cards -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Card 1 - Open Source -->
        <div class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition-all duration-300 dark:bg-slate-800 dark:border-slate-700 hover:border-blue-600 dark:hover:border-blue-500">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <div class="inline-flex items-center justify-center size-12 bg-gradient-to-br from-blue-600 to-emerald-600 rounded-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-slate-400 font-semibold">
                            오픈소스
                        </p>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-x-2">
                    <h3 class="text-3xl sm:text-4xl font-bold bg-clip-text bg-gradient-to-br from-blue-600 to-emerald-600 text-transparent dark:from-blue-400 dark:to-emerald-400">
                        100%
                    </h3>
                    <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-500/20 dark:text-green-400">
                        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5L20 7"/></svg>
                        무료
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 2 - License Cost -->
        <div class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition-all duration-300 dark:bg-slate-800 dark:border-slate-700 hover:border-blue-600 dark:hover:border-blue-500">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <div class="inline-flex items-center justify-center size-12 bg-gradient-to-br from-blue-600 to-emerald-600 rounded-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-slate-400 font-semibold">
                            라이선스 비용
                        </p>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-x-2">
                    <h3 class="text-3xl sm:text-4xl font-bold bg-clip-text bg-gradient-to-br from-blue-600 to-emerald-600 text-transparent dark:from-blue-400 dark:to-emerald-400">
                        0원
                    </h3>
                    <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-400">
                        영구 무료
                    </span>
                </div>
            </div>
        </div>

        <!-- Card 3 - Installation Time -->
        <div class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-lg transition-all duration-300 dark:bg-slate-800 dark:border-slate-700 hover:border-blue-600 dark:hover:border-blue-500">
            <div class="p-4 md:p-5">
                <div class="flex items-center gap-x-2">
                    <div class="shrink-0">
                        <div class="inline-flex items-center justify-center size-12 bg-gradient-to-br from-blue-600 to-emerald-600 rounded-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 17 18 12 13 7"/><polyline points="6 17 11 12 6 7"/></svg>
                        </div>
                    </div>
                    <div class="flex-grow">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-slate-400 font-semibold">
                            설치 시간
                        </p>
                    </div>
                </div>
                <div class="mt-3 flex items-center gap-x-2">
                    <h3 class="text-3xl sm:text-4xl font-bold bg-clip-text bg-gradient-to-br from-blue-600 to-emerald-600 text-transparent dark:from-blue-400 dark:to-emerald-400">
                        5초
                    </h3>
                    <span class="inline-flex items-center gap-x-1 py-1 px-2 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-400">
                        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        초고속
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section with Gradient Enhancements -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <!-- Section Header -->
    <div class="relative max-w-2xl mx-auto text-center mb-10 lg:mb-14">
        <h2 class="text-2xl font-bold md:text-4xl md:leading-tight dark:text-white">
            주요 <span class="bg-clip-text bg-gradient-to-tl from-blue-600 to-emerald-600 text-transparent">기능</span>
        </h2>
        <p class="mt-1 text-gray-600 dark:text-neutral-400">다양한 기능으로 강력한 웹사이트를 구축하세요</p>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Card - 공지사항 -->
        <a class="group relative flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:shadow-xl transition-all duration-300 dark:bg-slate-800 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-500" href="/boards/notice">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-600/10 to-cyan-600/10 rounded-bl-full -mr-16 -mt-16 group-hover:from-blue-600/20 group-hover:to-cyan-600/20 transition-all duration-300"></div>
            <div class="relative p-4 md:p-6">
                <div class="flex items-center gap-x-3 mb-4">
                    <span class="flex justify-center items-center size-12 bg-gradient-to-br from-blue-600 to-blue-500 rounded-lg shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300">
                        <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                    </span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 dark:text-slate-100 dark:group-hover:text-blue-400 transition-colors">
                    공지사항
                </h3>
                <p class="mt-3 text-gray-600 dark:text-slate-300">
                    중요한 공지사항과 업데이트를 확인하고 커뮤니티 소식을 받아보세요.
                </p>
                <div class="mt-4 flex items-center gap-x-2 text-sm text-blue-600 dark:text-blue-500 font-medium group-hover:gap-x-3 transition-all">
                    <span>바로가기</span>
                    <svg class="shrink-0 size-4 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </a>

        <!-- Card - 자유게시판 -->
        <a class="group relative flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:shadow-xl transition-all duration-300 dark:bg-slate-800 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-500" href="/boards/free">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-600/10 to-teal-600/10 rounded-bl-full -mr-16 -mt-16 group-hover:from-emerald-600/20 group-hover:to-teal-600/20 transition-all duration-300"></div>
            <div class="relative p-4 md:p-6">
                <div class="flex items-center gap-x-3 mb-4">
                    <span class="flex justify-center items-center size-12 bg-gradient-to-br from-emerald-600 to-teal-500 rounded-lg shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300">
                        <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                    </span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-emerald-600 dark:text-slate-100 dark:group-hover:text-emerald-400 transition-colors">
                    자유게시판
                </h3>
                <p class="mt-3 text-gray-600 dark:text-slate-300">
                    자유롭게 의견을 나누고 다른 사용자들과 소통할 수 있는 공간입니다.
                </p>
                <div class="mt-4 flex items-center gap-x-2 text-sm text-emerald-600 dark:text-emerald-500 font-medium group-hover:gap-x-3 transition-all">
                    <span>바로가기</span>
                    <svg class="shrink-0 size-4 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </a>

        <?php if (Helper::isLoggedIn()): ?>
        <!-- Card - 마이페이지 -->
        <a class="group relative flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:shadow-xl transition-all duration-300 dark:bg-slate-800 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-500" href="/mypage">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-600/10 to-blue-600/10 rounded-bl-full -mr-16 -mt-16 group-hover:from-indigo-600/20 group-hover:to-blue-600/20 transition-all duration-300"></div>
            <div class="relative p-4 md:p-6">
                <div class="flex items-center gap-x-3 mb-4">
                    <span class="flex justify-center items-center size-12 bg-gradient-to-br from-indigo-600 to-blue-500 rounded-lg shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300">
                        <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-indigo-600 dark:text-slate-100 dark:group-hover:text-indigo-400 transition-colors">
                    마이페이지
                </h3>
                <p class="mt-3 text-gray-600 dark:text-slate-300">
                    프로필 정보를 관리하고 개인 설정을 변경할 수 있습니다.
                </p>
                <div class="mt-4 flex items-center gap-x-2 text-sm text-indigo-600 dark:text-indigo-500 font-medium group-hover:gap-x-3 transition-all">
                    <span>바로가기</span>
                    <svg class="shrink-0 size-4 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </a>
        <?php endif; ?>

        <?php if (Helper::isAdmin()): ?>
        <!-- Card - 관리자 -->
        <a class="group relative flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl overflow-hidden hover:shadow-xl hover:-translate-y-1 focus:outline-none focus:shadow-xl transition-all duration-300 dark:bg-slate-800 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-500" href="/admin">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-600/10 to-pink-600/10 rounded-bl-full -mr-16 -mt-16 group-hover:from-purple-600/20 group-hover:to-pink-600/20 transition-all duration-300"></div>
            <div class="relative p-4 md:p-6">
                <div class="flex items-center gap-x-3 mb-4">
                    <span class="flex justify-center items-center size-12 bg-gradient-to-br from-purple-600 to-pink-500 rounded-lg shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300">
                        <svg class="shrink-0 size-6 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    </span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 group-hover:text-purple-600 dark:text-slate-100 dark:group-hover:text-purple-400 transition-colors">
                    관리자
                </h3>
                <p class="mt-3 text-gray-600 dark:text-slate-300">
                    사이트 전반을 관리하고 컨텐츠를 효율적으로 운영하세요.
                </p>
                <div class="mt-4 flex items-center gap-x-2 text-sm text-purple-600 dark:text-purple-500 font-medium group-hover:gap-x-3 transition-all">
                    <span>바로가기</span>
                    <svg class="shrink-0 size-4 group-hover:translate-x-1 transition-transform" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/default.php';
?>
