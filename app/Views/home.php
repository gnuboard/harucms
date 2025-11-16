<?php
$title = 'HaruCMS - 메인';
ob_start();
?>

<div class="container" style="text-align: center; max-width: 900px;">
    <div class="home-header" style="margin-bottom: 40px;">
        <h1 style="font-size: 48px; color: #333; margin-bottom: 20px;">환영합니다!</h1>
        <p style="color: #666; font-size: 18px;">저가형 호스팅 환경에 최적화된 경량 PHP CMS</p>
    </div>

    <?php
    use App\Core\Helper;

    if (Helper::isLoggedIn()):
    ?>
    <div style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 40px;">
        <p style="color: #333; font-size: 16px;">
            <strong style="color: #667eea;"><?= htmlspecialchars(Helper::userName()) ?></strong>님 환영합니다!
        </p>
    </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <a href="/boards/notice" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 30px 20px; border-radius: 8px; text-decoration: none; transition: transform 0.3s; display: flex; flex-direction: column; align-items: center; justify-content: center;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <h3 style="font-size: 20px; margin-bottom: 10px;">공지사항</h3>
            <p style="font-size: 14px; opacity: 0.9;">중요한 공지를 확인하세요</p>
        </a>
        <a href="/boards/free" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 30px 20px; border-radius: 8px; text-decoration: none; transition: transform 0.3s; display: flex; flex-direction: column; align-items: center; justify-content: center;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <h3 style="font-size: 20px; margin-bottom: 10px;">자유게시판</h3>
            <p style="font-size: 14px; opacity: 0.9;">자유롭게 소통하세요</p>
        </a>
        <?php if (Helper::isLoggedIn()): ?>
        <a href="/mypage" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 30px 20px; border-radius: 8px; text-decoration: none; transition: transform 0.3s; display: flex; flex-direction: column; align-items: center; justify-content: center;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <h3 style="font-size: 20px; margin-bottom: 10px;">마이페이지</h3>
            <p style="font-size: 14px; opacity: 0.9;">내 정보를 관리하세요</p>
        </a>
        <?php endif; ?>
        <?php if (Helper::isAdmin()): ?>
        <a href="/admin" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 30px 20px; border-radius: 8px; text-decoration: none; transition: transform 0.3s; display: flex; flex-direction: column; align-items: center; justify-content: center;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
            <h3 style="font-size: 20px; margin-bottom: 10px;">관리자</h3>
            <p style="font-size: 14px; opacity: 0.9;">사이트 관리 페이지</p>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/default.php';
?>
