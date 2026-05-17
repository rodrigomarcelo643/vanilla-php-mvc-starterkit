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
                <p class="text-2xl font-medium leading-relaxed mb-6">"Forgot your password?<br>No worries — it happens."</p>
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
            <?php foreach ([['1 hr','Token Expiry'],['Secure','Bcrypt'],['SMTP','Email Delivery']] as $s): ?>
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

                <?php if (!empty($expiredToken)): ?>
                <!-- Expired token notice -->
                <div class="mb-6 px-4 py-3.5 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 flex items-start gap-3">
                    <svg class="w-4 h-4 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                    <p class="text-sm text-red-700 dark:text-red-400">This reset link has <strong>expired or is invalid</strong>. Please request a new one below.</p>
                </div>
                <?php endif; ?>

                <!-- Sent state (hidden by default, shown via JS) -->
                <div id="fp-success" class="hidden text-center">
                    <div class="w-14 h-14 rounded-full bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 flex items-center justify-center mx-auto mb-5">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100 mb-2">Check your email</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">We sent a password reset link to <strong id="fp-sent-email" class="text-zinc-700 dark:text-zinc-300"></strong>. The link expires in 1 hour.</p>
                    <a href="<?= BASE_URL ?>/login" class="text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:underline underline-offset-4">← Back to sign in</a>
                </div>

                <!-- Form state -->
                <div id="fp-form-wrap">
                    <p class="mb-6">
                        <a href="<?= BASE_URL ?>/login" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 5l-7 7 7 7"/>
                            </svg>
                            Back to sign in
                        </a>
                    </p>
                    <div class="mb-8 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight">Forgot password?</h1>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Enter your email and we'll send you a reset link.</p>
                        </div>
                    </div>

                    <div id="fp-alert" class="hidden mb-5 px-3.5 py-3 rounded-lg text-sm"></div>

                    <form id="fp-form" novalidate class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email address</label>
                            <input type="email" name="email" id="fp-email"
                                class="w-full h-10 px-3.5 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition"
                                placeholder="you@example.com" required>
                        </div>

                        <button type="submit" id="fp-btn"
                            class="w-full h-10 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium rounded-lg
                                   transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="fp-btn-text">Send reset link</span>
                            <svg id="fp-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
