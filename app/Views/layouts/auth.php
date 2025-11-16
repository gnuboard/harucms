<!DOCTYPE html>
<html lang="ko" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HaruCMS' ?></title>

    <!-- Tailwind CSS + DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* 커스텀 그라디언트 배경 */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        /* DaisyUI에 없는 커스텀 버튼 스타일 */
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        .btn-gradient:hover {
            opacity: 0.9;
        }
    </style>
    <?php if (isset($additional_css)): ?>
    <style><?= $additional_css ?></style>
    <?php endif; ?>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-5">
    <div class="card w-full max-w-lg bg-base-100 shadow-2xl">
        <div class="card-body">
            <?= $content ?>
        </div>
    </div>
</body>
</html>
