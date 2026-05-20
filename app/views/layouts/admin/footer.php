        </main>

        </div><!-- end flex-1 -->

        </div><!-- end flex -->

        <!-- ── User Modals (outside overflow containers) ── -->
        <div x-data>

            <!-- Create / Edit User Modal -->
            <div x-show="$store.userModal && $store.userModal.open && $store.userModal.type !== 'delete'" style="display:none"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-md">

                <div class="relative bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden"
                    @click.stop>

                    <!-- Header -->
                    <div class="px-6 pt-6 pb-4 border-b border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100"
                                    x-text="$store.userModal.type === 'create' ? 'Add New User' : 'Edit User'">
                                </h2>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                    <span
                                        x-text="$store.userModal.type === 'create' ? 'Create a new account' : 'Update user information'"></span>
                                </p>
                            </div>
                            <button @click="$store.userModal.close()"
                                class="w-8 h-8 flex items-center justify-center text-zinc-400 hover:text-zinc-500 dark:hover:text-zinc-300 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6h12v12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <form @submit.prevent="$store.userModal.submit()" class="p-6 space-y-5">
                        <div id="modal-alert" class="hidden px-4 py-3 rounded-xl text-sm"></div>

                        <div class="space-y-5">
                            <!-- Full Name -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Full
                                    Name</label>
                                <input type="text" x-model="$store.userModal.form.name" required
                                    class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition-all">
                            </div>

                            <!-- Email -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Email
                                    Address</label>
                                <input type="email" x-model="$store.userModal.form.email" required
                                    class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition-all">
                            </div>

                            <!-- Password (Create only) -->
                            <div x-show="$store.userModal.type === 'create'" class="space-y-1.5">
                                <label
                                    class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Password</label>
                                <div class="relative">
                                    <input type="password" x-model="$store.userModal.form.password"
                                        class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition-all">
                                </div>
                            </div>

                            <!-- Role & Status -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label
                                        class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Role</label>
                                    <select x-model="$store.userModal.form.role"
                                        class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition-all">
                                        <option value="user">User</option>
                                        <option value="editor">Editor</option>
                                    </select>
                                </div>

                                <div class="space-y-1.5">
                                    <label
                                        class="block text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</label>
                                    <select x-model="$store.userModal.form.status"
                                        class="w-full h-10 px-4 text-sm bg-zinc-50 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition-all">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Buttons -->
                        <div class="flex gap-3 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                            <button type="button" @click="$store.userModal.close()"
                                class="flex-1 h-11 text-sm font-medium border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                                Cancel
                            </button>
                            <button type="submit" :disabled="$store.userModal.loading"
                                class="flex-1 h-11 bg-zinc-900 hover:bg-black dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-100 text-white text-sm font-medium rounded-xl transition-all flex items-center justify-center gap-2 disabled:opacity-70">
                                <span
                                    x-text="$store.userModal.loading ? 'Saving...' : ($store.userModal.type === 'create' ? 'Create User' : 'Save Changes')"></span>
                                <svg x-show="$store.userModal.loading" class="w-4 h-4 animate-spin" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Confirmation -->
            <div x-show="$store.userModal && $store.userModal.open && $store.userModal.type === 'delete'" style="display:none"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-md">

                <div class="relative bg-white dark:bg-zinc-900 border border-red-200 dark:border-red-900/30 rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden"
                    @click.stop>

                    <div class="p-8 text-center">
                        <div
                            class="mx-auto w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-2xl flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-red-600 dark:text-red-500"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>

                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Delete User?</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            Are you sure you want to permanently delete
                            <strong class="text-zinc-700 dark:text-zinc-200"
                                x-text="$store.userModal.form.name"></strong>?
                        </p>
                        <p class="text-xs text-red-500 mt-1">This action cannot be undone.</p>
                    </div>

                    <div class="flex gap-3 px-6 pb-6">
                        <button @click="$store.userModal.close()"
                            class="flex-1 h-11 text-sm font-medium border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded-xl transition-colors">
                            Cancel
                        </button>
                        <button @click="$store.userModal.submitDelete()" :disabled="$store.userModal.loading"
                            class="flex-1 h-11 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-all flex items-center justify-center gap-2">
                            <span x-text="$store.userModal.loading ? 'Deleting...' : 'Yes, Delete'"></span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

        <?php include 'app/views/components/shared/logout-modal.php'; ?>

        <script>
const BASE_URL = '<?= BASE_URL ?>';
        </script>
        <script src="<?= BASE_URL ?>/js/theme.js"></script>
        <script src="<?= BASE_URL ?>/js/ajax.js"></script>
        <script src="<?= BASE_URL ?>/js/app.js"></script>
        <script src="<?= BASE_URL ?>/js/skeleton.js"></script>
        <script src="<?= BASE_URL ?>/js/logout.js"></script>
        <script src="<?= BASE_URL ?>/js/auth.js"></script>
        <script src="<?= BASE_URL ?>/js/avatar.js"></script>
        <script src="<?= BASE_URL ?>/js/profile.js"></script>
        <script src="<?= BASE_URL ?>/js/admin/users.js"></script>
        <script src="<?= BASE_URL ?>/js/admin/admin.js"></script>
        <script src="<?= BASE_URL ?>/js/sidebar.js"></script>

        </body>

        </html>