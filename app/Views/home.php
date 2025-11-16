<?php
$title = 'HaruCMS - 메인';
ob_start();
?>

<div class="max-w-4xl mx-auto text-center">
    <div class="mb-12">
        <h1 class="text-5xl font-bold mb-4">환영합니다!</h1>
        <p class="text-lg text-muted-foreground">저가형 호스팅 환경에 최적화된 경량 PHP CMS</p>
    </div>

    <?php
    use App\Core\Helper;

    if (Helper::isLoggedIn()):
    ?>
    <div class="bg-muted border border-border rounded-lg p-6 mb-12">
        <p class="text-base">
            <strong class="font-semibold"><?= htmlspecialchars(Helper::userName()) ?></strong>님 환영합니다!
        </p>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <a href="/boards/notice" class="group bg-card border border-border rounded-lg p-8 transition-all hover:shadow-md hover:-translate-y-1 no-underline">
            <h3 class="text-xl font-semibold mb-2 text-foreground">공지사항</h3>
            <p class="text-sm text-muted-foreground">중요한 공지를 확인하세요</p>
        </a>
        <a href="/boards/free" class="group bg-card border border-border rounded-lg p-8 transition-all hover:shadow-md hover:-translate-y-1 no-underline">
            <h3 class="text-xl font-semibold mb-2 text-foreground">자유게시판</h3>
            <p class="text-sm text-muted-foreground">자유롭게 소통하세요</p>
        </a>
        <?php if (Helper::isLoggedIn()): ?>
        <a href="/mypage" class="group bg-card border border-border rounded-lg p-8 transition-all hover:shadow-md hover:-translate-y-1 no-underline">
            <h3 class="text-xl font-semibold mb-2 text-foreground">마이페이지</h3>
            <p class="text-sm text-muted-foreground">내 정보를 관리하세요</p>
        </a>
        <?php endif; ?>
        <?php if (Helper::isAdmin()): ?>
        <a href="/admin" class="group bg-card border border-border rounded-lg p-8 transition-all hover:shadow-md hover:-translate-y-1 no-underline">
            <h3 class="text-xl font-semibold mb-2 text-foreground">관리자</h3>
            <p class="text-sm text-muted-foreground">사이트 관리 페이지</p>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/default.php';
?>
