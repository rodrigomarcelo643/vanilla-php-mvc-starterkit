// Ctrl+B / Cmd+B — toggle sidebar
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
        e.preventDefault();
        const data = document.body._x_dataStack?.[0];
        if (data && 'sidebarOpen' in data) {
            data.sidebarOpen = !data.sidebarOpen;
        }
    }
});
