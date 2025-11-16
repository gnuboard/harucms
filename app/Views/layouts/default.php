<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        /* 헤더 */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .header-logo {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            padding: 20px 0;
        }
        .header-nav {
            display: flex;
            gap: 30px;
        }
        .header-nav a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            padding: 20px 0;
            transition: opacity 0.3s;
        }
        .header-nav a:hover {
            opacity: 0.8;
        }

        /* 메인 컨텐츠 */
        .main-content {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* 컨테이너 */
        .container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* 푸터 */
        .footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
        }
        .footer p {
            font-size: 14px;
            opacity: 0.8;
        }

        /* 반응형 */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .header-nav {
                gap: 15px;
                padding: 10px 0;
            }
            .container {
                padding: 20px;
            }
        }
    </style>
    <?php if (isset($additional_css)): ?>
    <style><?= $additional_css ?></style>
    <?php endif; ?>
</head>
<body>
    <!-- 헤더 -->
    <header class="header">
        <div class="header-container">
            <a href="/" class="header-logo">HaruCMS</a>
            <nav class="header-nav">
                <a href="/">홈</a>
                <a href="/boards/notice">공지사항</a>
                <a href="/boards/free">자유게시판</a>
                <?php
                use App\Core\Helper;
                if (Helper::isLoggedIn()):
                ?>
                    <a href="/mypage">마이페이지</a>
                    <?php if (Helper::isAdmin()): ?>
                    <a href="/admin">관리자</a>
                    <?php endif; ?>
                    <a href="/logout">로그아웃</a>
                <?php else: ?>
                    <a href="/login">로그인</a>
                    <a href="/signup">회원가입</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- 메인 컨텐츠 -->
    <main class="main-content">
        <?= $content ?>
    </main>

    <!-- 푸터 -->
    <footer class="footer">
        <p>&copy; <?= date('Y') ?> HaruCMS. All rights reserved.</p>
    </footer>
</body>
</html>
