<div class="fade-in max-w-3xl">

    <div class="mb-6">
        <h1 class="text-lg font-semibold text-zinc-900">Profile</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account information</p>
    </div>

    <div class="grid md:grid-cols-3 gap-5">

        <!-- Avatar card -->
        <div class="bg-white border border-zinc-200 rounded-xl p-6 flex flex-col items-center text-center shadow-sm gap-3">
            <?php include 'app/views/components/shared/avatar-uploader.php'; ?>
            <p class="text-sm font-semibold text-zinc-900" data-user-name><?= htmlspecialchars($user['name'] ?? '') ?></p>
            <p class="text-xs text-zinc-400"><?= htmlspecialchars($user['email'] ?? '') ?></p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-700">
                <?= ucfirst($user['role'] ?? 'admin') ?>
            </span>
        </div>

        <!-- Forms -->
        <div class="md:col-span-2 flex flex-col gap-5">
            <?php include 'app/views/components/shared/profile-form.php'; ?>
        </div>

    </div>
</div>
