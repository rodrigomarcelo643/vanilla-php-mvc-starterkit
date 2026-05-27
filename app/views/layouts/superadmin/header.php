<?php $tailwindConfig = ['DEFAULT' => '#7C3AED', 'hover' => '#6D28D9']; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <?php include 'app/views/components/shared/head.php'; ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/animations.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/skeleton.css">
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased flex flex-col h-screen overflow-hidden"
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

<?php include 'app/views/components/shared/maintenance-banner.php'; ?>

<div class="flex flex-1 overflow-hidden">

    <?php include 'app/views/components/superadmin/sidebar.php'; ?>

    <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">

        <?php include 'app/views/components/superadmin/topbar.php'; ?>

        <main class="flex-1 overflow-y-auto p-4 lg:p-6" style="overflow-anchor:none">
