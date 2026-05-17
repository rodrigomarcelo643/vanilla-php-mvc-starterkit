        </main>

    </div>

</div>

<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<?php include 'app/views/components/shared/logout-modal.php'; ?>

<script>const BASE_URL = '<?= BASE_URL ?>';</script>
<script>
const Theme = {
    toggle() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        this.updateIcons(isDark);
    },
    updateIcons(isDark) {
        document.getElementById('theme-icon-dark')?.classList.toggle('hidden', !isDark);
        document.getElementById('theme-icon-light')?.classList.toggle('hidden', isDark);
    },
    init() { this.updateIcons(document.documentElement.classList.contains('dark')); }
};
document.addEventListener('DOMContentLoaded', () => Theme.init());
</script>
<script src="<?= BASE_URL ?>/assets/js/ajax.js"></script>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
<script src="<?= BASE_URL ?>/assets/js/logout.js"></script>
<script src="<?= BASE_URL ?>/assets/js/sidebar.js"></script>
<script src="<?= BASE_URL ?>/assets/js/avatar.js"></script>
<script src="<?= BASE_URL ?>/assets/js/profile.js"></script>

</body>
</html>
