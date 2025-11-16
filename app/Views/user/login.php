<?php
$title = '로그인 - HaruCMS';
ob_start();
?>

<div class="space-y-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">로그인</h2>
        <p class="text-gray-600 dark:text-slate-400">HaruCMS에 오신 것을 환영합니다</p>
    </div>

    <?php
    use App\Core\Helper;
    if (Helper::hasFlash('success')):
    ?>
    <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 text-sm">
        <?= Helper::getFlash('success') ?>
    </div>
    <?php endif; ?>

    <?php if (Helper::hasFlash('error')): ?>
    <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-sm">
        <?= Helper::getFlash('error') ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="/login" class="space-y-5">
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
                class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
            >
        </div>

        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/40 hover:shadow-xl hover:shadow-emerald-500/50 dark:shadow-blue-500/30 dark:hover:shadow-emerald-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-all duration-300 hover:-translate-y-0.5">
            로그인
        </button>
    </form>

    <div class="flex items-center justify-center gap-2 text-sm text-gray-600 dark:text-slate-400">
        <a href="/signup" class="text-blue-600 dark:text-blue-400 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors">회원가입</a>
        <span>|</span>
        <a href="/" class="text-blue-600 dark:text-blue-400 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors">메인으로</a>
        <span>|</span>
        <a href="/admin/login" class="text-blue-600 dark:text-blue-400 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors">관리자</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/auth.php';
?>
