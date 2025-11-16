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
        /* 더 모던한 색상 팔레트 - Zinc 기반 */
        --background: 0 0% 100%;
        --foreground: 240 10% 3.9%;
        --card: 0 0% 100%;
        --card-foreground: 240 10% 3.9%;
        --muted: 240 4.8% 95.9%;
        --muted-foreground: 240 3.8% 46.1%;
        --border: 240 5.9% 90%;
        --input: 240 5.9% 90%;

        /* 모던한 블루-바이올렛 primary */
        --primary: 262.1 83.3% 57.8%;
        --primary-foreground: 210 20% 98%;

        --secondary: 240 4.8% 95.9%;
        --secondary-foreground: 240 5.9% 10%;

        /* 호버 효과를 위한 accent */
        --accent: 240 4.8% 95.9%;
        --accent-foreground: 240 5.9% 10%;

        --destructive: 0 84.2% 60.2%;
        --destructive-foreground: 0 0% 98%;

        --ring: 262.1 83.3% 57.8%;
    }

    .dark {
        --background: 224 71.4% 4.1%;
        --foreground: 210 20% 98%;
        --card: 224 71.4% 4.1%;
        --card-foreground: 210 20% 98%;
        --muted: 215 27.9% 16.9%;
        --muted-foreground: 217.9 10.6% 64.9%;
        --border: 215 27.9% 16.9%;
        --input: 215 27.9% 16.9%;

        /* 다크모드에서 더 밝고 선명한 primary */
        --primary: 263.4 70% 50.4%;
        --primary-foreground: 210 20% 98%;

        --secondary: 215 27.9% 16.9%;
        --secondary-foreground: 210 20% 98%;

        --accent: 215 27.9% 16.9%;
        --accent-foreground: 210 20% 98%;

        --destructive: 0 62.8% 30.6%;
        --destructive-foreground: 0 0% 98%;

        --ring: 263.4 70% 50.4%;
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
