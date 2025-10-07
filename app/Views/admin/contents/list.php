<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>컨텐츠 관리</title>
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
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-published { background: #28a745; color: #fff; }
        .badge-draft { background: #ffc107; color: #333; }
    </style>
</head>
<body>
    <div class="nav">
        <ul>
            <li><a href="/admin">대시보드</a></li>
            <li><a href="/admin/users">사용자 관리</a></li>
            <li><a href="/admin/boards">게시판 관리</a></li>
            <li><a href="/admin/contents">컨텐츠 관리</a></li>
            <li><a href="/admin/logout">로그아웃</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <h1>컨텐츠 관리</h1>
            <a href="/admin/contents/create" class="btn">컨텐츠 추가</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th width="150">URL 슬러그</th>
                    <th>제목</th>
                    <th width="100">상태</th>
                    <th width="120">작성자</th>
                    <th width="120">수정일</th>
                    <th width="150">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contents)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">등록된 컨텐츠가 없습니다.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($contents as $content): ?>
                    <tr>
                        <td><?= $content['id'] ?></td>
                        <td><code><?= htmlspecialchars($content['slug']) ?></code></td>
                        <td><?= htmlspecialchars($content['title']) ?></td>
                        <td>
                            <span class="badge badge-<?= $content['status'] ?>">
                                <?= $content['status'] == 'published' ? '공개' : '비공개' ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($content['author_name'] ?? $content['email'] ?? '-') ?></td>
                        <td><?= date('Y-m-d H:i', strtotime($content['updated_at'])) ?></td>
                        <td>
                            <a href="/page/<?= $content['slug'] ?>" class="btn" style="padding: 4px 8px; font-size: 12px; background: #28a745;">보기</a>
                            <a href="/admin/contents/<?= $content['id'] ?>/edit" class="btn" style="padding: 4px 8px; font-size: 12px;">수정</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
