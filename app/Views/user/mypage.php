<?php
$title = '마이페이지 - HaruCMS';
ob_start();
?>

<div class="max-w-4xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold bg-clip-text bg-gradient-to-r from-blue-600 via-emerald-600 to-blue-600 text-transparent dark:from-blue-400 dark:via-emerald-400 dark:to-blue-400 mb-2">
            마이페이지
        </h1>
        <p class="text-gray-600 dark:text-slate-400">회원 정보를 확인하고 수정할 수 있습니다</p>
    </div>

    <?php
    use App\Core\Helper;

    if (Helper::hasFlash('success')):
    ?>
    <div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 text-sm mb-6">
        <?= Helper::getFlash('success') ?>
    </div>
    <?php endif; ?>

    <?php if (Helper::hasFlash('error')): ?>
    <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-sm mb-6">
        <?= Helper::getFlash('error') ?>
    </div>
    <?php endif; ?>

    <!-- User Info Card -->
    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-6 mb-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="flex items-center justify-center size-16 bg-gradient-to-br from-blue-600 to-emerald-600 rounded-full">
                <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($user['nickname'] ?? '사용자') ?></h2>
                <p class="text-sm text-gray-600 dark:text-slate-400"><?= htmlspecialchars($user['email'] ?? '') ?></p>
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div class="flex items-center gap-3 p-4 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-800/10 border border-blue-200 dark:border-blue-800/50 rounded-lg">
                <div class="flex items-center justify-center size-10 bg-blue-600 rounded-lg">
                    <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600 dark:text-slate-400 font-medium">가입일</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white"><?= Helper::formatDate($user['created_at'] ?? '', 'Y-m-d H:i:s') ?></p>
                </div>
            </div>

            <div class="flex items-center gap-3 p-4 bg-gradient-to-br from-emerald-50 to-emerald-100/50 dark:from-emerald-900/20 dark:to-emerald-800/10 border border-emerald-200 dark:border-emerald-800/50 rounded-lg">
                <div class="flex items-center justify-center size-10 bg-emerald-600 rounded-lg">
                    <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600 dark:text-slate-400 font-medium">마지막 로그인</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white"><?= Helper::timeAgo($user['last_login'] ?? '') ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Edit Form -->
    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 pb-4 border-b border-gray-200 dark:border-slate-700">
            프로필 수정
        </h2>

        <form method="POST" action="/mypage" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">이메일</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                    readonly
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700/50 text-gray-500 dark:text-slate-400 cursor-not-allowed"
                >
                <p class="mt-2 text-xs text-gray-600 dark:text-slate-400">이메일은 변경할 수 없습니다</p>
            </div>

            <div>
                <label for="nickname" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">닉네임</label>
                <input
                    type="text"
                    id="nickname"
                    name="nickname"
                    value="<?= htmlspecialchars($user['nickname'] ?? '') ?>"
                    placeholder="새 닉네임 입력"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
                >
                <p class="mt-2 text-xs text-gray-600 dark:text-slate-400">2자 이상 20자 이하 (변경하지 않으려면 비워두세요)</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">새 비밀번호</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="변경하지 않으려면 비워두세요"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
                >
                <p class="mt-2 text-xs text-gray-600 dark:text-slate-400">최소 6자 이상</p>
            </div>

            <div>
                <label for="password_confirm" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">새 비밀번호 확인</label>
                <input
                    type="password"
                    id="password_confirm"
                    name="password_confirm"
                    placeholder="새 비밀번호 확인"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all"
                >
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/40 hover:shadow-xl hover:shadow-emerald-500/50 dark:shadow-blue-500/30 dark:hover:shadow-emerald-500/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition-all duration-300 hover:-translate-y-0.5">
                수정하기
            </button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layouts/default.php';
?>
