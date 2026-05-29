<!-- ── Hero ─────────────────────────────────────────────────── -->
<section class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 sm:py-28">
        <div class="max-w-3xl mx-auto text-center fade-in">

            <?php
            $githubRepo = 'rodrigomarcelo643/php-vanilla-mvc-starterkit';
            $githubUrl  = 'https://github.com/' . $githubRepo;
            ?>
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-zinc-200 dark:border-zinc-700 text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-7">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                v1.1.4 &mdash; Free for beginners
                <span class="w-px h-3 bg-zinc-300"></span>
                <a href="<?= $githubUrl ?>" target="_blank" class="inline-flex items-center gap-1 text-zinc-900 dark:text-zinc-100 hover:underline underline-offset-2">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                    Star on GitHub
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-bold text-zinc-900 dark:text-zinc-100 leading-[1.15] tracking-tight mb-5">
                Learn PHP the right way —<br>
                <span class="text-zinc-400 dark:text-zinc-500">before you touch Laravel.</span>
            </h1>

            <p class="text-base sm:text-lg text-zinc-500 dark:text-zinc-400 leading-relaxed mb-8 max-w-xl mx-auto">
                A beginner-friendly PHP MVC starter kit that teaches you how routing, controllers, models, and views actually work — so Laravel feels natural when you get there.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="<?= BASE_URL ?>/register"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-medium rounded-lg transition-colors">
                    Get started free
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="<?= BASE_URL ?>/docs"
                   class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 dark:border-zinc-700 hover:border-zinc-400 dark:hover:border-zinc-500 text-zinc-700 dark:text-zinc-300 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Read the docs
                </a>
            </div>

            <!-- Social proof -->
            <div class="flex flex-wrap items-center justify-center gap-5 mt-10 pt-8 border-t border-zinc-100 dark:border-zinc-800">
                <div x-data="{ stars: '...' }" x-init="fetch('https://api.github.com/repos/<?= $githubRepo ?>').then(r => r.json()).then(d => stars = d.stargazers_count || 0).catch(() => stars = 0)">
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100" x-text="stars">...</p>
                    <p class="text-xs text-zinc-400">GitHub Stars</p>
                </div>
                <?php foreach ([['Laravel-ready','MVC Patterns'],['Zero Frameworks','Pure PHP 8+']] as $s): ?>
                <div>
                    <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100"><?= $s[0] ?></p>
                    <p class="text-xs text-zinc-400"><?= $s[1] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ── Marquee strip ────────────────────────────────────────── -->
<div class="border-y border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900" style="overflow:hidden;padding:10px 0">
    <div class="marquee-track" style="display:flex;flex-direction:row;align-items:center;gap:2.5rem;width:max-content;white-space:nowrap">
        <?php
        $marqueeItems = ['Beginner Friendly', 'PHP MVC Starter Kit v1.1.4', 'Laravel Preparation', 'Tailwind CSS + Alpine.js', 'Session Auth built-in', 'Full Admin Panel', 'AJAX Ready', 'Fully Responsive', 'Open Source & Free', 'Composer Ready', 'PHP 8+', 'Understand MVC First'];
        $all = array_merge($marqueeItems, $marqueeItems);
        foreach ($all as $mi): ?>
        <span style="display:inline-flex;align-items:center;gap:8px;color:#a1a1aa;font-size:12px;font-weight:500;flex-shrink:0">
            <span style="width:3px;height:3px;border-radius:50%;background:#d4d4d8;display:inline-block"></span>
            <?= htmlspecialchars($mi) ?>
        </span>
        <?php endforeach; ?>
    </div>
</div>

<!-- ── Features ──────────────────────────────────────────────── -->
<section class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="max-w-xl mb-12 fade-in">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Features</p>
            <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 leading-tight">Everything a beginner needs,<br>nothing to overwhelm you.</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-3 leading-relaxed">Learn the patterns Laravel uses — routing, MVC, auth, env config — without the magic hiding how it works.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-zinc-200 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden">
            <?php
            $features = [
                [
                    'title' => 'MVC Architecture',
                    'desc'  => 'Understand Controllers, Models, and Views hands-on — the same pattern Laravel is built on.',
                    'svg'   => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
                    'fill'  => true,
                ],
                [
                    'title' => 'Session Auth',
                    'desc'  => 'Build login, register, and logout from scratch — so you know what Laravel Auth does under the hood.',
                    'svg'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 11h14l1 9H4l1-9z"/>',
                    'fill'  => false,
                ],
                [
                    'title' => 'Admin Dashboard',
                    'desc'  => 'A real-world admin panel with sidebar, topbar, and data tables — not just a tutorial toy.',
                    'svg'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 6h18M3 14h12M3 18h8"/>',
                    'fill'  => false,
                ],
                [
                    'title' => 'Routing from Scratch',
                    'desc'  => 'See exactly how URL routing works before Laravel\'s Route::get() abstracts it away.',
                    'svg'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                    'fill'  => false,
                ],
                [
                    'title' => 'REST API & JSON',
                    'desc'  => 'Build pure RESTful JSON endpoints for decoupled applications or choose full-stack templates.',
                    'svg'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                    'fill'  => false,
                ],
                [
                    'title' => 'Laravel-Ready Patterns',
                    'desc'  => 'Every pattern here — models, controllers, env config — maps directly to how Laravel works.',
                    'svg'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
                    'fill'  => false,
                ],
            ];
            foreach ($features as $f): ?>
            <div class="bg-white dark:bg-zinc-900 p-6 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors fade-in">
                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                    <svg class="w-4 h-4 text-zinc-700 dark:text-zinc-300" fill="<?= $f['fill'] ? 'currentColor' : 'none' ?>" stroke="<?= $f['fill'] ? 'none' : 'currentColor' ?>" stroke-width="2" viewBox="0 0 24 24">
                        <?= $f['svg'] ?>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-1.5"><?= $f['title'] ?></h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed"><?= $f['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── How it works ──────────────────────────────────────────── -->
<section class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="max-w-xl mb-12 fade-in">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">How it works</p>
            <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100">From zero to Laravel-ready in 3 steps.</h2>
        </div>
        <div class="grid sm:grid-cols-3 gap-6">
            <?php
            $steps = [
                ['01', 'Composer install',    'Install using composer create-project mardev/starter-kit to trigger the setup wizard.', '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>'],
                ['02', 'Read the code',        'Every file is readable and commented. No magic, no black boxes — just PHP.',         '<ellipse cx="12" cy="5" rx="9" ry="3"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 5v14c0 1.657 4.03 3 9 3s9-1.343 9-3V5M3 12c0 1.657 4.03 3 9 3s9-1.343 9-3"/>'],
                ['03', 'Graduate to Laravel',  'Once you understand MVC from scratch, Laravel\'s conventions will click immediately.', '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>'],
            ];
            foreach ($steps as $s): ?>
            <div class="bg-white dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 fade-in">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-mono font-bold text-zinc-400"><?= $s[0] ?></span>
                    <div class="flex-1 h-px bg-zinc-100 dark:bg-zinc-800"></div>
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <svg class="w-4 h-4 text-zinc-700 dark:text-zinc-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <?= $s[3] ?>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-1.5"><?= $s[1] ?></h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed"><?= $s[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Latest from blog ──────────────────────────────────────── -->
<section class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between mb-10 fade-in">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-2">Blog</p>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Latest articles</h2>
            </div>
            <a href="<?= BASE_URL ?>/blog" class="text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:underline underline-offset-4 hidden sm:block">
                View all →
            </a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php
            $posts = [
                ['Getting Started with PHP MVC',       'Learn how to set up and customize this starter kit for your next project.',  'Jan 12, 2025', '5 min read', 'Tutorial'],
                ['Building REST APIs with Vanilla PHP', 'How to create clean JSON endpoints without any framework overhead.',          'Jan 8, 2025',  '8 min read', 'Guide'],
                ['Tailwind CSS Tips for PHP Devs',      'Practical utility-first patterns that work great in PHP template files.',    'Jan 3, 2025',  '4 min read', 'Tips'],
            ];
            foreach ($posts as $p): ?>
            <a href="<?= BASE_URL ?>/blog" class="group block bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors fade-in">
                <span class="inline-block px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded mb-3"><?= $p[4] ?></span>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-zinc-600 dark:group-hover:text-zinc-400 transition-colors leading-snug mb-2"><?= $p[0] ?></h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4"><?= $p[1] ?></p>
                <div class="flex items-center gap-2 text-xs text-zinc-400">
                    <span><?= $p[2] ?></span>
                    <span>·</span>
                    <span><?= $p[3] ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── JS / AJAX / Alpine.js ────────────────────────────────── -->
<section class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="max-w-xl mb-12 fade-in">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Frontend Layer</p>
            <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-zinc-100 leading-tight">AJAX, API, Alpine.js &amp; jQuery interactions — all wired up.</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-3 leading-relaxed">No build pipeline. No bundler. Just clean, readable JavaScript files and preset frontend bundles that show you exactly how the frontend talks to the backend.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-zinc-200 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 rounded-xl overflow-hidden mb-10">
            <?php
            $jsFeatures = [
                [
                    'title' => 'Ajax.js / jquery_ajax.js',
                    'desc'  => 'Clean wrappers around Fetch API or jQuery $.ajax. Every form submission — login, register, profile update — is automatically wired through them.',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'file'  => 'js/ajax.js or jquery_ajax.js',
                ],
                [
                    'title' => 'App.js — Global Utilities',
                    'desc'  => 'Shared helpers used everywhere: <code>App.toast()</code> for notifications, <code>App.alert()</code> for inline errors, <code>App.setLoading()</code> for button spinners.',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/>',
                    'file'  => 'js/app.js',
                ],
                [
                    'title' => 'Auth.js — Form Handlers',
                    'desc'  => 'Handles login, register, forgot password, and reset password form submissions via AJAX — including a live password strength meter on the reset form.',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>',
                    'file'  => 'js/auth.js',
                ],
                [
                    'title' => 'Avatar.js — Upload & Preview',
                    'desc'  => 'Drag-and-drop or click-to-upload avatar with instant local preview, XHR upload progress bar, and live DOM update across topbar, sidebar, and profile card.',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'file'  => 'js/avatar.js',
                ],
                [
                    'title' => 'Alpine.js or jQuery Stack',
                    'desc'  => 'Pick Alpine.js for modern reactive attributes or jQuery for traditional AJAX stack monolith flows — both come fully ready out of the box.',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
                    'file'  => 'Alpine.js CDN or js/jquery.min.js',
                ],
                [
                    'title' => 'Theme.js + Sidebar.js',
                    'desc'  => 'Dark/light mode toggle persisted to <code>localStorage</code>. Sidebar open/close bound to frontend state with a <kbd>Ctrl+B</kbd> keyboard shortcut.',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>',
                    'file'  => 'js/theme.js · js/sidebar.js',
                ],
            ];
            foreach ($jsFeatures as $f): ?>
            <div class="bg-white dark:bg-zinc-900 p-6 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors fade-in">
                <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                    <svg class="w-4 h-4 text-zinc-700 dark:text-zinc-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <?= $f['icon'] ?>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-1.5"><?= $f['title'] ?></h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed mb-3"><?= $f['desc'] ?></p>
                <span class="inline-block font-mono text-[10px] text-zinc-400 dark:text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded"><?= $f['file'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- AJAX flow diagram -->
        <?php include __DIR__ . '/../components/shared/ajax-flow.php'; ?>

    </div>
</section>

<!-- ── CTA ───────────────────────────────────────────────────── -->
<section class="bg-zinc-950 py-16 sm:py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center fade-in">
        <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-4">Start learning today</p>
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Understand PHP before the framework does it for you.</h2>
        <p class="text-sm text-zinc-400 mb-8 leading-relaxed">
            Most beginners jump straight into Laravel without knowing what's happening underneath. Start here — build real features in vanilla PHP, then Laravel will make complete sense.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="<?= BASE_URL ?>/register"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white hover:bg-zinc-100 text-zinc-900 text-sm font-medium rounded-lg transition-colors">
                Create free account
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            <a href="<?= BASE_URL ?>/docs"
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 border border-zinc-700 hover:border-zinc-500 text-zinc-400 hover:text-white text-sm font-medium rounded-lg transition-colors">
                Read the docs
            </a>
        </div>
    </div>
</section>
