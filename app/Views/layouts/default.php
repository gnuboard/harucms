<!DOCTYPE html>
<html lang="ko" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

    <!-- Tailwind CSS + DaisyUI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@5.5.5/daisyui.min.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/daisyui@5.5.5/index.min.js"></script>

    <style>
        /* 커스텀 그라디언트 배경 */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
    <?php if (isset($additional_css)): ?>
    <style><?= $additional_css ?></style>
    <?php endif; ?>

    <!-- 테마 로드 스크립트 (FOUC 방지) -->
    <script>
        // 페이지 로드 전에 테마 적용
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', savedTheme);
            } catch (e) {
                console.error('테마 로드 실패:', e);
            }
        })();
    </script>
</head>
<body class="min-h-screen bg-base-200">
    <!-- 헤더 -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="navbar max-w-7xl mx-auto px-4">
            <div class="flex-1">
                <a href="/" class="btn btn-ghost text-xl font-bold">HaruCMS</a>
            </div>
            <nav class="flex-none flex items-center gap-2">
                <ul class="menu menu-horizontal px-1 gap-2">
                    <li><a href="/" class="hover:opacity-80">홈</a></li>
                    <li><a href="/boards/notice" class="hover:opacity-80">공지사항</a></li>
                    <li><a href="/boards/free" class="hover:opacity-80">자유게시판</a></li>
                    <?php
                    use App\Core\Helper;
                    if (Helper::isLoggedIn()):
                    ?>
                        <li><a href="/mypage" class="hover:opacity-80">마이페이지</a></li>
                        <?php if (Helper::isAdmin()): ?>
                        <li><a href="/admin" class="hover:opacity-80">관리자</a></li>
                        <?php endif; ?>
                        <li><a href="/logout" class="hover:opacity-80">로그아웃</a></li>
                    <?php else: ?>
                        <li><a href="/login" class="hover:opacity-80">로그인</a></li>
                        <li><a href="/signup" class="hover:opacity-80">회원가입</a></li>
                    <?php endif; ?>
                </ul>

                <!-- 테마 전환 버튼 -->
                <button onclick="toggleTheme()" class="btn btn-ghost btn-circle" title="테마 전환">
                    <svg id="theme-icon-light" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <svg id="theme-icon-dark" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>
            </nav>
        </div>
    </header>

    <!-- 메인 컨텐츠 -->
    <main class="max-w-7xl mx-auto py-10 px-4">
        <?= $content ?>
    </main>

    <!-- 푸터 -->
    <footer class="footer footer-center p-4 bg-neutral text-neutral-content mt-16">
        <aside>
            <p class="text-sm opacity-80">&copy; <?= date('Y') ?> HaruCMS. All rights reserved.</p>
        </aside>
    </footer>

    <!-- 테마 전환 스크립트 -->
    <script>
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';

            // 테마 변경
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // 아이콘 토글
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const lightIcon = document.getElementById('theme-icon-light');
            const darkIcon = document.getElementById('theme-icon-dark');

            if (theme === 'dark') {
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            } else {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            }
        }

        // 페이지 로드 시 아이콘 상태 업데이트
        document.addEventListener('DOMContentLoaded', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            updateThemeIcon(currentTheme);
        });
    </script>
</body>
</html>
