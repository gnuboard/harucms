<!DOCTYPE html>
<html lang="ko" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

    <?php require __DIR__ . '/theme-config.php'; ?>
</head>
<body class="min-h-screen bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
    <!-- 헤더 -->
    <header class="sticky top-0 z-50 w-full border-b border-gray-200 dark:border-slate-700 bg-white/95 dark:bg-slate-900/95 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-slate-900/60">
        <div class="max-w-7xl mx-auto flex h-16 items-center justify-between px-4">
            <div class="flex items-center gap-6">
                <a href="/" class="flex items-center space-x-2">
                    <span class="font-bold text-xl">HaruCMS</span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="/" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">홈</a>
                    <a href="/boards/notice" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">공지사항</a>
                    <a href="/boards/free" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">자유게시판</a>
                    <?php
                    use App\Core\Helper;
                    if (Helper::isLoggedIn()):
                    ?>
                        <a href="/mypage" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">마이페이지</a>
                        <?php if (Helper::isAdmin()): ?>
                        <a href="/admin" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">관리자</a>
                        <?php endif; ?>
                        <a href="/logout" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">로그아웃</a>
                    <?php else: ?>
                        <a href="/login" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">로그인</a>
                        <a href="/signup" class="transition-colors text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-white">회원가입</a>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- 테마 전환 버튼 -->
            <button onclick="toggleTheme()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100 dark:hover:bg-slate-800 h-10 w-10" title="테마 전환">
                <svg id="theme-icon-light" class="h-5 w-5 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <svg id="theme-icon-dark" class="absolute h-5 w-5 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- 메인 컨텐츠 -->
    <main class="max-w-7xl mx-auto py-10 px-4">
        <?= $content ?>
    </main>

    <!-- 푸터 -->
    <footer class="border-t border-gray-200 dark:border-slate-700 mt-16">
        <div class="max-w-7xl mx-auto py-6 px-4">
            <p class="text-center text-sm text-gray-600 dark:text-slate-400">&copy; <?= date('Y') ?> HaruCMS. All rights reserved.</p>
        </div>
    </footer>

    <!-- 테마 전환 스크립트 -->
    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const newTheme = isDark ? 'light' : 'dark';

            html.classList.toggle('dark', !isDark);
            localStorage.setItem('theme', newTheme);
        }
    </script>
</body>
</html>
