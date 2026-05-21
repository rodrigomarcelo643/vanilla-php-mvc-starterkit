<?php
$totalUsers    = $totalUsers    ?? 0;
$activeUsers   = $activeUsers   ?? 0;
$inactiveUsers = $inactiveUsers ?? 0;
$newThisMonth  = $newThisMonth  ?? 0;
$recentUsers   = $recentUsers   ?? [];

// Dummy data
$revenueData = [18, 32, 27, 45, 38, 52, 61, 47, 70, 65, 80, 74];
$months      = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

// User growth dummy datasets per filter
$growthDatasets = [
    'today'  => ['labels' => ['12am','3am','6am','9am','12pm','3pm','6pm','9pm'],  'data' => [1,0,2,4,3,6,5,8]],
    'week'   => ['labels' => ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],           'data' => [4,7,5,9,12,8,11]],
    'month'  => ['labels' => ['W1','W2','W3','W4'],                                'data' => [18,24,31,27]],
    'year'   => ['labels' => $months,                                              'data' => [5,12,9,18,14,22,19,28,24,33,29,38]],
    'custom' => ['labels' => ['Day 1','Day 2','Day 3','Day 4','Day 5','Day 6','Day 7'], 'data' => [3,8,5,11,7,14,10]],
];
$userGrowth = $growthDatasets['year']['data'];

$topPages = [
    ['page' => '/dashboard',   'views' => 4821, 'change' => 12],
    ['page' => '/admin/users', 'views' => 3204, 'change' => 8],
    ['page' => '/app/home',    'views' => 2891, 'change' => -3],
    ['page' => '/login',       'views' => 2104, 'change' => 5],
    ['page' => '/register',    'views' => 1763, 'change' => 21],
];

$activity = [
    ['icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'color' => 'blue',   'text' => 'New user <strong>Jane Cooper</strong> registered',         'time' => '2m ago'],
    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                         'color' => 'green',  'text' => 'User <strong>Tom Harris</strong> marked as active',         'time' => '14m ago'],
    ['icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', 'color' => 'amber',  'text' => 'System alert: <strong>disk usage at 74%</strong>',              'time' => '1h ago'],
    ['icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'color' => 'violet', 'text' => '<strong>Admin</strong> updated site settings',                  'time' => '3h ago'],
    ['icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', 'color' => 'red', 'text' => 'User <strong>Mark Lee</strong> deactivated',                   'time' => '5h ago'],
    ['icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4', 'color' => 'emerald', 'text' => 'Database backup <strong>completed successfully</strong>',         'time' => '8h ago'],
];

$colorMap = [
    'blue'   => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400',
    'green'  => 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400',
    'amber'  => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400',
    'violet' => 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400',
    'red'    => 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400',
    'emerald'=> 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400',
];
?>

<div class="fade-in space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Dashboard</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Welcome back, <span class="font-medium text-zinc-700 dark:text-zinc-300"><?= htmlspecialchars(Session::get('user')['name'] ?? 'Admin') ?></span>
                &mdash; <?= date('l, F j Y') ?>
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 text-xs text-zinc-500 dark:text-zinc-400 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg px-3 py-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                All systems operational
            </span>
        </div>
    </div>

    <!-- Stat cards -->
    <div id="admin-dash-stats" class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <?php
        $stats = [
            ['label' => 'Total Users',    'value' => number_format($totalUsers),    'change' => '+' . $newThisMonth . ' this month', 'up' => true,  'color' => 'indigo',
             'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
             'spark' => [40,55,45,60,52,70,65,80,74,88,82,95]],
            ['label' => 'Active Users',   'value' => number_format($activeUsers),   'change' => ($totalUsers ? round(($activeUsers/$totalUsers)*100) : 0).'% of total', 'up' => true,  'color' => 'emerald',
             'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
             'spark' => [30,42,38,50,44,58,54,66,60,72,68,78]],
            ['label' => 'Inactive Users', 'value' => number_format($inactiveUsers), 'change' => ($totalUsers ? round(($inactiveUsers/$totalUsers)*100) : 0).'% of total', 'up' => false, 'color' => 'red',
             'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636',
             'spark' => [20,18,22,16,20,14,18,12,16,10,14,8]],
            ['label' => 'New This Month', 'value' => number_format($newThisMonth),  'change' => date('M Y'), 'up' => true,  'color' => 'blue',
             'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z',
             'spark' => [5,8,6,12,9,15,11,18,14,20,17,24]],
        ];
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
                    <svg class="w-4.5 h-4.5 w-5 h-5 text-<?= $s['color'] ?>-600 dark:text-<?= $s['color'] ?>-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $s['icon'] ?>"/>
                    </svg>
                </div>
                <span class="text-xs font-medium px-2 py-0.5 rounded-full <?= $s['up'] ? 'bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400' : 'bg-red-50 dark:bg-red-900/20 text-red-500 dark:text-red-400' ?>">
                    <?= $s['up'] ? '↑' : '↓' ?> <?= $s['change'] ?>
                </span>
            </div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100"><?= $s['value'] ?></p>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5 mb-3"><?= $s['label'] ?></p>
            <!-- Sparkline -->
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-10">
                <polyline points="<?= trim($pts) ?>" fill="none"
                    stroke="<?= ['indigo'=>'#6366f1','emerald'=>'#10b981','red'=>'#ef4444','blue'=>'#3b82f6'][$s['color']] ?>"
                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/>
            </svg>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Charts row -->
    <div class="grid lg:grid-cols-3 gap-4">

        <!-- User growth bar chart -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 p-5"
             x-data="userGrowthChart()"
             x-init="init()">

            <!-- Header + filters -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">User Growth</p>
                    <p class="text-xs text-zinc-400 mt-0.5">New registrations over time</p>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <!-- Filter tabs -->
                    <div class="flex items-center bg-zinc-100 dark:bg-zinc-800 rounded-lg p-0.5 gap-0.5">
                        <?php foreach (['today' => 'Today', 'week' => 'Week', 'month' => 'Month', 'year' => 'Year'] as $key => $label): ?>
                        <button @click="setFilter('<?= $key ?>')"
                                :class="filter === '<?= $key ?>' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                                class="px-2.5 py-1 text-xs font-medium rounded-md transition-all duration-150">
                            <?= $label ?>
                        </button>
                        <?php endforeach; ?>
                        <button @click="setFilter('custom')"
                                :class="filter === 'custom' ? 'bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                                class="px-2.5 py-1 text-xs font-medium rounded-md transition-all duration-150">
                            Custom
                        </button>
                    </div>

                    <!-- Custom date range -->
                    <div x-show="filter === 'custom'"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="flex items-center gap-1.5" style="display:none">
                        <input type="date" x-model="dateFrom"
                               class="h-7 px-2 text-xs border border-zinc-200 dark:border-zinc-700 rounded-md bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <span class="text-xs text-zinc-400">to</span>
                        <input type="date" x-model="dateTo"
                               class="h-7 px-2 text-xs border border-zinc-200 dark:border-zinc-700 rounded-md bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <button @click="applyCustom()"
                                class="h-7 px-2.5 text-xs font-medium bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition-colors">
                            Apply
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary row -->
            <div class="flex items-center gap-4 mb-4">
                <div>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100" x-text="total"></p>
                    <p class="text-xs text-zinc-400">Total registrations</p>
                </div>
                <div class="flex items-center gap-1 text-xs font-medium"
                     :class="trend >= 0 ? 'text-green-500' : 'text-red-400'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"
                         :class="trend >= 0 ? '' : 'rotate-180'">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <span x-text="Math.abs(trend) + '% vs prev period'"></span>
                </div>
            </div>

            <!-- Bar chart -->
            <div class="flex items-end gap-1.5" style="height:144px">
                <template x-for="(bar, i) in bars" :key="i">
                    <div class="flex-1 flex flex-col items-center gap-1 group" style="height:100%">
                        <div style="flex:1;display:flex;flex-direction:column;justify-content:flex-end;width:100%">
                            <div class="text-center" style="font-size:10px;color:#a1a1aa;opacity:0;transition:opacity .15s" @mouseenter="$el.style.opacity=1" @mouseleave="$el.style.opacity=0" x-text="bar.value"></div>
                            <div :style="'height:' + bar.height + '%;border-radius:4px 4px 0 0;transition:height .4s ease;width:100%;background:' + (bar.current ? '#6366f1' : '#e4e4e7')"
                                 @mouseenter="if(!bar.current) $el.style.background='#818cf8'"
                                 @mouseleave="if(!bar.current) $el.style.background='#e4e4e7'"
                                 class="dark-bar"></div>
                        </div>
                        <span style="font-size:9px;color:#a1a1aa;white-space:nowrap" x-text="bar.label"></span>
                    </div>
                </template>
            </div>
        </div>

        <!-- User status donut -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 p-5">
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-1">User Status</p>
            <p class="text-xs text-zinc-400 mb-5">Active vs Inactive breakdown</p>
            <?php
            $activePct   = $totalUsers ? round(($activeUsers / $totalUsers) * 100) : 0;
            $inactivePct = 100 - $activePct;
            $r = 30; $cx = 50; $cy = 50;
            $circ = 2 * M_PI * $r;
            $activeDash   = round(($activePct / 100) * $circ, 2);
            $inactiveDash = round(($inactivePct / 100) * $circ, 2);
            ?>
            <div class="flex justify-center mb-5">
                <svg viewBox="0 0 100 100" class="w-32 h-32 -rotate-90">
                    <circle cx="<?= $cx ?>" cy="<?= $cy ?>" r="<?= $r ?>" fill="none" stroke="#e4e4e7" stroke-width="12"/>
                    <circle cx="<?= $cx ?>" cy="<?= $cy ?>" r="<?= $r ?>" fill="none" stroke="#10b981" stroke-width="12"
                        stroke-dasharray="<?= $activeDash ?> <?= $circ ?>" stroke-linecap="round"/>
                    <circle cx="<?= $cx ?>" cy="<?= $cy ?>" r="<?= $r ?>" fill="none" stroke="#ef4444" stroke-width="12"
                        stroke-dasharray="<?= $inactiveDash ?> <?= $circ ?>"
                        stroke-dashoffset="-<?= $activeDash ?>" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between text-xs">
                    <span class="flex items-center gap-1.5 text-zinc-600 dark:text-zinc-400"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Active</span>
                    <span class="font-semibold text-zinc-900 dark:text-zinc-100"><?= number_format($activeUsers) ?> <span class="text-zinc-400 font-normal">(<?= $activePct ?>%)</span></span>
                </div>
                <div class="flex items-center justify-between text-xs">
                    <span class="flex items-center gap-1.5 text-zinc-600 dark:text-zinc-400"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>Inactive</span>
                    <span class="font-semibold text-zinc-900 dark:text-zinc-100"><?= number_format($inactiveUsers) ?> <span class="text-zinc-400 font-normal">(<?= $inactivePct ?>%)</span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom row: Recent users + Activity + Top pages -->
    <div class="grid lg:grid-cols-3 gap-4">

        <!-- Recent users table -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 overflow-hidden">
            <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Recent Users</p>
                <a href="<?= BASE_URL ?>/admin/users" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">View all →</a>
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
                    <tbody id="admin-dash-tbody" class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        <?php foreach ($recentUsers as $r): ?>
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs font-bold shrink-0">
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

        <!-- Right column: Activity + Top pages -->
        <div class="flex flex-col gap-4">

            <!-- Activity feed -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 p-5 flex-1">
                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Recent Activity</p>
                <div class="space-y-3">
                    <?php foreach ($activity as $a): ?>
                    <div class="flex items-start gap-2.5">
                        <div class="w-7 h-7 rounded-full <?= $colorMap[$a['color']] ?> flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="<?= $a['icon'] ?>"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-zinc-700 dark:text-zinc-300 leading-snug"><?= $a['text'] ?></p>
                            <p class="text-[10px] text-zinc-400 mt-0.5"><?= $a['time'] ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Top pages -->
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800 p-5">
                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Top Pages</p>
                <div class="space-y-3">
                    <?php
                    $maxViews = max(array_column($topPages, 'views'));
                    foreach ($topPages as $p):
                    ?>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-mono text-zinc-600 dark:text-zinc-400 truncate max-w-[120px]"><?= $p['page'] ?></span>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <span class="text-xs font-medium text-zinc-900 dark:text-zinc-100"><?= number_format($p['views']) ?></span>
                                <span class="text-[10px] <?= $p['change'] >= 0 ? 'text-green-500' : 'text-red-400' ?>">
                                    <?= $p['change'] >= 0 ? '+' : '' ?><?= $p['change'] ?>%
                                </span>
                            </div>
                        </div>
                        <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-1.5">
                            <div class="bg-indigo-500 h-1.5 rounded-full transition-all duration-500"
                                 style="width:<?= round(($p['views']/$maxViews)*100) ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const statsGrid = document.getElementById('admin-dash-stats');
    if (statsGrid) {
        const cardHTML = `
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-5 border border-zinc-100 dark:border-zinc-800">
            <div class="flex items-start justify-between mb-3">
                <div class="skeleton-base w-9 h-9 rounded-lg"></div>
                <div class="skeleton-base h-5 w-24 rounded-full"></div>
            </div>
            <div class="skeleton-base h-7 w-16 rounded mb-1"></div>
            <div class="skeleton-base h-3 w-24 rounded mb-3"></div>
            <div class="skeleton-base h-10 w-full rounded"></div>
        </div>`;
        const saved = statsGrid.innerHTML;
        statsGrid.innerHTML = cardHTML.repeat(4);
        setTimeout(() => { statsGrid.innerHTML = saved; }, 600);
    }
    const tbody = document.getElementById('admin-dash-tbody');
    if (tbody) {
        const rowHTML = `
        <tr>
            <td class="px-5 py-3">
                <div class="flex items-center gap-2.5">
                    <div class="skeleton-base w-7 h-7 rounded-full shrink-0"></div>
                    <div>
                        <div class="skeleton-base h-3 w-28 rounded mb-1"></div>
                        <div class="skeleton-base h-2.5 w-36 rounded"></div>
                    </div>
                </div>
            </td>
            <td class="px-5 py-3"><div class="skeleton-base h-5 w-16 rounded-full"></div></td>
            <td class="px-5 py-3"><div class="skeleton-base h-3 w-12 rounded"></div></td>
            <td class="px-5 py-3"><div class="skeleton-base h-3 w-20 rounded"></div></td>
        </tr>`;
        const savedTbody = tbody.innerHTML;
        tbody.innerHTML = rowHTML.repeat(5);
        setTimeout(() => { tbody.innerHTML = savedTbody; }, 600);
    }
});
</script>

<script>
const growthDatasets = <?= json_encode($growthDatasets) ?>;

function userGrowthChart() {
    return {
        filter: 'year',
        bars: [],
        total: 0,
        trend: 0,
        dateFrom: '',
        dateTo: '',

        init() { this.render('year'); },

        setFilter(f) {
            this.filter = f;
            if (f !== 'custom') this.render(f);
        },

        applyCustom() { this.render('custom'); },

        render(key) {
            const ds = growthDatasets[key];
            const max = Math.max(...ds.data);
            const currentIdx = key === 'year'  ? new Date().getMonth() :
                               key === 'week'  ? (new Date().getDay() || 7) - 1 :
                               key === 'today' ? Math.floor(new Date().getHours() / 3) : -1;
            this.bars = ds.data.map((v, i) => ({
                value: v,
                label: ds.labels[i],
                height: max > 0 ? Math.round((v / max) * 100) : 0,
                current: i === currentIdx,
            }));
            this.total = ds.data.reduce((a, b) => a + b, 0);
            const half = Math.floor(ds.data.length / 2);
            const prev = ds.data.slice(0, half).reduce((a, b) => a + b, 0);
            const curr = ds.data.slice(half).reduce((a, b) => a + b, 0);
            this.trend = prev > 0 ? Math.round(((curr - prev) / prev) * 100) : 100;
        }
    };
}
</script>

<style>
.dark .dark-bar[style*="background:#e4e4e7"] { background: #3f3f46 !important; }
</style>
