const Theme = {
    toggle() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        this.updateIcons(isDark);
    },
    updateIcons(isDark) {
        document.getElementById('theme-icon-dark')?.classList.toggle('hidden', !isDark);
        document.getElementById('theme-icon-light')?.classList.toggle('hidden', isDark);
        document.getElementById('theme-icon-dark-mobile')?.classList.toggle('hidden', !isDark);
        document.getElementById('theme-icon-light-mobile')?.classList.toggle('hidden', isDark);
        const lbl = document.getElementById('theme-label-mobile');
        if (lbl) lbl.textContent = isDark ? 'Light mode' : 'Dark mode';
    },
    init() { this.updateIcons(document.documentElement.classList.contains('dark')); }
};
document.addEventListener('DOMContentLoaded', () => Theme.init());
