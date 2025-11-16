<!-- Tailwind CSS (Local) -->
<script src="/assets/js/tailwind.js"></script>

<!-- Preline UI -->
<script src="https://cdn.jsdelivr.net/npm/preline@3.2.3/dist/preline.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/preline@3.2.3/src/plugins/accordion/variants.min.css">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }

    /* 라이트 모드 */
    :root {
        --bg-main: #ffffff;
        --bg-subtle: #f8fafc;
        --bg-muted: #f1f5f9;
        --text-primary: #0f172a;
        --text-secondary: #475569;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --primary: #3b82f6;
        --primary-hover: #2563eb;
        --primary-text: #ffffff;
        --card-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        --card-shadow-hover: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    /* 다크 모드 */
    .dark {
        --bg-main: #1e293b;
        --bg-subtle: #334155;
        --bg-muted: #475569;
        --text-primary: #f8fafc;
        --text-secondary: #e2e8f0;
        --text-muted: #cbd5e1;
        --border-color: #475569;
        --primary: #60a5fa;
        --primary-hover: #93c5fd;
        --primary-text: #ffffff;
        --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.5);
        --card-shadow-hover: 0 10px 15px -3px rgb(0 0 0 / 0.5);
    }

    /* Tailwind 커스텀 클래스 오버라이드 */
    .bg-background { background-color: var(--bg-main) !important; }
    .bg-muted { background-color: var(--bg-muted) !important; }
    .bg-card { background-color: var(--bg-main) !important; }
    .text-foreground { color: var(--text-primary) !important; }
    .text-muted-foreground { color: var(--text-muted) !important; }
    .border-border { border-color: var(--border-color) !important; }

    .hover\:bg-accent:hover { background-color: var(--bg-subtle) !important; }
    .hover\:text-accent-foreground:hover { color: var(--text-primary) !important; }

    /* 공통 유틸리티 */
    .space-y-6 > * + * {
        margin-top: 1.5rem;
    }

    .space-y-4 > * + * {
        margin-top: 1rem;
    }
</style>

<?php if (isset($additional_css)): ?>
<style><?= $additional_css ?></style>
<?php endif; ?>

<!-- 테마 로드 스크립트 (FOUC 방지) -->
<script>
    (function() {
        try {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.classList.toggle('dark', savedTheme === 'dark');
        } catch (e) {
            console.error('테마 로드 실패:', e);
        }
    })();
</script>
