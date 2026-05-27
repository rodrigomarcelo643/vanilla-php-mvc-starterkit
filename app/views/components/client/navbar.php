<?php
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base        = trim(BASE_URL, '/');
if ($base && str_starts_with($currentPath, $base)) {
    $currentPath = trim(substr($currentPath, strlen($base)), '/');
}
$currentPath = $currentPath ?: '/';

$githubRepo = 'rodrigomarcelo643/php-vanilla-mvc-starterkit';
$githubUrl  = 'https://github.com/' . $githubRepo;

$navLinks = [
    ['href' => '/',      'label' => 'Home'],
    ['href' => '/about', 'label' => 'About'],
    ['href' => '/docs',  'label' => 'Docs'],
    ['href' => '/blog',  'label' => 'Blog'],
];

$u           = Auth::check() ? Session::get('user') : null;
    $role      = $u['role'] ?? '';
    $isAdmin   = $role === 'admin';
    $isSuper   = $role === 'superadmin';
    $dashUrl   = $isSuper ? BASE_URL . '/superadmin/dashboard' : ($isAdmin ? BASE_URL . '/admin/dashboard' : BASE_URL . '/app/home');
    $profileUrl = $isSuper ? BASE_URL . '/superadmin/profile' : ($isAdmin ? BASE_URL . '/admin/profile' : BASE_URL . '/app/profile');
    $settingsUrl = $isSuper ? BASE_URL . '/superadmin/settings' : ($isAdmin ? BASE_URL . '/admin/settings' : BASE_URL . '/app/settings');
?>

<!-- Navbar -->
<nav class="sticky top-0 z-40 bg-white/95 dark:bg-zinc-950/95 backdrop-blur-sm border-b border-zinc-200 dark:border-zinc-800"
    x-data="{ open: false, drop: false, stars: '...' }" x-init="fetch('https://api.github.com/repos/<?= $githubRepo ?>').then(r => r.json()).then(d => stars = d.stargazers_count || 0).catch(() => stars = 0)">

    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center h-14 gap-4">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 shrink-0">
                <div class="w-7 h-7 rounded-lg bg-zinc-900 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span
                    class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight"><?= APP_NAME ?></span>
            </a>

            <div class="hidden md:block w-px h-4 bg-zinc-200 dark:bg-zinc-700 shrink-0"></div>

            <!-- Nav links -->
            <div class="hidden md:flex items-center gap-0.5 flex-1">
                <?php foreach ($navLinks as $link):
                    $path   = trim($link['href'], '/') ?: '/';
                    $active = ($currentPath === $path);
                ?>
                <a href="<?= BASE_URL . $link['href'] ?>"
                    class="px-3 py-1.5 text-sm rounded-md transition-colors <?= $active ? 'text-zinc-900 dark:text-zinc-100 font-medium bg-zinc-100 dark:bg-zinc-800' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-50 dark:hover:bg-zinc-800' ?>">
                    <?= $link['label'] ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Right actions -->
            <div class="hidden md:flex items-center gap-2 ml-auto shrink-0">

                <!-- Theme toggle -->
                <button onclick="Theme.toggle()"
                    class="inline-flex items-center justify-center w-8 h-8 text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-md transition-colors">
                    <svg id="theme-icon-dark" class="w-3.5 h-3.5 hidden" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                    <svg id="theme-icon-light" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Follow -->
                <a href="https://github.com/rodrigomarcelo643" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-1.5 h-8 px-3 text-xs font-medium text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-md transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                    </svg>
                    Follow
                </a>

                <!-- GitHub Star -->
                <a href="<?= $githubUrl ?>" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-1.5 h-8 px-3 text-xs font-medium text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-md transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                    </svg>
                    Star
                    <span x-text="stars"
                        class="px-1.5 py-0.5 text-[10px] bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 rounded font-mono">...</span>
                </a>

                <div class="w-px h-4 bg-zinc-200 dark:bg-zinc-700"></div>

                <?php if ($u): ?>
                <!-- User dropdown — relative wrapper fixes absolute positioning -->
                <div class="relative">
                    <button @click="drop = !drop"
                        class="flex items-center gap-2 h-8 pl-1.5 pr-2.5 border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-md transition-colors focus:outline-none">
                        <div class="w-5 h-5 rounded-full bg-zinc-900 flex items-center justify-center text-white shrink-0 overflow-hidden"
                            style="font-size:9px;font-weight:700">
                            <?php if (!empty($u['avatar'])): ?>
                            <img data-avatar-img src="<?= htmlspecialchars($u['avatar']) ?>"
                                class="w-full h-full object-cover">
                            <?php else: ?>
                            <span data-avatar-initials><?= strtoupper(substr($u['name'] ?? 'U', 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <span class="text-sm text-zinc-700 dark:text-zinc-300 font-medium"
                            data-user-name><?= htmlspecialchars($u['name'] ?? '') ?></span>
                        <svg class="w-3 h-3 text-zinc-400 transition-transform duration-150"
                            :class="drop ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="drop" @click.away="drop = false" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 top-full mt-2 w-52 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-lg py-1 z-50 origin-top-right"
                        style="display:none">

                        <div class="px-3 py-2.5 border-b border-zinc-100 dark:border-zinc-800">
                            <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 truncate" data-user-name>
                                <?= htmlspecialchars($u['name'] ?? '') ?></p>
                            <p class="text-xs text-zinc-400 truncate mt-0.5" data-user-email>
                                <?= htmlspecialchars($u['email'] ?? '') ?></p>
                        </div>

                        <div class="py-1">
                            <a href="<?= $dashUrl ?>"
                                class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="<?= $profileUrl ?>"
                                class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            <a href="<?= $settingsUrl ?>"
                                class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Settings
                            </a>
                        </div>

                        <div class="border-t border-zinc-100 dark:border-zinc-800 py-1">
                            <button onclick="App.logout()"
                                class="flex items-center gap-2.5 w-full px-3 py-1.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-950 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sign out
                            </button>
                        </div>
                    </div>
                </div>

                <?php else: ?>
                <a href="<?= BASE_URL ?>/login"
                    class="h-8 px-3 inline-flex items-center text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-md transition-colors">
                    Sign in
                </a>
                <a href="<?= BASE_URL ?>/register"
                    class="h-8 px-3 inline-flex items-center text-sm font-medium bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 hover:bg-zinc-700 dark:hover:bg-zinc-300 rounded-md transition-colors">
                    Get started
                </a>
                <?php endif; ?>
            </div>

            <!-- Mobile hamburger -->
            <button @click="open = !open"
                class="md:hidden ml-auto inline-flex items-center justify-center w-8 h-8 rounded-md text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" 
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" 
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden border-t border-zinc-100 dark:border-zinc-800 bg-white/98 dark:bg-zinc-950/98 backdrop-blur-md px-4 py-5 shadow-2xl max-h-[85vh] overflow-y-auto space-y-6"
        style="display:none">

        <!-- Section: Navigation links with clean modern styling -->
        <div>
            <span class="block text-[10px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 mb-2 px-3">Navigation</span>
            <div class="grid grid-cols-2 gap-2">
                <?php foreach ($navLinks as $link):
                    $path   = trim($link['href'], '/') ?: '/';
                    $active = ($currentPath === $path);
                    
                    // Simple custom icon choosing based on label
                    $iconSvg = '';
                    if ($link['label'] === 'Home') {
                        $iconSvg = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>';
                    } elseif ($link['label'] === 'About') {
                        $iconSvg = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>';
                    } elseif ($link['label'] === 'Docs') {
                        $iconSvg = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>';
                    } else {
                        $iconSvg = '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v6a2 2 0 01-2 2h-2m0 0V9a2 2 0 00-2-2h-2M9 5.5V12m-3-3.5L9 12l3-3.5"/></svg>';
                    }
                ?>
                <a href="<?= BASE_URL . $link['href'] ?>"
                    class="flex items-center gap-2.5 px-3 py-2.5 text-sm rounded-xl transition-all <?= $active ? 'text-zinc-900 dark:text-zinc-50 font-medium bg-zinc-100 dark:bg-zinc-800/80 border border-zinc-200/50 dark:border-zinc-700/50' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 hover:text-zinc-900 dark:hover:text-zinc-100 border border-transparent' ?>">
                    <span class="<?= $active ? 'text-zinc-950 dark:text-zinc-100' : 'text-zinc-400 dark:text-zinc-500' ?>">
                        <?= $iconSvg ?>
                    </span>
                    <?= $link['label'] ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Section: Community -->
        <div>
            <span class="block text-[10px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 mb-2 px-3">Community</span>
            <div class="space-y-1.5">
                <a href="https://github.com/rodrigomarcelo643" target="_blank" rel="noopener"
                    class="flex items-center justify-between gap-3 px-3.5 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 rounded-xl transition-colors border border-transparent hover:border-zinc-100 dark:hover:border-zinc-800/50">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                        </svg>
                        <span>Follow on GitHub</span>
                    </div>
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="<?= $githubUrl ?>" target="_blank" rel="noopener"
                    class="flex items-center justify-between gap-3 px-3.5 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 rounded-xl transition-colors border border-transparent hover:border-zinc-100 dark:hover:border-zinc-800/50">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-amber-500 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span>Star Repository</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="px-2 py-0.5 text-xs bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded-md font-mono font-medium border border-zinc-200/50 dark:border-zinc-700/50" x-text="stars">...</span>
                        <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Section: User Account or Auth CTAs -->
        <div class="border-t border-zinc-100 dark:border-zinc-800/80 pt-5">
            <?php if ($u): ?>
                <!-- Clean interactive card for Logged-In User -->
                <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-100 dark:border-zinc-850 rounded-2xl p-4 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-zinc-900 dark:bg-zinc-700 flex items-center justify-center text-white shrink-0 overflow-hidden border-2 border-white dark:border-zinc-800 shadow-md font-semibold text-sm">
                            <?php if (!empty($u['avatar'])): ?>
                                <img data-avatar-img src="<?= htmlspecialchars($u['avatar']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span data-avatar-initials><?= strtoupper(substr($u['name'] ?? 'U', 0, 1)) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate" data-user-name><?= htmlspecialchars($u['name'] ?? '') ?></p>
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 truncate" data-user-email><?= htmlspecialchars($u['email'] ?? '') ?></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <a href="<?= $dashUrl ?>"
                        class="flex items-center justify-center gap-2 h-10 px-3 text-sm font-medium border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900/80 rounded-xl transition-all">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        Dashboard
                    </a>
                    <a href="<?= $profileUrl ?>"
                        class="flex items-center justify-center gap-2 h-10 px-3 text-sm font-medium border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900/80 rounded-xl transition-all">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profile
                    </a>
                    <a href="<?= $settingsUrl ?>"
                        class="flex items-center justify-center gap-2 h-10 px-3 text-sm font-medium border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900/80 rounded-xl transition-all">
                        <svg class="w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Settings
                    </a>
                    <button onclick="App.logout()"
                        class="flex items-center justify-center gap-2 h-10 px-3 text-sm font-semibold bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-950/60 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sign out
                    </button>
                </div>
            <?php else: ?>
                <!-- Beautiful CTAs for Visitors -->
                <div class="grid grid-cols-2 gap-3 px-1">
                    <a href="<?= BASE_URL ?>/login"
                        class="flex items-center justify-center h-11 text-sm font-medium border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 rounded-xl transition-all">
                        Sign in
                    </a>
                    <a href="<?= BASE_URL ?>/register"
                        class="flex items-center justify-center h-11 text-sm font-semibold bg-zinc-900 dark:bg-zinc-50 text-white dark:text-zinc-950 hover:bg-zinc-800 dark:hover:bg-zinc-200 rounded-xl transition-all shadow-md">
                        Get started
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Section: Interactive Theme Preferences -->
        <div class="border-t border-zinc-100 dark:border-zinc-800/80 pt-5">
            <span class="block text-[10px] font-bold uppercase tracking-wider text-zinc-400 dark:text-zinc-500 mb-2 px-3">Preferences</span>
            <button onclick="Theme.toggle()"
                class="flex items-center justify-between w-full px-3.5 py-2.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 rounded-xl transition-colors border border-transparent hover:border-zinc-100 dark:hover:border-zinc-800/50">
                <div class="flex items-center gap-2.5">
                    <svg id="theme-icon-dark-mobile" class="w-4 h-4 text-zinc-500 dark:text-zinc-400 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                    <svg id="theme-icon-light-mobile" class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <span id="theme-label-mobile">Dark mode</span>
                </div>
                <!-- Interactive Toggle Pill Switch -->
                <div class="w-9 h-5 bg-zinc-200 dark:bg-zinc-800 rounded-full p-0.5 transition-colors relative flex items-center">
                    <div class="w-4 h-4 bg-white dark:bg-zinc-450 rounded-full shadow-md transform transition-transform duration-200 translate-x-0 dark:translate-x-4"></div>
                </div>
            </button>
        </div>

    </div>
</nav>