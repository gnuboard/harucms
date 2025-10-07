<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($content['title']) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f5f5f5; line-height: 1.6; }
        .nav { background: #333; color: #fff; padding: 0; }
        .nav ul { list-style: none; display: flex; max-width: 1200px; margin: 0 auto; }
        .nav a { color: #fff; text-decoration: none; padding: 15px 20px; display: block; }
        .nav a:hover { background: #555; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .content { background: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { font-size: 2.5em; margin-bottom: 20px; color: #333; }
        .meta { color: #999; font-size: 0.9em; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .body { font-size: 1.1em; color: #333; }
        .body img { max-width: 100%; height: auto; }
        .body h2 { margin-top: 1.5em; margin-bottom: 0.5em; }
        .body h3 { margin-top: 1.2em; margin-bottom: 0.5em; }
        .body p { margin-bottom: 1em; }
        .body ul, .body ol { margin-left: 2em; margin-bottom: 1em; }
        .body pre { background: #f4f4f4; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .body code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: 'Courier New', monospace; }
        .body pre code { background: none; padding: 0; }
        .body blockquote { border-left: 4px solid #667eea; padding-left: 20px; margin: 1em 0; color: #666; }
    </style>
</head>
<body>
    <div class="nav">
        <ul>
            <li><a href="/">홈</a></li>
            <li><a href="/boards/free">게시판</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="content">
            <h1><?= htmlspecialchars($content['title']) ?></h1>
            <div class="meta">
                작성자: <?= htmlspecialchars($content['author_name'] ?? $content['email'] ?? '관리자') ?> |
                작성일: <?= date('Y-m-d H:i', strtotime($content['created_at'])) ?>
                <?php if ($content['created_at'] != $content['updated_at']): ?>
                    | 수정일: <?= date('Y-m-d H:i', strtotime($content['updated_at'])) ?>
                <?php endif; ?>
            </div>
            <div class="body">
                <?= $content['content'] ?>
            </div>
        </div>
    </div>
</body>
</html>
