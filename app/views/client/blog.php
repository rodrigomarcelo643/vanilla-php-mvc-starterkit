<!-- Header -->
<section class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-14 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 fade-in">
        <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-3">Blog</p>
        <h1 class="text-3xl sm:text-4xl font-bold text-zinc-900 dark:text-zinc-100 mb-3">Articles & Guides</h1>
        <p class="text-base text-zinc-500 dark:text-zinc-400 max-w-lg leading-relaxed">
            Beginner-friendly tutorials on PHP MVC, vanilla patterns, and everything you need to know before jumping into Laravel.
        </p>
    </div>
</section>

<!-- Posts -->
<section class="bg-white dark:bg-zinc-950 py-12 sm:py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">

        <!-- Category filter -->
        <div class="flex flex-wrap gap-2 mb-10 fade-in">
            <?php foreach (['All', 'Tutorial', 'Guide', 'Tips', 'Laravel Prep'] as $i => $cat): ?>
            <button class="px-3 py-1.5 text-xs font-medium rounded-full border transition-colors
                           <?= $i === 0 ? 'bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 border-zinc-900 dark:border-zinc-100' : 'border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 hover:border-zinc-400 dark:hover:border-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100' ?>">
                <?= $cat ?>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Featured post -->
        <?php
        $posts = [
            ['PHP MVC from Scratch — Before You Touch Laravel',  'A complete walkthrough of how routing, controllers, models, and views work in plain PHP — so Laravel\'s magic finally makes sense.',                                    'Jan 12, 2025', '5 min read', 'Tutorial',    true],
            ['How Laravel\'s Router Actually Works',               'We build a mini router in vanilla PHP so you understand exactly what Route::get() is doing under the hood.',                                                         'Jan 8, 2025',  '8 min read', 'Laravel Prep', false],
            ['Tailwind CSS for PHP Beginners',                     'Practical utility-first patterns that work great in PHP template files. No build step, no Node.js — just drop in the CDN and go.',                                   'Jan 3, 2025',  '4 min read', 'Tips',         false],
            ['Session Auth Deep Dive',                             'How login, logout, and password hashing work in raw PHP — and how that maps to Laravel\'s Auth facade.',                                                            'Dec 28, 2024', '6 min read', 'Guide',        false],
            ['Building an Admin Panel Without a Framework',        'How to structure a real admin dashboard with sidebar, topbar, and data tables using only PHP and Tailwind.',                                                          'Dec 20, 2024', '5 min read', 'Tutorial',    false],
            ['From This Starter Kit to Laravel — Your Roadmap',   'You\'ve learned MVC, routing, and auth from scratch. Here\'s exactly what to learn next to make the jump to Laravel confidently.',                                 'Dec 15, 2024', '3 min read', 'Laravel Prep', false],
        ];
        $featured = $posts[0];
        ?>

        <a href="#" class="group block bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 sm:p-8 mb-6 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors fade-in">
            <span class="inline-block px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide bg-zinc-200 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded mb-3"><?= $featured[4] ?></span>
            <h2 class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-zinc-600 dark:group-hover:text-zinc-400 transition-colors mb-2 leading-snug"><?= $featured[0] ?></h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4 max-w-2xl"><?= $featured[1] ?></p>
            <div class="flex items-center gap-3 text-xs text-zinc-400">
                <span><?= $featured[2] ?></span>
                <span>·</span>
                <span><?= $featured[3] ?></span>
                <span class="ml-auto text-zinc-900 dark:text-zinc-100 font-medium group-hover:underline underline-offset-4">Read article →</span>
            </div>
        </a>

        <!-- Post grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach (array_slice($posts, 1) as $p): ?>
            <a href="#" class="group block bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-5 hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors fade-in">
                <span class="inline-block px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 rounded mb-3"><?= $p[4] ?></span>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 group-hover:text-zinc-600 dark:group-hover:text-zinc-400 transition-colors leading-snug mb-2"><?= $p[0] ?></h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4 line-clamp-2"><?= $p[1] ?></p>
                <div class="flex items-center gap-2 text-xs text-zinc-400">
                    <span><?= $p[2] ?></span>
                    <span>·</span>
                    <span><?= $p[3] ?></span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Newsletter -->
        <div class="mt-14 bg-zinc-950 rounded-2xl p-8 sm:p-10 text-center fade-in">
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mb-3">Newsletter</p>
            <h3 class="text-xl font-bold text-white mb-2">Level up your PHP before Laravel</h3>
            <p class="text-sm text-zinc-400 mb-6">Get new tutorials on PHP MVC, beginner patterns, and Laravel prep delivered to your inbox.</p>
            <div class="flex flex-col sm:flex-row gap-2 max-w-sm mx-auto">
                <input type="email" placeholder="you@example.com"
                    class="flex-1 h-10 px-4 text-sm bg-zinc-900 border border-zinc-700 rounded-lg text-white placeholder-zinc-500 focus:outline-none focus:border-zinc-500 transition-colors">
                <button class="h-10 px-5 bg-white hover:bg-zinc-100 text-zinc-900 text-sm font-medium rounded-lg transition-colors whitespace-nowrap">
                    Subscribe
                </button>
            </div>
        </div>
    </div>
</section>
