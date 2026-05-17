<?php
$userList = $users ?? [];
$total    = count($userList);
?>

<div class="fade-in" x-data="UsersTable(<?= htmlspecialchars(json_encode($userList), ENT_QUOTES) ?>)">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Users</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Manage all registered users</p>
        </div>
        <button @click="openCreate()"
            class="inline-flex items-center gap-2 h-9 px-4 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add User
        </button>
    </div>

    <!-- Table card -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">

        <!-- Toolbar -->
        <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-zinc-100 dark:border-zinc-800">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" x-model="search" placeholder="Search users…"
                    class="h-8 pl-8 pr-3 w-56 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md placeholder-zinc-400 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:bg-white dark:focus:bg-zinc-800 transition">
            </div>
            <div class="flex items-center gap-2">
                <select x-model="filterRole"
                    class="h-8 px-2 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition">
                    <option value="">All roles</option>
                    <option value="user">User</option>
                    <option value="editor">Editor</option>
                </select>
                <select x-model="filterStatus"
                    class="h-8 px-2 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition">
                    <option value="">All status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <span class="text-xs text-zinc-400" x-text="filtered.length + ' of <?= $total ?>'"></span>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-zinc-100">
                    <tr>
                        <?php
                        $cols = [
                            ['key' => 'id',         'label' => '#'],
                            ['key' => 'name',       'label' => 'Name'],
                            ['key' => 'email',      'label' => 'Email'],
                            ['key' => 'role',       'label' => 'Role'],
                            ['key' => 'status',     'label' => 'Status'],
                            ['key' => 'created_at', 'label' => 'Joined'],
                        ];
                        foreach ($cols as $col): ?>
                        <th class="px-4 py-3 text-left">
                            <button @click="sort('<?= $col['key'] ?>')"
                                class="inline-flex items-center gap-1 text-xs font-medium text-zinc-500 hover:text-zinc-900 uppercase tracking-wide transition-colors">
                                <?= $col['label'] ?>
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortKey === '<?= $col['key'] ?>' && sortDir === 'asc' ? 'text-zinc-900' : 'text-zinc-300'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortKey === '<?= $col['key'] ?>' && sortDir === 'desc' ? 'text-zinc-900' : 'text-zinc-300'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </button>
                        </th>
                        <?php endforeach; ?>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                    <template x-for="u in paginated" :key="u.id">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-xs text-zinc-400 dark:text-zinc-500 font-mono" x-text="u.id"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <template x-if="u.avatar">
                                        <img :src="u.avatar" :alt="u.name" class="w-7 h-7 rounded-full object-cover shrink-0">
                                    </template>
                                    <template x-if="!u.avatar">
                                        <div class="w-7 h-7 rounded-full bg-zinc-900 dark:bg-zinc-600 flex items-center justify-center text-white shrink-0 text-[10px] font-semibold" x-text="u.name.charAt(0).toUpperCase()"></div>
                                    </template>
                                    <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100" x-text="u.name"></span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400" x-text="u.email"></td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 capitalize" x-text="u.role"></span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium capitalize"
                                    :class="u.status === 'active' ? 'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="u.status === 'active' ? 'bg-green-500 dark:bg-green-400' : 'bg-zinc-400 dark:bg-zinc-500'"></span>
                                    <span x-text="u.status"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-400 dark:text-zinc-500" x-text="formatDate(u.created_at)"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <button @click="openEdit(u)"
                                        class="inline-flex items-center gap-1 h-7 px-2.5 text-xs font-medium border border-zinc-200 dark:border-zinc-700 rounded-md text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 hover:border-zinc-300 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-2a2 2 0 01.586-1.414z"/></svg>
                                        Edit
                                    </button>
                                    <button @click="openDelete(u)"
                                        class="inline-flex items-center gap-1 h-7 px-2.5 text-xs font-medium border border-red-200 rounded-md text-red-500 hover:bg-red-50 hover:border-red-300 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filtered.length === 0">
                        <td colspan="7" class="px-4 py-10 text-center text-sm text-zinc-400 dark:text-zinc-500">No users found.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between px-4 py-3 border-t border-zinc-100 dark:border-zinc-800" x-show="totalPages > 1">
            <p class="text-xs text-zinc-400 dark:text-zinc-500">Page <span x-text="page"></span> of <span x-text="totalPages"></span></p>
            <div class="flex items-center gap-1">
                <button @click="page = 1" :disabled="page === 1" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">«</button>
                <button @click="page--" :disabled="page === 1" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">‹</button>
                <template x-for="p in pageRange" :key="p">
                    <button x-text="p === '...' ? '…' : p"
                        @click="p !== '...' && (page = p)"
                        :class="p === page ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100' : 'border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800'"
                        :disabled="p === '...'"
                        class="h-7 min-w-[28px] px-1 flex items-center justify-center rounded-md text-xs border transition-colors disabled:cursor-default">
                    </button>
                </template>
                <button @click="page++" :disabled="page === totalPages" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">›</button>
                <button @click="page = totalPages" :disabled="page === totalPages" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 dark:border-zinc-700 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">»</button>
            </div>
        </div>
    </div>

</div>

