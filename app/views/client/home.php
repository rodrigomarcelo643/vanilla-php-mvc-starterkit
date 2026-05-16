<!-- ── Hero ─────────────────────────────────────────────────── -->
<section class="bg-white border-b border-zinc-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 sm:py-28">
        <div class="max-w-3xl mx-auto text-center fade-in">

            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-zinc-200 text-xs font-medium text-zinc-600 mb-7">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                v1.0 &mdash; Open source & free
                <span class="w-px h-3 bg-zinc-300"></span>
                <a href="https://github.com" target="_blank" class="inline-flex items-center gap-1 text-zinc-900 hover:underline underline-offset-2">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                    Star on GitHub
                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-bold text-zinc-900 leading-[1.15] tracking-tight mb-5">
                The PHP starter kit<br>
                <span class="text-zinc-400">built for developers.</span>
            </h1>

            <p class="text-base sm:text-lg text-zinc-500 leading-relaxed mb-8 max-w-xl mx-auto">
                A clean MVC foundation with Tailwind CSS, AJAX, session auth, and a full admin panel.
                Start building in minutes, not hours.
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
                   class="inline-flex items-center gap-2 px-5 py-2.5 border border-zinc-300 hover:border-zinc-400 text-zinc-700 text-sm font-medium rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Read the docs
                </a>
            </div>

            <!-- Social proof -->
            <div class="flex flex-wrap items-center justify-center gap-5 mt-10 pt-8 border-t border-zinc-100">
                <?php foreach ([['1.2k','GitHub Stars'],['MIT','License'],['PHP 8+','Required'],['Zero deps','No Composer']] as $s): ?>
                <div>
                    <p class="text-sm font-semibold text-zinc-900"><?= $s[0] ?></p>
                    <p class="text-xs text-zinc-400"><?= $s[1] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- ── Marquee strip ────────────────────────────────────────── -->
<div class="border-y border-zinc-200 bg-zinc-50" style="overflow:hidden;padding:10px 0">
    <div class="marquee-track" style="display:flex;flex-direction:row;align-items:center;gap:2.5rem;width:max-content;white-space:nowrap">
        <?php
        $marqueeItems = ['PHP MVC Starter Kit v1.0', 'Tailwind CSS + Alpine.js', 'Session Auth built-in', 'Full Admin Panel', 'AJAX Ready', 'Fully Responsive', 'Open Source & Free', 'MIT License', 'Zero Dependencies', 'PHP 8+'];
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
<section class="bg-white border-b border-zinc-200 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <div class="max-w-xl mb-12 fade-in">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Features</p>
            <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900 leading-tight">Everything included,<br>nothing unnecessary.</h2>
            <p class="text-sm text-zinc-500 mt-3 leading-relaxed">A carefully selected set of tools and patterns to get you productive immediately.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-px bg-zinc-200 border border-zinc-200 rounded-xl overflow-hidden">
            <?php
            $features = [
                ['icon' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z',
                 'title' => 'MVC Architecture',  'desc' => 'Controllers, Models, Views — clean separation of concerns out of the box.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                 'title' => 'Session Auth',       'desc' => 'Login, register, and logout with secure PHP sessions and bcrypt passwords.'],
                ['icon' => 'M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7',
                 'title' => 'Admin Dashboard',    'desc' => 'Full admin panel with collapsible sidebar, topbar, and data tables.'],
                ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                 'title' => 'AJAX Helpers',       'desc' => 'Lightweight fetch wrappers for POST/GET with JSON responses built in.'],
                ['icon' => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                 'title' => 'Tailwind CSS',        'desc' => 'Utility-first styling via CDN — no build step required.'],
                ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                 'title' => 'Zero Dependencies',  'desc' => 'No Composer, no npm. Just PHP, a browser, and your ideas.'],
            ];
            foreach ($features as $f): ?>
            <div class="bg-white p-6 hover:bg-zinc-50 transition-colors fade-in">
                <div class="w-8 h-8 rounded-lg bg-zinc-100 flex items-center justify-center mb-4">
                    <svg class="w-4 h-4 text-zinc-700" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?= $f['icon'] ?>"/>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-zinc-900 mb-1.5"><?= $f['title'] ?></h3>
                <p class="text-xs text-zinc-500 leading-relaxed"><?= $f['desc'] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── How it works ──────────────────────────────────────────── -->
<section class="bg-zinc-50 border-b border-zinc-200 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="max-w-xl mb-12 fade-in">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">How it works</p>
            <h2 class="text-2xl sm:text-3xl font-bold text-zinc-900">Up and running in 3 steps.</h2>
        </div>
        <div class="grid sm:grid-cols-3 gap-6">
            <?php
            $steps = [
                ['01', 'Clone the repo',    'Download or clone the project into your htdocs folder.', 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
                ['02', 'Import the DB',     'Run the SQL file in phpMyAdmin to set up your database.', 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4'],
                ['03', 'Start building',    'Visit localhost and start customizing for your project.', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ];
            foreach ($steps as $s): ?>
            <div class="bg-white border border-zinc-200 rounded-xl p-6 fade-in">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs font-mono font-bold text-zinc-400"><?= $s[0] ?></span>
                    <div class="flex-1 h-px bg-zinc-100"></div>
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-zinc-700" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="<?= $s[2] ?>"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-zinc-900 mb-1.5"><?= $s[1] ?></h3>
                <p class="text-xs text-zinc-500 leading-relaxed"><?= $s[3] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── Latest from blog ──────────────────────────────────────── -->
<section class="bg-white border-b border-zinc-200 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-end justify-between mb-10 fade-in">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-2">Blog</p>
                <h2 class="text-2xl font-bold text-zinc-900">Latest articles</h2>
            </div>
            <a href="<?= BASE_URL ?>/blog" class="text-sm font-medium text-zinc-900 hover:underline underline-offset-4 hidden sm:block">
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
            <a href="<?= BASE_URL ?>/blog" class="group block bg-white border border-zinc-200 rounded-xl p-5 hover:border-zinc-300 transition-colors fade-in">
                <span class="inline-block px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide bg-zinc-100 text-zinc-600 rounded mb-3"><?= $p[4] ?></span>
                <h3 class="text-sm font-semibold text-zinc-900 group-hover:text-zinc-600 transition-colors leading-snug mb-2"><?= $p[0] ?></h3>
                <p class="text-xs text-zinc-500 leading-relaxed mb-4"><?= $p[1] ?></p>
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

<!-- ── CTA ───────────────────────────────────────────────────── -->
<section class="bg-zinc-950 py-16 sm:py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center fade-in">
        <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-4">Get started today</p>
        <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4">Ready to build something great?</h2>
        <p class="text-sm text-zinc-400 mb-8 leading-relaxed">
            Create your free account and start building. No credit card required.
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
