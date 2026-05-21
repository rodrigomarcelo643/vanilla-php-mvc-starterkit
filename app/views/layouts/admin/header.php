<?php $tailwindConfig = ['DEFAULT' => '#4F46E5', 'hover' => '#4338CA']; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <?php include 'app/views/components/shared/head.php'; ?>
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

    <?php include 'app/views/components/admin/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">

        <?php include 'app/views/components/admin/topbar.php'; ?>

        <main class="flex-1 overflow-y-auto p-4 lg:p-6" style="overflow-anchor:none">
