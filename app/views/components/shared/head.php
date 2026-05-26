<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#18181b">
<meta name="csrf-token" content="<?= defined('CSRF_TOKEN') ? CSRF_TOKEN : '' ?>">
<title><?= htmlspecialchars($title ?? APP_NAME) ?> — <?= APP_NAME ?></title>
<link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/favicon.svg">
<script>if(localStorage.getItem('theme')==='dark')document.documentElement.classList.add('dark');</script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
        <?php if (!empty($tailwindConfig)): ?>
        theme: { extend: { colors: { primary: <?= json_encode($tailwindConfig) ?> } } }
        <?php endif; ?>
    };
</script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
