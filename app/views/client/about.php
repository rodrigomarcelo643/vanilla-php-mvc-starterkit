<!-- Header -->
<section class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-14 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 fade-in">
        <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">About</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-zinc-100 leading-tight mb-4 max-w-2xl">
            Built for developers who value simplicity.
        </h1>
        <p class="text-base text-zinc-500 dark:text-zinc-400 max-w-xl leading-relaxed">
            <?= APP_NAME ?> is a minimal PHP MVC starter kit designed to give you a clean, well-structured foundation without the bloat of a full framework.
        </p>
    </div>
</section>

<!-- Mission -->
<section class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 py-14 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="fade-in">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Our mission</p>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Less boilerplate, more building.</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Most PHP frameworks come with hundreds of files, complex configurations, and steep learning curves. We believe you should be able to open a project and understand every file in under an hour.
                </p>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    <?= APP_NAME ?> gives you routing, MVC structure, authentication, and an admin panel — nothing more, nothing less.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-4 fade-in">
                <?php foreach ([
                    ['100%', 'Vanilla PHP'],
                    ['0',    'Dependencies'],
                    ['5min', 'Setup time'],
                    ['MIT',  'License'],
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
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Tech stack</p>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">What's under the hood.</h2>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php
            $stack = [
                ['PHP 8+',       'Core language',         'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                ['Tailwind CSS', 'Utility-first styling',  'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343'],
                ['Alpine.js',    'Lightweight reactivity', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['MySQL / PDO',  'Database layer',         'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4'],
            ];
            foreach ($stack as $s): ?>
            <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 fade-in">
                <div class="w-8 h-8 rounded-lg bg-zinc-900 dark:bg-zinc-700 flex items-center justify-center mb-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $s[2] ?>"/>
                    </svg>
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
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-3">Ready to get started?</h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">Create your account and start building today.</p>
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
