<?php $u = Session::get('user'); ?>
<div class="fade-in">
    <div class="mb-8">
        <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Welcome back, <?= htmlspecialchars($u['name'] ?? 'there') ?> 👋</h1>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Here's what's happening with your account.</p>
    </div>

    <!-- Skeleton -->
    <div id="app-home-skeleton">
        <div class="grid sm:grid-cols-3 gap-4 mb-8">
            <?php for ($i = 0; $i < 3; $i++): ?>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
                <div class="skeleton-base h-3 w-24 rounded mb-3"></div>
                <div class="skeleton-base h-6 w-16 rounded-full"></div>
            </div>
            <?php endfor; ?>
        </div>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
                <div class="skeleton-base h-4 w-28 rounded"></div>
            </div>
            <?php for ($i = 0; $i < 2; $i++): ?>
            <div class="flex items-center gap-4 px-5 py-4 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                <div class="skeleton-base w-8 h-8 rounded-lg shrink-0"></div>
                <div class="flex-1">
                    <div class="skeleton-base h-3.5 w-40 rounded mb-1.5"></div>
                    <div class="skeleton-base h-3 w-56 rounded"></div>
                </div>
                <div class="skeleton-base w-4 h-4 rounded"></div>
            </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Real content -->
    <div id="app-home-content" style="display:none">

    <!-- Stats -->
    <div class="grid sm:grid-cols-3 gap-4 mb-8">
        <?php foreach ([
            ['Account Status', 'Active',              'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'],
            ['Member Since',   date('M Y'),            'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300'],
            ['Role',           ucfirst($u['role'] ?? 'user'), 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400'],
        ] as $s): ?>
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 shadow-sm">
            <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-2"><?= $s[0] ?></p>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold <?= $s[2] ?>"><?= $s[1] ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Quick links -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Quick Actions</h2>
        </div>
        <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
            <?php foreach ([
                ['Update your profile',  'Keep your information up to date.',  'app/profile',  'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['Account settings',     'Manage your preferences.',           'app/settings', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z'],
            ] as $q): ?>
            <a href="<?= BASE_URL ?>/<?= $q[2] ?>" class="flex items-center gap-4 px-5 py-4 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors group">
                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $q[3] ?>"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100"><?= $q[0] ?></p>
                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-0.5"><?= $q[1] ?></p>
                </div>
                <svg class="w-4 h-4 text-zinc-300 dark:text-zinc-600 group-hover:text-zinc-500 dark:group-hover:text-zinc-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    </div><!-- end app-home-content -->
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sk = document.getElementById('app-home-skeleton');
    const ct = document.getElementById('app-home-content');
    if (sk && ct) {
        setTimeout(() => { sk.style.display = 'none'; ct.style.display = ''; }, 500);
    }
});
</script>
