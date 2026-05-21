<div class="fade-in max-w-3xl">

    <!-- Page header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Settings</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Manage your account preferences</p>
        </div>
        <span class="inline-flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
            All systems operational
        </span>
    </div>

    <!-- Skeleton -->
    <div id="app-settings-skeleton" class="space-y-4">
        <?php foreach ([['w-24', 1], ['w-20', 2], ['w-28', 3], ['w-24', 2]] as [$tw, $rows]): ?>
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="skeleton-base w-8 h-8 rounded-lg"></div>
                <div class="skeleton-base h-3.5 <?= $tw ?> rounded"></div>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                <?php for ($i = 0; $i < $rows; $i++): ?>
                <div class="flex items-center justify-between px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="skeleton-base w-8 h-8 rounded-lg"></div>
                        <div class="space-y-1.5">
                            <div class="skeleton-base h-3 w-32 rounded"></div>
                            <div class="skeleton-base h-2.5 w-48 rounded"></div>
                        </div>
                    </div>
                    <div class="skeleton-base h-6 w-11 rounded-full"></div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <div class="flex justify-end pt-2">
            <div class="skeleton-base h-9 w-32 rounded-lg"></div>
        </div>
    </div>

    <!-- Real content -->
    <div id="app-settings-content" style="display:none" class="space-y-4">

        <div id="settings-alert" class="hidden px-4 py-3 rounded-lg text-sm font-medium"></div>

        <!-- Appearance -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Appearance</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Customize how the interface looks</p>
                </div>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                <!-- Dark mode -->
                <div class="flex items-center justify-between px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Dark mode</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Switch between light and dark theme</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="settings-theme-toggle" class="sr-only peer" onchange="Theme.toggle()">
                        <div class="w-11 h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>
                <!-- Compact sidebar -->
                <div class="flex items-center justify-between px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Compact sidebar</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Collapse sidebar to icon-only mode by default</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- General -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">General</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Basic account configuration</p>
                </div>
            </div>
            <div class="px-5 py-5 space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Display Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <?php $u = Session::get('user'); ?>
                            <input type="text" value="<?= htmlspecialchars($u['name'] ?? '') ?>"
                                class="w-full h-9 pl-8 pr-3 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent transition">
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="email" value="<?= htmlspecialchars($u['email'] ?? '') ?>" readonly
                                class="w-full h-9 pl-8 pr-3 text-sm bg-zinc-100 dark:bg-zinc-800/60 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-400 dark:text-zinc-500 cursor-not-allowed">
                        </div>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500">Change your email from the <a href="<?= BASE_URL ?>/app/profile" class="text-indigo-500 hover:underline">Profile</a> page</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notifications</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Control what alerts you receive</p>
                </div>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                <?php
                $toggles = [
                    ['icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                     'label' => 'Email notifications', 'desc' => 'Receive updates and alerts via email', 'checked' => true,
                     'color' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'],
                    ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                     'label' => 'Security alerts', 'desc' => 'Get notified about suspicious login attempts', 'checked' => true,
                     'color' => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400'],
                    ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                     'label' => 'Weekly digest', 'desc' => 'Receive a weekly summary of your account activity', 'checked' => false,
                     'color' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400'],
                ];
                foreach ($toggles as $t):
                ?>
                <div class="flex items-center justify-between px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg <?= $t['color'] ?> flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="<?= $t['icon'] ?>"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100"><?= $t['label'] ?></p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5"><?= $t['desc'] ?></p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" <?= $t['checked'] ? 'checked' : '' ?>>
                        <div class="w-11 h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Security -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Security</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Session and access control preferences</p>
                </div>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                <div class="flex items-center justify-between px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Session timeout</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Auto-logout after inactivity</p>
                        </div>
                    </div>
                    <select class="h-8 px-2 text-xs bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition">
                        <option>30 minutes</option>
                        <option>1 hour</option>
                        <option selected>2 hours</option>
                        <option>8 hours</option>
                        <option>Never</option>
                    </select>
                </div>
                <div class="flex items-center justify-between px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Login activity log</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Track all login attempts and sessions</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-zinc-200 dark:bg-zinc-700 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Save footer -->
        <div class="flex items-center justify-between bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 rounded-xl px-5 py-4">
            <p class="text-xs text-zinc-400 dark:text-zinc-500">Changes are saved to your current session</p>
            <button onclick="Admin.saveSettings(this)"
                class="inline-flex items-center gap-2 h-9 px-5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Save Changes
            </button>
        </div>

    </div><!-- end app-settings-content -->
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sk = document.getElementById('app-settings-skeleton');
    const ct = document.getElementById('app-settings-content');
    if (sk && ct) {
        setTimeout(() => { sk.style.display = 'none'; ct.style.display = ''; }, 500);
    }
});
</script>

<script src="<?= BASE_URL ?>/js/settings.js"></script>
