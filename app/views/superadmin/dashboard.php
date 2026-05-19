<?php
$totalUsers    = $totalUsers    ?? 0;
$activeUsers   = $activeUsers   ?? 0;
$inactiveUsers = $inactiveUsers ?? 0;
$newThisMonth  = $newThisMonth  ?? 0;
$totalAdmins   = $totalAdmins   ?? 0;
$recentUsers   = $recentUsers   ?? [];
?>

<div class="fade-in space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-0.5">
                <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Dashboard</h1>
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-violet-600 dark:text-violet-400 bg-violet-50 dark:bg-violet-900/20 px-2 py-0.5 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Super Admin
                </span>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Welcome back, <span class="font-medium text-zinc-700 dark:text-zinc-300"><?= htmlspecialchars(Session::get('user')['name'] ?? 'Super Admin') ?></span>
                &mdash; <?= date('l, F j Y') ?>
            </p>
        </div>
        <span class="inline-flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
            All systems operational
        </span>
    </div>

    <!-- Stat cards -->
    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <?php
        $stats = [
            ['label' => 'Total Users',    'value' => number_format($totalUsers),    'change' => '+' . $newThisMonth . ' this month', 'up' => true,  'color' => 'violet',
             'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
             'spark' => [40,55,45,60,52,70,65,80,74,88,82,95]],
            ['label' => 'Active Users',   'value' => number_format($activeUsers),   'change' => ($totalUsers ? round(($activeUsers/$totalUsers)*100) : 0).'% of total', 'up' => true,  'color' => 'emerald',
             'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
             'spark' => [30,42,38,50,44,58,54,66,60,72,68,78]],
            ['label' => 'Inactive Users', 'value' => number_format($inactiveUsers), 'change' => ($totalUsers ? round(($inactiveUsers/$totalUsers)*100) : 0).'% of total', 'up' => false, 'color' => 'red',
             'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
             'spark' => [20,18,22,16,20,14,18,12,16,10,14,8]],
            ['label' => 'Total Admins',   'value' => number_format($totalAdmins),   'change' => 'admin accounts', 'up' => true,  'color' => 'blue',
             'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
             'spark' => [1,1,2,2,2,3,3,3,4,4,4,5]],
        ];
        $sparkColors = ['violet'=>'#7C3AED','emerald'=>'#10b981','red'=>'#ef4444','blue'=>'#3b82f6'];
        foreach ($stats as $s):
            $max = max($s['spark']); $min = min($s['spark']);
            $pts = '';
            foreach ($s['spark'] as $i => $v) {
                $x = round(($i / (count($s['spark'])-1)) * 100, 1);
                $y = round(100 - (($v - $min) / max($max - $min, 1)) * 70 - 10, 1);
                $pts .= "$x,$y ";
            }
        ?>
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-5 border border-zinc-100 dark:border-zinc-800 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-9 h-9 rounded-lg bg-<?= $s['color'] ?>-100 dark:bg-<?= $s['color'] ?>-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-<?= $s['color'] ?>-600 dark:text-<?= $s['color'] ?>-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $s['icon'] ?>"/>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2 py-0.5 rounded-full <?= $s['up'] ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400' : 'bg-red-50 dark:bg-red-900/20 text-red-500 dark:text-red-400' ?>">
                    <?= $s['up'] ? '↑' : '↓' ?> <?= $s['change'] ?>
                </span>
            </div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100"><?= $s['value'] ?></p>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 mb-3"><?= $s['label'] ?></p>
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-10">
                <polyline points="<?= trim($pts) ?>" fill="none"
                    stroke="<?= $sparkColors[$s['color']] ?>"
                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>
            </svg>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Quick links -->
    <div class="grid sm:grid-cols-2 gap-4">
        <a href="<?= BASE_URL ?>/superadmin/admins"
            class="bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 rounded-xl p-5 hover:shadow-md hover:border-violet-200 dark:hover:border-violet-800 transition-all group">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 rounded-lg bg-violet-100 dark:bg-violet-900/30 flex items-center justify-center group-hover:bg-violet-200 dark:group-hover:bg-violet-900/50 transition-colors">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <p class="font-semibold text-zinc-900 dark:text-zinc-100">Manage Admins</p>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">View and manage all admin accounts</p>
        </a>
        <a href="<?= BASE_URL ?>/superadmin/users"
            class="bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 rounded-xl p-5 hover:shadow-md hover:border-violet-200 dark:hover:border-violet-800 transition-all group">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover:bg-blue-200 dark:group-hover:bg-blue-900/50 transition-colors">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
                    </svg>
                </div>
                <p class="font-semibold text-zinc-900 dark:text-zinc-100">Manage Users</p>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">View and manage all user accounts</p>
        </a>
    </div>

    <!-- Recent users table -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
        <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Recent Users</p>
            <a href="<?= BASE_URL ?>/superadmin/users" class="text-xs font-medium text-violet-600 dark:text-violet-400 hover:underline">View all →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-zinc-400 dark:text-zinc-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left font-medium">User</th>
                        <th class="px-5 py-3 text-left font-medium">Status</th>
                        <th class="px-5 py-3 text-left font-medium">Role</th>
                        <th class="px-5 py-3 text-left font-medium">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    <?php foreach ($recentUsers as $r): ?>
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center text-violet-600 dark:text-violet-400 text-xs font-bold shrink-0">
                                    <?= strtoupper(substr($r['name'], 0, 1)) ?>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-medium text-zinc-900 dark:text-zinc-100 truncate"><?= htmlspecialchars($r['name']) ?></p>
                                    <p class="text-xs text-zinc-400 truncate"><?= htmlspecialchars($r['email']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium <?= $r['status'] === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400' ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?= $r['status'] === 'active' ? 'bg-green-500' : 'bg-zinc-400' ?>"></span>
                                <?= ucfirst($r['status']) ?>
                            </span>
                        </td>
                        <td class="px-5 py-3 text-xs text-zinc-500 dark:text-zinc-400 capitalize"><?= htmlspecialchars($r['role'] ?? 'user') ?></td>
                        <td class="px-5 py-3 text-xs text-zinc-400"><?= date('M d, Y', strtotime($r['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($recentUsers)): ?>
                    <tr><td colspan="4" class="px-5 py-8 text-center text-sm text-zinc-400">No users yet</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
