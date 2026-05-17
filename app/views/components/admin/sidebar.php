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
            ['uri' => 'dashboard', 'label' => 'Dashboard',
             'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ],
    ],
    [
        'label' => 'Management',
        'items' => [
            ['uri' => 'admin/users', 'label' => 'Users',
             'icon' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z'],
        ],
    ],
];
?>

<!-- Mobile backdrop only -->
<div
    x-show="isMobile && sidebarOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-black/40"
    style="display:none"
></div>

<!-- Sidebar -->
<aside
    @mouseenter="if (!isMobile && !sidebarOpen) hovered = true"
    @mouseleave="if (!isMobile && !sidebarOpen) hovered = false"
    :class="{
        'w-64':  sidebarOpen || hovered || (!isMobile && sidebarOpen),
        'w-[60px]': !isMobile && !sidebarOpen && !hovered,
        'translate-x-0':  !isMobile || sidebarOpen,
        '-translate-x-full': isMobile && !sidebarOpen
    }"
    class="fixed top-0 left-0 h-screen z-40 flex flex-col
           bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800 shadow-sm
           transition-all duration-300 ease-in-out overflow-hidden"
>
    <!-- Header -->
    <div class="flex items-center h-14 border-b border-zinc-200 dark:border-zinc-800 shrink-0 px-3 gap-3">
        <!-- Logo icon — always visible -->
        <div class="w-7 h-7 rounded-lg bg-zinc-900 dark:bg-zinc-700 flex items-center justify-center shrink-0">
            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <!-- App name — shown when expanded -->
        <div x-show="sidebarOpen || hovered"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="flex-1 min-w-0" style="display:none">
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate whitespace-nowrap"><?= APP_NAME ?></p>
            <p class="text-xs text-zinc-400 whitespace-nowrap">Admin Panel</p>
        </div>
        <!-- Close — mobile only -->
        <button x-show="isMobile && sidebarOpen"
                @click="sidebarOpen = false"
                class="ml-auto p-1.5 rounded-md text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition shrink-0"
                style="display:none">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Nav -->
    <div class="flex-1 overflow-y-auto overflow-x-hidden py-3 px-2 space-y-4">
        <?php foreach ($navGroups as $group): ?>
        <div>
            <!-- Group label — only when expanded -->
            <div x-show="sidebarOpen || hovered"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="px-2 mb-1" style="display:none">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-zinc-400">
                    <?= $group['label'] ?>
                </span>
            </div>

            <div class="space-y-0.5">
                <?php foreach ($group['items'] as $item):
                    $active = ($currentUri === $item['uri']);
                ?>
                <a href="<?= BASE_URL ?>/<?= $item['uri'] ?>"
                   @click="if (isMobile) sidebarOpen = false"
                   class="group relative flex items-center gap-3 px-2 py-2 rounded-md text-sm transition-colors duration-150
                          <?= $active ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-zinc-100' ?>">

                    <!-- Icon — always visible -->
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $item['icon'] ?>"/>
                    </svg>

                    <!-- Label — shown when expanded -->
                    <span x-show="sidebarOpen || hovered"
                          x-transition:enter="transition ease-out duration-150"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100"
                          x-transition:leave="transition ease-in duration-100"
                          x-transition:leave-start="opacity-100"
                          x-transition:leave-end="opacity-0"
                          class="flex-1 truncate whitespace-nowrap" style="display:none">
                        <?= $item['label'] ?>
                    </span>

                    <!-- Active dot -->
                    <?php if ($active): ?>
                    <span x-show="sidebarOpen || hovered"
                          class="w-1.5 h-1.5 rounded-full bg-zinc-900 shrink-0" style="display:none"></span>
                    <?php endif; ?>

                    <!-- Tooltip — icon-only desktop collapsed -->
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

    <!-- Footer — user dropdown trigger -->
    <div class="border-t border-zinc-200 dark:border-zinc-800 p-2 shrink-0" x-data="{ userDrop: false }">
        <?php $u = Session::get('user'); ?>

        <!-- Trigger button -->
        <button @click="userDrop = !userDrop"
            class="group relative flex items-center gap-2.5 w-full px-2 py-2 rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-left">

            <!-- Avatar — always visible -->
            <div class="w-7 h-7 rounded-full bg-zinc-900 flex items-center justify-center text-white shrink-0 font-semibold overflow-hidden" style="font-size:10px">
                <?php if (!empty($u['avatar'])): ?>
                    <img data-avatar-img src="<?= htmlspecialchars($u['avatar']) ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <span data-avatar-initials><?= strtoupper(substr($u['name'] ?? 'A', 0, 1)) ?></span>
                <?php endif; ?>
            </div>

            <!-- Name + email — shown when expanded -->
            <div x-show="sidebarOpen || hovered"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="flex-1 min-w-0" style="display:none">
                <p class="text-sm font-medium text-zinc-900 truncate whitespace-nowrap leading-tight" data-user-name><?= htmlspecialchars($u['name'] ?? 'Admin') ?></p>
                <p class="text-xs text-zinc-400 truncate whitespace-nowrap leading-tight" data-user-email><?= htmlspecialchars($u['email'] ?? '') ?></p>
            </div>

            <!-- Chevron — shown when expanded -->
            <svg x-show="sidebarOpen || hovered"
                 class="w-3.5 h-3.5 text-zinc-400 shrink-0 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 style="display:none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
            </svg>

            <!-- Tooltip — icon-only collapsed -->
            <div x-show="!isMobile && !sidebarOpen && !hovered"
                 class="pointer-events-none absolute left-11 z-50 opacity-0 group-hover:opacity-100 transition-opacity duration-150"
                 style="display:none">
                <div class="bg-zinc-900 text-white text-xs font-medium px-2.5 py-1.5 rounded-md shadow-lg whitespace-nowrap">
                    <?= htmlspecialchars($u['name'] ?? 'Admin') ?>
                </div>
            </div>
        </button>

        <!-- Dropdown — opens upward -->
        <div x-show="userDrop" @click.away="userDrop = false"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute bottom-16 left-2 right-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg py-1 z-50 origin-bottom-left"
             style="display:none">

            <!-- User info header -->
            <div class="px-3 py-2 border-b border-zinc-100 dark:border-zinc-800 mb-1">
                <p class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 truncate" data-user-name><?= htmlspecialchars($u['name'] ?? 'Admin') ?></p>
                <p class="text-xs text-zinc-400 truncate" data-user-email><?= htmlspecialchars($u['email'] ?? '') ?></p>
            </div>

            <a href="<?= BASE_URL ?>/profile"
               class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profile
            </a>

            <a href="<?= BASE_URL ?>/admin/settings"
               class="flex items-center gap-2.5 px-3 py-1.5 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Settings
            </a>

            <div class="border-t border-zinc-100 dark:border-zinc-800 mt-1 pt-1">
                <button onclick="App.logout()"
                    class="flex items-center gap-2.5 w-full px-3 py-1.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-950 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign out
                </button>
            </div>
        </div>
    </div>
</aside>

<!-- Desktop spacer — w-64 when open, w-[60px] when collapsed, 0 on mobile -->
<div :class="isMobile ? 'w-0' : (sidebarOpen ? 'w-64' : 'w-[60px]')"
     class="shrink-0 transition-all duration-300"></div>
