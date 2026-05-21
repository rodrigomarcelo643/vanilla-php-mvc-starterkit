<div class="fade-in max-w-3xl">

    <div class="mb-6">
        <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Profile</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Your account information</p>
    </div>

    <!-- Skeleton -->
    <div id="app-profile-skeleton" class="grid md:grid-cols-3 gap-5">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 flex flex-col items-center gap-3 shadow-sm">
            <div class="skeleton-base w-20 h-20 rounded-full"></div>
            <div class="skeleton-base h-4 w-28 rounded"></div>
            <div class="skeleton-base h-3 w-36 rounded"></div>
            <div class="skeleton-base h-5 w-16 rounded-full"></div>
        </div>
        <div class="md:col-span-2 flex flex-col gap-5">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 space-y-4">
                <div class="skeleton-base h-4 w-32 rounded"></div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5"><div class="skeleton-base h-3 w-16 rounded mb-1"></div><div class="skeleton-base h-9 w-full rounded-lg"></div></div>
                    <div class="space-y-1.5"><div class="skeleton-base h-3 w-16 rounded mb-1"></div><div class="skeleton-base h-9 w-full rounded-lg"></div></div>
                </div>
                <div class="flex justify-end"><div class="skeleton-base h-9 w-28 rounded-lg"></div></div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 space-y-4">
                <div class="skeleton-base h-4 w-36 rounded"></div>
                <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="space-y-1.5"><div class="skeleton-base h-3 w-24 rounded mb-1"></div><div class="skeleton-base h-9 w-full rounded-lg"></div></div>
                <?php endfor; ?>
                <div class="flex justify-end"><div class="skeleton-base h-9 w-36 rounded-lg"></div></div>
            </div>
        </div>
    </div>

    <!-- Real content -->
    <div id="app-profile-content" style="display:none" class="grid md:grid-cols-3 gap-5">

        <!-- Avatar card -->
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 flex flex-col items-center text-center shadow-sm gap-3">
            <?php include 'app/views/components/shared/avatar-uploader.php'; ?>
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100" data-user-name><?= htmlspecialchars($user['name'] ?? '') ?></p>
            <p class="text-xs text-zinc-400 dark:text-zinc-500"><?= htmlspecialchars($user['email'] ?? '') ?></p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                <?= ucfirst($user['role'] ?? 'user') ?>
            </span>
        </div>

        <!-- Forms -->
        <div class="md:col-span-2 flex flex-col gap-5">
            <?php $headingInfo = 'Account Details'; include 'app/views/components/shared/profile-form.php'; ?>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sk = document.getElementById('app-profile-skeleton');
    const ct = document.getElementById('app-profile-content');
    if (sk && ct) {
        setTimeout(() => { sk.style.display = 'none'; ct.style.display = ''; }, 500);
    }
});
</script>
