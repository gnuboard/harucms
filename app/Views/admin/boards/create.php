<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 추가</title>
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
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        textarea { min-height: 100px; }
        select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .help-text { font-size: 12px; color: #666; margin-top: 5px; }
        .btn { background: #667eea; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #5568d3; }
        .btn-secondary { background: #6c757d; }
        .btn-group { display: flex; gap: 10px; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
        input[type="checkbox"] { width: 18px; height: 18px; }
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
            <h1>게시판 추가</h1>
            <a href="/admin/boards" class="btn btn-secondary">목록으로</a>
        </div>

        <div class="form-card">
            <form method="POST" action="/admin/boards/create">
                <div class="form-group">
                    <label for="name">게시판 ID *</label>
                    <input type="text" id="name" name="name" required placeholder="free" pattern="[a-z0-9_-]+">
                    <div class="help-text">영문 소문자, 숫자, 언더스코어, 하이픈만 사용 (예: free, notice, qna)</div>
                </div>

                <div class="form-group">
                    <label for="title">게시판 제목 *</label>
                    <input type="text" id="title" name="title" required placeholder="자유게시판">
                </div>

                <div class="form-group">
                    <label for="description">설명</label>
                    <textarea id="description" name="description" placeholder="게시판 설명"></textarea>
                </div>

                <div class="form-group">
                    <label>옵션</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="use_comments" name="use_comments" value="1" checked>
                        <label for="use_comments" style="margin: 0;">댓글 사용</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="use_files" name="use_files" value="1" checked>
                        <label for="use_files" style="margin: 0;">파일 첨부 사용</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="order_num">정렬 순서</label>
                    <input type="number" id="order_num" name="order_num" value="0" min="0">
                    <div class="help-text">낮은 숫자가 먼저 표시됩니다</div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn">게시판 추가</button>
                    <a href="/admin/boards" class="btn btn-secondary">취소</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
