<div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 fade-in">
    <div class="flex gap-10">

        <!-- Sidebar -->
        <aside class="hidden lg:block w-52 shrink-0">
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
                        <?php foreach ($items as $i => $item): ?>
                        <li>
                            <a href="#<?= strtolower(str_replace(' ', '-', $item)) ?>"
                               class="block px-2 py-1.5 text-sm rounded-md transition-colors <?= ($group === 'Getting Started' && $i === 0) ? 'bg-zinc-100 text-zinc-900 font-medium' : 'text-zinc-500 hover:text-zinc-900 hover:bg-zinc-50' ?>">
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
            <div class="mb-10 pb-8 border-b border-zinc-200">
                <p class="text-xs font-semibold uppercase tracking-widest text-zinc-400 mb-2">Documentation</p>
                <h1 class="text-3xl font-bold text-zinc-900 mb-3">Introduction</h1>
                <p class="text-base text-zinc-500 leading-relaxed">
                    Welcome to the <?= APP_NAME ?> documentation. This guide covers everything you need to get up and running.
                </p>
            </div>

            <!-- Section: Installation -->
            <div id="installation" class="mb-10 pb-10 border-b border-zinc-100">
                <h2 class="text-xl font-bold text-zinc-900 mb-4">Installation</h2>
                <p class="text-sm text-zinc-500 leading-relaxed mb-4">
                    Clone or download the project into your web server's document root (e.g. <code class="px-1.5 py-0.5 bg-zinc-100 rounded text-zinc-800 text-xs font-mono">htdocs</code>).
                </p>
                <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                    <p><span class="text-zinc-500"># 1. Place in htdocs</span></p>
                    <p>htdocs/<?= strtolower(str_replace(' ', '-', APP_NAME)) ?>/</p>
                    <p class="mt-2"><span class="text-zinc-500"># 2. Import database</span></p>
                    <p>phpMyAdmin → Import → database/starter.sql</p>
                    <p class="mt-2"><span class="text-zinc-500"># 3. Configure base URL</span></p>
                    <p>app/config/app.php → BASE_URL</p>
                </div>
            </div>

            <!-- Section: Routing -->
            <div id="routing" class="mb-10 pb-10 border-b border-zinc-100">
                <h2 class="text-xl font-bold text-zinc-900 mb-4">Routing</h2>
                <p class="text-sm text-zinc-500 leading-relaxed mb-4">
                    All routes are defined in <code class="px-1.5 py-0.5 bg-zinc-100 rounded text-zinc-800 text-xs font-mono">routes/web.php</code>. The router supports GET and POST methods.
                </p>
                <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                    <p><span class="text-green-400">// GET route</span></p>
                    <p>Router::<span class="text-blue-400">get</span>(<span class="text-yellow-300">'about'</span>, [<span class="text-yellow-300">'HomeController'</span>, <span class="text-yellow-300">'about'</span>]);</p>
                    <p class="mt-2"><span class="text-green-400">// POST route (AJAX)</span></p>
                    <p>Router::<span class="text-blue-400">post</span>(<span class="text-yellow-300">'ajax/login'</span>, [<span class="text-yellow-300">'AuthController'</span>, <span class="text-yellow-300">'ajaxLogin'</span>]);</p>
                </div>
            </div>

            <!-- Section: Controllers -->
            <div id="controllers" class="mb-10 pb-10 border-b border-zinc-100">
                <h2 class="text-xl font-bold text-zinc-900 mb-4">Controllers</h2>
                <p class="text-sm text-zinc-500 leading-relaxed mb-4">
                    Controllers live in <code class="px-1.5 py-0.5 bg-zinc-100 rounded text-zinc-800 text-xs font-mono">app/controllers/</code> and extend the base <code class="px-1.5 py-0.5 bg-zinc-100 rounded text-zinc-800 text-xs font-mono">Controller</code> class.
                </p>
                <div class="bg-zinc-950 rounded-xl p-4 font-mono text-xs text-zinc-300 space-y-1">
                    <p><span class="text-blue-400">class</span> <span class="text-green-400">PageController</span> <span class="text-blue-400">extends</span> Controller {</p>
                    <p class="pl-4"><span class="text-blue-400">public function</span> <span class="text-yellow-300">index</span>() {</p>
                    <p class="pl-8">$this-><span class="text-yellow-300">client</span>(<span class="text-yellow-300">'client/page'</span>, [<span class="text-yellow-300">'title'</span> => <span class="text-yellow-300">'Page'</span>]);</p>
                    <p class="pl-4">}</p>
                    <p>}</p>
                </div>
            </div>

            <!-- More coming soon -->
            <div class="bg-zinc-50 border border-zinc-200 rounded-xl p-6 text-center">
                <p class="text-sm font-medium text-zinc-900 mb-1">More docs coming soon</p>
                <p class="text-xs text-zinc-500">Check back for full documentation on Models, Views, Auth, and more.</p>
            </div>
        </div>
    </div>
</div>
