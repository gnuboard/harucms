<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>세션 관리</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; }
        .nav { background: #333; color: #fff; padding: 0; }
        .nav ul { list-style: none; display: flex; max-width: 1200px; margin: 0 auto; }
        .nav a { color: #fff; text-decoration: none; padding: 15px 20px; display: block; }
        .nav a:hover { background: #555; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .header { background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 20px; }
        .stat-card { background: #fff; padding: 20px; border-radius: 8px; }
        .stat-card h3 { font-size: 14px; color: #666; margin-bottom: 5px; }
        .stat-card .number { font-size: 32px; font-weight: bold; color: #667eea; }
        table { width: 100%; background: #fff; border-collapse: collapse; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-active { background: #28a745; color: #fff; }
        .badge-guest { background: #6c757d; color: #fff; }
        .btn { background: #667eea; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block; cursor: pointer; }
        .btn-danger { background: #dc3545; }
        .btn-small { padding: 4px 8px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="nav">
        <ul>
            <li><a href="/admin">대시보드</a></li>
            <li><a href="/admin/users">사용자 관리</a></li>
            <li><a href="/admin/boards">게시판 관리</a></li>
            <li><a href="/admin/contents">컨텐츠 관리</a></li>
            <li><a href="/admin/sessions">세션 관리</a></li>
            <li><a href="/admin/logout">로그아웃</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <h1>세션 관리</h1>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>전체 활성 세션</h3>
                <div class="number"><?= $stats['total_sessions'] ?></div>
            </div>
            <div class="stat-card">
                <h3>로그인 사용자</h3>
                <div class="number"><?= $stats['logged_in_sessions'] ?></div>
            </div>
            <div class="stat-card">
                <h3>게스트 세션</h3>
                <div class="number"><?= $stats['guest_sessions'] ?></div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="300">세션 ID</th>
                    <th width="150">사용자</th>
                    <th width="120">IP 주소</th>
                    <th>User Agent</th>
                    <th width="150">최근 활동</th>
                    <th width="80">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sessions)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #999;">활성 세션이 없습니다.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($sessions as $session): ?>
                    <tr>
                        <td><code style="font-size: 11px;"><?= htmlspecialchars(substr($session['id'], 0, 40)) ?>...</code></td>
                        <td>
                            <?php if ($session['user_id']): ?>
                                <span class="badge badge-active">사용자</span><br>
                                <small><?= htmlspecialchars($session['email'] ?? '-') ?></small>
                            <?php else: ?>
                                <span class="badge badge-guest">게스트</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($session['ip_address'] ?? '-') ?></td>
                        <td style="font-size: 11px; color: #666;">
                            <?= htmlspecialchars(substr($session['user_agent'] ?? '-', 0, 50)) ?>...
                        </td>
                        <td><?= date('Y-m-d H:i:s', $session['last_activity']) ?></td>
                        <td>
                            <form method="POST" action="/admin/sessions/delete" style="display: inline;">
                                <input type="hidden" name="session_id" value="<?= htmlspecialchars($session['id']) ?>">
                                <button type="submit" class="btn btn-danger btn-small" onclick="return confirm('이 세션을 삭제하시겠습니까?')">삭제</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
