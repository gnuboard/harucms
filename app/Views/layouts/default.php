<!DOCTYPE html>
<html lang="ko" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

    <!-- Tailwind CSS + DaisyUI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@5.5.5/daisyui.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* 커스텀 그라디언트 배경 */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
    <?php if (isset($additional_css)): ?>
    <style><?= $additional_css ?></style>
    <?php endif; ?>
</head>
<body class="min-h-screen bg-base-200">
    <!-- 헤더 -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="navbar max-w-7xl mx-auto px-4">
            <div class="flex-1">
                <a href="/" class="btn btn-ghost text-xl font-bold">HaruCMS</a>
            </div>
            <nav class="flex-none">
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
</body>
</html>
