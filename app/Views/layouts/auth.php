<!DOCTYPE html>
<html lang="ko" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

    <?php require __DIR__ . '/theme-config.php'; ?>

    <style>
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
            box-shadow: 0 0 0 3px hsl(var(--ring) / 0.1);
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
            box-shadow: 0 0 0 3px hsl(var(--ring) / 0.3);
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
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .dark .alert-success {
            background-color: #14532d;
            color: #bbf7d0;
            border-color: #166534;
        }

        .dark .alert-error {
            background-color: #7f1d1d;
            color: #fecaca;
            border-color: #991b1b;
        }
    </style>
</head>
<body class="min-h-screen bg-background flex items-center justify-center p-5">
    <div class="w-full max-w-lg bg-background border border-border rounded-lg shadow-sm p-8">
        <?= $content ?>
    </div>
</body>
</html>
