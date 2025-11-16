<!DOCTYPE html>
<html lang="ko" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(var(--border))',
                        input: 'hsl(var(--input))',
                        ring: 'hsl(var(--ring))',
                        background: 'hsl(var(--background))',
                        foreground: 'hsl(var(--foreground))',
                        primary: {
                            DEFAULT: 'hsl(var(--primary))',
                            foreground: 'hsl(var(--primary-foreground))',
                        },
                        secondary: {
                            DEFAULT: 'hsl(var(--secondary))',
                            foreground: 'hsl(var(--secondary-foreground))',
                        },
                        muted: {
                            DEFAULT: 'hsl(var(--muted))',
                            foreground: 'hsl(var(--muted-foreground))',
                        },
                        accent: {
                            DEFAULT: 'hsl(var(--accent))',
                            foreground: 'hsl(var(--accent-foreground))',
                        },
                        card: {
                            DEFAULT: 'hsl(var(--card))',
                            foreground: 'hsl(var(--card-foreground))',
                        },
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 240 10% 3.9%;
            --card: 0 0% 100%;
            --card-foreground: 240 10% 3.9%;
            --muted: 240 4.8% 95.9%;
            --muted-foreground: 240 3.8% 46.1%;
            --border: 240 5.9% 90%;
            --input: 240 5.9% 90%;
            --primary: 240 5.9% 10%;
            --primary-foreground: 0 0% 98%;
            --secondary: 240 4.8% 95.9%;
            --secondary-foreground: 240 5.9% 10%;
            --accent: 240 4.8% 95.9%;
            --accent-foreground: 240 5.9% 10%;
            --ring: 240 5.9% 10%;
        }

        .dark {
            --background: 240 10% 3.9%;
            --foreground: 0 0% 98%;
            --card: 240 10% 3.9%;
            --card-foreground: 0 0% 98%;
            --muted: 240 3.7% 15.9%;
            --muted-foreground: 240 5% 64.9%;
            --border: 240 3.7% 15.9%;
            --input: 240 3.7% 15.9%;
            --primary: 0 0% 98%;
            --primary-foreground: 240 5.9% 10%;
            --secondary: 240 3.7% 15.9%;
            --secondary-foreground: 0 0% 98%;
            --accent: 240 3.7% 15.9%;
            --accent-foreground: 0 0% 98%;
            --ring: 240 4.9% 83.9%;
        }
    </style>
    <?php if (isset($additional_css)): ?>
    <style><?= $additional_css ?></style>
    <?php endif; ?>

    <!-- 테마 로드 스크립트 (FOUC 방지) -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.classList.toggle('dark', savedTheme === 'dark');
            } catch (e) {
                console.error('테마 로드 실패:', e);
            }
        })();
    </script>
</head>
<body class="min-h-screen bg-background text-foreground">
    <!-- 헤더 -->
    <header class="sticky top-0 z-50 w-full border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
        <div class="max-w-7xl mx-auto flex h-16 items-center justify-between px-4">
            <div class="flex items-center gap-6">
                <a href="/" class="flex items-center space-x-2">
                    <span class="font-bold text-xl">HaruCMS</span>
                </a>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="/" class="transition-colors hover:text-foreground/80 text-foreground/60">홈</a>
                    <a href="/boards/notice" class="transition-colors hover:text-foreground/80 text-foreground/60">공지사항</a>
                    <a href="/boards/free" class="transition-colors hover:text-foreground/80 text-foreground/60">자유게시판</a>
                    <?php
                    use App\Core\Helper;
                    if (Helper::isLoggedIn()):
                    ?>
                        <a href="/mypage" class="transition-colors hover:text-foreground/80 text-foreground/60">마이페이지</a>
                        <?php if (Helper::isAdmin()): ?>
                        <a href="/admin" class="transition-colors hover:text-foreground/80 text-foreground/60">관리자</a>
                        <?php endif; ?>
                        <a href="/logout" class="transition-colors hover:text-foreground/80 text-foreground/60">로그아웃</a>
                    <?php else: ?>
                        <a href="/login" class="transition-colors hover:text-foreground/80 text-foreground/60">로그인</a>
                        <a href="/signup" class="transition-colors hover:text-foreground/80 text-foreground/60">회원가입</a>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- 테마 전환 버튼 -->
            <button onclick="toggleTheme()" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-10 w-10" title="테마 전환">
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
    <footer class="border-t border-border mt-16">
        <div class="max-w-7xl mx-auto py-6 px-4">
            <p class="text-center text-sm text-muted-foreground">&copy; <?= date('Y') ?> HaruCMS. All rights reserved.</p>
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
