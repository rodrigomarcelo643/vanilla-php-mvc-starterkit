<?php
$currentUri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$base       = trim(BASE_URL, '/');
if ($base && str_starts_with($currentUri, $base)) {
    $currentUri = trim(substr($currentUri, strlen($base)), '/');
}

$navGroups = [
    [
        'label' => 'Main',
        'items' => [
            ['uri' => 'superadmin/dashboard', 'label' => 'Dashboard',
             'icon' => 'M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z'],
        ],
    ],
    [
        'label' => 'Management',
        'items' => [
            ['uri' => 'superadmin/admins', 'label' => 'Admins',
             'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['uri' => 'superadmin/users', 'label' => 'Users',
             'icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z'],
        ],
    ],
];
?>

<!-- Sidebar skeleton — visible until Alpine boots -->
<aside id="sidebar-skeleton"
    style="position:fixed;top:0;left:0;height:100vh;z-index:40;display:flex;flex-direction:column;background:#fff;border-right:1px solid #e4e4e7;width:60px">
<script>(function(){
    var dk = localStorage.getItem('theme')==='dark';
    var el = document.getElementById('sidebar-skeleton');
    el.style.width = window.innerWidth >= 1024 ? '256px' : '60px';
    if(dk){
        el.style.background        = '#18181b';
        el.style.borderRightColor  = '#27272a';
    }
    // header border
    var hb = el.querySelector('.sk-hdr-border');
    if(hb) hb.style.borderBottomColor = dk ? '#27272a' : '#e4e4e7';
    // footer border
    var fb = el.querySelector('.sk-ftr-border');
    if(fb) fb.style.borderTopColor = dk ? '#27272a' : '#e4e4e7';
})();</script>

    <!-- header -->
    <div class="sk-hdr-border" style="display:flex;align-items:center;height:56px;border-bottom:1px solid #e4e4e7;padding:0 12px;gap:12px;overflow:hidden;flex-shrink:0">
        <div class="skeleton-base" style="width:28px;height:28px;border-radius:8px;flex-shrink:0"></div>
        <div class="skeleton-base sk-label" style="height:14px;width:96px;border-radius:4px"></div>
    </div>

    <!-- nav -->
    <div style="flex:1;padding:12px 8px;display:flex;flex-direction:column;gap:16px;overflow:hidden">
        <!-- group Main -->
        <div>
            <div style="padding:0 8px;margin-bottom:4px">
                <div class="skeleton-base sk-label" style="height:10px;width:32px;border-radius:3px"></div>
            </div>
            <div style="display:flex;align-items:center;gap:12px;padding:8px">
                <div class="skeleton-base" style="width:16px;height:16px;border-radius:3px;flex-shrink:0"></div>
                <div class="skeleton-base sk-label" style="height:12px;width:80px;border-radius:3px"></div>
            </div>
        </div>
        <!-- group Management -->
        <div>
            <div style="padding:0 8px;margin-bottom:4px">
                <div class="skeleton-base sk-label" style="height:10px;width:80px;border-radius:3px"></div>
            </div>
            <div style="display:flex;align-items:center;gap:12px;padding:8px">
                <div class="skeleton-base" style="width:16px;height:16px;border-radius:3px;flex-shrink:0"></div>
                <div class="skeleton-base sk-label" style="height:12px;width:56px;border-radius:3px"></div>
            </div>
            <div style="display:flex;align-items:center;gap:12px;padding:8px">
                <div class="skeleton-base" style="width:16px;height:16px;border-radius:3px;flex-shrink:0"></div>
                <div class="skeleton-base sk-label" style="height:12px;width:40px;border-radius:3px"></div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="sk-ftr-border" style="border-top:1px solid #e4e4e7;padding:8px;flex-shrink:0">
        <div style="display:flex;align-items:center;gap:10px;padding:8px">
            <div class="skeleton-base" style="width:28px;height:28px;border-radius:9999px;flex-shrink:0"></div>
            <div class="sk-label" style="display:flex;flex-direction:column;gap:6px">
                <div class="skeleton-base" style="height:12px;width:96px;border-radius:3px"></div>
                <div class="skeleton-base" style="height:10px;width:64px;border-radius:3px"></div>
            </div>
        </div>
    </div>
</aside>
<style>
    #sidebar-skeleton .sk-label { display:none; }
    @media(min-width:1024px){ #sidebar-skeleton .sk-label { display:block; } }
</style>

<!-- Mobile backdrop -->
<div x-show="isMobile && sidebarOpen" x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/40"
    style="display:none"></div>

<!-- Sidebar -->
<aside @mouseenter="if (!isMobile && !sidebarOpen) hovered = true"
    @mouseleave="if (!isMobile && !sidebarOpen) hovered = false" :class="{
        'w-64':  sidebarOpen || hovered || (!isMobile && sidebarOpen),
        'w-[60px]': !isMobile && !sidebarOpen && !hovered,
        'translate-x-0':  !isMobile || sidebarOpen,
        '-translate-x-full': isMobile && !sidebarOpen
    }" class="fixed top-0 left-0 h-screen z-40 flex flex-col
           bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 shadow-sm
           transition-all duration-300 ease-in-out overflow-hidden"
    style="display:none"
    x-init="$el.style.display = '';">

    <!-- Header -->
    <div class="flex items-center h-14 border-b border-zinc-200 dark:border-zinc-800 shrink-0 px-3 gap-3">
        <div class="w-7 h-7 rounded-lg bg-violet-600 flex items-center justify-center shrink-0">
            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div x-show="sidebarOpen || hovered" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="flex-1 min-w-0" style="display:none">
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate whitespace-nowrap"><?= APP_NAME ?></p>
            <p class="text-xs text-violet-500 font-medium whitespace-nowrap">Super Admin</p>
        </div>
        <button x-show="isMobile && sidebarOpen" @click="sidebarOpen = false"
            class="ml-auto p-1.5 rounded-md text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition shrink-0"
            style="display:none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Nav -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden py-3 px-2 space-y-4">
        <?php foreach ($navGroups as $group): ?>
        <div>
            <div x-show="sidebarOpen || hovered" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="px-2 mb-1" style="display:none">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-400">
                    <?= $group['label'] ?>
                </span>
            </div>
            <div class="space-y-0.5">
                <?php foreach ($group['items'] as $item):
                    $active = ($currentUri === $item['uri']);
                ?>
                <a href="<?= BASE_URL ?>/<?= $item['uri'] ?>" @click="if (isMobile) sidebarOpen = false"
                    class="group relative flex items-center gap-3 px-2 py-2 rounded-md text-sm transition-colors duration-150
                          <?= $active ? 'bg-violet-50 dark:bg-violet-900/20 text-violet-700 dark:text-violet-300 font-medium' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' ?>">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $item['icon'] ?>" />
                    </svg>
                    <span x-show="sidebarOpen || hovered" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="flex-1 truncate whitespace-nowrap" style="display:none">
                        <?= $item['label'] ?>
                    </span>
                    <?php if ($active): ?>
                    <span x-show="sidebarOpen || hovered" class="w-1.5 h-1.5 rounded-full bg-violet-600 shrink-0" style="display:none"></span>
                    <?php endif; ?>
                    <div x-show="!isMobile && !sidebarOpen && !hovered"
                        class="pointer-events-none absolute left-11 z-50 opacity-0 group-hover:opacity-100 transition-opacity duration-150"
                        style="display:none">
                        <div class="bg-zinc-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-md shadow-lg whitespace-nowrap">
                            <?= $item['label'] ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Footer -->
    <div class="border-t border-zinc-200 dark:border-zinc-800 p-2 shrink-0" x-data="{ userDrop: false }">
        <?php $u = Session::get('user'); ?>
        <button @click="userDrop = !userDrop"
            class="group relative flex items-center gap-2.5 w-full px-2 py-2 rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-left">
            <div class="w-7 h-7 rounded-full bg-violet-600 flex items-center justify-center text-white shrink-0 font-semibold overflow-hidden" style="font-size:10px">
                <?php if (!empty($u['avatar'])): ?>
                <img data-avatar-img src="<?= htmlspecialchars($u['avatar']) ?>" class="w-full h-full object-cover">
                <?php else: ?>
                <span data-avatar-initials><?= strtoupper(substr($u['name'] ?? 'S', 0, 1)) ?></span>
                <?php endif; ?>
            </div>
            <div x-show="sidebarOpen || hovered" x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="flex-1 min-w-0" style="display:none">
                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate whitespace-nowrap leading-tight" data-user-name><?= htmlspecialchars($u['name'] ?? 'Super Admin') ?></p>
                <p class="text-xs text-violet-500 font-medium whitespace-nowrap leading-tight">Super Admin</p>
            </div>
            <svg x-show="sidebarOpen || hovered" class="w-3.5 h-3.5 text-zinc-400 shrink-0 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div x-show="userDrop" @click.away="userDrop = false" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute bottom-16 left-2 right-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg py-1 z-50 origin-bottom-left"
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
</aside>

<div id="sidebar-spacer" :class="isMobile ? 'w-0' : (sidebarOpen ? 'w-64' : 'w-[60px]')" class="shrink-0 transition-all duration-300"
     x-init="document.getElementById('sidebar-skeleton')?.remove(); document.getElementById('sidebar-spacer').style.width = '';">
    <script>
        (function(){
            var el = document.getElementById('sidebar-spacer');
            el.style.width = window.innerWidth >= 1024 ? '256px' : '0px';
        })();
    </script>
</div>
