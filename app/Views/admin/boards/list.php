<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 관리</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; }
        .nav { background: #333; color: #fff; padding: 0; }
        .nav ul { list-style: none; display: flex; max-width: 1200px; margin: 0 auto; }
        .nav a { color: #fff; text-decoration: none; padding: 15px 20px; display: block; }
        .nav a:hover { background: #555; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .header { background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .btn { background: #667eea; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block; }
        table { width: 100%; background: #fff; border-collapse: collapse; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; background: #e0e0e0; }
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
            <h1>게시판 관리</h1>
            <a href="/admin/boards/create" class="btn">게시판 추가</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th width="120">게시판명</th>
                    <th>제목</th>
                    <th width="100">게시글 수</th>
                    <th width="80">댓글</th>
                    <th width="80">파일첨부</th>
                    <th width="80">순서</th>
                    <th width="120">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boards as $board): ?>
                <tr>
                    <td><?= $board['id'] ?></td>
                    <td><code><?= htmlspecialchars($board['name']) ?></code></td>
                    <td><?= htmlspecialchars($board['title']) ?></td>
                    <td><?= $board['post_count'] ?? 0 ?></td>
                    <td><?= $board['use_comments'] ? '사용' : '미사용' ?></td>
                    <td><?= $board['use_files'] ? '사용' : '미사용' ?></td>
                    <td><?= $board['order_num'] ?></td>
                    <td>
                        <a href="/boards/<?= $board['name'] ?>" class="btn" style="padding: 4px 8px; font-size: 12px; background: #28a745;">보기</a>
                        <a href="/admin/boards/<?= $board['id'] ?>/edit" class="btn" style="padding: 4px 8px; font-size: 12px;">수정</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
