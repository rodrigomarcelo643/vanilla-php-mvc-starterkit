<div class="min-h-screen flex fade-in">

    <!-- Left — brand panel -->
    <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] flex-col justify-between bg-zinc-950 p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]"
             style="background-image:linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:40px 40px"></div>

        <a href="<?= BASE_URL ?>/" class="flex items-center gap-2.5 relative z-10">
            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center">
                <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="text-white font-semibold text-sm"><?= APP_NAME ?></span>
        </a>

        <div class="relative z-10">
            <blockquote class="text-white">
                <p class="text-2xl font-medium leading-relaxed mb-6">"Choose a strong password<br>and keep it safe."</p>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-zinc-700 flex items-center justify-center text-white text-xs font-bold">S</div>
                    <div>
                        <p class="text-sm font-medium text-white"><?= APP_NAME ?></p>
                        <p class="text-xs text-zinc-500">PHP MVC Starter Kit</p>
                    </div>
                </div>
            </blockquote>
        </div>

        <div class="flex items-center gap-8 relative z-10">
            <?php foreach ([['8+','Min Characters'],['Bcrypt','Hashing'],['1 use','Token']] as $s): ?>
            <div>
                <p class="text-white font-semibold text-lg"><?= $s[0] ?></p>
                <p class="text-zinc-500 text-xs"><?= $s[1] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider -->
    <div class="hidden lg:block w-px bg-zinc-200 dark:bg-zinc-800"></div>

    <!-- Right — form panel -->
    <div class="flex-1 flex flex-col min-h-screen">

        <div class="flex items-center justify-between px-6 sm:px-10 h-14 border-b border-zinc-100 dark:border-zinc-800">
            <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 lg:hidden">
                <div class="w-6 h-6 rounded bg-zinc-900 dark:bg-zinc-100 flex items-center justify-center">
                    <svg class="w-3 h-3 text-white dark:text-zinc-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100"><?= APP_NAME ?></span>
            </a>
            <div class="lg:ml-auto">
                <span class="text-sm text-zinc-500 dark:text-zinc-400">Remember your password?</span>
                <a href="<?= BASE_URL ?>/login" class="ml-2 text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:underline underline-offset-4">Sign in</a>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center px-6 sm:px-10 py-12">
            <div class="w-full max-w-sm">

                <div class="mb-8">
                    <div class="w-10 h-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight">Set new password</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1.5">Must be at least 8 characters.</p>
                </div>

                <div id="rp-alert" class="hidden mb-5 px-3.5 py-3 rounded-lg text-sm"></div>

                <form id="rp-form" novalidate class="space-y-4">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">New password</label>
                        <div class="relative">
                            <input type="password" name="password" id="rp-password"
                                class="w-full h-10 px-3.5 pr-10 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition"
                                placeholder="Create a strong password" required>
                            <button type="button" onclick="Auth.togglePassword('rp-password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Strength meter -->
                        <div class="flex gap-1 mt-2">
                            <div id="str-1" class="h-1 flex-1 rounded-full bg-zinc-200 dark:bg-zinc-700 transition-colors duration-300"></div>
                            <div id="str-2" class="h-1 flex-1 rounded-full bg-zinc-200 dark:bg-zinc-700 transition-colors duration-300"></div>
                            <div id="str-3" class="h-1 flex-1 rounded-full bg-zinc-200 dark:bg-zinc-700 transition-colors duration-300"></div>
                            <div id="str-4" class="h-1 flex-1 rounded-full bg-zinc-200 dark:bg-zinc-700 transition-colors duration-300"></div>
                        </div>
                        <p id="str-label" class="text-xs mt-1"></p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Confirm password</label>
                        <div class="relative">
                            <input type="password" name="confirm" id="rp-confirm"
                                class="w-full h-10 px-3.5 pr-10 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition"
                                placeholder="Repeat your password" required>
                            <button type="button" onclick="Auth.togglePassword('rp-confirm', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <!-- Match indicator -->
                        <p id="rp-confirm-hint" class="hidden text-xs mt-1"></p>
                    </div>

                    <button type="submit" id="rp-btn"
                        class="w-full h-10 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium rounded-lg
                               transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="rp-btn-text">Reset password</span>
                        <svg id="rp-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
