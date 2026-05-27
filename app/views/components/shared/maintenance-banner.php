<?php if (($_ENV['MAINTENANCE_MODE'] ?? 'false') === 'true'): ?>
<div class="bg-red-100 dark:bg-red-950/60 border-b border-red-200 dark:border-red-900/50 text-red-800 dark:text-red-300 py-2 px-4 relative overflow-hidden select-none z-50 flex items-center" style="min-height:36px">
    <!-- Alert icon — static, no bounce -->
    <span class="flex-shrink-0 flex items-center mr-3">
        <svg class="w-4 h-4 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
    </span>
    <!-- Marquee scrolling text -->
    <div class="overflow-hidden flex-1 relative">
        <div class="marquee-maintenance whitespace-nowrap inline-block text-xs sm:text-sm font-semibold" style="animation: maintenance-scroll 30s linear infinite;">
            <?php
            $msg = '⚠ Under Maintenance Mode — We are currently performing scheduled maintenance. Some features may be temporarily offline. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ⚠ Under Maintenance Mode — We are currently performing scheduled maintenance. Some features may be temporarily offline. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ⚠ Under Maintenance Mode — We are currently performing scheduled maintenance. Some features may be temporarily offline.';
            echo $msg;
            ?>
        </div>
    </div>
    <!-- Maintenance badge -->
    <span class="flex-shrink-0 ml-3 text-[10px] font-bold uppercase tracking-widest bg-red-200 dark:bg-red-900/50 text-red-700 dark:text-red-400 px-2 py-0.5 rounded-full">
        Maintenance
    </span>
</div>
<style>
@keyframes maintenance-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-33.333%); }
}
</style>
<script>
    // Set --banner-h so fixed sidebars can offset their top/height
    (function() {
        var banner = document.currentScript.previousElementSibling.previousElementSibling;
        // Walk back to find the banner div
        var el = document.currentScript;
        while (el && el.tagName !== 'DIV') el = el.previousElementSibling;
        function applyBannerHeight() {
            var bh = el ? el.offsetHeight : 0;
            document.documentElement.style.setProperty('--banner-h', bh + 'px');
        }
        applyBannerHeight();
        window.addEventListener('resize', applyBannerHeight);
    })();
</script>
<?php endif; ?>
