<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .post-header { background: #fff; padding: 20px; border-radius: 8px 8px 0 0; border-bottom: 2px solid #667eea; }
        .post-title { font-size: 24px; margin-bottom: 10px; }
        .post-meta { color: #666; font-size: 14px; display: flex; gap: 15px; }
        .post-content { background: #fff; padding: 30px 20px; min-height: 300px; line-height: 1.8; }
        .post-footer { background: #fff; padding: 15px 20px; border-radius: 0 0 8px 8px; display: flex; justify-content: space-between; }
        .btn { background: #667eea; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; text-decoration: none; display: inline-block; cursor: pointer; }
        .btn-secondary { background: #6c757d; }
        .btn-danger { background: #dc3545; }
        .nav-posts { background: #fff; margin-top: 10px; border-radius: 8px; }
        .nav-posts a { display: block; padding: 12px 20px; color: #333; text-decoration: none; border-bottom: 1px solid #eee; }
        .nav-posts a:hover { background: #f8f9fa; }
        .nav-posts a:last-child { border-bottom: none; }
        .comments { background: #fff; margin-top: 20px; padding: 20px; border-radius: 8px; }
        .comment { padding: 15px 0; border-bottom: 1px solid #eee; }
        .comment:last-child { border-bottom: none; }
        .comment-meta { color: #666; font-size: 14px; margin-bottom: 8px; }
        .comment-form textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; resize: vertical; min-height: 80px; }
        .comment-form { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="post-header">
            <h1 class="post-title"><?= htmlspecialchars($post['title']) ?></h1>
            <div class="post-meta">
                <span>작성자: <?= htmlspecialchars($post['author_name'] ?? $post['username'] ?? '익명') ?></span>
                <span>작성일: <?= date('Y-m-d H:i', strtotime($post['created_at'])) ?></span>
                <span>조회: <?= $post['view_count'] ?></span>
            </div>
        </div>

        <div class="post-content">
            <?= nl2br($post['content']) ?>
        </div>

        <div class="post-footer">
            <a href="/boards/<?= $post['board_name'] ?>" class="btn btn-secondary">목록</a>
            <div>
                <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || ($_SESSION['is_admin'] ?? 0))): ?>
                    <a href="/boards/<?= $post['board_name'] ?>/<?= $post['id'] ?>/edit" class="btn">수정</a>
                    <a href="/boards/<?= $post['board_name'] ?>/<?= $post['id'] ?>/delete" class="btn btn-danger" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($adjacentPosts['prev'] || $adjacentPosts['next']): ?>
        <div class="nav-posts">
            <?php if ($adjacentPosts['next']): ?>
                <a href="/boards/<?= $post['board_name'] ?>/<?= $adjacentPosts['next']['id'] ?>">
                    다음글: <?= htmlspecialchars($adjacentPosts['next']['title']) ?>
                </a>
            <?php endif; ?>
            <?php if ($adjacentPosts['prev']): ?>
                <a href="/boards/<?= $post['board_name'] ?>/<?= $adjacentPosts['prev']['id'] ?>">
                    이전글: <?= htmlspecialchars($adjacentPosts['prev']['title']) ?>
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($board['use_comments']): ?>
        <div class="comments">
            <h3>댓글 (<?= count($comments) ?>)</h3>

            <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <div class="comment-meta">
                    <strong><?= htmlspecialchars($comment['author_name'] ?? $comment['username'] ?? '익명') ?></strong>
                    <span><?= date('Y-m-d H:i', strtotime($comment['created_at'])) ?></span>
                </div>
                <div><?= nl2br(htmlspecialchars($comment['content'])) ?></div>
            </div>
            <?php endforeach; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
            <form class="comment-form" method="POST" action="/boards/<?= $post['board_name'] ?>/<?= $post['id'] ?>/comments">
                <textarea name="content" placeholder="댓글을 입력하세요" required></textarea>
                <br><br>
                <button type="submit" class="btn">댓글 작성</button>
            </form>
            <?php else: ?>
            <p style="margin-top: 20px; color: #666;">댓글을 작성하려면 <a href="/login">로그인</a>이 필요합니다.</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
