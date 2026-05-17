<div class="fade-in max-w-2xl">
    <div class="mb-6">
        <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Settings</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Manage your account preferences</p>
    </div>

    <div id="settings-alert" class="hidden mb-4 px-3.5 py-3 rounded-lg text-sm"></div>

    <!-- Appearance -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Appearance</h2>
        </div>
        <div class="flex items-center justify-between px-5 py-4">
            <div>
                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Dark mode</p>
                <p class="text-xs text-zinc-400 mt-0.5">Switch between light and dark theme</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="settings-theme-toggle" class="sr-only peer" onchange="Theme.toggle()">
                <div class="w-11 h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
            </label>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notifications</h2>
        </div>
        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
            <?php foreach ([
                ['Email notifications', 'Receive updates via email', true],
                ['Security alerts',     'Get notified of login activity', true],
            ] as $t): ?>
            <div class="flex items-center justify-between px-5 py-4">
                <div>
                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100"><?= $t[0] ?></p>
                    <p class="text-xs text-zinc-400 mt-0.5"><?= $t[1] ?></p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" <?= $t[2] ? 'checked' : '' ?>>
                    <div class="w-11 h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-checked:bg-indigo-600 dark:peer-checked:bg-indigo-500 peer-focus:ring-2 peer-focus:ring-indigo-500 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex justify-end">
        <button onclick="Admin.saveSettings(this)"
            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-700 dark:hover:bg-zinc-300 text-white dark:text-zinc-900 text-sm font-medium rounded-lg transition-colors">
            Save changes
        </button>
    </div>
</div>

<script src="<?= BASE_URL ?>/js/settings.js"></script>
