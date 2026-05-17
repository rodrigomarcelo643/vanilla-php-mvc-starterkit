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

    if (regPassword) {
        regPassword.addEventListener('input', () => {
            const level = calcStrength(regPassword.value);
            [1, 2, 3, 4].forEach((n, i) => {
                document.getElementById('reg-str-' + n).className =
                    'h-1 flex-1 rounded-full transition-colors duration-300 ' +
                    (i < level ? strColors[level] : 'bg-zinc-200 dark:bg-zinc-700');
            });
            const lbl = document.getElementById('reg-str-label');
            lbl.textContent = strLabels[level];
            lbl.className   = 'text-xs transition-colors ' + strClass[level];
        });
    }

    if (regConfirm) {
        regConfirm.addEventListener('input', () => {
            const mismatch = regConfirm.value && regConfirm.value !== regPassword.value;
            regHint.classList.toggle('hidden', !mismatch);
        });
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
    // Password strength meter
    const rpPassword = document.getElementById('rp-password');
    if (rpPassword) {
        rpPassword.addEventListener('input', () => {
            const val = rpPassword.value;
            const bars  = [1,2,3,4].map(i => document.getElementById('str-' + i));
            const label = document.getElementById('str-label');
            const levels = [
                { min: 0,  color: 'bg-zinc-200', text: '' },
                { min: 1,  color: 'bg-red-400',  text: 'Weak' },
                { min: 6,  color: 'bg-amber-400', text: 'Fair' },
                { min: 10, color: 'bg-blue-400',  text: 'Good' },
                { min: 14, color: 'bg-green-500', text: 'Strong' },
            ];
            let score = 0;
            if (val.length >= 8)  score++;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            const level = Math.min(4, score);
            const colors = ['bg-zinc-200','bg-red-400','bg-amber-400','bg-blue-400','bg-green-500'];
            const labels = ['','Weak','Fair','Good','Strong'];
            bars.forEach((b, i) => {
                b.className = 'h-1 flex-1 rounded-full transition-colors duration-300 ' + (i < level ? colors[level] : 'bg-zinc-200');
            });
            label.textContent = labels[level];
            label.className = 'text-xs transition-colors ' + ['text-zinc-400','text-red-500','text-amber-500','text-blue-500','text-green-600'][level];
        });
    }

    rpForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const password = document.getElementById('rp-password').value;
        const confirm  = document.getElementById('rp-confirm').value;
        if (password !== confirm) {
            App.alert('rp-alert', 'Passwords do not match.', 'error');
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
