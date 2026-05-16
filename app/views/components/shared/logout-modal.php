<!-- ── Logout Confirmation Modal ──────────────────────────── -->
<div id="logout-modal"
     class="hidden fixed inset-0 z-[999] flex items-center justify-center p-4"
     aria-modal="true" role="dialog" aria-labelledby="logout-modal-title">

    <!-- Backdrop -->
    <div id="logout-backdrop"
         class="absolute inset-0 bg-black/40 backdrop-blur-sm opacity-0 transition-opacity duration-200"></div>

    <!-- Panel -->
    <div id="logout-panel"
         class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 opacity-0 scale-95 transition-all duration-200">

        <!-- Icon -->
        <div class="w-11 h-11 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
        </div>

        <!-- Text -->
        <h2 id="logout-modal-title" class="text-base font-semibold text-zinc-900 text-center mb-1">Sign out?</h2>
        <p class="text-sm text-zinc-500 text-center mb-6">You'll need to sign in again to access your account.</p>

        <!-- Actions -->
        <div class="flex gap-3">
            <button id="logout-cancel-btn" type="button"
                class="flex-1 h-10 border border-zinc-200 rounded-xl text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                Cancel
            </button>
            <button id="logout-confirm-btn" type="button"
                class="flex-1 h-10 bg-red-500 hover:bg-red-600 rounded-xl text-sm font-medium text-white transition-colors flex items-center justify-center gap-2 disabled:opacity-60">
                <span id="logout-confirm-text">Sign out</span>
                <svg id="logout-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
            </button>
        </div>
    </div>
</div>
