<div class="min-h-screen flex fade-in">

    <!-- Left — brand panel (hidden on mobile) -->
    <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] flex-col justify-between bg-zinc-950 p-12 relative overflow-hidden">

        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-[0.04]"
             style="background-image: linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:40px 40px"></div>

        <!-- Logo -->
        <a href="<?= BASE_URL ?>/" class="flex items-center gap-2.5 relative z-10">
            <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center">
                <svg class="w-4 h-4 text-zinc-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="text-white font-semibold text-sm"><?= APP_NAME ?></span>
        </a>

        <!-- Center quote -->
        <div class="relative z-10">
            <blockquote class="text-white">
                <p class="text-2xl font-medium leading-relaxed mb-6">
                    "A clean foundation to build<br>anything you can imagine."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-zinc-700 flex items-center justify-center text-white text-xs font-bold">S</div>
                    <div>
                        <p class="text-sm font-medium text-white">Starter Kit</p>
                        <p class="text-xs text-zinc-500">PHP MVC Framework</p>
                    </div>
                </div>
            </blockquote>
        </div>

        <!-- Bottom stats -->
        <?php
        $loginStars = '—';
        $ctx = stream_context_create(['http' => ['timeout' => 3, 'header' => "User-Agent: PHP\r\n"]]);
        $json = @file_get_contents('https://api.github.com/repos/rodrigomarcelo643/php-vanilla-mvc-starterkit', false, $ctx);
        if ($json) {
            $d = json_decode($json, true);
            $c = $d['stargazers_count'] ?? 0;
            $loginStars = $c >= 1000 ? round($c / 1000, 1) . 'k' : $c;
        }
        ?>
        <div class="flex items-center gap-8 relative z-10">
            <?php foreach ([[$loginStars,'GitHub Stars'],['PHP 8+','Required']] as $s): ?>
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

        <!-- Top bar -->
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
                <span class="text-sm text-zinc-500 dark:text-zinc-400">Don't have an account?</span>
                <a href="<?= BASE_URL ?>/register" class="ml-2 text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:underline underline-offset-4">Sign up</a>
            </div>
        </div>

        <!-- Form -->
        <div class="flex-1 flex items-center justify-center px-6 sm:px-10 py-12">
            <div class="w-full max-w-sm">

                <div class="mb-8">
                    <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 tracking-tight">Sign in</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1.5">Enter your credentials to access your account</p>
                </div>

                <!-- Alert -->
                <div id="login-alert" class="hidden mb-5 px-3.5 py-3 rounded-lg text-sm"></div>

                <form id="login-form" novalidate class="space-y-4">

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email address</label>
                        <input type="email" name="email" id="login-email"
                            class="w-full h-10 px-3.5 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400
                                   focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition"
                            placeholder="you@example.com" required>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">Password</label>
                            <a href="<?= BASE_URL ?>/forgot-password" class="text-xs text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <input type="password" name="password" id="login-password"
                                class="w-full h-10 px-3.5 pr-10 text-sm border border-zinc-300 dark:border-zinc-700 rounded-lg bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 placeholder-zinc-400
                                       focus:outline-none focus:ring-2 focus:ring-zinc-900 dark:focus:ring-zinc-400 focus:border-transparent transition"
                                placeholder="••••••••" required>
                            <button type="button" onclick="Auth.togglePassword('login-password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="login-btn"
                        class="w-full h-10 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium rounded-lg
                               transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="login-btn-text">Sign in</span>
                        <svg id="login-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                    </button>

                    <!-- Divider -->
                    <div class="relative my-2">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-zinc-200 dark:border-zinc-700"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="bg-white dark:bg-zinc-950 px-3 text-xs text-zinc-400 dark:text-zinc-500">or continue with</span>
                        </div>
                    </div>

                    <!-- OAuth placeholders -->
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button"
                            class="flex items-center justify-center gap-2 h-10 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            Google
                        </button>
                        <button type="button"
                            class="flex items-center justify-center gap-2 h-10 border border-zinc-300 dark:border-zinc-700 rounded-lg text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                            </svg>
                            GitHub
                        </button>
                    </div>
                </form>

                <p class="text-center text-xs text-zinc-400 dark:text-zinc-500 mt-6">
                    By signing in, you agree to our
                    <a href="#" class="underline underline-offset-2 hover:text-zinc-700 dark:hover:text-zinc-300">Terms</a> and
                    <a href="#" class="underline underline-offset-2 hover:text-zinc-700 dark:hover:text-zinc-300">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
</div>
