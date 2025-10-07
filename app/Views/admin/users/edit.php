<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>사용자 수정</title>
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
        input[type="text"], input[type="email"], input[type="password"], select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .help-text { font-size: 12px; color: #666; margin-top: 5px; }
        .btn { background: #667eea; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn:hover { background: #5568d3; }
        .btn-secondary { background: #6c757d; }
        .btn-group { display: flex; gap: 10px; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
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
            <h1>사용자 수정</h1>
            <a href="/admin/users" class="btn btn-secondary">목록으로</a>
        </div>

        <div class="form-card">
            <form method="POST" action="/admin/users/<?= $user['id'] ?>/edit">
                <div class="form-group">
                    <label for="email">이메일 *</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="name">이름</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="password">새 비밀번호</label>
                    <input type="password" id="password" name="password" placeholder="변경하지 않으려면 비워두세요">
                    <div class="help-text">최소 6자 이상</div>
                </div>

                <div class="form-group">
                    <label for="status">상태 *</label>
                    <select id="status" name="status" required>
                        <option value="1" <?= $user['status'] == 1 ? 'selected' : '' ?>>활성</option>
                        <option value="0" <?= $user['status'] == 0 ? 'selected' : '' ?>>비활성</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_admin" name="is_admin" value="1" <?= $user['is_admin'] == 1 ? 'checked' : '' ?>>
                        <label for="is_admin" style="margin: 0;">관리자 권한 부여</label>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn">수정 저장</button>
                    <a href="/admin/users" class="btn btn-secondary">취소</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
