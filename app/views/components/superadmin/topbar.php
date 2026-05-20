<?php
$u          = Session::get('user');
$currentUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base       = trim(BASE_URL, '/');
if ($base && str_starts_with($currentUri, $base)) {
    $currentUri = trim(substr($currentUri, strlen($base)), '/');
}
$pageLabels = [
    'superadmin/dashboard' => 'Dashboard',
    'superadmin/admins'    => 'Admins',
    'superadmin/users'     => 'Users',
    'superadmin/settings'  => 'Settings',
    'superadmin/profile'   => 'Profile',
];
$pageLabel = $pageLabels[$currentUri] ?? 'Dashboard';
$labelPx   = max(40, strlen($pageLabel) * 8); // approx px width for skeleton
?>

<!-- Topbar skeleton — mirrors real header structure exactly -->
<div id="topbar-skeleton" style="height:56px;background:#fff;border-bottom:1px solid #e4e4e7;display:flex;align-items:center;padding:0 16px;gap:16px;flex-shrink:0">
<script>(function(){
    var dk = localStorage.getItem('theme')==='dark';
    var s  = document.getElementById('topbar-skeleton');
    if(dk){
        s.style.background        = '#18181b';
        s.style.borderBottomColor = '#27272a';
    }
    // badge bg
    var badge = s.querySelector('.sk-badge');
    if(badge) badge.style.background = dk ? 'rgba(124,58,237,.15)' : '#f5f3ff';
    // divider
    var div = s.querySelector('.sk-divider');
    if(div) div.style.background = dk ? '#3f3f46' : '#e4e4e7';
})();</script>

    <!-- LEFT mirrors: flex items-center gap-3 shrink-0 -->
    <div style="display:flex;align-items:center;gap:12px;flex-shrink:0">

        <!-- hamburger: inline-flex w-8 h-8 rounded-md -->
        <div style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:6px;flex-shrink:0">
            <div class="skeleton-base" style="width:16px;height:16px;border-radius:3px"></div>
        </div>

        <!-- Super Admin badge: rounded-full px-2 py-0.5 text-xs gap-1.5 -->
        <div class="sk-badge" style="display:flex;align-items:center;gap:6px;padding:2px 8px;border-radius:9999px">
            <div class="skeleton-base" style="width:12px;height:12px;border-radius:50%"></div>
            <div class="skeleton-base" style="width:60px;height:11px;border-radius:3px"></div>
        </div>

        <!-- breadcrumb nav: flex items-center gap-1.5 -->
        <div style="display:flex;align-items:center;gap:6px">
            <?php if ($currentUri !== 'superadmin/dashboard'): ?>
            <div class="skeleton-base" style="width:54px;height:13px;border-radius:3px"></div>
            <div class="skeleton-base" style="width:14px;height:14px;border-radius:3px"></div>
            <?php endif; ?>
            <div class="skeleton-base" style="width:<?= $labelPx ?>px;height:14px;border-radius:3px"></div>
        </div>
    </div>

    <!-- CENTER mirrors: flex-1 flex justify-center px-4 -->
    <div style="flex:1;display:flex;justify-content:center;padding:0 16px">
        <div class="skeleton-base" style="width:100%;max-width:448px;height:36px;border-radius:8px"></div>
    </div>

    <!-- RIGHT mirrors: flex items-center gap-1 shrink-0 -->
    <div style="display:flex;align-items:center;gap:4px;flex-shrink:0">

        <!-- theme btn: inline-flex w-8 h-8 rounded-md -->
        <div style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:6px">
            <div class="skeleton-base" style="width:16px;height:16px;border-radius:3px"></div>
        </div>

        <!-- divider: w-px h-5 mx-1 -->
        <div class="sk-divider" style="width:1px;height:20px;margin:0 4px;flex-shrink:0"></div>

        <!-- avatar btn: flex items-center gap-2 h-8 pl-1 pr-2 -->
        <div style="display:flex;align-items:center;gap:8px;height:32px;padding:0 8px 0 4px;border-radius:6px">
            <div class="skeleton-base" style="width:24px;height:24px;border-radius:9999px;flex-shrink:0"></div>
            <div class="skeleton-base" style="width:72px;height:13px;border-radius:3px"></div>
            <div class="skeleton-base" style="width:12px;height:12px;border-radius:3px"></div>
        </div>
    </div>

</div>

<header class="h-14 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center px-4 shrink-0 z-20 gap-4"
        style="display:none"
        x-init="document.getElementById('topbar-skeleton')?.remove(); $el.style.display='flex'">

    <!-- Left: hamburger + breadcrumb -->
    <div class="flex items-center gap-3 shrink-0">
        <button @click="sidebarOpen = !sidebarOpen; hovered = false"
            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors focus:outline-none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <span class="hidden sm:flex items-center gap-1.5 text-xs font-semibold text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 px-2 py-0.5 rounded-full">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Super Admin
        </span>
        <nav class="hidden sm:flex items-center gap-1.5 text-sm">
            <?php if ($currentUri === 'superadmin/dashboard'): ?>
                <span class="font-medium text-zinc-900 dark:text-zinc-100">Dashboard</span>
            <?php else: ?>
                <a href="<?= BASE_URL ?>/superadmin/dashboard"
                    class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors whitespace-nowrap">Dashboard</a>
                <svg class="w-3.5 h-3.5 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-zinc-900 dark:text-zinc-100"><?= $pageLabel ?></span>
            <?php endif; ?>
        </nav>
        <span class="sm:hidden text-sm font-medium text-zinc-900 dark:text-zinc-100"><?= $pageLabel ?></span>
    </div>

    <!-- Center: search -->
    <div class="flex-1 flex justify-center px-4" x-data="GlobalSearch([
        { label: 'Dashboard', desc: 'Overview & stats',    href: '<?= BASE_URL ?>/superadmin/dashboard', icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
        { label: 'Admins',    desc: 'Manage admins',       href: '<?= BASE_URL ?>/superadmin/admins',    icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z' },
        { label: 'Users',     desc: 'Manage all users',    href: '<?= BASE_URL ?>/superadmin/users',     icon: 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z' },
        { label: 'Settings',  desc: 'Super admin settings',href: '<?= BASE_URL ?>/superadmin/settings',  icon: 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z' },
    ])">
        <div class="relative w-full max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
            </svg>
            <input type="text" x-model="query" @focus="open = true" @click.away="open = false"
                @keydown.escape="open = false" @keydown.arrow-down.prevent="move(1)"
                @keydown.arrow-up.prevent="move(-1)" @keydown.enter.prevent="go()" placeholder="Search…"
                class="w-full h-9 pl-9 pr-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-zinc-900 dark:text-zinc-100 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent focus:bg-white dark:focus:bg-zinc-700 transition">
            <div x-show="open && results.length > 0" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                class="absolute top-full left-0 right-0 mt-1.5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl shadow-lg z-[9999] overflow-hidden"
                style="display:none">
                <template x-for="(r, i) in results" :key="r.href">
                    <a :href="r.href" @click="open = false"
                        class="flex items-center gap-3 px-3 py-2.5 hover:bg-zinc-50 transition-colors"
                        :class="i === active ? 'bg-zinc-50' : ''">
                        <div class="w-7 h-7 rounded-md bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="r.icon" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100" x-text="r.label"></p>
                            <p class="text-xs text-zinc-400" x-text="r.desc"></p>
                        </div>
                    </a>
                </template>
            </div>
        </div>
    </div>

    <!-- Right: actions -->
    <div class="flex items-center gap-1 shrink-0" x-data="{ dropOpen: false }">
        <!-- Theme toggle -->
        <button onclick="Theme.toggle()"
            class="inline-flex items-center justify-center w-8 h-8 rounded-md text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
            <svg id="theme-icon-dark" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
            </svg>
            <svg id="theme-icon-light" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <div class="w-px h-5 bg-zinc-200 dark:bg-zinc-700 mx-1"></div>

        <!-- Avatar dropdown -->
        <div class="relative">
            <button @click="dropOpen = !dropOpen"
                class="flex items-center gap-2 h-8 pl-1 pr-2 rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none">
                <div class="w-6 h-6 rounded-full bg-violet-600 flex items-center justify-center text-white font-semibold shrink-0 overflow-hidden" style="font-size:10px">
                    <?php if (!empty($u['avatar'])): ?>
                    <img data-avatar-img src="<?= htmlspecialchars($u['avatar']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                    <span data-avatar-initials><?= strtoupper(substr($u['name'] ?? 'S', 0, 1)) ?></span>
                    <?php endif; ?>
                </div>
                <span class="hidden sm:block text-sm font-medium text-zinc-700 dark:text-zinc-300 whitespace-nowrap" data-user-name>
                    <?= htmlspecialchars($u['name'] ?? 'Super Admin') ?>
                </span>
                <svg class="w-3 h-3 text-zinc-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="dropOpen" @click.away="dropOpen = false" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 mt-2 w-52 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-lg py-1 z-50 origin-top-right"
                style="display:none">
                <div class="px-3 py-2 border-b border-zinc-100 dark:border-zinc-800 mb-1">
                    <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 truncate" data-user-name><?= htmlspecialchars($u['name'] ?? 'Super Admin') ?></p>
                    <p class="text-xs text-violet-500 font-medium">Super Admin</p>
                </div>
                <a href="<?= BASE_URL ?>/superadmin/profile"
                    class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </a>
                <a href="<?= BASE_URL ?>/superadmin/settings"
                    class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </a>
                <div class="border-t border-zinc-100 dark:border-zinc-800 mt-1 pt-1">
                    <button onclick="App.logout()"
                        class="flex items-center gap-2.5 w-full px-3 py-1.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-950 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sign out
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
