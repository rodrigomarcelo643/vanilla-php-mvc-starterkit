<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 fade-in">
    <div class="flex gap-10">

        <!-- Sidebar -->
        <aside class="hidden lg:block w-52 shrink-0" x-data="{ active: 'introduction' }" x-init="
            const sectionIds = ['introduction','installation','configuration','routing','controllers','models','views','authentication','admin-panel','ajax','database','custom-routes','middleware','deployment'];
            const sections = sectionIds.map(id => document.getElementById(id)).filter(Boolean);
            window.addEventListener('scroll', () => {
                let current = 'introduction';
                sections.forEach(el => {
                    if (el.getBoundingClientRect().top <= 120) current = el.id;
                });
                active = current;
            });
            if (location.hash) active = location.hash.replace('#','');
        ">
            <div class="sticky top-20 space-y-6">
                <?php
                $sections = [
                    'Getting Started' => ['Introduction', 'Installation', 'Configuration'],
                    'Core Concepts'   => ['Routing', 'Controllers', 'Models', 'Views'],
                    'Features'        => ['Authentication', 'Admin Panel', 'AJAX', 'Database'],
                    'Advanced'        => ['Custom Routes', 'Middleware', 'Deployment'],
                ];
                foreach ($sections as $group => $items): ?>
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-zinc-400 mb-2"><?= $group ?></p>
                    <ul class="space-y-0.5">
                        <?php foreach ($items as $item):
                            $id = strtolower(str_replace(' ', '-', $item));
                        ?>
                        <li>
                            <a href="#<?= $id ?>"
                               @click="active = '<?= $id ?>'"
                               :class="active === '<?= $id ?>' ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 font-medium' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-50 dark:hover:bg-zinc-800'"
                               class="block px-2 py-1.5 text-sm rounded-md transition-colors">
                                <?= $item ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </aside>

        <!-- Content -->
        <div class="flex-1 min-w-0 max-w-2xl">

            <!-- Page header -->
            <div id="introduction" class="mb-10 pb-8 border-b border-zinc-200 dark:border-zinc-800">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-2">Documentation</p>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100 mb-3">Introduction</h1>
                <p class="text-base text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    Welcome to the <?= APP_NAME ?> documentation. This guide covers everything you need to get up and running.
                </p>
            </div>

            <!-- Section: Installation -->
            <div id="installation" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Installation</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-5">
                    Get up and running in minutes. You'll need PHP 8.0+, MySQL 5.7+, Apache with mod_rewrite, and Composer.
                </p>

                <!-- Step 1 -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-zinc-900 text-white text-[10px] font-bold flex items-center justify-center shrink-0">1</span>
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Clone the repository</h3>
                    </div>
                    <div class="relative">
                        <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300">
                            <p><span class="text-zinc-500"># Place inside your web root</span></p>
                            <p>git clone https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit.git</p>
                        </div>
                        <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                            <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="label-copy">Copy</span>
                            <span class="label-check hidden text-green-400">Copied!</span>
                        </button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-zinc-900 text-white text-[10px] font-bold flex items-center justify-center shrink-0">2</span>
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Install dependencies</h3>
                    </div>
                    <div class="relative">
                        <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300">
                            <p>composer install</p>
                        </div>
                        <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                            <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="label-copy">Copy</span>
                            <span class="label-check hidden text-green-400">Copied!</span>
                        </button>
                    </div>
                    <p class="text-xs text-zinc-400 mt-2">This installs PHPMailer, PHPUnit, and other packages defined in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 font-mono">composer.json</code>.</p>
                </div>

                <!-- Step 3 -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-zinc-900 text-white text-[10px] font-bold flex items-center justify-center shrink-0">3</span>
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Import the database</h3>
                    </div>
                    <div class="relative">
                        <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300">
                            <p><span class="text-zinc-500"># Open phpMyAdmin</span></p>
                            <p>Import &rarr; database/starter.sql</p>
                        </div>
                        <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                            <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="label-copy">Copy</span>
                            <span class="label-check hidden text-green-400">Copied!</span>
                        </button>
                    </div>
                    <p class="text-xs text-zinc-400 mt-2">Creates the <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 font-mono">starter</code> database with all tables and seed data including default admin and user accounts.</p>
                </div>

                <!-- Step 4 -->
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-zinc-900 text-white text-[10px] font-bold flex items-center justify-center shrink-0">4</span>
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Configure environment</h3>
                    </div>
                    <div class="relative">
                        <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                            <p><span class="text-zinc-500"># Copy the example file</span></p>
                            <p>cp .env.example .env</p>
                            <p class="mt-3"><span class="text-zinc-500"># Edit .env with your values</span></p>
                            <p>APP_NAME=<span class="text-yellow-300">"Starter Kit"</span></p>
                            <p>BASE_URL=<span class="text-yellow-300">"/your-folder-path"</span></p>
                            <p class="mt-1">DB_HOST=<span class="text-yellow-300">localhost</span></p>
                            <p>DB_NAME=<span class="text-yellow-300">starter</span></p>
                            <p>DB_USER=<span class="text-yellow-300">root</span></p>
                            <p>DB_PASS=<span class="text-yellow-300"></span></p>
                        </div>
                        <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                            <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="label-copy">Copy</span>
                            <span class="label-check hidden text-green-400">Copied!</span>
                        </button>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="mb-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-5 h-5 rounded-full bg-zinc-900 text-white text-[10px] font-bold flex items-center justify-center shrink-0">5</span>
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Visit the app</h3>
                    </div>
                    <div class="relative">
                        <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300">
                            <p>http://localhost/your-folder-path</p>
                        </div>
                        <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                            <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="label-copy">Copy</span>
                            <span class="label-check hidden text-green-400">Copied!</span>
                        </button>
                    </div>
                </div>

                <!-- Default credentials -->
                <div class="mt-5 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-4">
                    <p class="text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-3">Default credentials</p>
                    <div class="grid grid-cols-3 gap-2 text-xs">
                        <span class="font-medium text-zinc-500">Role</span>
                        <span class="font-medium text-zinc-500">Email</span>
                        <span class="font-medium text-zinc-500">Password</span>
                        <span class="text-zinc-900 dark:text-zinc-100">Admin</span>
                        <span class="text-zinc-700 dark:text-zinc-300 font-mono">admin@starter.com</span>
                        <span class="text-zinc-700 dark:text-zinc-300 font-mono">password</span>
                        <span class="text-zinc-900 dark:text-zinc-100">User</span>
                        <span class="text-zinc-700 dark:text-zinc-300 font-mono">alice@example.com</span>
                        <span class="text-zinc-700 dark:text-zinc-300 font-mono">password</span>
                    </div>
                </div>
            </div>

            <!-- Section: Configuration -->
            <div id="configuration" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Configuration</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-5">
                    All configuration is driven by the <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">.env</code> file. Never hardcode credentials — always use <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">$_ENV['KEY']</code>.
                </p>

                <div class="space-y-4">
                    <?php
                    $configs = [
                        ['app/config/app.php',      'APP_NAME, BASE_URL, environment settings'],
                        ['app/config/database.php', 'DB_HOST, DB_NAME, DB_USER, DB_PASS — PDO connection'],
                        ['app/config/mail.php',     'MAIL_HOST, MAIL_USER, MAIL_PASS — SMTP for password reset'],
                    ];
                    foreach ($configs as $c): ?>
                    <div class="flex items-start gap-3 p-3 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                        <code class="text-xs font-mono text-zinc-700 dark:text-zinc-300 shrink-0"><?= $c[0] ?></code>
                        <span class="text-xs text-zinc-400"><?= $c[1] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-5 relative">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-zinc-500"># Reading config values in PHP</span></p>
                        <p>$_ENV[<span class="text-yellow-300">'APP_NAME'</span>]</p>
                        <p>$_ENV[<span class="text-yellow-300">'DB_HOST'</span>]</p>
                        <p>$_ENV[<span class="text-yellow-300">'MAIL_HOST'</span>]</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
            </div>

            <!-- Section: Routing -->
            <div id="routing" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Routing</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Routes are split across four files inside <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">routes/web/</code> and loaded by <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">routes/web.php</code>.
                </p>

                <div class="grid grid-cols-2 gap-2 mb-5">
                    <?php foreach ([
                        ['client.php', '/',       'Public pages'],
                        ['admin.php',  'admin/',  'Admin panel'],
                        ['app.php',    'app/',    'Authenticated users'],
                        ['ajax.php',   'ajax/',   'AJAX endpoints'],
                    ] as $r): ?>
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                        <code class="text-xs font-mono text-zinc-700 dark:text-zinc-300"><?= $r[0] ?></code>
                        <p class="text-xs text-zinc-400 mt-0.5"><span class="font-mono"><?= $r[1] ?></span> — <?= $r[2] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="relative">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-green-400">// GET route</span></p>
                        <p>Router::<span class="text-blue-400">get</span>(<span class="text-yellow-300">'about'</span>, [<span class="text-yellow-300">'HomeController'</span>, <span class="text-yellow-300">'about'</span>]);</p>
                        <p class="mt-2"><span class="text-green-400">// POST route (AJAX)</span></p>
                        <p>Router::<span class="text-blue-400">post</span>(<span class="text-yellow-300">'ajax/login'</span>, [<span class="text-yellow-300">'AuthController'</span>, <span class="text-yellow-300">'ajaxLogin'</span>]);</p>
                        <p class="mt-2"><span class="text-green-400">// GET or POST</span></p>
                        <p>Router::<span class="text-blue-400">any</span>(<span class="text-yellow-300">'contact'</span>, [<span class="text-yellow-300">'HomeController'</span>, <span class="text-yellow-300">'contact'</span>]);</p>
                        <p class="mt-2"><span class="text-green-400">// JSON response</span></p>
                        <p>Router::<span class="text-blue-400">json</span>([<span class="text-yellow-300">'success'</span> => <span class="text-blue-400">true</span>]);</p>
                        <p class="mt-2"><span class="text-green-400">// Redirect</span></p>
                        <p>Router::<span class="text-blue-400">redirect</span>(<span class="text-yellow-300">'login'</span>);</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
            </div>

            <!-- Section: Controllers -->
            <div id="controllers" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Controllers</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Controllers live in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">app/controllers/</code>, extend the base <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">Controller</code> class, and use panel render helpers to load views.
                </p>

                <div class="grid grid-cols-2 gap-2 mb-5">
                    <?php foreach ([
                        ['$this->client()', 'Renders a public client view'],
                        ['$this->app()',    'Renders an authenticated user view'],
                        ['$this->admin()',  'Renders an admin panel view'],
                        ['$this->auth()',   'Renders a login/register view'],
                    ] as $m): ?>
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                        <code class="text-xs font-mono text-zinc-700 dark:text-zinc-300"><?= $m[0] ?></code>
                        <p class="text-xs text-zinc-400 mt-0.5"><?= $m[1] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="relative">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-blue-400">class</span> <span class="text-green-400">PageController</span> <span class="text-blue-400">extends</span> Controller {</p>
                        <p class="pl-4 mt-1"><span class="text-blue-400">public function</span> <span class="text-yellow-300">index</span>() {</p>
                        <p class="pl-8"><span class="text-zinc-500">// pass data to view</span></p>
                        <p class="pl-8">$this-><span class="text-yellow-300">client</span>(<span class="text-yellow-300">'client/page'</span>, [</p>
                        <p class="pl-12"><span class="text-yellow-300">'title'</span> => <span class="text-yellow-300">'Page Title'</span>,</p>
                        <p class="pl-8">]);</p>
                        <p class="pl-4">}</p>
                        <p>}</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
                <p class="text-xs text-zinc-400 mt-3">File naming convention: <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 font-mono">PascalCaseController.php</code></p>
            </div>

            <!-- Section: Models -->
            <div id="models" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Models</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Models live in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">app/models/</code> and extend the base <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">Model</code> class which provides PDO access.
                </p>
                <div class="relative">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-blue-400">class</span> <span class="text-green-400">Post</span> <span class="text-blue-400">extends</span> Model {</p>
                        <p class="pl-4 mt-1"><span class="text-blue-400">public function</span> <span class="text-yellow-300">getAll</span>() {</p>
                        <p class="pl-8"><span class="text-blue-400">return</span> $this->db-><span class="text-yellow-300">fetchAll</span>(<span class="text-yellow-300">"SELECT * FROM posts"</span>);</p>
                        <p class="pl-4">}</p>
                        <p class="pl-4 mt-1"><span class="text-blue-400">public function</span> <span class="text-yellow-300">create</span>(<span class="text-blue-400">array</span> $data) {</p>
                        <p class="pl-8"><span class="text-blue-400">return</span> $this->db-><span class="text-yellow-300">execute</span>(</p>
                        <p class="pl-12"><span class="text-yellow-300">"INSERT INTO posts (title, body) VALUES (?, ?)"</span>,</p>
                        <p class="pl-12">[$data[<span class="text-yellow-300">'title'</span>], $data[<span class="text-yellow-300">'body'</span>]]</p>
                        <p class="pl-8">);</p>
                        <p class="pl-4">}</p>
                        <p>}</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
                <p class="text-xs text-zinc-400 mt-3">DB logic stays in models — keep controllers thin.</p>
            </div>

            <!-- Section: Views -->
            <div id="views" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Views</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Views are plain PHP files in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">app/views/</code>, organized by panel. Each panel has its own layout (header + footer) and components.
                </p>
                <div class="grid grid-cols-2 gap-2 mb-5">
                    <?php foreach ([
                        ['app/views/client/',     'Public pages'],
                        ['app/views/app/',        'Authenticated user pages'],
                        ['app/views/admin/',      'Admin panel pages'],
                        ['app/views/auth/',       'Login, register, reset'],
                        ['app/views/layouts/',    'Header & footer per panel'],
                        ['app/views/components/', 'Shared UI components'],
                    ] as $v): ?>
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                        <code class="text-xs font-mono text-zinc-700 dark:text-zinc-300"><?= $v[0] ?></code>
                        <p class="text-xs text-zinc-400 mt-0.5"><?= $v[1] ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p class="text-xs text-zinc-400">Always sanitize output with <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 font-mono">htmlspecialchars()</code>. File naming: <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 font-mono">snake_case.php</code>.</p>
            </div>

            <!-- Section: Authentication -->
            <div id="authentication" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Authentication</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Auth is session-based via <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">app/core/Auth.php</code>. Passwords are hashed with bcrypt.
                </p>
                <div class="relative mb-4">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-zinc-500">// Check if logged in</span></p>
                        <p>Auth::<span class="text-yellow-300">check</span>();  <span class="text-zinc-500">// returns bool</span></p>
                        <p class="mt-2"><span class="text-zinc-500">// Get session user</span></p>
                        <p>Session::<span class="text-yellow-300">get</span>(<span class="text-yellow-300">'user'</span>);</p>
                        <p class="mt-2"><span class="text-zinc-500">// Destroy session (logout)</span></p>
                        <p>Session::<span class="text-yellow-300">destroy</span>();</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach ([
                        ['Login',           '/login'],
                        ['Register',        '/register'],
                        ['Forgot password', '/forgot-password'],
                        ['Reset password',  '/reset-password'],
                    ] as $a): ?>
                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                        <span class="text-xs text-zinc-700 dark:text-zinc-300"><?= $a[0] ?></span>
                        <code class="text-xs font-mono text-zinc-400"><?= $a[1] ?></code>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Section: Admin Panel -->
            <div id="admin-panel" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Admin Panel</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    The admin panel is accessible at <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">/admin/dashboard</code> and requires an admin session. It includes a collapsible sidebar, topbar with user menu, and data tables.
                </p>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach ([
                        ['Dashboard',  '/admin/dashboard'],
                        ['Users',      '/admin/users'],
                        ['Profile',    '/admin/profile'],
                        ['Settings',   '/admin/settings'],
                    ] as $a): ?>
                    <div class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                        <span class="text-xs text-zinc-700 dark:text-zinc-300"><?= $a[0] ?></span>
                        <code class="text-xs font-mono text-zinc-400"><?= $a[1] ?></code>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Section: AJAX -->
            <div id="ajax" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">AJAX</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    AJAX endpoints live under the <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">ajax/</code> prefix in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">routes/web/ajax.php</code>. All responses use <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">Router::json()</code>. No jQuery — use the built-in fetch helpers in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">assets/js/ajax.js</code>.
                </p>
                <div class="relative mb-4">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-zinc-500">// PHP — return JSON from a controller</span></p>
                        <p>Router::<span class="text-yellow-300">json</span>([<span class="text-yellow-300">'success'</span> => <span class="text-blue-400">true</span>, <span class="text-yellow-300">'message'</span> => <span class="text-yellow-300">'Done'</span>]);</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
                <div class="relative">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-zinc-500">// JS — POST with fetch helper</span></p>
                        <p><span class="text-blue-400">Ajax</span>.<span class="text-yellow-300">post</span>(<span class="text-yellow-300">'/ajax/my-endpoint'</span>, { key: <span class="text-yellow-300">'value'</span> })</p>
                        <p class="pl-4">.<span class="text-yellow-300">then</span>(res => console.<span class="text-yellow-300">log</span>(res));</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
            </div>

            <!-- Section: Database -->
            <div id="database" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Database</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Database access goes through <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">app/core/Database.php</code> — a PDO singleton. Use it inside models via <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">$this->db</code>.
                </p>
                <div class="relative mb-4">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-zinc-500">// Fetch single row</span></p>
                        <p>$this->db-><span class="text-yellow-300">fetch</span>(<span class="text-yellow-300">"SELECT * FROM users WHERE id = ?"</span>, [$id]);</p>
                        <p class="mt-2"><span class="text-zinc-500">// Fetch all rows</span></p>
                        <p>$this->db-><span class="text-yellow-300">fetchAll</span>(<span class="text-yellow-300">"SELECT * FROM users"</span>);</p>
                        <p class="mt-2"><span class="text-zinc-500">// Insert / Update / Delete</span></p>
                        <p>$this->db-><span class="text-yellow-300">execute</span>(<span class="text-yellow-300">"INSERT INTO users (name) VALUES (?)"</span>, [$name]);</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach (['users','admins','sessions','password_resets','activity_logs'] as $t): ?>
                    <div class="p-3 bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg">
                        <code class="text-xs font-mono text-zinc-700 dark:text-zinc-300"><?= $t ?></code>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Section: Custom Routes -->
            <div id="custom-routes" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Custom Routes</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    Add new routes to the appropriate file in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">routes/web/</code> based on who can access them.
                </p>
                <div class="relative">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-zinc-500">// routes/web/client.php — public</span></p>
                        <p>Router::<span class="text-blue-400">get</span>(<span class="text-yellow-300">'contact'</span>, [<span class="text-yellow-300">'HomeController'</span>, <span class="text-yellow-300">'contact'</span>]);</p>
                        <p class="mt-2"><span class="text-zinc-500">// routes/web/app.php — auth required</span></p>
                        <p>Router::<span class="text-blue-400">get</span>(<span class="text-yellow-300">'app/dashboard'</span>, [<span class="text-yellow-300">'AppController'</span>, <span class="text-yellow-300">'dashboard'</span>]);</p>
                        <p class="mt-2"><span class="text-zinc-500">// routes/web/ajax.php — AJAX POST</span></p>
                        <p>Router::<span class="text-blue-400">post</span>(<span class="text-yellow-300">'ajax/save'</span>, [<span class="text-yellow-300">'MyController'</span>, <span class="text-yellow-300">'save'</span>]);</p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
            </div>

            <!-- Section: Deployment -->
            <div id="deployment" class="mb-10 pb-10 border-b border-zinc-100 dark:border-zinc-800">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-4">Deployment</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed mb-4">
                    The project ships with a <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 text-xs font-mono">deploy.yml</code> GitHub Actions workflow that rsyncs to a remote server over SSH.
                </p>
                <div class="relative mb-4">
                    <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                        <p><span class="text-zinc-500"># Required GitHub secrets</span></p>
                        <p>SSH_HOST=<span class="text-yellow-300">your-server-ip</span></p>
                        <p>SSH_USER=<span class="text-yellow-300">your-ssh-user</span></p>
                        <p>SSH_PRIVATE_KEY=<span class="text-yellow-300">contents-of-id_rsa</span></p>
                        <p>DEPLOY_PATH=<span class="text-yellow-300">/var/www/html/project</span></p>
                    </div>
                    <button onclick="copyCode(this)" class="absolute top-2.5 right-2.5 flex items-center gap-1.5 px-2 py-1 rounded-md bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-zinc-100 text-[10px] font-medium transition-colors">
                        <svg class="w-3 h-3 icon-copy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <svg class="w-3 h-3 icon-check hidden text-green-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="label-copy">Copy</span>
                        <span class="label-check hidden text-green-400">Copied!</span>
                    </button>
                </div>
                <p class="text-xs text-zinc-400">Uncomment the <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 font-mono">push</code> trigger in <code class="px-1 py-0.5 bg-zinc-100 dark:bg-zinc-800 rounded text-zinc-700 dark:text-zinc-300 font-mono">.github/workflows/deploy.yml</code> to activate on every push to main.</p>
            </div>

            <!-- Bottom CTA -->
            <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 text-center">
                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-1">Something missing?</p>
                <p class="text-xs text-zinc-500 mb-3">Open an issue or contribute on GitHub.</p>
                <a href="https://github.com/rodrigomarcelo643/php-vanilla-mvc-starterkit" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-zinc-900 hover:bg-zinc-700 text-white text-xs font-medium rounded-lg transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                    </svg>
                    View on GitHub
                </a>
            </div>
        </div>
    </div>
</div>

<script src="<?= BASE_URL ?>/js/docs.js"></script>
