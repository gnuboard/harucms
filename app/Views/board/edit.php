<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글수정 - <?= htmlspecialchars($board['title']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; padding: 20px; }
        .form-card { background: #fff; padding: 30px; border-radius: 8px; }
        .form-card h1 { margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .form-group textarea { min-height: 400px; resize: vertical; font-family: inherit; }
        .form-actions { display: flex; gap: 10px; }
        .btn { background: #667eea; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #5568d3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #5a6268; }
        .checkbox-group { display: flex; align-items: center; gap: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-card">
            <h1>글수정</h1>

            <form method="POST" action="/boards/<?= $board['name'] ?>/<?= $post['id'] ?>/edit">
                <div class="form-group">
                    <label>제목</label>
                    <input type="text" name="title" required value="<?= htmlspecialchars($post['title']) ?>">
                </div>

                <div class="form-group">
                    <label>내용</label>
                    <textarea name="content" id="content" required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>

                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" name="is_notice" id="is_notice" value="1" <?= $post['is_notice'] ? 'checked' : '' ?>>
                        <label for="is_notice" style="margin: 0;">공지사항으로 등록</label>
                    </div>
                </div>
                <?php endif; ?>

                <div class="form-actions">
                    <button type="submit" class="btn">수정</button>
                    <a href="/boards/<?= $board['name'] ?>/<?= $post['id'] ?>" class="btn btn-secondary">취소</a>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/ckeditor/ckeditor.js"></script>
    <script>
        // CKEditor가 로드되어 있으면 적용
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('content', {
                height: 400,
                filebrowserUploadUrl: '/upload'
            });
        }
    </script>
</body>
</html>
