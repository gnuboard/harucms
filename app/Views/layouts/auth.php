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
            color: var(--text-primary);
        }

        .auth-header p {
            color: var(--text-muted);
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
            color: var(--text-primary);
        }

        .form-group input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            background-color: var(--bg-main);
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: all 0.15s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group small {
            display: block;
            margin-top: 0.375rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .btn {
            width: 100%;
            padding: 0.625rem 1rem;
            background-color: var(--primary);
            color: var(--primary-text);
            border: none;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .links a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.15s ease;
            font-weight: 500;
        }

        .links a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .alert {
            padding: 0.875rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            border: 1px solid;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border-color: #86efac;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
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
