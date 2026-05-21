
<div id="toast-container" style="position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px"></div>
<script>const BASE_URL = '<?= BASE_URL ?>';</script>
<script src="<?= BASE_URL ?>/js/ajax.js"></script>
<script src="<?= BASE_URL ?>/js/app.js?v=<?= filemtime('js/app.js') ?>"></script>
<script src="<?= BASE_URL ?>/js/auth.js"></script>
<?php $toast = Session::flash('toast'); if ($toast): ?>
<script>document.addEventListener('DOMContentLoaded',()=>App.toast(<?= json_encode($toast['message']) ?>,<?= json_encode($toast['type']) ?>));</script>
<?php endif; ?>
</body>
</html>
