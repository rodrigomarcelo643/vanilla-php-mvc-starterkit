/**
 * User CRUD modal store — registered after Alpine defer script has run.
 */
document.addEventListener('alpine:init', () => {
    Alpine.store('userModal', {
        open: false,
        type: '',
        loading: false,
        form: {},

        openCreate() {
            this.form = { name: '', email: '', password: '', role: 'user', status: 'active' };
            this.type = 'create';
            this.open = true;
            this._clearAlert();
        },
        openEdit(u) {
            this.form = { id: u.id, name: u.name, email: u.email, role: u.role ?? 'user', status: u.status };
            this.type = 'edit';
            this.open = true;
            this._clearAlert();
        },
        openDelete(u) {
            this.form = { id: u.id, name: u.name };
            this.type = 'delete';
            this.open = true;
        },
        close() { this.open = false; },

        _clearAlert() {
            setTimeout(() => document.getElementById('modal-alert')?.classList.add('hidden'), 0);
        },
        _showAlert(msg, type) {
            const el = document.getElementById('modal-alert');
            if (!el) return;
            el.textContent = msg;
            el.className = 'mb-2 px-3 py-2.5 rounded-lg text-sm ' + (type === 'error'
                ? 'bg-red-50 text-red-600 border border-red-200'
                : 'bg-green-50 text-green-700 border border-green-200');
            el.classList.remove('hidden');
        },

        async submit() {
            this.loading = true;
            const isCreate = this.type === 'create';
            const url = BASE_URL + (isCreate ? '/ajax/users/create' : '/ajax/users/update');
            const fd = new FormData();
            Object.entries(this.form).forEach(([k, v]) => fd.append(k, v));
            try {
                const res = await Ajax.post(url, fd);
                if (res.success) {
                    this.open = false;
                    App.toast(res.message, 'success');
                    document.dispatchEvent(new CustomEvent('users:refresh', { detail: { res, form: { ...this.form } } }));
                } else {
                    this._showAlert(res.message ?? 'Something went wrong.', 'error');
                }
            } catch {
                this._showAlert('Network error.', 'error');
            }
            this.loading = false;
        },

        async submitDelete() {
            this.loading = true;
            const fd = new FormData();
            fd.append('id', this.form.id);
            try {
                const res = await Ajax.post(BASE_URL + '/ajax/users/delete', fd);
                if (res.success) {
                    this.open = false;
                    App.toast(res.message, 'success');
                    document.dispatchEvent(new CustomEvent('users:refresh', { detail: { deleted: this.form.id } }));
                } else {
                    App.toast(res.message ?? 'Delete failed.', 'error');
                    this.open = false;
                }
            } catch {
                App.toast('Network error.', 'error');
                this.open = false;
            }
            this.loading = false;
        },
    });
});
