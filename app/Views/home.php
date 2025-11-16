<?php
$title = 'HaruCMS - 메인';
ob_start();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php use App\Core\Helper; ?>

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-3xl overflow-hidden mb-16 shadow-2xl">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:20px_20px]"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-blue-900/50"></div>

        <div class="relative px-8 py-20 sm:px-12 sm:py-24 lg:py-32">
            <div class="text-center">
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white mb-6 tracking-tight">
                    <span class="block">HaruCMS</span>
                </h1>
                <p class="text-xl sm:text-2xl text-blue-100 mb-8 font-light max-w-3xl mx-auto">
                    경량, 빠름, 그리고 강력한 PHP CMS 솔루션
                </p>

                <?php if (Helper::isLoggedIn()): ?>
                    <div class="inline-flex items-center gap-3 px-6 py-3 bg-white/20 backdrop-blur-xl border border-white/30 rounded-full text-white font-semibold shadow-lg">
                        <span class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-lg">👋</span>
                        <span><strong><?= htmlspecialchars(Helper::userNickname()) ?></strong>님 환영합니다!</span>
                    </div>
                <?php else: ?>
                    <div class="flex flex-wrap gap-4 justify-center mt-8">
                        <a href="/login" class="px-8 py-3 bg-white text-blue-700 rounded-xl font-bold hover:bg-blue-50 transition-all duration-200 shadow-xl hover:shadow-2xl hover:-translate-y-0.5">
                            로그인
                        </a>
                        <a href="/signup" class="px-8 py-3 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 rounded-xl font-bold hover:bg-white/20 transition-all duration-200 shadow-xl">
                            회원가입
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 border border-blue-200 dark:border-blue-800 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow duration-300">
            <div class="text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                100%
            </div>
            <div class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                오픈소스
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 border border-blue-200 dark:border-blue-800 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow duration-300">
            <div class="text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                0원
            </div>
            <div class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                라이선스 비용
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 border border-blue-200 dark:border-blue-800 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow duration-300">
            <div class="text-5xl font-black bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                5초
            </div>
            <div class="text-sm font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                설치 시간
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="mb-16">
        <h2 class="text-4xl font-black text-center mb-12 bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
            주요 기능
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- 공지사항 -->
            <a href="/boards/notice" class="group relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    📢
                </div>

                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
                    공지사항
                </h3>

                <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                    중요한 공지사항과 업데이트를 확인하고 커뮤니티 소식을 받아보세요.
                </p>

                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    자세히 보기
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- 자유게시판 -->
            <a href="/boards/free" class="group relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    💬
                </div>

                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
                    자유게시판
                </h3>

                <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                    자유롭게 의견을 나누고 다른 사용자들과 소통할 수 있는 공간입니다.
                </p>

                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    자세히 보기
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <?php if (Helper::isLoggedIn()): ?>
            <!-- 마이페이지 -->
            <a href="/mypage" class="group relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    👤
                </div>

                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
                    마이페이지
                </h3>

                <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                    프로필 정보를 관리하고 개인 설정을 변경할 수 있습니다.
                </p>

                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    자세히 보기
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            <?php endif; ?>

            <?php if (Helper::isAdmin()): ?>
            <!-- 관리자 -->
            <a href="/admin" class="group relative bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>

                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg group-hover:shadow-xl group-hover:scale-110 transition-all duration-300">
                    ⚙️
                </div>

                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">
                    관리자
                </h3>

                <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                    사이트 전반을 관리하고 컨텐츠를 효율적으로 운영하세요.
                </p>

                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    자세히 보기
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/default.php';
?>
