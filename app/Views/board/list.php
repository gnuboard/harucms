<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($board['title']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { color: #666; font-size: 14px; }
        .toolbar { display: flex; justify-content: space-between; margin-bottom: 15px; }
        .search-form { display: flex; gap: 10px; }
        .search-form select, .search-form input { padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { background: #667eea; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block; cursor: pointer; }
        .btn:hover { background: #5568d3; }
        table { width: 100%; background: #fff; border-collapse: collapse; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; }
        .post-title { color: #333; text-decoration: none; }
        .post-title:hover { color: #667eea; }
        .notice { background: #fff9e6; }
        .pagination { display: flex; justify-content: center; gap: 5px; margin-top: 20px; }
        .pagination a { padding: 8px 12px; background: #fff; border: 1px solid #ddd; text-decoration: none; color: #333; }
        .pagination a.active { background: #667eea; color: #fff; border-color: #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?= htmlspecialchars($board['title']) ?></h1>
            <p><?= htmlspecialchars($board['description'] ?? '') ?></p>
        </div>

        <div class="toolbar">
            <form class="search-form" method="GET">
                <select name="search_type">
                    <option value="all">전체</option>
                    <option value="title">제목</option>
                    <option value="content">내용</option>
                    <option value="author">작성자</option>
                </select>
                <input type="text" name="keyword" placeholder="검색어 입력" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                <button type="submit" class="btn">검색</button>
            </form>
            <a href="/boards/<?= $board['name'] ?>/write" class="btn">글쓰기</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="60">번호</th>
                    <th>제목</th>
                    <th width="120">작성자</th>
                    <th width="100">날짜</th>
                    <th width="60">조회</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #999;">게시글이 없습니다.</td>
                </tr>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                    <tr class="<?= $post['is_notice'] ? 'notice' : '' ?>">
                        <td><?= $post['is_notice'] ? '공지' : $post['id'] ?></td>
                        <td>
                            <a href="/boards/<?= $board['name'] ?>/<?= $post['id'] ?>" class="post-title">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($post['author_name'] ?? $post['email'] ?? '익명') ?></td>
                        <td><?= date('Y-m-d', strtotime($post['created_at'])) ?></td>
                        <td><?= $post['view_count'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ($pagination['total_pages'] > 1): ?>
        <div class="pagination">
            <?php if ($pagination['has_prev']): ?>
                <a href="?page=<?= $pagination['prev_page'] ?>">이전</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i == $pagination['current_page'] ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($pagination['has_next']): ?>
                <a href="?page=<?= $pagination['next_page'] ?>">다음</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
