<!-- Header -->
<section class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-14 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 fade-in">
        <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">About</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-zinc-100 leading-tight mb-4 max-w-2xl">
            Built for beginners who want to understand PHP before Laravel.
        </h1>
        <p class="text-base text-zinc-500 dark:text-zinc-400 max-w-xl leading-relaxed">
            <?= APP_NAME ?> is a beginner-friendly PHP MVC starter kit that bridges the gap between raw PHP and modern frameworks like Laravel — teaching you the fundamentals hands-on.
        </p>
    </div>
</section>

<!-- Mission -->
<section class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 py-14 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="fade-in">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Our mission</p>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Learn the foundation, not just the framework.</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Most beginners jump straight into Laravel and struggle because they don't understand what's happening underneath. This starter kit makes you build routing, auth, and MVC from scratch — so when you open Laravel, nothing feels like magic.
                </p>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    <?= APP_NAME ?> gives you the same patterns Laravel uses — controllers, models, views, env config, middleware — written in plain PHP you can read and understand line by line.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4 fade-in">
                <?php foreach ([
                    ['100%', 'Vanilla PHP'],
                    ['0',    'Magic / Black Boxes'],
                    ['1 hr', 'To understand every file'],
                ] as $s): ?>
                <div class="bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5">
                    <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100"><?= $s[0] ?></p>
                    <p class="text-xs text-zinc-400 mt-1"><?= $s[1] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Stack -->
<section class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-14 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="max-w-xl mb-10 fade-in">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">What you'll use</p>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Tools that are beginner-friendly.</h2>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <?php
            $stack = [
                ['PHP 8+',       'Core language — same as Laravel',   'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',  false, null],
                ['REST API',     'JSON-only endpoints for decoupled applications', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', false, null],
                ['Tailwind CSS', 'Same styling Laravel ships with',    null, false, 'tailwind'],
                ['Alpine.js / jQuery', 'Lightweight reactivity or traditional AJAX stack presets', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', false, null],
                ['MySQL / PDO',  'Raw queries before Eloquent ORM',   'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4', false, null],
            ];
            foreach ($stack as $s): ?>
            <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 fade-in">
                <div class="w-8 h-8 rounded-lg bg-zinc-900 dark:bg-zinc-700 flex items-center justify-center mb-3">
                    <?php if ($s[4] === 'tailwind'): ?>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6C9.6 6 8.1 7.2 7.5 9.6c.9-1.2 1.95-1.65 3.15-1.35.685.171 1.174.668 1.715 1.219C13.24 10.39 14.205 11.4 16.5 11.4c2.4 0 3.9-1.2 4.5-3.6-.9 1.2-1.95 1.65-3.15 1.35-.685-.171-1.174-.668-1.715-1.219C15.26 7.011 14.295 6 12 6zm-4.5 5.4C5.1 11.4 3.6 12.6 3 15c.9-1.2 1.95-1.65 3.15-1.35.685.171 1.174.668 1.715 1.219C8.74 15.79 9.705 16.8 12 16.8c2.4 0 3.9-1.2 4.5-3.6-.9 1.2-1.95 1.65-3.15 1.35-.685-.171-1.174-.668-1.715-1.219C10.76 12.411 9.795 11.4 7.5 11.4z"/>
                    </svg>
                    <?php else: ?>
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $s[2] ?>"/>
                    </svg>
                    <?php endif; ?>
                </div>
                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100"><?= $s[0] ?></p>
                <p class="text-xs text-zinc-400 mt-0.5"><?= $s[1] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="bg-white dark:bg-zinc-950 py-14 sm:py-20">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 text-center fade-in">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-3">Ready to stop guessing and start understanding?</h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">Build your first real PHP app from scratch. When you're ready, Laravel will feel like home.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="<?= BASE_URL ?>/register"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-zinc-900 dark:bg-zinc-100 hover:bg-zinc-700 dark:hover:bg-zinc-300 text-white dark:text-zinc-900 text-sm font-medium rounded-lg transition-colors">
                Get started free
            </a>
            <a href="<?= BASE_URL ?>/docs"
               class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 text-zinc-700 dark:text-zinc-300 text-sm font-medium rounded-lg transition-colors">
                Read the docs
            </a>
        </div>
    </div>
</section>
