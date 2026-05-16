<?php
$userList = $users ?? [];
$total    = count($userList);
?>

<div class="fade-in" x-data="UsersTable(<?= htmlspecialchars(json_encode($userList), ENT_QUOTES) ?>)">

    <!-- Header -->
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-semibold text-zinc-900">Users</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Manage all registered users</p>
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
    <div class="bg-white border border-zinc-200 rounded-xl shadow-sm overflow-hidden">

        <!-- Toolbar -->
        <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-zinc-100">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" x-model="search" placeholder="Search users…"
                    class="h-8 pl-8 pr-3 w-56 text-sm bg-zinc-50 border border-zinc-200 rounded-md placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:bg-white transition">
            </div>
            <div class="flex items-center gap-2">
                <select x-model="filterRole"
                    class="h-8 px-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition">
                    <option value="">All roles</option>
                    <option value="user">User</option>
                    <option value="editor">Editor</option>
                </select>
                <select x-model="filterStatus"
                    class="h-8 px-2 text-sm bg-zinc-50 border border-zinc-200 rounded-md text-zinc-700 focus:outline-none focus:ring-2 focus:ring-zinc-900 transition">
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
                <tbody class="divide-y divide-zinc-50">
                    <template x-for="u in paginated" :key="u.id">
                        <tr class="hover:bg-zinc-50 transition-colors">
                            <td class="px-4 py-3 text-xs text-zinc-400 font-mono" x-text="u.id"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-zinc-900 flex items-center justify-center text-white shrink-0 text-[10px] font-semibold" x-text="u.name.charAt(0).toUpperCase()"></div>
                                    <span class="text-sm font-medium text-zinc-900" x-text="u.name"></span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-500" x-text="u.email"></td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-zinc-100 text-zinc-700 capitalize" x-text="u.role"></span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium capitalize"
                                    :class="u.status === 'active' ? 'bg-green-50 text-green-700' : 'bg-zinc-100 text-zinc-500'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="u.status === 'active' ? 'bg-green-500' : 'bg-zinc-400'"></span>
                                    <span x-text="u.status"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-400" x-text="formatDate(u.created_at)"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <button @click="openEdit(u)"
                                        class="inline-flex items-center gap-1 h-7 px-2.5 text-xs font-medium border border-zinc-200 rounded-md text-zinc-600 hover:bg-zinc-50 hover:border-zinc-300 transition-colors">
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
                        <td colspan="7" class="px-4 py-10 text-center text-sm text-zinc-400">No users found.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between px-4 py-3 border-t border-zinc-100" x-show="totalPages > 1">
            <p class="text-xs text-zinc-400">Page <span x-text="page"></span> of <span x-text="totalPages"></span></p>
            <div class="flex items-center gap-1">
                <button @click="page = 1" :disabled="page === 1" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 text-zinc-500 hover:bg-zinc-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">«</button>
                <button @click="page--" :disabled="page === 1" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 text-zinc-500 hover:bg-zinc-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">‹</button>
                <template x-for="p in pageRange" :key="p">
                    <button x-text="p === '...' ? '…' : p"
                        @click="p !== '...' && (page = p)"
                        :class="p === page ? 'bg-zinc-900 text-white border-zinc-900' : 'border-zinc-200 text-zinc-600 hover:bg-zinc-50'"
                        :disabled="p === '...'"
                        class="h-7 min-w-[28px] px-1 flex items-center justify-center rounded-md text-xs border transition-colors disabled:cursor-default">
                    </button>
                </template>
                <button @click="page++" :disabled="page === totalPages" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 text-zinc-500 hover:bg-zinc-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">›</button>
                <button @click="page = totalPages" :disabled="page === totalPages" class="h-7 w-7 flex items-center justify-center rounded-md text-xs border border-zinc-200 text-zinc-500 hover:bg-zinc-50 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">»</button>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('userModal', {
        open: false, type: '', loading: false, form: {}, _table: null,

        close() { this.open = false; },

        showAlert(msg, type) {
            const el = document.getElementById('modal-alert');
            if (!el) return;
            el.textContent = msg;
            el.className = 'mb-4 px-3 py-2.5 rounded-lg text-sm ' + (type === 'error' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-green-50 text-green-700 border border-green-200');
            el.classList.remove('hidden');
        },

        async submit() {
            this.loading = true;
            const url = this.type === 'create' ? BASE_URL + '/ajax/users/create' : BASE_URL + '/ajax/users/update';
            const fd  = new FormData();
            Object.entries(this.form).forEach(([k, v]) => fd.append(k, v));
            try {
                const res = await Ajax.post(url, fd);
                if (res.success) {
                    this.open = false;
                    App.toast(res.message, 'success');
                    if (this.type === 'create') {
                        this._table.rows.unshift({ id: res.id, name: this.form.name, email: this.form.email, role: this.form.role, status: this.form.status, created_at: new Date().toISOString() });
                    } else {
                        const idx = this._table.rows.findIndex(u => u.id === this.form.id);
                        if (idx !== -1) Object.assign(this._table.rows[idx], { name: this.form.name, email: this.form.email, role: this.form.role, status: this.form.status });
                    }
                } else {
                    this.showAlert(res.message ?? 'Something went wrong.', 'error');
                }
            } catch { this.showAlert('Network error.', 'error'); }
            this.loading = false;
        },

        async submitDelete() {
            this.loading = true;
            const fd = new FormData();
            fd.append('id', this.form.id);
            try {
                const res = await Ajax.post(BASE_URL + '/ajax/users/delete', fd);
                if (res.success) {
                    this._table.rows = this._table.rows.filter(u => u.id !== this.form.id);
                    this.open = false;
                    App.toast(res.message, 'success');
                    if (this._table.page > this._table.totalPages) this._table.page = this._table.totalPages;
                } else {
                    App.toast(res.message ?? 'Delete failed.', 'error');
                    this.open = false;
                }
            } catch { App.toast('Network error.', 'error'); this.open = false; }
            this.loading = false;
        }
    });
});

function UsersTable(initial) {
    return {
        rows: initial, search: '', filterRole: '', filterStatus: '',
        sortKey: 'id', sortDir: 'asc', page: 1, perPage: 10,

        get filtered() {
            let data = this.rows.filter(u => {
                const q = this.search.toLowerCase();
                return (!q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q))
                    && (!this.filterRole   || u.role   === this.filterRole)
                    && (!this.filterStatus || u.status === this.filterStatus);
            });
            return [...data].sort((a, b) => {
                let av = (a[this.sortKey] ?? '').toString().toLowerCase();
                let bv = (b[this.sortKey] ?? '').toString().toLowerCase();
                return this.sortDir === 'asc' ? (av > bv ? 1 : -1) : (av < bv ? 1 : -1);
            });
        },

        get totalPages() { return Math.max(1, Math.ceil(this.filtered.length / this.perPage)); },
        get paginated()  { return this.filtered.slice((this.page - 1) * this.perPage, this.page * this.perPage); },

        get pageRange() {
            const total = this.totalPages, cur = this.page, pages = [];
            if (total <= 7) { for (let i = 1; i <= total; i++) pages.push(i); return pages; }
            pages.push(1);
            if (cur > 3) pages.push('...');
            for (let i = Math.max(2, cur - 1); i <= Math.min(total - 1, cur + 1); i++) pages.push(i);
            if (cur < total - 2) pages.push('...');
            pages.push(total);
            return pages;
        },

        sort(key) {
            this.sortDir = this.sortKey === key ? (this.sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
            this.sortKey = key; this.page = 1;
        },

        formatDate(d) {
            return d ? new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '—';
        },

        openCreate() {
            Alpine.store('userModal')._table   = this;
            Alpine.store('userModal').open     = true;
            Alpine.store('userModal').type     = 'create';
            Alpine.store('userModal').loading  = false;
            Alpine.store('userModal').form     = { name: '', email: '', password: '', role: 'user', status: 'active' };
            document.getElementById('modal-alert')?.classList.add('hidden');
        },

        openEdit(u) {
            Alpine.store('userModal')._table   = this;
            Alpine.store('userModal').open     = true;
            Alpine.store('userModal').type     = 'edit';
            Alpine.store('userModal').loading  = false;
            Alpine.store('userModal').form     = { id: u.id, name: u.name, email: u.email, role: u.role, status: u.status };
            document.getElementById('modal-alert')?.classList.add('hidden');
        },

        openDelete(u) {
            Alpine.store('userModal')._table   = this;
            Alpine.store('userModal').open     = true;
            Alpine.store('userModal').type     = 'delete';
            Alpine.store('userModal').loading  = false;
            Alpine.store('userModal').form     = { id: u.id, name: u.name };
        },

        init() {
            this.$watch('search',       () => { this.page = 1; });
            this.$watch('filterRole',   () => { this.page = 1; });
            this.$watch('filterStatus', () => { this.page = 1; });
        }
    };
}
</script>
