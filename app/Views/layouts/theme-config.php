<!-- Tailwind CSS (Local) -->
<script src="/assets/js/tailwind.js"></script>

<!-- Tailwind CSS 다크모드 설정 -->
<script>
    tailwind.config = {
        darkMode: 'class',
    }
</script>

<style>
    /* 애니메이션 */
    @keyframes gradient {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .animate-gradient {
        animation: gradient 8s ease infinite;
    }

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    /* 브라우저 자동완성 스타일 오버라이드 */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
        -webkit-background-clip: text;
        -webkit-text-fill-color: #111827;
        transition: background-color 5000s ease-in-out 0s;
        box-shadow: inset 0 0 20px 20px #ffffff;
    }

    .dark input:-webkit-autofill,
    .dark input:-webkit-autofill:hover,
    .dark input:-webkit-autofill:focus,
    .dark input:-webkit-autofill:active {
        -webkit-text-fill-color: #ffffff;
        box-shadow: inset 0 0 20px 20px #334155;
    }

    input[readonly]:-webkit-autofill,
    input[readonly]:-webkit-autofill:hover,
    input[readonly]:-webkit-autofill:focus {
        box-shadow: inset 0 0 20px 20px #f9fafb;
    }

    .dark input[readonly]:-webkit-autofill,
    .dark input[readonly]:-webkit-autofill:hover,
    .dark input[readonly]:-webkit-autofill:focus {
        box-shadow: inset 0 0 20px 20px rgba(51, 65, 85, 0.5);
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
