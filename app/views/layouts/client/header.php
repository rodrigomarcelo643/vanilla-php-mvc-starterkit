<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <?php include 'app/views/components/shared/head.php'; ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/animations.css">
</head>
<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased">
    <?php include 'app/views/components/shared/maintenance-banner.php'; ?>

    <?php if (empty($hideNavbar)): ?>
        <?php include 'app/views/components/client/navbar.php'; ?>
    <?php endif; ?>

    <main>
