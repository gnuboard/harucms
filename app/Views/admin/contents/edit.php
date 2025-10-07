<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>컨텐츠 수정</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; }
        .nav { background: #333; color: #fff; padding: 0; }
        .nav ul { list-style: none; display: flex; max-width: 1200px; margin: 0 auto; }
        .nav a { color: #fff; text-decoration: none; padding: 15px 20px; display: block; }
        .nav a:hover { background: #555; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .header { background: #fff; padding: 20px; margin-bottom: 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; }
        .form-card { background: #fff; padding: 30px; border-radius: 8px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        textarea { min-height: 200px; font-family: monospace; }
        select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .help-text { font-size: 12px; color: #666; margin-top: 5px; }
        .btn { background: #667eea; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #5568d3; }
        .btn-secondary { background: #6c757d; }
        .btn-danger { background: #dc3545; }
        .btn-group { display: flex; gap: 10px; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
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
            <h1>컨텐츠 수정</h1>
            <a href="/admin/contents" class="btn btn-secondary">목록으로</a>
        </div>

        <?php if (isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="/admin/contents/<?= $content['id'] ?>/edit">
                <div class="form-group">
                    <label for="slug">URL 슬러그 *</label>
                    <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($content['slug']) ?>" required placeholder="about">
                    <div class="help-text">영문, 숫자, 하이픈만 사용 가능 (예: about, privacy-policy)</div>
                </div>

                <div class="form-group">
                    <label for="title">제목 *</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($content['title']) ?>" required placeholder="페이지 제목">
                </div>

                <div class="form-group">
                    <label for="content">내용</label>
                    <textarea id="content" name="content" placeholder="페이지 내용 (HTML 사용 가능)"><?= htmlspecialchars($content['content'] ?? '') ?></textarea>
                    <div class="help-text">HTML 태그를 사용할 수 있습니다</div>
                </div>

                <div class="form-group">
                    <label for="status">상태 *</label>
                    <select id="status" name="status" required>
                        <option value="draft" <?= $content['status'] === 'draft' ? 'selected' : '' ?>>비공개</option>
                        <option value="published" <?= $content['status'] === 'published' ? 'selected' : '' ?>>공개</option>
                    </select>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn">수정 저장</button>
                    <a href="/admin/contents" class="btn btn-secondary">취소</a>
                    <button type="button" class="btn btn-danger" onclick="if(confirm('정말 삭제하시겠습니까?')) { document.getElementById('deleteForm').submit(); }">삭제</button>
                </div>
            </form>

            <form id="deleteForm" method="POST" action="/admin/contents/<?= $content['id'] ?>/delete" style="display: none;">
            </form>
        </div>
    </div>
</body>
</html>
