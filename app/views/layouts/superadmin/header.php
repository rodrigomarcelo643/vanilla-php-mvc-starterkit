<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Super Admin') ?> — <?= APP_NAME ?></title>
    <script>if(localStorage.getItem('theme')==='dark')document.documentElement.classList.add('dark');</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { primary: { DEFAULT: '#7C3AED', hover: '#6D28D9' } } } }
        }
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/animations.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/skeleton.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased"
      x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        isMobile: window.innerWidth < 1024,
        hovered: false
      }"
      x-init="
        $watch('isMobile', val => { if (!val) sidebarOpen = true; });
        window.addEventListener('resize', () => {
            isMobile = window.innerWidth < 1024;
        });
      ">

<div class="flex h-screen">

    <?php include 'app/views/components/superadmin/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">

        <?php include 'app/views/components/superadmin/topbar.php'; ?>

        <main class="flex-1 overflow-y-auto p-4 lg:p-6" style="overflow-anchor:none">
