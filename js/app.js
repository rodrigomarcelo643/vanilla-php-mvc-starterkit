/**
 * App — global utilities
 */
const App = {

    // App Toast
    toast(message, type = 'info') {
        const cfg = {
            success: {
                bg:     'linear-gradient(to right, #10b981, #059669)',
                border: '1px solid rgba(52,211,153,0.35)',
                bar:    '#6ee7b7',
                icon: `<svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`
            },
            error: {
                bg:     'linear-gradient(to right, #f43f5e, #dc2626)',
                border: '1px solid rgba(251,113,133,0.35)',
                bar:    '#fda4af',
                icon: `<svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`
            },
            info: {
                bg:     'linear-gradient(to right, #6366f1, #7c3aed)',
                border: '1px solid rgba(129,140,248,0.35)',
                bar:    '#a5b4fc',
                icon: `<svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="9" stroke-linecap="round"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8h.01M11 12h1v4h1"/></svg>`
            }
        };
        const c = cfg[type] ?? cfg.info;
        const toast = document.createElement('div');
        toast.className = 'toast-in';
        toast.style.cssText = `
            position:relative; overflow:hidden; display:flex; align-items:center; gap:12px;
            background:${c.bg}; border:${c.border}; border-radius:12px;
            color:#fff; font-size:14px; font-weight:500; padding:12px 14px;
            box-shadow:0 8px 24px rgba(0,0,0,0.18); max-width:320px; width:max-content;
        `;
        toast.innerHTML = `
            <span style="opacity:.9;display:flex;flex-shrink:0">${c.icon}</span>
            <span style="flex:1;line-height:1.4">${message}</span>
            <button onclick="this.parentElement.remove()" style="opacity:.6;font-size:18px;line-height:1;background:none;border:none;color:#fff;cursor:pointer;padding:0 2px" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=.6">&times;</button>
            <span class="toast-bar" style="position:absolute;bottom:0;left:0;height:2px;width:100%;background:${c.bar};transform-origin:left"></span>
        `;
        const container = document.getElementById('toast-container');
        if (container) {
            container.appendChild(toast);
            setTimeout(() => { toast.classList.add('toast-out'); setTimeout(() => toast.remove(), 300); }, 4000);
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
