<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? APP_NAME) ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/animations.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-zinc-50 text-zinc-900 antialiased"
      x-data="{
        sidebarOpen: window.innerWidth >= 1024,
        isMobile: window.innerWidth < 1024,
        hovered: false
      }"
      x-init="
        $watch('isMobile', val => { if (!val) sidebarOpen = true; });
        window.addEventListener('resize', () => { isMobile = window.innerWidth < 1024; });
      ">

<div class="flex h-screen overflow-hidden">

    <?php include 'app/views/components/app/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden transition-all duration-300">

        <?php include 'app/views/components/app/topbar.php'; ?>

        <main class="flex-1 overflow-y-auto p-4 lg:p-6">
