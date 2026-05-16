/**
 * profile.js — profile info edit + change password handlers
 */

(function () {
    // ── Shared helper ─────────────────────────────────────────
    function showAlert(el, msg, type) {
        el.textContent = msg;
        el.className   = 'px-3.5 py-3 rounded-lg text-sm ' +
            (type === 'error'
                ? 'bg-red-50 text-red-600 border border-red-200'
                : 'bg-green-50 text-green-700 border border-green-200');
        el.classList.remove('hidden');
    }

    // ── Profile info edit ─────────────────────────────────────
    const editBtn     = document.getElementById('profile-edit-btn');
    const cancelBtn   = document.getElementById('profile-cancel-btn');
    const viewEl      = document.getElementById('profile-view');
    const formEl      = document.getElementById('profile-edit-form');
    const alertEl     = document.getElementById('profile-alert');
    const saveBtn     = document.getElementById('profile-save-btn');
    const saveText    = document.getElementById('profile-save-text');
    const saveSpinner = document.getElementById('profile-save-spinner');

    if (editBtn) {
        editBtn.addEventListener('click', () => {
            viewEl.classList.add('hidden');
            formEl.classList.remove('hidden');
            editBtn.classList.add('hidden');
            alertEl.classList.add('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            viewEl.classList.remove('hidden');
            formEl.classList.add('hidden');
            editBtn.classList.remove('hidden');
            alertEl.classList.add('hidden');
        });

        formEl.addEventListener('submit', async e => {
            e.preventDefault();
            saveBtn.disabled     = true;
            saveText.textContent = 'Saving…';
            saveSpinner.classList.remove('hidden');

            try {
                const res = await Ajax.post(BASE_URL + '/ajax/profile', new FormData(formEl));
                if (res.success) {
                    // Update input values
                    document.getElementById('profile-name').value  = res.name;
                    document.getElementById('profile-email').value = res.email;
                    // Update view rows
                    viewEl.querySelectorAll('[data-profile-key]').forEach(el => {
                        if (el.dataset.profileKey === 'name')  el.textContent = res.name;
                        if (el.dataset.profileKey === 'email') el.textContent = res.email;
                    });
                    // Update every name/email node across topbar, sidebar, navbar, avatar card
                    document.querySelectorAll('[data-user-name]').forEach(el => el.textContent = res.name);
                    document.querySelectorAll('[data-user-email]').forEach(el => el.textContent = res.email);
                    cancelBtn.click();
                    App.toast(res.message, 'success');
                } else {
                    showAlert(alertEl, res.message ?? 'Update failed.', 'error');
                }
            } catch {
                showAlert(alertEl, 'Something went wrong. Please try again.', 'error');
            } finally {
                saveBtn.disabled     = false;
                saveText.textContent = 'Save changes';
                saveSpinner.classList.add('hidden');
            }
        });
    }

    // ── Change password ───────────────────────────────────────
    const pwToggle  = document.getElementById('pw-toggle-btn');
    const pwHint    = document.getElementById('pw-hint');
    const pwForm    = document.getElementById('pw-form');
    const pwAlert   = document.getElementById('pw-alert');
    const pwCancel  = document.getElementById('pw-cancel-btn');
    const pwSaveBtn = document.getElementById('pw-save-btn');
    const pwSaveTxt = document.getElementById('pw-save-text');
    const pwSpinner = document.getElementById('pw-save-spinner');
    const pwNew     = document.getElementById('pw-new');

    if (pwToggle) {
        pwToggle.addEventListener('click', () => {
            pwHint.classList.add('hidden');
            pwForm.classList.remove('hidden');
            pwToggle.classList.add('hidden');
        });

        pwCancel.addEventListener('click', () => {
            pwHint.classList.remove('hidden');
            pwForm.classList.add('hidden');
            pwToggle.classList.remove('hidden');
            pwForm.reset();
            pwAlert.classList.add('hidden');
            resetStrength();
        });

        // ── Strength meter ────────────────────────────────────
        const colors = ['bg-zinc-200', 'bg-red-400', 'bg-amber-400', 'bg-blue-400', 'bg-green-500'];
        const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
        const lclass = ['text-zinc-400', 'text-red-500', 'text-amber-500', 'text-blue-500', 'text-green-600'];

        function resetStrength() {
            [1, 2, 3, 4].forEach(i => {
                document.getElementById('pw-str-' + i).className =
                    'h-1 flex-1 rounded-full bg-zinc-200 transition-colors duration-300';
            });
            document.getElementById('pw-str-label').textContent = '';
        }

        pwNew.addEventListener('input', () => {
            const val = pwNew.value;
            let score = 0;
            if (val.length >= 8)  score++;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const level = Math.min(4, score);
            [1, 2, 3, 4].forEach((n, i) => {
                document.getElementById('pw-str-' + n).className =
                    'h-1 flex-1 rounded-full transition-colors duration-300 ' +
                    (i < level ? colors[level] : 'bg-zinc-200');
            });
            const lbl = document.getElementById('pw-str-label');
            lbl.textContent = labels[level];
            lbl.className   = 'text-xs transition-colors ' + lclass[level];
        });

        pwForm.addEventListener('submit', async e => {
            e.preventDefault();
            pwSaveBtn.disabled    = true;
            pwSaveTxt.textContent = 'Updating…';
            pwSpinner.classList.remove('hidden');

            try {
                const res = await Ajax.post(BASE_URL + '/ajax/change-password', new FormData(pwForm));
                if (res.success) {
                    pwCancel.click();
                    App.toast(res.message, 'success');
                } else {
                    showAlert(pwAlert, res.message ?? 'Update failed.', 'error');
                }
            } catch {
                showAlert(pwAlert, 'Something went wrong. Please try again.', 'error');
            } finally {
                pwSaveBtn.disabled    = false;
                pwSaveTxt.textContent = 'Update password';
                pwSpinner.classList.add('hidden');
            }
        });
    }
})();
