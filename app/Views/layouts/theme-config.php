<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    border: 'var(--border)',
                    input: 'var(--input)',
                    ring: 'var(--ring)',
                    background: 'var(--background)',
                    foreground: 'var(--foreground)',
                    primary: {
                        DEFAULT: 'var(--primary)',
                        foreground: 'var(--primary-foreground)',
                    },
                    secondary: {
                        DEFAULT: 'var(--secondary)',
                        foreground: 'var(--secondary-foreground)',
                    },
                    muted: {
                        DEFAULT: 'var(--muted)',
                        foreground: 'var(--muted-foreground)',
                    },
                    accent: {
                        DEFAULT: 'var(--accent)',
                        foreground: 'var(--accent-foreground)',
                    },
                    card: {
                        DEFAULT: 'var(--card)',
                        foreground: 'var(--card-foreground)',
                    },
                    destructive: {
                        DEFAULT: 'var(--destructive)',
                        foreground: 'var(--destructive-foreground)',
                    },
                },
            }
        }
    }
</script>

<style>
    :root {
        /* 라이트 모드 - 선명한 파란색 테마 */
        --background: #ffffff;
        --foreground: #0f172a;
        --card: #ffffff;
        --card-foreground: #0f172a;
        --muted: #f1f5f9;
        --muted-foreground: #64748b;
        --border: #e2e8f0;
        --input: #e2e8f0;

        /* 메인 파란색 - 선명하고 진한 블루 */
        --primary: #1d4ed8;
        --primary-foreground: #ffffff;

        --secondary: #f1f5f9;
        --secondary-foreground: #0f172a;

        --accent: #dbeafe;
        --accent-foreground: #1e40af;

        --destructive: #dc2626;
        --destructive-foreground: #ffffff;

        --ring: #3b82f6;
    }

    .dark {
        /* 다크 모드 - 네이비 배경 + 밝은 블루 */
        --background: #0f172a;
        --foreground: #f1f5f9;
        --card: #1e293b;
        --card-foreground: #f1f5f9;
        --muted: #1e293b;
        --muted-foreground: #94a3b8;
        --border: #334155;
        --input: #334155;

        /* 다크모드 메인 색상 - 밝은 스카이 블루 */
        --primary: #3b82f6;
        --primary-foreground: #ffffff;

        --secondary: #1e293b;
        --secondary-foreground: #f1f5f9;

        --accent: #1e40af;
        --accent-foreground: #93c5fd;

        --destructive: #ef4444;
        --destructive-foreground: #f1f5f9;

        --ring: #60a5fa;
    }

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
