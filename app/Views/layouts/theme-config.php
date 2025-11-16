<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        theme: {
            extend: {
                colors: {
                    border: 'hsl(var(--border))',
                    input: 'hsl(var(--input))',
                    ring: 'hsl(var(--ring))',
                    background: 'hsl(var(--background))',
                    foreground: 'hsl(var(--foreground))',
                    primary: {
                        DEFAULT: 'hsl(var(--primary))',
                        foreground: 'hsl(var(--primary-foreground))',
                    },
                    secondary: {
                        DEFAULT: 'hsl(var(--secondary))',
                        foreground: 'hsl(var(--secondary-foreground))',
                    },
                    muted: {
                        DEFAULT: 'hsl(var(--muted))',
                        foreground: 'hsl(var(--muted-foreground))',
                    },
                    accent: {
                        DEFAULT: 'hsl(var(--accent))',
                        foreground: 'hsl(var(--accent-foreground))',
                    },
                    card: {
                        DEFAULT: 'hsl(var(--card))',
                        foreground: 'hsl(var(--card-foreground))',
                    },
                    destructive: {
                        DEFAULT: 'hsl(var(--destructive))',
                        foreground: 'hsl(var(--destructive-foreground))',
                    },
                },
            }
        }
    }
</script>

<style>
    :root {
        /* 선명한 파란색 계열 색상 팔레트 */
        --background: 0 0% 100%;
        --foreground: 220 13% 13%;
        --card: 0 0% 100%;
        --card-foreground: 220 13% 13%;
        --muted: 214 32% 91%;
        --muted-foreground: 215 14% 34%;
        --border: 214 32% 85%;
        --input: 214 32% 85%;

        /* 진하고 선명한 파란색 primary - #2563eb (Blue 600) */
        --primary: 217 91% 60%;
        --primary-foreground: 0 0% 100%;

        --secondary: 214 95% 93%;
        --secondary-foreground: 217 91% 60%;

        /* 파란색 accent */
        --accent: 214 95% 93%;
        --accent-foreground: 217 91% 60%;

        --destructive: 0 84% 60%;
        --destructive-foreground: 0 0% 98%;

        --ring: 217 91% 60%;
    }

    .dark {
        /* 다크 블루 배경 */
        --background: 220 26% 14%;
        --foreground: 213 31% 91%;
        --card: 220 26% 14%;
        --card-foreground: 213 31% 91%;
        --muted: 217 33% 17%;
        --muted-foreground: 215 20% 65%;
        --border: 217 33% 24%;
        --input: 217 33% 24%;

        /* 다크모드용 밝은 스카이블루 - #60a5fa (Blue 400) */
        --primary: 213 94% 68%;
        --primary-foreground: 220 26% 14%;

        --secondary: 217 33% 17%;
        --secondary-foreground: 213 31% 91%;

        --accent: 217 33% 24%;
        --accent-foreground: 213 94% 68%;

        --destructive: 0 63% 31%;
        --destructive-foreground: 213 31% 91%;

        --ring: 213 94% 68%;
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
