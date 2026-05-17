        </main>

    </div><!-- end flex-1 -->

</div><!-- end flex -->

<!-- ── User Modals (outside overflow containers) ── -->
<div x-data>

    <!-- Create / Edit -->
    <div x-show="$store.userModal && $store.userModal.open && $store.userModal.type !== 'delete'"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         style="display:none">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="$store.userModal.close()"></div>
        <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl w-full max-w-md p-6" @click.stop
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100" x-text="$store.userModal.type === 'create' ? 'Add User' : 'Edit User'"></h2>
                <button @click="$store.userModal.close()" class="text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="modal-alert" class="hidden mb-4 px-3 py-2.5 rounded-lg text-sm"></div>
            <form @submit.prevent="$store.userModal.submit()" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2 space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Full name</label>
                        <input type="text" x-model="$store.userModal.form.name" required
                            class="w-full h-9 px-3 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition">
                    </div>
                    <div class="col-span-2 space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Email address</label>
                        <input type="email" x-model="$store.userModal.form.email" required
                            class="w-full h-9 px-3 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition">
                    </div>
                    <div x-show="$store.userModal.type === 'create'" class="col-span-2 space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Password</label>
                        <input type="password" x-model="$store.userModal.form.password"
                            class="w-full h-9 px-3 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Role</label>
                        <select x-model="$store.userModal.form.role"
                            class="w-full h-9 px-3 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition">
                            <option value="user">User</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</label>
                        <select x-model="$store.userModal.form.status"
                            class="w-full h-9 px-3 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-2 pt-1">
                    <button type="button" @click="$store.userModal.close()"
                        class="flex-1 h-9 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">Cancel</button>
                    <button type="submit" :disabled="$store.userModal.loading"
                        class="flex-1 h-9 bg-zinc-900 hover:bg-zinc-700 text-white rounded-lg text-sm font-medium transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                        <span x-text="$store.userModal.loading ? 'Saving…' : ($store.userModal.type === 'create' ? 'Create' : 'Save changes')"></span>
                        <svg x-show="$store.userModal.loading" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete -->
    <div x-show="$store.userModal && $store.userModal.open && $store.userModal.type === 'delete'"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
         style="display:none">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="$store.userModal.close()"></div>
        <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-xl w-full max-w-sm p-6" @click.stop
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 text-center mb-1">Delete user?</h2>
            <p class="text-xs text-zinc-500 dark:text-zinc-400 text-center mb-5"><strong x-text="$store.userModal.form.name"></strong> will be permanently removed.</p>
            <div class="flex gap-2">
                <button @click="$store.userModal.close()"
                    class="flex-1 h-9 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">Cancel</button>
                <button @click="$store.userModal.submitDelete()" :disabled="$store.userModal.loading"
                    class="flex-1 h-9 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                    <span x-text="$store.userModal.loading ? 'Deleting…' : 'Delete'"></span>
                    <svg x-show="$store.userModal.loading" class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/></svg>
                </button>
            </div>
        </div>
    </div>

</div>

<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<?php include 'app/views/components/shared/logout-modal.php'; ?>

<script>const BASE_URL = '<?= BASE_URL ?>';</script>
<script src="<?= BASE_URL ?>/js/theme.js"></script>
<script src="<?= BASE_URL ?>/js/ajax.js"></script>
<script src="<?= BASE_URL ?>/js/app.js"></script>
<script src="<?= BASE_URL ?>/js/logout.js"></script>
<script src="<?= BASE_URL ?>/js/auth.js"></script>
<script src="<?= BASE_URL ?>/js/avatar.js"></script>
<script src="<?= BASE_URL ?>/js/profile.js"></script>
<script src="<?= BASE_URL ?>/js/admin/users.js"></script>
<script src="<?= BASE_URL ?>/js/admin/admin.js"></script>
<script src="<?= BASE_URL ?>/js/sidebar.js"></script>

</body>
</html>
