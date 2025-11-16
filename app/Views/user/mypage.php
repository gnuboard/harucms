<?php
$title = '마이페이지';
$additional_css = '
.user-info {
    background: #f5f5f5;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}
.user-info-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
}
.user-info-item:last-child {
    border-bottom: none;
}
.user-info-item label {
    font-weight: 600;
    color: #333;
}
.user-info-item span {
    color: #666;
}
.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #667eea;
}
.form-group {
    margin-bottom: 20px;
}
.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #333;
    font-weight: 600;
    font-size: 14px;
}
.form-group input {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s;
}
.form-group input:focus {
    outline: none;
    border-color: #667eea;
}
.form-group small {
    display: block;
    margin-top: 5px;
    color: #999;
    font-size: 12px;
}
.btn {
    width: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    padding: 14px;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.3s;
    margin-top: 10px;
}
.btn:hover {
    opacity: 0.9;
}
.alert {
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 6px;
    font-size: 14px;
}
.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}
.alert-error {
    background: #fee;
    color: #c33;
    border: 1px solid #fcc;
}
';
ob_start();
?>

<div class="container" style="max-width: 700px;">
    <h1 style="font-size: 28px; color: #333; margin-bottom: 30px; text-align: center;">마이페이지</h1>

    <?php
    use App\Core\Helper;

    if (Helper::hasFlash('success')):
    ?>
    <div class="alert alert-success">
        <?= Helper::getFlash('success') ?>
    </div>
    <?php endif; ?>

    <?php if (Helper::hasFlash('error')): ?>
    <div class="alert alert-error">
        <?= Helper::getFlash('error') ?>
    </div>
    <?php endif; ?>

    <!-- 현재 사용자 정보 -->
    <div class="user-info">
        <div class="user-info-item">
            <label>이메일</label>
            <span><?= htmlspecialchars($user['email'] ?? '') ?></span>
        </div>
        <div class="user-info-item">
            <label>이름</label>
            <span><?= htmlspecialchars($user['name'] ?? '') ?></span>
        </div>
        <div class="user-info-item">
            <label>가입일</label>
            <span><?= Helper::formatDate($user['created_at'] ?? '', 'Y-m-d') ?></span>
        </div>
        <div class="user-info-item">
            <label>마지막 로그인</label>
            <span><?= Helper::timeAgo($user['last_login'] ?? '') ?></span>
        </div>
    </div>

    <!-- 프로필 수정 폼 -->
    <h2 class="section-title">프로필 수정</h2>
    <form method="POST" action="/mypage">
        <div class="form-group">
            <label for="email">이메일</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" readonly>
            <small>이메일은 변경할 수 없습니다</small>
        </div>

        <div class="form-group">
            <label for="name">이름</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" placeholder="새 이름 입력">
            <small>2자 이상 20자 이하 (변경하지 않으려면 비워두세요)</small>
        </div>

        <div class="form-group">
            <label for="password">새 비밀번호</label>
            <input type="password" id="password" name="password" placeholder="변경하지 않으려면 비워두세요">
            <small>최소 6자 이상</small>
        </div>

        <div class="form-group">
            <label for="password_confirm">새 비밀번호 확인</label>
            <input type="password" id="password_confirm" name="password_confirm" placeholder="새 비밀번호 확인">
        </div>

        <button type="submit" class="btn">수정하기</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/default.php';
?>
