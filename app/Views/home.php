<?php
$title = 'HaruCMS - 메인';
$additional_css = '
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 4rem 2rem;
    border-radius: 1.5rem;
    margin-bottom: 4rem;
    position: relative;
    overflow: hidden;
}
.hero-section::before {
    content: "";
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 15s ease-in-out infinite;
}
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}
.hero-content {
    position: relative;
    z-index: 1;
}
.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 1rem;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    letter-spacing: -0.02em;
}
.hero-subtitle {
    font-size: 1.25rem;
    color: rgba(255,255,255,0.95);
    margin-bottom: 2rem;
    font-weight: 400;
}
.user-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    padding: 0.75rem 1.5rem;
    border-radius: 2rem;
    border: 1px solid rgba(255,255,255,0.3);
    color: #ffffff;
    font-weight: 500;
    margin-top: 1rem;
}
.user-badge-icon {
    width: 24px;
    height: 24px;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}
.feature-card {
    background: var(--bg-main);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 2rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    text-decoration: none;
    display: block;
}
.feature-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}
.feature-card:hover::before {
    transform: scaleX(1);
}
.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border-color: var(--primary);
}
.feature-icon {
    width: 3.5rem;
    height: 3.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    color: #ffffff;
    box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
}
.feature-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
}
.feature-description {
    font-size: 0.95rem;
    color: var(--text-secondary);
    line-height: 1.6;
}
.feature-arrow {
    margin-top: 1rem;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 0;
    transform: translateX(-10px);
    transition: all 0.3s ease;
}
.feature-card:hover .feature-arrow {
    opacity: 1;
    transform: translateX(0);
}
.stats-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 4rem;
}
.stat-card {
    background: var(--bg-subtle);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
}
.stat-value {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
}
.stat-label {
    font-size: 0.875rem;
    color: var(--text-muted);
    font-weight: 500;
}
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    .hero-subtitle {
        font-size: 1.125rem;
    }
}
';
ob_start();
?>

<div class="max-w-6xl mx-auto">
    <?php
    use App\Core\Helper;
    ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content text-center">
            <h1 class="hero-title">HaruCMS</h1>
            <p class="hero-subtitle">경량, 빠름, 그리고 강력한 PHP CMS 솔루션</p>

            <?php if (Helper::isLoggedIn()): ?>
                <div class="user-badge">
                    <div class="user-badge-icon">👋</div>
                    <span><strong><?= htmlspecialchars(Helper::userName()) ?></strong>님 환영합니다!</span>
                </div>
            <?php else: ?>
                <div class="flex gap-3 justify-center mt-4">
                    <a href="/login" style="display: inline-block; padding: 0.75rem 2rem; background: rgba(255,255,255,0.95); color: #667eea; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: all 0.2s;">로그인</a>
                    <a href="/signup" style="display: inline-block; padding: 0.75rem 2rem; background: rgba(255,255,255,0.2); color: #ffffff; border: 1px solid rgba(255,255,255,0.3); border-radius: 0.5rem; font-weight: 600; text-decoration: none; backdrop-filter: blur(10px); transition: all 0.2s;">회원가입</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-value">100%</div>
            <div class="stat-label">오픈소스</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">0원</div>
            <div class="stat-label">라이선스 비용</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">5초</div>
            <div class="stat-label">설치 시간</div>
        </div>
    </div>

    <!-- Features Section -->
    <h2 style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 2rem; text-align: center;">주요 기능</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <a href="/boards/notice" class="feature-card">
            <div class="feature-icon">📢</div>
            <h3 class="feature-title">공지사항</h3>
            <p class="feature-description">중요한 공지사항과 업데이트를 확인하고 커뮤니티 소식을 받아보세요.</p>
            <div class="feature-arrow">
                자세히 보기 →
            </div>
        </a>

        <a href="/boards/free" class="feature-card">
            <div class="feature-icon">💬</div>
            <h3 class="feature-title">자유게시판</h3>
            <p class="feature-description">자유롭게 의견을 나누고 다른 사용자들과 소통할 수 있는 공간입니다.</p>
            <div class="feature-arrow">
                자세히 보기 →
            </div>
        </a>

        <?php if (Helper::isLoggedIn()): ?>
        <a href="/mypage" class="feature-card">
            <div class="feature-icon">👤</div>
            <h3 class="feature-title">마이페이지</h3>
            <p class="feature-description">프로필 정보를 관리하고 개인 설정을 변경할 수 있습니다.</p>
            <div class="feature-arrow">
                자세히 보기 →
            </div>
        </a>
        <?php endif; ?>

        <?php if (Helper::isAdmin()): ?>
        <a href="/admin" class="feature-card">
            <div class="feature-icon">⚙️</div>
            <h3 class="feature-title">관리자</h3>
            <p class="feature-description">사이트 전반을 관리하고 컨텐츠를 효율적으로 운영하세요.</p>
            <div class="feature-arrow">
                자세히 보기 →
            </div>
        </a>
        <?php endif; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layouts/default.php';
?>
