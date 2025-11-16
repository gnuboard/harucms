<?php
$title = '로그인';
ob_start();
?>

<div class="auth-header">
    <h1>로그인</h1>
    <p>HaruCMS에 오신 것을 환영합니다</p>
</div>

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

<form method="POST" action="/login">
    <div class="form-group">
        <label for="email">이메일</label>
        <input type="email" id="email" name="email" required autofocus placeholder="email@example.com">
    </div>

    <div class="form-group">
        <label for="password">비밀번호</label>
        <input type="password" id="password" name="password" required>
    </div>

    <button type="submit" class="btn">로그인</button>
</form>

<div class="links">
    <a href="/signup">회원가입</a> |
    <a href="/">메인으로</a> |
    <a href="/admin/login">관리자</a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
?>
