<?php
$code = $code ?? 500;
$cleanTitle = $title ?? 'Internal Server Error';
$message = $message ?? 'Something went wrong on our end. Please try again later.';
$pageTitle = "$code — $cleanTitle";
$title = $pageTitle; // Sets title for the client header

$hideNavbar = true;
$hideFooter = true;

include 'app/views/layouts/client/header.php';
?>

<!-- Error Section -->
<section class="min-h-screen flex items-center justify-center pt-32 pb-20 px-4 relative overflow-hidden bg-zinc-50 dark:bg-zinc-950 transition-colors duration-300">
    <!-- Subtle Background Glows to match the premium dark/light mode -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[20%] w-[60%] h-[60%] rounded-full bg-indigo-500/10 blur-[130px] dark:bg-indigo-500/5"></div>
        <div class="absolute -bottom-[20%] -right-[20%] w-[60%] h-[60%] rounded-full bg-purple-500/10 blur-[130px] dark:bg-purple-500/5"></div>
    </div>

    <!-- Theme Toggle at top right -->
    <div class="absolute top-6 right-6 z-20">
        <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                class="w-10 h-10 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm flex items-center justify-center hover:scale-105 transition-transform text-zinc-600 dark:text-zinc-400">
            <!-- Sun / Moon Icon -->
            <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
            </svg>
            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
    </div>

    <div class="relative w-full max-w-xl text-center z-10 bg-white/70 dark:bg-zinc-900/60 backdrop-blur-xl border border-zinc-200/80 dark:border-zinc-800/80 p-8 sm:p-12 rounded-3xl shadow-2xl shadow-zinc-200/50 dark:shadow-none"
         x-data="{ 
             show: false,
             rotateX: 0, 
             rotateY: 0,
             handleMouseMove(e) {
                 const card = $el;
                 const rect = card.getBoundingClientRect();
                 const x = e.clientX - rect.left - rect.width/2;
                 const y = e.clientY - rect.top - rect.height/2;
                 this.rotateY = (x / (rect.width/2)) * 8; // max 8 deg
                 this.rotateX = -(y / (rect.height/2)) * 8; // max 8 deg
             },
             handleMouseLeave() {
                 this.rotateX = 0;
                 this.rotateY = 0;
             }
         }" 
         x-init="setTimeout(() => show = true, 50)"
         @mousemove="handleMouseMove"
         @mouseleave="handleMouseLeave"
         :style="`transform: perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg); transition: ${rotateX === 0 ? 'transform 0.5s ease' : 'none'}`">
        
        <!-- Animated Error Status Badge / Illustration -->
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-700" 
             x-transition:enter-start="opacity-0 scale-90 translate-y-4" 
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             class="inline-flex items-center justify-center w-24 h-24 rounded-2xl bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800/80 shadow-inner mb-6 relative">
            <span class="text-5xl font-black bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">
                <?= htmlspecialchars($code) ?>
            </span>
            <div class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-indigo-500 rounded-full animate-ping"></div>
            <div class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-indigo-500 rounded-full border-2 border-white dark:border-zinc-900"></div>
        </div>

        <!-- Heading & Message -->
        <div x-show="show" 
             x-transition:enter="transition ease-out duration-700 delay-100" 
             x-transition:enter-start="opacity-0 translate-y-4" 
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-4">
            
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white leading-tight">
                <?= htmlspecialchars($cleanTitle) ?>
            </h1>
            
            <p class="text-base text-zinc-500 dark:text-zinc-400 max-w-md mx-auto leading-relaxed">
                <?= htmlspecialchars($message) ?>
            </p>

            <!-- Quick navigation links for high engagement -->
            <div class="py-4 border-t border-b border-zinc-100 dark:border-zinc-800/80 my-6">
                <p class="text-xs font-semibold text-zinc-400 uppercase tracking-wider mb-3">Suggested Pages</p>
                <div class="flex flex-wrap gap-2 justify-center">
                    <a href="<?= BASE_URL ?>/docs" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Documentation
                    </a>
                    <a href="<?= BASE_URL ?>/blog" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        Blog Articles
                    </a>
                    <a href="https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit" target="_blank" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-indigo-50 dark:hover:bg-indigo-950/30 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        GitHub Repo
                    </a>
                </div>
            </div>
            
            <?php if (isset($exception) && ($_ENV['APP_DEBUG'] ?? 'false') === 'true'): ?>
                <!-- Debug Info for Developers in Dev Mode -->
                <div class="text-left bg-zinc-950 dark:bg-zinc-950 p-5 rounded-2xl border border-zinc-800 overflow-x-auto max-h-60 text-[11px] font-mono text-zinc-400 shadow-inner">
                    <div class="flex items-center justify-between border-b border-zinc-800 pb-2 mb-3">
                        <span class="font-bold text-red-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                            Exception Debug Info
                        </span>
                        <span class="text-[9px] text-zinc-500 bg-zinc-900 px-1.5 py-0.5 rounded">DEV MODE</span>
                    </div>
                    <p class="mb-2"><strong class="text-zinc-300">Message:</strong> <?= htmlspecialchars($exception->getMessage()) ?></p>
                    <p class="mb-2"><strong class="text-zinc-300">File:</strong> <?= htmlspecialchars($exception->getFile()) ?>:<?= $exception->getLine() ?></p>
                    <p class="font-bold mb-1 text-zinc-300">Stack Trace:</p>
                    <pre class="whitespace-pre-wrap leading-relaxed"><?= htmlspecialchars($exception->getTraceAsString()) ?></pre>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="pt-6 flex flex-col sm:flex-row gap-3.5 justify-center items-center">
                <a href="<?= BASE_URL ?>/" 
                   class="relative group w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-6 py-3.5 bg-zinc-900 hover:bg-zinc-700 text-white dark:bg-zinc-100 dark:hover:bg-zinc-200 dark:text-zinc-900 text-sm font-semibold rounded-xl transition duration-300 shadow-md hover:shadow-xl hover:shadow-indigo-500/10 active:scale-95">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-indigo-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl"></span>
                    <span class="relative flex items-center justify-center gap-2 text-zinc-100 dark:text-zinc-900 group-hover:text-white transition-colors duration-300">
                        <svg class="w-4 h-4 transform group-hover:scale-110 group-hover:-translate-y-0.5 transition-all duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Go Back Home
                    </span>
                </a>
                
                <button onclick="window.location.reload();" 
                        class="group w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 text-zinc-700 dark:text-zinc-300 text-sm font-semibold rounded-xl transition duration-300 bg-transparent hover:bg-zinc-50 dark:hover:bg-zinc-900/40 active:scale-95 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 transform group-hover:rotate-180 transition-transform duration-500 ease-in-out" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                    </svg>
                    Reload Page
                </button>
            </div>
        </div>
    </div>
</section>

<?php
include 'app/views/layouts/client/footer.php';
?>
