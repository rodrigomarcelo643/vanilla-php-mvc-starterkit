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
            ['label' => 'Total Users',   'value' => number_format($totalUsers ?? 0), 'change' => '+12%', 'up' => true,  'color' => 'indigo', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['label' => 'Revenue',       'value' => '$8,420', 'change' => '+8%',  'up' => true,  'color' => 'green',  'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Active Sessions','value' => '342',   'change' => '+5%',  'up' => true,  'color' => 'blue',   'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ['label' => 'Bounce Rate',   'value' => '24.5%',  'change' => '-3%',  'up' => false, 'color' => 'red',    'icon' => 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6'],
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
