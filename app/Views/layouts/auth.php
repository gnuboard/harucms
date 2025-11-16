<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

    <?php require __DIR__ . '/theme-config.php'; ?>
</head>
<body class="min-h-screen bg-gradient-to-br from-white via-blue-50/30 to-emerald-50/30 dark:bg-gradient-to-br dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 flex items-center justify-center p-5 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-emerald-400/20 dark:bg-emerald-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- 테마 전환 버튼 (우측 상단) -->
    <button onclick="toggleTheme()" class="absolute top-4 right-4 inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100 dark:hover:bg-slate-800 h-10 w-10 z-50" title="테마 전환">
        <svg id="theme-icon-light" class="h-5 w-5 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <svg id="theme-icon-dark" class="absolute h-5 w-5 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    </button>

    <!-- Auth Card -->
    <div class="w-full max-w-md bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-gray-200 dark:border-slate-700 rounded-2xl shadow-xl p-8 relative z-10 animate-fade-in">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <h1 class="text-3xl font-bold bg-clip-text bg-gradient-to-r from-blue-600 via-emerald-600 to-blue-600 text-transparent">HaruCMS</h1>
            </a>
        </div>

        <?= $content ?>
    </div>

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
