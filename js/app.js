/**
 * App — global utilities
 */
const App = {

    // App Toast
    toast(message, type = 'info') {
        const colors = { success: 'bg-green-600', error: 'bg-red-600', info: 'bg-indigo-600' };
        const toast = document.createElement('div');
        toast.className = `${colors[type] ?? colors.info} text-white text-sm font-medium px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 animate-slide-in max-w-xs`;
        toast.innerHTML = `
            <span class="flex-1">${message}</span>
            <button onclick="this.parentElement.remove()" class="opacity-70 hover:opacity-100 text-lg leading-none">&times;</button>
        `;
        const container = document.getElementById('toast-container');
        if (container) {
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 4000);
        }
    },
    // Error Alert
    alert(id, message, type = 'error') {
        const el = document.getElementById(id);
        if (!el) return;
        el.className = `mb-4 px-3 py-2.5 rounded-lg text-sm ${type === 'success' ? 'alert-success' : 'alert-error'}`;
        el.textContent = message;
        el.classList.remove('hidden');
    },

    setLoading(btnId, spinnerId, loading) {
        const btn     = document.getElementById(btnId);
        const spinner = document.getElementById(spinnerId);
        if (!btn) return;
        btn.disabled = loading;
        if (spinner) spinner.classList.toggle('hidden', !loading);
    },

    // Logout Redirection
    logout() {
        if (typeof LogoutModal !== 'undefined') {
            LogoutModal.show();
        } else {
            Ajax.post(BASE_URL + '/ajax/logout', {}).then(res => {
                window.location.href = res.redirect ?? BASE_URL + '/login';
            }).catch(() => { window.location.href = BASE_URL + '/login'; });
        }
    },
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.fade-in').forEach((el, i) => {
        el.style.animationDelay = `${i * 60}ms`;
    });
});

function GlobalSearch(items) {
    return {
        query: '',
        open: false,
        active: 0,
        items,
        get results() {
            if (!this.query.trim()) return [];
            const q = this.query.toLowerCase();
            return this.items.filter(r =>
                r.label.toLowerCase().includes(q) || r.desc.toLowerCase().includes(q)
            );
        },
        move(dir) {
            if (!this.results.length) return;
            this.active = (this.active + dir + this.results.length) % this.results.length;
        },
        go() {
            if (this.results[this.active]) {
                window.location.href = this.results[this.active].href;
            }
        }
    };
}
