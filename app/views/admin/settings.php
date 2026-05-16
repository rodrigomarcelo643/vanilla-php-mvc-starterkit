<div class="fade-in max-w-3xl">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
        <p class="text-gray-500 text-sm mt-1">Manage your application settings</p>
    </div>

    <div id="settings-alert" class="hidden mb-4 px-4 py-3 rounded-lg text-sm font-medium"></div>

    <!-- General settings -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-semibold text-gray-900 mb-5">General</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">App Name</label>
                <input type="text" value="<?= APP_NAME ?>"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Admin Email</label>
                <input type="email" value="admin@example.com"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="font-semibold text-gray-900 mb-5">Notifications</h2>
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
                    <p class="text-sm font-medium text-gray-900"><?= $label ?></p>
                    <p class="text-xs text-gray-500 mt-0.5"><?= $desc ?></p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" <?= $checked ? 'checked' : '' ?>>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
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
