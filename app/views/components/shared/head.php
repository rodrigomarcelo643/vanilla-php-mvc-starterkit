<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#18181b">
<meta name="csrf-token" content="<?= defined('CSRF_TOKEN') ? CSRF_TOKEN : '' ?>">
<title><?= htmlspecialchars($title ?? APP_NAME) ?> — <?= APP_NAME ?></title>
<link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/public/favicon.svg">
<script>if(localStorage.getItem('theme')==='dark')document.documentElement.classList.add('dark');</script>
<script>
    // Global Frontend Error Boundary
    window.addEventListener('error', function (event) {
        if (event.filename && !event.filename.includes(window.location.host) && !event.filename.includes('unpkg.com') && !event.filename.includes('tailwindcss')) {
            return;
        }
        console.error('Captured JS Error:', event.error || event.message);
        showErrorToast('A client-side error occurred: ' + event.message);
    });

    window.addEventListener('unhandledrejection', function (event) {
        console.error('Captured Promise Rejection:', event.reason);
        showErrorToast('Unhandled Promise Rejection: ' + (event.reason ? (event.reason.message || event.reason) : 'Unknown error'));
    });

    function showErrorToast(msg) {
        if (document.getElementById('js-error-toast')) return;
        const toast = document.createElement('div');
        toast.id = 'js-error-toast';
        toast.className = 'fixed top-4 right-4 z-[9999] max-w-sm w-full bg-red-50 dark:bg-red-950/80 backdrop-blur-md border border-red-200 dark:border-red-900/50 p-4 rounded-xl shadow-xl flex gap-3 transform translate-y-2 opacity-0 transition-all duration-300 pointer-events-auto';
        toast.innerHTML = `
            <div class="flex-shrink-0 text-red-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-red-900 dark:text-red-200">Application Error</p>
                <p class="text-xs text-red-700 dark:text-red-300 mt-1 line-clamp-2">${msg}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-red-400 hover:text-red-600 dark:hover:text-red-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        }, 100);
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-2', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }
        }, 6000);
    }
</script>
<script>
    const tempWarn = console.warn;
    console.warn = function (...args) {
        if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com')) {
            return;
        }
        tempWarn.apply(console, args);
    };
</script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
    console.warn = tempWarn;
    tailwind.config = {
        darkMode: 'class',
        <?php if (!empty($tailwindConfig)): ?>
        theme: { extend: { colors: { primary: <?= json_encode($tailwindConfig) ?> } } }
        <?php endif; ?>
    };
</script>
<script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
