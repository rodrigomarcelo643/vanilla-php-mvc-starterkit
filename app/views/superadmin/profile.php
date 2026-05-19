<div class="fade-in max-w-3xl">

    <div class="mb-6">
        <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Profile</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Manage your super admin account</p>
    </div>

    <div class="grid md:grid-cols-3 gap-5">

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 flex flex-col items-center text-center shadow-sm gap-3">
            <?php include 'app/views/components/shared/avatar-uploader.php'; ?>
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100" data-user-name><?= htmlspecialchars($user['name'] ?? '') ?></p>
            <p class="text-xs text-zinc-400 dark:text-zinc-500"><?= htmlspecialchars($user['email'] ?? '') ?></p>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Super Admin
            </span>
        </div>

        <div class="md:col-span-2 flex flex-col gap-5">
            <?php include 'app/views/components/shared/profile-form.php'; ?>
        </div>

    </div>
</div>
