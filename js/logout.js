/**
 * logout.js — confirmation modal + AJAX session destroy
 */

const LogoutModal = (() => {
    function getEl(id) { return document.getElementById(id); }

    function show() {
        const modal    = getEl('logout-modal');
        const backdrop = getEl('logout-backdrop');
        const panel    = getEl('logout-panel');
        if (!modal) return;
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                backdrop.style.opacity = '1';
                panel.style.opacity    = '1';
                panel.style.transform  = 'scale(1)';
            });
        });
        document.addEventListener('keydown', onKeydown);
        getEl('logout-backdrop').addEventListener('click', hide);
    }

    function hide() {
        const modal    = getEl('logout-modal');
        const backdrop = getEl('logout-backdrop');
        const panel    = getEl('logout-panel');
        if (!modal) return;
        backdrop.style.opacity = '0';
        panel.style.opacity    = '0';
        panel.style.transform  = 'scale(0.95)';
        document.removeEventListener('keydown', onKeydown);
        setTimeout(() => {
            modal.classList.add('hidden');
            const btn = getEl('logout-confirm-btn');
            const txt = getEl('logout-confirm-text');
            const spn = getEl('logout-spinner');
            if (btn) btn.disabled = false;
            if (txt) txt.textContent = 'Sign out';
            if (spn) spn.classList.add('hidden');
        }, 200);
    }

    function onKeydown(e) {
        if (e.key === 'Escape') hide();
    }

    async function doLogout() {
        const btn = getEl('logout-confirm-btn');
        const txt = getEl('logout-confirm-text');
        const spn = getEl('logout-spinner');
        if (btn) btn.disabled = true;
        if (txt) txt.textContent = 'Signing out…';
        if (spn) spn.classList.remove('hidden');
        try {
            const res = await Ajax.post(BASE_URL + '/ajax/logout', {});
            window.location.href = res.redirect ?? BASE_URL + '/';
        } catch {
            window.location.href = BASE_URL + '/';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const cancelBtn  = getEl('logout-cancel-btn');
        const confirmBtn = getEl('logout-confirm-btn');
        if (cancelBtn)  cancelBtn.addEventListener('click', hide);
        if (confirmBtn) confirmBtn.addEventListener('click', doLogout);
    });

    return { show, hide };
})();
