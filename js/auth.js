/**
 * Auth — login, register, forgot password & reset password handlers
 */
const Auth = {
    togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.querySelector('svg').style.opacity = input.type === 'text' ? '0.5' : '1';
    },
};

// ── Login ─────────────────────────────────────────────────────
const loginForm = document.getElementById('login-form');
if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        App.setLoading('login-btn', 'login-spinner', true);
        try {
            const res = await Ajax.post(BASE_URL + '/ajax/login', new FormData(loginForm));
            if (res.success) {
                App.toast('Login successful! Redirecting…', 'success');
                setTimeout(() => window.location.href = res.redirect ?? BASE_URL + '/', 800);
            } else {
                App.alert('login-alert', res.message ?? 'Login failed.', 'error');
                App.setLoading('login-btn', 'login-spinner', false);
            }
        } catch {
            App.alert('login-alert', 'Something went wrong. Please try again.', 'error');
            App.setLoading('login-btn', 'login-spinner', false);
        }
    });
}

// ── Register ──────────────────────────────────────────────────
const registerForm = document.getElementById('register-form');
if (registerForm) {
    const regPassword = document.getElementById('register-password');
    const regConfirm  = document.getElementById('register-confirm');
    const regHint     = document.getElementById('reg-confirm-hint');

    const strColors = ['bg-zinc-200', 'bg-red-400', 'bg-amber-400', 'bg-blue-400', 'bg-green-500'];
    const strLabels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    const strClass  = ['text-zinc-400', 'text-red-500', 'text-amber-500', 'text-blue-500', 'text-green-600'];

    function calcStrength(val) {
        let score = 0;
        if (val.length >= 8)                          score++;
        if (val.length >= 12)                         score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val))  score++;
        if (/[0-9]/.test(val))                        score++;
        if (/[^A-Za-z0-9]/.test(val))                 score++;
        return Math.min(4, score);
    }

    function updateStrength(val) {
        const level = calcStrength(val);
        [1, 2, 3, 4].forEach((n, i) => {
            const el = document.getElementById('reg-str-' + n);
            if (el) el.className = 'h-1 flex-1 rounded-full transition-colors duration-300 ' + (i < level ? strColors[level] : 'bg-zinc-200 dark:bg-zinc-700');
        });
        const lbl = document.getElementById('reg-str-label');
        if (lbl) { lbl.textContent = strLabels[level]; lbl.className = 'text-xs transition-colors ' + strClass[level]; }
    }

    function updateConfirmMatch() {
        if (!regConfirm || !regPassword) return;
        if (!regConfirm.value) { if (regHint) regHint.classList.add('hidden'); return; }
        const match = regConfirm.value === regPassword.value;
        if (regHint) {
            regHint.classList.remove('hidden');
            regHint.textContent = match ? '✓ Passwords match' : '✗ Passwords do not match';
            regHint.className   = 'text-xs mt-1 ' + (match ? 'text-green-600' : 'text-red-500');
        }
    }

    if (regPassword) {
        regPassword.addEventListener('input', () => {
            updateStrength(regPassword.value);
            updateConfirmMatch();
        });
    }

    if (regConfirm) {
        regConfirm.addEventListener('input', () => updateConfirmMatch());
    }

    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (regPassword.value !== regConfirm.value) {
            App.alert('register-alert', 'Passwords do not match.', 'error');
            return;
        }
        if (calcStrength(regPassword.value) < 2) {
            App.alert('register-alert', 'Password is too weak. Add uppercase, numbers, or symbols.', 'error');
            return;
        }

        App.setLoading('register-btn', 'register-spinner', true);
        try {
            const res = await Ajax.post(BASE_URL + '/ajax/register', new FormData(registerForm));
            if (res.success) {
                App.toast('Account created! Redirecting…', 'success');
                setTimeout(() => window.location.href = res.redirect ?? BASE_URL + '/', 800);
            } else {
                App.alert('register-alert', res.message ?? 'Registration failed.', 'error');
                App.setLoading('register-btn', 'register-spinner', false);
            }
        } catch {
            App.alert('register-alert', 'Something went wrong. Please try again.', 'error');
            App.setLoading('register-btn', 'register-spinner', false);
        }
    });
}

// ── Forgot Password ───────────────────────────────────────────
const fpForm = document.getElementById('fp-form');
if (fpForm) {
    fpForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        App.setLoading('fp-btn', 'fp-spinner', true);
        try {
            const res = await Ajax.post(BASE_URL + '/ajax/forgot-password', new FormData(fpForm));
            if (res.success) {
                const email = document.getElementById('fp-email').value;
                document.getElementById('fp-sent-email').textContent = email;
                document.getElementById('fp-form-wrap').classList.add('hidden');
                document.getElementById('fp-success').classList.remove('hidden');
            } else {
                App.alert('fp-alert', res.message ?? 'Something went wrong.', 'error');
                App.setLoading('fp-btn', 'fp-spinner', false);
            }
        } catch {
            App.alert('fp-alert', 'Something went wrong. Please try again.', 'error');
            App.setLoading('fp-btn', 'fp-spinner', false);
        }
    });
}

// ── Reset Password ────────────────────────────────────────────
const rpForm = document.getElementById('rp-form');
if (rpForm) {
    const rpPassword = document.getElementById('rp-password');
    const rpConfirm  = document.getElementById('rp-confirm');
    const rpHint     = document.getElementById('rp-confirm-hint');

    const rpColors = ['bg-zinc-200', 'bg-red-400', 'bg-amber-400', 'bg-blue-400', 'bg-green-500'];
    const rpLabels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    const rpClass  = ['text-zinc-400', 'text-red-500', 'text-amber-500', 'text-blue-500', 'text-green-600'];

    function rpCalcStrength(val) {
        let score = 0;
        if (val.length >= 8)                          score++;
        if (val.length >= 12)                         score++;
        if (/[A-Z]/.test(val) && /[a-z]/.test(val))  score++;
        if (/[0-9]/.test(val))                        score++;
        if (/[^A-Za-z0-9]/.test(val))                 score++;
        return Math.min(4, score);
    }

    function rpUpdateStrength(val) {
        const level = rpCalcStrength(val);
        [1, 2, 3, 4].forEach((n, i) => {
            const el = document.getElementById('str-' + n);
            if (el) el.className = 'h-1 flex-1 rounded-full transition-colors duration-300 ' + (i < level ? rpColors[level] : 'bg-zinc-200 dark:bg-zinc-700');
        });
        const lbl = document.getElementById('str-label');
        if (lbl) { lbl.textContent = rpLabels[level]; lbl.className = 'text-xs transition-colors ' + rpClass[level]; }
    }

    function rpUpdateConfirmMatch() {
        if (!rpConfirm || !rpPassword) return;
        if (!rpConfirm.value) { if (rpHint) rpHint.classList.add('hidden'); return; }
        const match = rpConfirm.value === rpPassword.value;
        if (rpHint) {
            rpHint.classList.remove('hidden');
            rpHint.textContent = match ? '✓ Passwords match' : '✗ Passwords do not match';
            rpHint.className   = 'text-xs mt-1 ' + (match ? 'text-green-600' : 'text-red-500');
        }
    }

    if (rpPassword) {
        rpPassword.addEventListener('input', () => {
            rpUpdateStrength(rpPassword.value);
            rpUpdateConfirmMatch();
        });
    }

    if (rpConfirm) {
        rpConfirm.addEventListener('input', () => rpUpdateConfirmMatch());
    }

    rpForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const password = rpPassword.value;
        const confirm  = rpConfirm.value;
        if (password !== confirm) {
            App.alert('rp-alert', 'Passwords do not match.', 'error');
            return;
        }
        if (rpCalcStrength(password) < 2) {
            App.alert('rp-alert', 'Password is too weak. Add uppercase, numbers, or symbols.', 'error');
            return;
        }
        App.setLoading('rp-btn', 'rp-spinner', true);
        try {
            const res = await Ajax.post(BASE_URL + '/ajax/reset-password', new FormData(rpForm));
            if (res.success) {
                App.toast('Password reset! Redirecting…', 'success');
                setTimeout(() => window.location.href = res.redirect ?? BASE_URL + '/login', 1000);
            } else {
                App.alert('rp-alert', res.message ?? 'Something went wrong.', 'error');
                App.setLoading('rp-btn', 'rp-spinner', false);
            }
        } catch {
            App.alert('rp-alert', 'Something went wrong. Please try again.', 'error');
            App.setLoading('rp-btn', 'rp-spinner', false);
        }
    });
}
