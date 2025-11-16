<!DOCTYPE html>
<html lang="ko" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

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
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 240 10% 3.9%;
            --muted: 240 4.8% 95.9%;
            --muted-foreground: 240 3.8% 46.1%;
            --border: 240 5.9% 90%;
            --input: 240 5.9% 90%;
            --primary: 240 5.9% 10%;
            --primary-foreground: 0 0% 98%;
            --secondary: 240 4.8% 95.9%;
            --secondary-foreground: 240 5.9% 10%;
            --accent: 240 4.8% 95.9%;
            --accent-foreground: 240 5.9% 10%;
            --ring: 240 5.9% 10%;
        }

        .dark {
            --background: 240 10% 3.9%;
            --foreground: 0 0% 98%;
            --muted: 240 3.7% 15.9%;
            --muted-foreground: 240 5% 64.9%;
            --border: 240 3.7% 15.9%;
            --input: 240 3.7% 15.9%;
            --primary: 0 0% 98%;
            --primary-foreground: 240 5.9% 10%;
            --secondary: 240 3.7% 15.9%;
            --secondary-foreground: 0 0% 98%;
            --accent: 240 3.7% 15.9%;
            --accent-foreground: 0 0% 98%;
            --ring: 240 4.9% 83.9%;
        }

        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .auth-header h1 {
            font-size: 1.875rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: hsl(var(--muted-foreground));
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid hsl(var(--border));
            border-radius: 0.375rem;
            background-color: hsl(var(--background));
            color: hsl(var(--foreground));
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: hsl(var(--ring));
            box-shadow: 0 0 0 3px hsla(var(--ring), 0.1);
        }

        .form-group small {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.75rem;
            color: hsl(var(--muted-foreground));
        }

        .btn {
            width: 100%;
            padding: 0.625rem 1rem;
            background-color: hsl(var(--primary));
            color: hsl(var(--primary-foreground));
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px hsla(var(--ring), 0.3);
        }

        .links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: hsl(var(--muted-foreground));
        }

        .links a {
            color: hsl(var(--primary));
            text-decoration: none;
            transition: all 0.2s;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background-color: hsl(142.1 76.2% 96.3%);
            color: hsl(142.1 76.2% 26.3%);
            border: 1px solid hsl(142.1 76.2% 86.3%);
        }

        .alert-error {
            background-color: hsl(0 84.2% 96.5%);
            color: hsl(0 84.2% 40.2%);
            border: 1px solid hsl(0 84.2% 86.5%);
        }

        .dark .alert-success {
            background-color: hsl(142.1 76.2% 13.9%);
            color: hsl(142.1 76.2% 76.3%);
            border-color: hsl(142.1 76.2% 23.9%);
        }

        .dark .alert-error {
            background-color: hsl(0 84.2% 13.9%);
            color: hsl(0 84.2% 76.3%);
            border-color: hsl(0 84.2% 23.9%);
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
</head>
<body class="min-h-screen bg-background flex items-center justify-center p-5">
    <div class="w-full max-w-lg bg-background border border-border rounded-lg shadow-sm p-8">
        <?= $content ?>
    </div>
</body>
</html>
