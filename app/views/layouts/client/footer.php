    </main>

    <?php include 'app/views/components/client/footer.php'; ?>

    <script>const BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/ajax.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/app.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/logout.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/auth.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/avatar.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/profile.js"></script>

    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

    <?php include 'app/views/components/shared/logout-modal.php'; ?>

</body>
</html>
