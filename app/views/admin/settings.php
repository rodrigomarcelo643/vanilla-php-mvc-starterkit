<div class="fade-in max-w-3xl">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Settings</h1>
        <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">Manage your application settings</p>
    </div>

    <div id="settings-alert" class="hidden mb-4 px-4 py-3 rounded-lg text-sm font-medium"></div>

    <!-- Appearance -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800 p-6 mb-6">
        <h2 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-5">Appearance</h2>
        <div class="flex items-center justify-between py-2">
            <div>
                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Dark mode</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Switch between light and dark theme</p>
            </div>
            <button onclick="Theme.toggle()" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 transition-colors">
                <svg id="admin-settings-theme-icon-dark" class="w-3.5 h-3.5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                <svg id="admin-settings-theme-icon-light" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                <span id="admin-settings-theme-label">Dark mode</span>
            </button>
        </div>
    </div>

    <!-- General settings -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800 p-6 mb-6">
        <h2 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-5">General</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">App Name</label>
                <input type="text" value="<?= APP_NAME ?>"
                    class="w-full border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1.5">Admin Email</label>
                <input type="email" value="admin@example.com"
                    class="w-full border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-zinc-100 dark:border-zinc-800 p-6 mb-6">
        <h2 class="font-semibold text-zinc-900 dark:text-zinc-100 mb-5">Notifications</h2>
        <div class="space-y-4">
            <?php
            $toggles = [
                ['Email notifications', 'Receive email alerts for new registrations', true],
                ['Security alerts',     'Get notified about suspicious login attempts', true],
                ['Weekly reports',      'Receive weekly summary reports', false],
            ];
            foreach ($toggles as [$label, $desc, $checked]):
            ?>
            <div class="flex items-center justify-between py-2">
                <div>
                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100"><?= $label ?></p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5"><?= $desc ?></p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" <?= $checked ? 'checked' : '' ?>>
                    <div class="w-11 h-6 bg-zinc-200 dark:bg-zinc-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex justify-end">
        <button onclick="Admin.saveSettings(this)"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl transition flex items-center gap-2">
            Save Changes
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const isDark = document.documentElement.classList.contains('dark');
    document.getElementById('admin-settings-theme-icon-dark')?.classList.toggle('hidden', !isDark);
    document.getElementById('admin-settings-theme-icon-light')?.classList.toggle('hidden', isDark);
    const lbl = document.getElementById('admin-settings-theme-label');
    if (lbl) lbl.textContent = isDark ? 'Light mode' : 'Dark mode';

    const _toggle = Theme.toggle.bind(Theme);
    Theme.toggle = function() {
        _toggle();
        const dark = document.documentElement.classList.contains('dark');
        document.getElementById('admin-settings-theme-icon-dark')?.classList.toggle('hidden', !dark);
        document.getElementById('admin-settings-theme-icon-light')?.classList.toggle('hidden', dark);
        const l = document.getElementById('admin-settings-theme-label');
        if (l) l.textContent = dark ? 'Light mode' : 'Dark mode';
    };
});
</script>
