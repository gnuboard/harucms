<?php
$title = '회원가입 - HaruCMS';
ob_start();
?>

<div class="space-y-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">회원가입</h2>
        <p class="text-gray-600 dark:text-slate-400">HaruCMS에 가입하고 시작하세요</p>
    </div>

    <?php
    use App\Core\Helper;
    if (Helper::hasFlash('error')):
    ?>
    <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-sm">
        <?= Helper::getFlash('error') ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="/signup" class="space-y-5">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">이메일</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                autofocus
                placeholder="email@example.com"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
            >
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">비밀번호</label>
            <input
                type="password"
                id="password"
                name="password"
                required
                placeholder="••••••••"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
            >
        </div>

        <div>
            <label for="password_confirm" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">비밀번호 확인</label>
            <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                required
                placeholder="••••••••"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
            >
        </div>

        <div>
            <label for="nickname" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">닉네임 (선택사항)</label>
            <input
                type="text"
                id="nickname"
                name="nickname"
                placeholder="홍길동"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
            >
            <p class="mt-2 text-xs text-gray-600 dark:text-slate-400">입력하지 않으면 자동으로 생성됩니다 (예: 밝은행복한호랑이)</p>
        </div>

        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/40 hover:shadow-xl hover:shadow-emerald-500/50 dark:shadow-blue-500/30 dark:hover:shadow-emerald-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-all duration-300 hover:-translate-y-0.5">
            가입하기
        </button>
    </form>

    <div class="text-center text-sm text-gray-600 dark:text-slate-400">
        이미 계정이 있으신가요? <a href="/login" class="text-blue-600 dark:text-blue-400 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors">로그인</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
?>
