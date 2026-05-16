<footer class="border-t border-zinc-200 bg-white mt-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2">
            <div class="w-5 h-5 rounded bg-zinc-900 flex items-center justify-center">
                <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="text-xs text-zinc-400">&copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="#" class="text-xs text-zinc-400 hover:text-zinc-700 transition-colors">Privacy</a>
            <a href="#" class="text-xs text-zinc-400 hover:text-zinc-700 transition-colors">Terms</a>
            <a href="#" class="text-xs text-zinc-400 hover:text-zinc-700 transition-colors">Contact</a>
        </div>
    </div>
</footer>
