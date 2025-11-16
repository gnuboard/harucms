<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HaruCMS - 메인</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .home-container {
            background: #fff;
            padding: 60px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 800px;
            text-align: center;
        }
        .home-header h1 {
            font-size: 48px;
            color: #333;
            margin-bottom: 20px;
        }
        .home-header p {
            color: #666;
            font-size: 18px;
            margin-bottom: 40px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .menu-item {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            padding: 30px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: transform 0.3s, opacity 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .menu-item:hover {
            transform: translateY(-5px);
            opacity: 0.9;
        }
        .menu-item h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .menu-item p {
            font-size: 14px;
            opacity: 0.9;
        }
        .user-info {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .user-info p {
            color: #333;
            font-size: 16px;
        }
        .user-info strong {
            color: #667eea;
        }
        .links {
            margin-top: 30px;
            font-size: 14px;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="home-container">
        <div class="home-header">
            <h1>HaruCMS</h1>
            <p>저가형 호스팅 환경에 최적화된 경량 PHP CMS</p>
        </div>

        <?php
        use App\Core\Helper;

        if (Helper::isLoggedIn()):
        ?>
        <div class="user-info">
            <p><strong><?= htmlspecialchars(Helper::userName()) ?></strong>님 환영합니다!</p>
        </div>
        <?php endif; ?>

        <div class="menu-grid">
            <a href="/boards/notice" class="menu-item">
                <h3>공지사항</h3>
                <p>중요한 공지를 확인하세요</p>
            </a>
            <a href="/boards/free" class="menu-item">
                <h3>자유게시판</h3>
                <p>자유롭게 소통하세요</p>
            </a>
            <?php if (Helper::isLoggedIn()): ?>
            <a href="/mypage" class="menu-item">
                <h3>마이페이지</h3>
                <p>내 정보를 관리하세요</p>
            </a>
            <?php endif; ?>
            <?php if (Helper::isAdmin()): ?>
            <a href="/admin" class="menu-item">
                <h3>관리자</h3>
                <p>사이트 관리 페이지</p>
            </a>
            <?php endif; ?>
        </div>

        <div class="links">
            <?php if (Helper::isLoggedIn()): ?>
                <a href="/logout">로그아웃</a>
            <?php else: ?>
                <a href="/login">로그인</a> |
                <a href="/signup">회원가입</a>
            <?php endif; ?>
            <?php if (!Helper::isAdmin()): ?>
                | <a href="/admin/login">관리자</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
