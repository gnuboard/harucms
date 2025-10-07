<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe24 CMS 설치</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 1px solid #eee;
        }
        .section:last-of-type {
            border-bottom: none;
        }
        .section-title {
            color: #667eea;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }
        .license-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            max-height: 200px;
            overflow-y: auto;
            font-size: 12px;
            line-height: 1.6;
            color: #495057;
            margin-bottom: 15px;
        }
        .license-box h3 {
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 13px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            font-weight: normal;
        }
        .help-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
            font-size: 14px;
        }
        .alert-error strong {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 12px;
            margin-top: 10px;
            font-size: 13px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Cafe24 CMS 설치</h1>
        <p class="subtitle">빠르고 가벼운 PHP 기반 CMS 솔루션</p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <strong>⚠️ 설치 실패</strong><br>
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <strong>✅ 성공</strong><br>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash'])): ?>
            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                <div class="alert alert-<?= $type ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form method="POST" action="/install" id="installForm">
            <!-- 라이센스 섹션 -->
            <div class="section">
                <div class="section-title">📜 라이센스</div>
                <div class="license-box">
                    <h3>MIT License</h3>
                    <p>Copyright (c) 2025 Cafe24 CMS</p>
                    <br>
                    <p>Permission is hereby granted, free of charge, to any person obtaining a copy
                    of this software and associated documentation files (the "Software"), to deal
                    in the Software without restriction, including without limitation the rights
                    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
                    copies of the Software, and to permit persons to whom the Software is
                    furnished to do so, subject to the following conditions:</p>
                    <br>
                    <p>The above copyright notice and this permission notice shall be included in all
                    copies or substantial portions of the Software.</p>
                    <br>
                    <p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
                    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
                    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
                    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
                    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
                    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
                    SOFTWARE.</p>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" id="agree_license" name="agree_license" required>
                    <label for="agree_license">위 라이센스에 동의합니다 *</label>
                </div>
            </div>

            <!-- MySQL 정보 섹션 -->
            <div class="section">
                <div class="section-title">🗄️ MySQL 데이터베이스 정보</div>
                <div class="form-group">
                    <label for="db_host">호스트 *</label>
                    <input type="text" id="db_host" name="db_host" value="localhost" required>
                    <div class="help-text">일반적으로 localhost를 사용합니다</div>
                </div>
                <div class="form-group">
                    <label for="db_name">데이터베이스명 *</label>
                    <input type="text" id="db_name" name="db_name" value="cafe24" required>
                    <div class="help-text">데이터베이스가 없으면 자동으로 생성됩니다</div>
                </div>
                <div class="form-group">
                    <label for="db_user">사용자명 *</label>
                    <input type="text" id="db_user" name="db_user" value="root" required>
                </div>
                <div class="form-group">
                    <label for="db_password">비밀번호</label>
                    <input type="password" id="db_password" name="db_password">
                    <div class="help-text">비밀번호가 없으면 비워두세요</div>
                </div>
            </div>

            <!-- 관리자 정보 섹션 -->
            <div class="section">
                <div class="section-title">👤 관리자 계정 정보</div>
                <div class="form-group">
                    <label for="admin_email">관리자 이메일 *</label>
                    <input type="email" id="admin_email" name="admin_email" required placeholder="admin@example.com">
                    <div class="help-text">로그인 ID로 사용됩니다</div>
                </div>
                <div class="form-group">
                    <label for="admin_password">관리자 비밀번호 *</label>
                    <input type="password" id="admin_password" name="admin_password" required minlength="6">
                    <div class="help-text">최소 6자 이상</div>
                </div>
                <div class="form-group">
                    <label for="admin_name">관리자 이름</label>
                    <input type="text" id="admin_name" name="admin_name" value="관리자">
                </div>
            </div>

            <!-- 설치 옵션 -->
            <div class="section">
                <div class="section-title">⚙️ 설치 옵션</div>
                <div class="checkbox-group">
                    <input type="checkbox" id="overwrite_data" name="overwrite_data" value="1">
                    <label for="overwrite_data">기존 데이터 덮어쓰기</label>
                </div>
                <div class="warning-box" id="overwriteWarning" style="display: none;">
                    ⚠️ 경고: 기존의 모든 데이터가 삭제됩니다!
                </div>
                <div class="help-text">체크하지 않으면 기존 데이터를 유지하면서 관리자 계정을 추가합니다</div>
            </div>

            <button type="submit" class="btn" id="installBtn">🎉 설치 시작</button>
        </form>
    </div>

    <script>
        // 라이센스 동의 체크에 따라 버튼 활성화
        const agreeCheckbox = document.getElementById('agree_license');
        const installBtn = document.getElementById('installBtn');
        const overwriteCheckbox = document.getElementById('overwrite_data');
        const overwriteWarning = document.getElementById('overwriteWarning');

        agreeCheckbox.addEventListener('change', function() {
            installBtn.disabled = !this.checked;
        });

        overwriteCheckbox.addEventListener('change', function() {
            overwriteWarning.style.display = this.checked ? 'block' : 'none';
        });

        // 폼 제출 시 확인
        document.getElementById('installForm').addEventListener('submit', function(e) {
            if (overwriteCheckbox.checked) {
                if (!confirm('정말로 기존 데이터를 모두 삭제하고 새로 설치하시겠습니까?')) {
                    e.preventDefault();
                    return false;
                }
            }

            installBtn.textContent = '⏳ 설치 중...';
            installBtn.disabled = true;
        });

        // 초기 상태 설정
        installBtn.disabled = !agreeCheckbox.checked;
    </script>
</body>
</html>
