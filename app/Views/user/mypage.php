<?php
$title = '마이페이지';
$additional_css = '
.user-info {
    background-color: hsl(var(--muted));
    border: 1px solid hsl(var(--border));
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
}
.user-info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid hsl(var(--border));
}
.user-info-item:last-child {
    border-bottom: none;
}
.user-info-item label {
    font-weight: 600;
    color: hsl(var(--foreground));
}
.user-info-item span {
    color: hsl(var(--muted-foreground));
}
.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: hsl(var(--foreground));
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid hsl(var(--border));
}
.form-group {
    margin-bottom: 1.25rem;
}
.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: hsl(var(--foreground));
    font-weight: 500;
    font-size: 0.875rem;
}
.form-group input {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid hsl(var(--border));
    border-radius: 0.375rem;
    background-color: hsl(var(--background));
    color: hsl(var(--foreground));
    font-size: 0.875rem;
    transition: all 0.2s;
}
.form-group input:focus {
    outline: none;
    border-color: hsl(var(--ring));
    box-shadow: 0 0 0 3px hsla(var(--ring), 0.1);
}
.form-group input:read-only {
    background-color: hsl(var(--muted));
    color: hsl(var(--muted-foreground));
}
.form-group small {
    display: block;
    margin-top: 0.25rem;
    color: hsl(var(--muted-foreground));
    font-size: 0.75rem;
}
.btn {
    width: 100%;
    background-color: hsl(var(--primary));
    color: hsl(var(--primary-foreground));
    border: none;
    padding: 0.625rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 0.5rem;
}
.btn:hover {
    opacity: 0.9;
}
.btn:focus-visible {
    outline: none;
    box-shadow: 0 0 0 3px hsla(var(--ring), 0.3);
}
.alert {
    padding: 0.75rem 1rem;
    margin-bottom: 1.25rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
}
.alert-success {
    background-color: hsl(142.1 76.2% 96.3%);
    color: hsl(142.1 76.2% 26.3%);
    border: 1px solid hsl(142.1 76.2% 86.3%);
}
.alert-error {
    background-color: hsl(0 84.2% 96.5%);
    color: hsl(0 84.2% 40.2%);
    border: 1px solid hsl(0 84.2% 86.5%);
}
.dark .alert-success {
    background-color: hsl(142.1 76.2% 13.9%);
    color: hsl(142.1 76.2% 76.3%);
    border-color: hsl(142.1 76.2% 23.9%);
}
.dark .alert-error {
    background-color: hsl(0 84.2% 13.9%);
    color: hsl(0 84.2% 76.3%);
    border-color: hsl(0 84.2% 23.9%);
}
';
ob_start();
?>

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-center">마이페이지</h1>

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
