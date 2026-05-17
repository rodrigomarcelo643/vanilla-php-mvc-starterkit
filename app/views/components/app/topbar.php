<?php
$u          = Session::get('user');
$currentUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base       = trim(BASE_URL, '/');
if ($base && str_starts_with($currentUri, $base)) {
    $currentUri = trim(substr($currentUri, strlen($base)), '/');
}
$pageLabels = [
    'app/home'     => 'Home',
    'app/profile'  => 'Profile',
    'app/settings' => 'Settings',
];
$pageLabel = $pageLabels[$currentUri] ?? 'Home';
?>

<header class="h-14 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center px-4 shrink-0 z-20 gap-4">

    <!-- Left: hamburger + breadcrumb -->
    <div class="flex items-center gap-3 shrink-0">
        <button @click="sidebarOpen = !sidebarOpen; hovered = false"
            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors focus:outline-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <span class="text-zinc-300 select-none hidden sm:block">/</span>
        <nav class="hidden sm:flex items-center gap-1.5 text-sm">
            <a href="<?= BASE_URL ?>/app/home" class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors whitespace-nowrap">My Account</a>
            <svg class="w-3.5 h-3.5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="font-medium text-zinc-900 dark:text-zinc-100"><?= $pageLabel ?></span>
        </nav>
        <span class="sm:hidden text-sm font-medium text-zinc-900 dark:text-zinc-100"><?= $pageLabel ?></span>
    </div>

    <!-- Center: search -->
    <div class="flex-1 flex justify-center px-4" x-data="GlobalSearch([
        { label: 'Home',           desc: 'App dashboard',       href: '<?= BASE_URL ?>/app/home',        icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
        { label: 'Profile',        desc: 'Your account info',   href: '<?= BASE_URL ?>/app/profile',     icon: 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z' },
        { label: 'Settings',       desc: 'Account preferences', href: '<?= BASE_URL ?>/app/settings',    icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z' },
    ])">
        <div class="relative w-full max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
            <input type="text" x-model="query" @focus="open = true" @click.away="open = false"
                @keydown.escape="open = false" @keydown.arrow-down.prevent="move(1)" @keydown.arrow-up.prevent="move(-1)"
                @keydown.enter.prevent="go()"
                placeholder="Search…"
                class="w-full h-9 pl-9 pr-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-500 focus:border-transparent focus:bg-white dark:focus:bg-zinc-700 transition">

            <div x-show="open && results.length > 0"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute top-full left-0 right-0 mt-1.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-lg z-[9999] overflow-hidden"
                 style="display:none">
                <template x-for="(r, i) in results" :key="r.href">
                    <a :href="r.href" @click="open = false"
                        class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition-colors"
                        :class="i === active ? 'bg-zinc-50' : ''">
                        <div class="w-7 h-7 rounded-md bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="r.icon"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100" x-text="r.label"></p>
                            <p class="text-xs text-zinc-400" x-text="r.desc"></p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-zinc-300 ml-auto shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <!-- Right -->
    <div class="flex items-center gap-1 shrink-0" x-data="{ dropOpen: false, notifOpen: false }">

        <!-- Notification -->
        <div class="relative">
            <button @click="notifOpen = !notifOpen"
                class="relative inline-flex items-center justify-center w-8 h-8 rounded-md text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1 right-1 w-1.5 h-1.5 bg-red-500 rounded-full ring-1 ring-white"></span>
            </button>
            <div x-show="notifOpen" @click.away="notifOpen = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-72 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-lg z-50 overflow-hidden"
                 style="display:none">
                <div class="flex items-center justify-between px-4 py-3 border-b border-zinc-100 dark:border-zinc-800">
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Notifications</p>
                    <span class="text-xs bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-medium px-1.5 py-0.5 rounded-full">2</span>
                </div>
                <?php foreach ([
                    ['Welcome to ' . APP_NAME . '!', 'just now', 'bg-green-500'],
                    ['Your profile is incomplete',   '1h ago',   'bg-yellow-500'],
                ] as $n): ?>
                <div class="flex items-start gap-3 px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors cursor-pointer border-b border-zinc-50 dark:border-zinc-800 last:border-0">
                    <span class="mt-1.5 w-2 h-2 rounded-full <?= $n[2] ?> shrink-0"></span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-zinc-800 dark:text-zinc-200"><?= $n[0] ?></p>
                        <p class="text-xs text-zinc-400 mt-0.5"><?= $n[1] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="w-px h-5 bg-zinc-200 dark:bg-zinc-700 mx-1"></div>

        <!-- Avatar dropdown -->
        <div class="relative">
            <button @click="dropOpen = !dropOpen"
                class="flex items-center gap-2 h-8 pl-1 pr-2 rounded-md hover:bg-zinc-100 transition-colors focus:outline-none">
                <div class="w-6 h-6 rounded-full bg-zinc-900 flex items-center justify-center text-white font-semibold shrink-0 overflow-hidden" style="font-size:10px">
                    <?php if (!empty($u['avatar'])): ?>
                        <img data-avatar-img src="<?= htmlspecialchars($u['avatar']) ?>" class="w-full h-full object-cover">
                        <span data-avatar-initials class="hidden"><?= strtoupper(substr($u['name'] ?? 'U', 0, 1)) ?></span>
                    <?php else: ?>
                        <img data-avatar-img src="" class="w-full h-full object-cover hidden">
                        <span data-avatar-initials><?= strtoupper(substr($u['name'] ?? 'U', 0, 1)) ?></span>
                    <?php endif; ?>
                </div>
                <span class="hidden sm:block text-sm font-medium text-zinc-700 whitespace-nowrap"><?= htmlspecialchars($u['name'] ?? '') ?></span>
                <svg class="w-3 h-3 text-zinc-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="dropOpen" @click.away="dropOpen = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-52 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-lg py-1 z-50 origin-top-right"
                 style="display:none">
                <div class="px-3 py-2 border-b border-zinc-100 dark:border-zinc-800 mb-1">
                    <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 truncate"><?= htmlspecialchars($u['name'] ?? '') ?></p>
                    <p class="text-xs text-zinc-400 truncate"><?= htmlspecialchars($u['email'] ?? '') ?></p>
                </div>
                <a href="<?= BASE_URL ?>/app/profile" class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile
                </a>
                <a href="<?= BASE_URL ?>/app/settings" class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Settings
                </a>
                <div class="border-t border-zinc-100 dark:border-zinc-800 mt-1 pt-1">
                    <button onclick="App.logout()" class="flex items-center gap-2.5 w-full px-3 py-1.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-950 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sign out
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
