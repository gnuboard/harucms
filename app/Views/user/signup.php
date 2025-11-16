<?php
$title = '회원가입';
ob_start();
?>

<div class="auth-header">
    <h1>회원가입</h1>
    <p>새로운 계정을 만들어보세요</p>
</div>

<?php
use App\Core\Helper;
if (Helper::hasFlash('error')):
?>
<div class="alert alert-error">
    <?= Helper::getFlash('error') ?>
</div>
<?php endif; ?>

<form method="POST" action="/signup">
    <div class="form-group">
        <label for="email">이메일 *</label>
        <input type="email" id="email" name="email" required autofocus placeholder="email@example.com">
        <small>이메일이 로그인 아이디로 사용됩니다</small>
    </div>

    <div class="form-group">
        <label for="password">비밀번호 *</label>
        <input type="password" id="password" name="password" required>
        <small>최소 6자 이상</small>
    </div>

    <div class="form-group">
        <label for="password_confirm">비밀번호 확인 *</label>
        <input type="password" id="password_confirm" name="password_confirm" required>
    </div>

    <div class="form-group">
        <label for="name">이름 (선택사항)</label>
        <input type="text" id="name" name="name" placeholder="홍길동">
        <small>입력하지 않으면 자동으로 생성됩니다 (예: 밝은행복한호랑이)</small>
    </div>

    <button type="submit" class="btn">가입하기</button>
</form>

<div class="links">
    이미 계정이 있으신가요? <a href="/login">로그인</a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
?>
