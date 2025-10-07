<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 대시보드</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .welcome-card h2 {
            color: #333;
            margin-bottom: 10px;
        }

        .welcome-card p {
            color: #666;
            line-height: 1.6;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: #999;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .stat-card .number {
            color: #667eea;
            font-size: 32px;
            font-weight: 700;
        }

        .quick-links {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .quick-links h3 {
            color: #333;
            margin-bottom: 20px;
        }

        .links-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .link-item {
            display: block;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            transition: opacity 0.3s;
        }

        .link-item:hover {
            opacity: 0.9;
        }

        .admin-info {
            background: #f0f4ff;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .admin-info p {
            color: #555;
            font-size: 14px;
            margin: 5px 0;
        }

        .admin-info strong {
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>관리자 대시보드</h1>
            <div class="user-info">
                <span><?php echo htmlspecialchars($_SESSION['name'] ?? $_SESSION['username']); ?>님</span>
                <a href="/admin/logout" class="logout-btn">로그아웃</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h2>환영합니다! 👋</h2>
            <p>HaruCMS PHP 웹솔루션 관리자 페이지입니다.</p>

            <div class="admin-info">
                <p><strong>이메일:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                <p><strong>관리자 권한:</strong> <?php echo $_SESSION['is_admin'] ? '예' : '아니오'; ?></p>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>전체 사용자</h3>
                <div class="number"><?php echo $stats['total_users'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>전체 게시글</h3>
                <div class="number"><?php echo $stats['total_posts'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>게시판 수</h3>
                <div class="number"><?php echo $stats['total_boards'] ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>컨텐츠 페이지</h3>
                <div class="number"><?php echo $stats['total_contents'] ?? 0; ?></div>
            </div>
        </div>

        <div class="quick-links">
            <h3>빠른 메뉴</h3>
            <div class="links-grid">
                <a href="/admin/contents" class="link-item">컨텐츠 관리</a>
                <a href="/admin/users" class="link-item">사용자 관리</a>
                <a href="/admin/boards" class="link-item">게시판 관리</a>
                <a href="/admin/sessions" class="link-item">세션 관리</a>
                <a href="/" class="link-item">사이트 보기</a>
            </div>
        </div>
    </div>
</body>
</html>
