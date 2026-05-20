<?php
$adminList = $admins ?? [];
$total     = count($adminList);
?>

<div class="fade-in"
     x-data="AdminsTable(<?= htmlspecialchars(json_encode($adminList), ENT_QUOTES) ?>)"
     x-init="init()">

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Admins</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Manage all admin accounts</p>
        </div>
        <button @click="openCreate()"
            class="inline-flex items-center gap-2 h-9 px-4 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Admin
        </button>
    </div>

    <!-- Table card -->
    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm overflow-hidden">

        <!-- Skeleton overlay -->
        <div id="admins-skeleton" class="overflow-hidden">
            <!-- toolbar -->
            <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-zinc-100 dark:border-zinc-800">
                <div class="skeleton-base h-8 w-56 rounded-md"></div>
                <div class="flex items-center gap-2">
                    <div class="skeleton-base h-8 w-28 rounded-md"></div>
                    <div class="skeleton-base h-4 w-12 rounded"></div>
                </div>
            </div>
            <!-- table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-zinc-100 dark:border-zinc-800">
                        <tr>
                            <?php foreach (['w-6','w-28','w-40','w-20','w-24','w-20'] as $w): ?>
                            <th class="px-4 py-3 text-left"><div class="skeleton-base h-3 <?= $w ?> rounded"></div></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-50 dark:divide-zinc-800">
                        <?php
                        $nameWidths = ['w-24','w-32','w-20','w-28','w-36','w-24','w-30','w-28'];
                        $emailWidths = ['w-36','w-44','w-32','w-40','w-48','w-36','w-40','w-44'];
                        for ($i = 0; $i < 8; $i++): ?>
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3"><div class="skeleton-base h-3 w-6 rounded"></div></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="skeleton-base w-7 h-7 rounded-full shrink-0"></div>
                                    <div class="skeleton-base h-3 <?= $nameWidths[$i] ?> rounded"></div>
                                </div>
                            </td>
                            <td class="px-4 py-3"><div class="skeleton-base h-3 <?= $emailWidths[$i] ?> rounded"></div></td>
                            <td class="px-4 py-3"><div class="skeleton-base h-5 w-16 rounded-md"></div></td>
                            <td class="px-4 py-3"><div class="skeleton-base h-3 w-20 rounded"></div></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <div class="skeleton-base h-7 w-14 rounded-md"></div>
                                    <div class="skeleton-base h-7 w-16 rounded-md"></div>
                                </div>
                            </td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <!-- pagination -->
            <div class="flex items-center justify-between px-4 py-3 border-t border-zinc-100 dark:border-zinc-800">
                <div class="skeleton-base h-3 w-32 rounded"></div>
                <div class="flex items-center gap-1">
                    <?php for($i=0;$i<5;$i++): ?><div class="skeleton-base h-7 w-7 rounded-md"></div><?php endfor; ?>
                </div>
            </div>
        </div>

        <div id="admins-content" style="display:none">

        <div class="flex items-center justify-between gap-3 px-4 py-3 border-b border-zinc-100 dark:border-zinc-800">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-zinc-400 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" x-model="search" placeholder="Search admins…"
                    class="h-8 pl-8 pr-3 w-56 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md placeholder-zinc-400 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-violet-600 focus:bg-white dark:focus:bg-zinc-800 transition">
            </div>
            <div class="flex items-center gap-2">
                <select x-model="filterStatus"
                    class="h-8 px-2 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-md text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-violet-600 transition">
                    <option value="">All status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <span class="text-xs text-zinc-400" x-text="filtered.length + ' of <?= $total ?>'"></span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-zinc-100">
                    <tr>
                        <?php foreach ([['id','#'],['name','Name'],['email','Email'],['status','Status'],['created_at','Created']] as [$key,$label]): ?>
                        <th class="px-4 py-3 text-left">
                            <button @click="sort('<?= $key ?>')"
                                class="inline-flex items-center gap-1 text-xs font-medium text-zinc-500 hover:text-zinc-900 uppercase tracking-wide transition-colors">
                                <?= $label ?>
                                <span class="flex flex-col leading-none">
                                    <svg class="w-2.5 h-2.5" :class="sortKey==='<?= $key ?>'&&sortDir==='asc'?'text-zinc-900':'text-zinc-300'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                                    <svg class="w-2.5 h-2.5" :class="sortKey==='<?= $key ?>'&&sortDir==='desc'?'text-zinc-900':'text-zinc-300'" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </span>
                            </button>
                        </th>
                        <?php endforeach; ?>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody id="admins-tbody" class="divide-y divide-zinc-50 dark:divide-zinc-800">
                    <template x-for="u in paginated" :key="u.id">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-xs text-zinc-400 font-mono" x-text="u.id"></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-violet-600 flex items-center justify-center text-white shrink-0 text-[10px] font-semibold" x-text="u.name.charAt(0).toUpperCase()"></div>
                                    <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100" x-text="u.name"></span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400" x-text="u.email"></td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium capitalize"
                                    :class="u.status==='active'?'bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400':'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'">
                                    <span class="w-1.5 h-1.5 rounded-full" :class="u.status==='active'?'bg-green-500':'bg-zinc-400'"></span>
                                    <span x-text="u.status"></span>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-zinc-400" x-text="formatDate(u.created_at)"></td>
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
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-zinc-400">No admins found.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="admins-pagination" class="flex items-center justify-between px-4 py-3 border-t border-zinc-100 dark:border-zinc-800" x-show="totalPages > 1">
            <p class="text-xs text-zinc-400">
                Showing <span class="font-medium text-zinc-700 dark:text-zinc-300" x-text="(page-1)*perPage+1"></span>–<span class="font-medium text-zinc-700 dark:text-zinc-300" x-text="Math.min(page*perPage,filtered.length)"></span> of <span class="font-medium text-zinc-700 dark:text-zinc-300" x-text="filtered.length"></span>
            </p>
            <div class="flex items-center gap-1">
                <button @click="page--" :disabled="page===1" class="h-7 w-7 flex items-center justify-center rounded-md border border-zinc-200 dark:border-zinc-700 text-zinc-500 hover:bg-zinc-50 disabled:opacity-40 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <template x-for="p in pageRange" :key="p">
                    <button x-text="p==='...'?'…':p" @click="p!=='...'&&(page=p)"
                        :class="p===page?'bg-violet-600 text-white border-violet-600 font-semibold':'border-zinc-200 dark:border-zinc-700 text-zinc-600 hover:bg-zinc-50'"
                        :disabled="p==='...'"
                        class="h-7 min-w-[28px] px-1.5 flex items-center justify-center rounded-md text-xs border transition-colors disabled:cursor-default">
                    </button>
                </template>
                <button @click="page++" :disabled="page===totalPages" class="h-7 w-7 flex items-center justify-center rounded-md border border-zinc-200 dark:border-zinc-700 text-zinc-500 hover:bg-zinc-50 disabled:opacity-40 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
        </div><!-- end admins-content -->

    </div><!-- end table card -->

    <!-- Create / Edit Modal — teleported to body to escape overflow containers -->
    <template x-teleport="body">
        <div x-show="modal.open && modal.type !== 'delete'" style="display:none"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-md">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden" @click.stop>
                <div class="px-6 pt-6 pb-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100" x-text="modal.type==='create'?'Add New Admin':'Edit Admin'"></h2>
                        <p class="text-xs text-zinc-500 mt-0.5" x-text="modal.type==='create'?'Create a new admin account':'Update admin information'"></p>
                    </div>
                    <button @click="modal.open=false" class="w-8 h-8 flex items-center justify-center text-zinc-400 hover:text-zinc-600 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form @submit.prevent="submitForm()" class="p-6 space-y-4">
                    <div id="admin-modal-alert" class="hidden px-4 py-3 rounded-xl text-sm"></div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500">Full Name</label>
                        <input type="text" x-model="modal.form.name" required
                            class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500">Email Address</label>
                        <input type="email" x-model="modal.form.email" required
                            class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent transition-all">
                    </div>
                    <div x-show="modal.type==='create'" class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500">Password</label>
                        <input type="password" x-model="modal.form.password"
                            class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500">Status</label>
                        <select x-model="modal.form.status"
                            class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-600 focus:border-transparent transition-all">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="flex gap-3 pt-2 border-t border-zinc-100 dark:border-zinc-800">
                        <button type="button" @click="modal.open=false"
                            class="flex-1 h-11 text-sm font-medium border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                            Cancel
                        </button>
                        <button type="submit" :disabled="modal.loading"
                            class="flex-1 h-11 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-xl transition-all flex items-center justify-center gap-2 disabled:opacity-70">
                            <span x-text="modal.loading?'Saving...':(modal.type==='create'?'Create Admin':'Save Changes')"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <!-- Delete Modal — teleported to body -->
    <template x-teleport="body">
        <div x-show="modal.open && modal.type==='delete'" style="display:none"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
            class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-md">
            <div class="bg-white dark:bg-zinc-900 border border-red-200 dark:border-red-900/30 rounded-2xl shadow-2xl max-w-sm w-full" @click.stop>
                <div class="p-8 text-center">
                    <div class="mx-auto w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Delete Admin?</h3>
                    <p class="text-sm text-zinc-500">Permanently delete <strong class="text-zinc-700 dark:text-zinc-200" x-text="modal.form.name"></strong>?</p>
                    <p class="text-xs text-red-500 mt-1">This action cannot be undone.</p>
                </div>
                <div class="flex gap-3 px-6 pb-6">
                    <button @click="modal.open=false" class="flex-1 h-11 text-sm font-medium border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-xl transition-colors">Cancel</button>
                    <button @click="submitDelete()" :disabled="modal.loading"
                        class="flex-1 h-11 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-all flex items-center justify-center">
                        <span x-text="modal.loading?'Deleting...':'Yes, Delete'"></span>
                    </button>
                </div>
            </div>
        </div>
    </template>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const sk = document.getElementById('admins-skeleton');
    const ct = document.getElementById('admins-content');
    if (sk && ct) {
        setTimeout(() => { sk.style.display = 'none'; ct.style.display = ''; }, 500);
    }
});

function AdminsTable(data) {
    return {
        rows: data,
        search: '', filterStatus: '',
        sortKey: 'id', sortDir: 'asc',
        page: 1, perPage: 10,
        modal: { open: false, type: '', loading: false, form: {} },

        init() {
            this.$watch('search',       () => { this.page = 1; });
            this.$watch('filterStatus', () => { this.page = 1; });
        },

        get filtered() {
            let d = this.rows.filter(u => {
                const q = this.search.toLowerCase();
                return (!q || u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q))
                    && (!this.filterStatus || u.status === this.filterStatus);
            });
            return [...d].sort((a, b) => {
                const av = (a[this.sortKey] ?? '').toString().toLowerCase();
                const bv = (b[this.sortKey] ?? '').toString().toLowerCase();
                return this.sortDir === 'asc' ? (av > bv ? 1 : -1) : (av < bv ? 1 : -1);
            });
        },
        get totalPages() { return Math.max(1, Math.ceil(this.filtered.length / this.perPage)); },
        get paginated()  { return this.filtered.slice((this.page - 1) * this.perPage, this.page * this.perPage); },
        get pageRange() {
            const t = this.totalPages, p = this.page, r = [];
            if (t <= 7) { for (let i = 1; i <= t; i++) r.push(i); return r; }
            r.push(1);
            if (p > 3) r.push('...');
            for (let i = Math.max(2, p - 1); i <= Math.min(t - 1, p + 1); i++) r.push(i);
            if (p < t - 2) r.push('...');
            r.push(t);
            return r;
        },

        sort(key) {
            this.sortDir = this.sortKey === key ? (this.sortDir === 'asc' ? 'desc' : 'asc') : 'asc';
            this.sortKey = key; this.page = 1;
        },

        formatDate(d) {
            return d ? new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '—';
        },

        showAlert(msg, type) {
            const el = document.getElementById('admin-modal-alert');
            if (!el) return;
            el.textContent = msg;
            el.className = 'mb-2 px-3 py-2.5 rounded-lg text-sm ' + (type === 'error'
                ? 'bg-red-50 text-red-600 border border-red-200'
                : 'bg-green-50 text-green-700 border border-green-200');
            el.classList.remove('hidden');
        },

        openCreate() {
            this.modal = { open: true, type: 'create', loading: false, form: { name: '', email: '', password: '', status: 'active' } };
            this.$nextTick(() => document.getElementById('admin-modal-alert')?.classList.add('hidden'));
        },

        openEdit(u) {
            this.modal = { open: true, type: 'edit', loading: false, form: { id: u.id, name: u.name, email: u.email, status: u.status } };
            this.$nextTick(() => document.getElementById('admin-modal-alert')?.classList.add('hidden'));
        },

        openDelete(u) {
            this.modal = { open: true, type: 'delete', loading: false, form: { id: u.id, name: u.name } };
        },

        async submitForm() {
            this.modal.loading = true;
            const url = this.modal.type === 'create'
                ? BASE_URL + '/ajax/admins/create'
                : BASE_URL + '/ajax/admins/update';
            const fd = new FormData();
            Object.entries(this.modal.form).forEach(([k, v]) => fd.append(k, v));
            try {
                const res = await Ajax.post(url, fd);
                if (res.success) {
                    this.modal.open = false;
                    App.toast(res.message, 'success');
                    if (this.modal.type === 'create') {
                        this.rows.unshift({ id: res.id, name: this.modal.form.name, email: this.modal.form.email, status: this.modal.form.status, created_at: new Date().toISOString() });
                    } else {
                        const idx = this.rows.findIndex(r => r.id === this.modal.form.id);
                        if (idx !== -1) Object.assign(this.rows[idx], { name: this.modal.form.name, email: this.modal.form.email, status: this.modal.form.status });
                    }
                } else {
                    this.showAlert(res.message ?? 'Something went wrong.', 'error');
                }
            } catch { this.showAlert('Network error.', 'error'); }
            this.modal.loading = false;
        },

        async submitDelete() {
            this.modal.loading = true;
            const fd = new FormData();
            fd.append('id', this.modal.form.id);
            try {
                const res = await Ajax.post(BASE_URL + '/ajax/admins/delete', fd);
                if (res.success) {
                    this.rows = this.rows.filter(r => r.id !== this.modal.form.id);
                    this.modal.open = false;
                    App.toast(res.message, 'success');
                    if (this.page > this.totalPages) this.page = this.totalPages;
                } else {
                    App.toast(res.message ?? 'Delete failed.', 'error');
                    this.modal.open = false;
                }
            } catch { App.toast('Network error.', 'error'); this.modal.open = false; }
            this.modal.loading = false;
        },
    };
}
</script>
