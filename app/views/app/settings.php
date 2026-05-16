<div class="fade-in max-w-2xl">
    <div class="mb-6">
        <h1 class="text-lg font-semibold text-zinc-900">Settings</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Manage your account preferences</p>
    </div>

    <div id="settings-alert" class="hidden mb-4 px-3.5 py-3 rounded-lg text-sm"></div>

    <div class="bg-white border border-zinc-200 rounded-xl shadow-sm overflow-hidden mb-5">
        <div class="px-5 py-4 border-b border-zinc-100">
            <h2 class="text-sm font-semibold text-zinc-900">Notifications</h2>
        </div>
        <div class="divide-y divide-zinc-100">
            <?php foreach ([
                ['Email notifications', 'Receive updates via email', true],
                ['Security alerts',     'Get notified of login activity', true],
            ] as $t): ?>
            <div class="flex items-center justify-between px-5 py-4">
                <div>
                    <p class="text-sm font-medium text-zinc-900"><?= $t[0] ?></p>
                    <p class="text-xs text-zinc-400 mt-0.5"><?= $t[1] ?></p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" <?= $t[2] ? 'checked' : '' ?>>
                    <div class="w-9 h-5 bg-zinc-200 rounded-full peer peer-checked:bg-zinc-900 peer-focus:ring-2 peer-focus:ring-zinc-900 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex justify-end">
        <button onclick="Admin.saveSettings(this)"
            class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium rounded-lg transition-colors">
            Save changes
        </button>
    </div>
</div>
