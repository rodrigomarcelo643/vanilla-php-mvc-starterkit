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
