<div class="fade-in">
    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-zinc-100">Dashboard</h1>
        <p class="text-gray-500 dark:text-zinc-400 text-sm mt-1">Welcome back, <?= htmlspecialchars(Session::get('user')['name'] ?? 'Admin') ?>!</p>
    </div>

    <!-- Stat cards -->
    <div class="grid sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <?php
        $stats = [
            ['label' => 'Total Users',    'value' => number_format($totalUsers ?? 0),   'change' => $totalUsers . ' registered',   'up' => true,  'color' => 'indigo', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label' => 'Active Users',   'value' => number_format($activeUsers ?? 0),   'change' => ($totalUsers ? round(($activeUsers / $totalUsers) * 100) : 0) . '% of total', 'up' => true,  'color' => 'green',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Inactive Users', 'value' => number_format($inactiveUsers ?? 0), 'change' => ($totalUsers ? round(($inactiveUsers / $totalUsers) * 100) : 0) . '% of total', 'up' => false, 'color' => 'red',    'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
            ['label' => 'New This Month', 'value' => number_format($newThisMonth ?? 0),  'change' => date('M Y'),                   'up' => true,  'color' => 'blue',   'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
        ];
        foreach ($stats as $s):
        ?>
        <div class="bg-white dark:bg-zinc-900 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-zinc-800 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-<?= $s['color'] ?>-100 dark:bg-<?= $s['color'] ?>-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-<?= $s['color'] ?>-600 dark:text-<?= $s['color'] ?>-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $s['icon'] ?>"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold px-2 py-1 rounded-full <?= $s['up'] ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' ?>">
                    <?= $s['change'] ?>
                </span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-zinc-100"><?= $s['value'] ?></p>
            <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1"><?= $s['label'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Recent activity table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-gray-100 dark:border-zinc-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-zinc-800 flex items-center justify-between">
            <h2 class="font-semibold text-gray-900 dark:text-zinc-100">Recent Users</h2>
            <a href="/?url=admin/users" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline font-medium">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-zinc-800 text-gray-500 dark:text-zinc-400 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">Name</th>
                        <th class="px-6 py-3 text-left font-medium">Email</th>
                        <th class="px-6 py-3 text-left font-medium">Status</th>
                        <th class="px-6 py-3 text-left font-medium">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-zinc-800">
                    <?php
                    $rows = $recentUsers ?? [];
                    foreach ($rows as $r):
                    ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-zinc-100"><?= htmlspecialchars($r['name']) ?></td>
                        <td class="px-6 py-4 text-gray-500 dark:text-zinc-400"><?= htmlspecialchars($r['email']) ?></td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $r['status'] === 'active' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-zinc-400' ?>">
                                <?= ucfirst($r['status']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-zinc-400"><?= date('M d, Y', strtotime($r['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
