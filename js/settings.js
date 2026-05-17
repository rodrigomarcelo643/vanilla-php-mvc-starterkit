document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('admin-settings-theme-toggle')
                ?? document.getElementById('settings-theme-toggle');
    if (toggle) toggle.checked = document.documentElement.classList.contains('dark');

    const _toggle = Theme.toggle.bind(Theme);
    Theme.toggle = function () {
        _toggle();
        if (toggle) toggle.checked = document.documentElement.classList.contains('dark');
    };
});
