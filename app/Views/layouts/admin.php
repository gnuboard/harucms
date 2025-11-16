<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS Admin' ?></title>

    <?php require __DIR__ . '/theme-config.php'; ?>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-white">
    <!-- Admin Navigation -->
    <nav class="sticky top-0 z-50 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 border-b border-blue-700 dark:border-indigo-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo and Main Nav -->
                <div class="flex items-center gap-8">
                    <a href="/admin" class="flex items-center gap-2 text-white font-bold text-lg">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        HaruCMS Admin
                    </a>

                    <!-- Desktop Nav -->
                    <div class="hidden md:flex items-center gap-1">
                        <a href="/admin" class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-white/10 transition-colors">
                            대시보드
                        </a>
                        <a href="/admin/contents" class="px-3 py-2 rounded-md text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                            컨텐츠
                        </a>
                        <a href="/admin/users" class="px-3 py-2 rounded-md text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                            사용자
                        </a>
                        <a href="/admin/boards" class="px-3 py-2 rounded-md text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                            게시판
                        </a>
                        <a href="/admin/sessions" class="px-3 py-2 rounded-md text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-colors">
                            세션
                        </a>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-3">
                    <!-- Site Link -->
                    <a href="/" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 rounded-md transition-colors">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        사이트 보기
                    </a>

                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="inline-flex items-center justify-center rounded-md text-white hover:bg-white/10 h-9 w-9 transition-colors" title="테마 전환">
                        <svg id="theme-icon-light" class="h-5 w-5 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="theme-icon-dark" class="absolute h-5 w-5 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>

                    <!-- User Menu -->
                    <?php
                    use App\Core\Helper;
                    ?>
                    <div class="flex items-center gap-2 pl-3 border-l border-white/20">
                        <span class="hidden sm:inline text-sm text-white/90"><?= htmlspecialchars($_SESSION['nickname'] ?? $_SESSION['email'] ?? '관리자') ?></span>
                        <a href="/admin/logout" class="px-3 py-1.5 text-sm font-medium text-white bg-white/10 hover:bg-white/20 rounded-md transition-colors">
                            로그아웃
                        </a>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="md:hidden inline-flex items-center justify-center rounded-md text-white hover:bg-white/10 h-9 w-9 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-white/10">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/admin" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/10">
                    대시보드
                </a>
                <a href="/admin/contents" class="block px-3 py-2 rounded-md text-base font-medium text-white/80 hover:text-white hover:bg-white/10">
                    컨텐츠 관리
                </a>
                <a href="/admin/users" class="block px-3 py-2 rounded-md text-base font-medium text-white/80 hover:text-white hover:bg-white/10">
                    사용자 관리
                </a>
                <a href="/admin/boards" class="block px-3 py-2 rounded-md text-base font-medium text-white/80 hover:text-white hover:bg-white/10">
                    게시판 관리
                </a>
                <a href="/admin/sessions" class="block px-3 py-2 rounded-md text-base font-medium text-white/80 hover:text-white hover:bg-white/10">
                    세션 관리
                </a>
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-white/80 hover:text-white hover:bg-white/10 border-t border-white/10 mt-2 pt-3">
                    사이트 보기
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-slate-700 mt-16 bg-white dark:bg-slate-800">
        <div class="max-w-7xl mx-auto py-6 px-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-600 dark:text-slate-400">
                    &copy; <?= date('Y') ?> HaruCMS Admin Panel. All rights reserved.
                </p>
                <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-slate-500">
                    <span>PHP <?= PHP_VERSION ?></span>
                    <span>•</span>
                    <span>v1.0.0</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const newTheme = isDark ? 'light' : 'dark';

            html.classList.toggle('dark', !isDark);
            localStorage.setItem('theme', newTheme);
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
