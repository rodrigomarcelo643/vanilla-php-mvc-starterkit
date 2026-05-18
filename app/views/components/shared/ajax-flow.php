<!-- AJAX Flow Diagram -->
<div class="w-full max-w-2xl mx-auto px-4 py-8 font-sans select-none" x-data="ajaxFlow()" x-init="init()">

    <!-- Title -->
    <div class="text-center mb-8">
        <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            AJAX Request Flow
        </span>
        <h2 class="mt-1 text-xl font-bold text-zinc-900 dark:text-zinc-100">How a request travels end-to-end</h2>
    </div>

    <!-- Steps -->
    <div class="relative flex flex-col gap-0">

        <?php
        $steps = [
            [
                'id'      => 'user',
                'label'   => 'User Action',
                'desc'    => 'Form submit or button click triggers the flow',
                'color'   => 'violet',
                'bg'      => 'bg-violet-50 dark:bg-violet-950/40',
                'border'  => 'border-violet-200 dark:border-violet-800',
                'badge'   => 'bg-violet-100 dark:bg-violet-900 text-violet-700 dark:text-violet-300',
                'dot'     => 'bg-violet-500',
                'icon'    => 'M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122',
                'tag'     => '01',
            ],
            [
                'id'      => 'ajax',
                'label'   => 'Ajax.post()',
                'desc'    => 'Fetch POST with FormData + X-Requested-With header',
                'color'   => 'blue',
                'bg'      => 'bg-blue-50 dark:bg-blue-950/40',
                'border'  => 'border-blue-200 dark:border-blue-800',
                'badge'   => 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300',
                'dot'     => 'bg-blue-500',
                'icon'    => 'M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'tag'     => '02',
            ],
            [
                'id'      => 'route',
                'label'   => 'PHP Route',
                'desc'    => 'ajax/* route matched → Controller method dispatched',
                'color'   => 'amber',
                'bg'      => 'bg-amber-50 dark:bg-amber-950/40',
                'border'  => 'border-amber-200 dark:border-amber-800',
                'badge'   => 'bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300',
                'dot'     => 'bg-amber-500',
                'icon'    => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7',
                'tag'     => '03',
            ],
            [
                'id'      => 'json',
                'label'   => 'JSON Response',
                'desc'    => '{ success, message, data } returned to the client',
                'color'   => 'emerald',
                'bg'      => 'bg-emerald-50 dark:bg-emerald-950/40',
                'border'  => 'border-emerald-200 dark:border-emerald-800',
                'badge'   => 'bg-emerald-100 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300',
                'dot'     => 'bg-emerald-500',
                'icon'    => 'M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4',
                'tag'     => '04',
            ],
            [
                'id'      => 'toast',
                'label'   => 'App.toast()',
                'desc'    => 'UI updates instantly — zero page reload',
                'color'   => 'rose',
                'bg'      => 'bg-rose-50 dark:bg-rose-950/40',
                'border'  => 'border-rose-200 dark:border-rose-800',
                'badge'   => 'bg-rose-100 dark:bg-rose-900 text-rose-700 dark:text-rose-300',
                'dot'     => 'bg-rose-500',
                'icon'    => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9',
                'tag'     => '05',
            ],
        ];
        ?>

        <?php foreach ($steps as $i => $s): ?>
        <div class="relative flex gap-4 group"
             x-data
             x-intersect.once="$el.classList.add('flow-visible')"
             style="opacity:0;transform:translateY(16px);transition:opacity .4s ease <?= $i * 80 ?>ms, transform .4s ease <?= $i * 80 ?>ms"
             :class="'flow-step'">

            <!-- Left: connector line + dot -->
            <div class="flex flex-col items-center w-8 shrink-0">
                <!-- dot -->
                <div class="relative z-10 w-8 h-8 rounded-full <?= $s['bg'] ?> <?= $s['border'] ?> border-2 flex items-center justify-center shadow-sm mt-1">
                    <div class="w-2.5 h-2.5 rounded-full <?= $s['dot'] ?>"></div>
                </div>
                <!-- line -->
                <?php if ($i < count($steps) - 1): ?>
                <div class="w-px flex-1 mt-1 mb-0 <?= $s['dot'] ?> opacity-20 min-h-[2rem]"></div>
                <?php endif; ?>
            </div>

            <!-- Right: card -->
            <div class="flex-1 mb-4">
                <div class="<?= $s['bg'] ?> <?= $s['border'] ?> border rounded-xl p-4 shadow-sm
                             group-hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start gap-3">
                        <!-- Icon -->
                        <div class="<?= $s['badge'] ?> rounded-lg p-2 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="<?= $s['icon'] ?>"/>
                            </svg>
                        </div>
                        <!-- Text -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100"><?= $s['label'] ?></span>
                                <span class="text-[10px] font-bold tracking-widest <?= $s['badge'] ?> px-1.5 py-0.5 rounded-full"><?= $s['tag'] ?></span>
                            </div>
                            <p class="mt-0.5 text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed"><?= $s['desc'] ?></p>
                        </div>
                    </div>

                    <?php if ($s['id'] === 'ajax'): ?>
                    <!-- Code snippet -->
                    <div class="mt-3 rounded-lg bg-zinc-900 dark:bg-zinc-950 px-3 py-2.5 font-mono text-[11px] leading-relaxed overflow-x-auto">
                        <span class="text-zinc-500">// js/ajax.js</span><br>
                        <span class="text-blue-400">Ajax</span><span class="text-zinc-300">.post(</span><span class="text-emerald-400">'ajax/login'</span><span class="text-zinc-300">, formData).then(</span><span class="text-violet-400">res</span> <span class="text-zinc-300">=> {</span><br>
                        <span class="text-zinc-300">&nbsp;&nbsp;</span><span class="text-blue-400">App</span><span class="text-zinc-300">.toast(</span><span class="text-violet-400">res</span><span class="text-zinc-300">.message);</span><br>
                        <span class="text-zinc-300">});</span>
                    </div>
                    <?php endif; ?>

                    <?php if ($s['id'] === 'route'): ?>
                    <div class="mt-3 rounded-lg bg-zinc-900 dark:bg-zinc-950 px-3 py-2.5 font-mono text-[11px] leading-relaxed overflow-x-auto">
                        <span class="text-zinc-500">// routes/web/auth/ajax.php</span><br>
                        <span class="text-violet-400">$router</span><span class="text-zinc-300">->post(</span><span class="text-emerald-400">'ajax/login'</span><span class="text-zinc-300">, [</span><span class="text-blue-400">AuthController</span><span class="text-zinc-300">::class, </span><span class="text-emerald-400">'login'</span><span class="text-zinc-300">]);</span>
                    </div>
                    <?php endif; ?>

                    <?php if ($s['id'] === 'json'): ?>
                    <div class="mt-3 rounded-lg bg-zinc-900 dark:bg-zinc-950 px-3 py-2.5 font-mono text-[11px] leading-relaxed overflow-x-auto">
                        <span class="text-zinc-300">{</span><br>
                        <span class="text-zinc-300">&nbsp;&nbsp;</span><span class="text-emerald-400">"success"</span><span class="text-zinc-300">: </span><span class="text-blue-400">true</span><span class="text-zinc-300">,</span><br>
                        <span class="text-zinc-300">&nbsp;&nbsp;</span><span class="text-emerald-400">"message"</span><span class="text-zinc-300">: </span><span class="text-amber-400">"Logged in"</span><span class="text-zinc-300">,</span><br>
                        <span class="text-zinc-300">&nbsp;&nbsp;</span><span class="text-emerald-400">"data"</span><span class="text-zinc-300">: { ... }</span><br>
                        <span class="text-zinc-300">}</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

    <!-- Replay button -->
    <div class="flex justify-center mt-2">
        <button @click="replay()"
                class="inline-flex items-center gap-1.5 text-xs font-medium text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200
                       border border-zinc-200 dark:border-zinc-700 rounded-full px-3 py-1.5 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Replay animation
        </button>
    </div>
</div>

<style>
.flow-visible {
    opacity: 1 !important;
    transform: translateY(0) !important;
}
</style>

<script>
function ajaxFlow() {
    return {
        init() {
            // trigger on load for browsers without x-intersect
            setTimeout(() => {
                document.querySelectorAll('.flow-step').forEach(el => el.classList.add('flow-visible'));
            }, 100);
        },
        replay() {
            document.querySelectorAll('.flow-step').forEach(el => {
                el.classList.remove('flow-visible');
            });
            setTimeout(() => {
                document.querySelectorAll('.flow-step').forEach((el, i) => {
                    setTimeout(() => el.classList.add('flow-visible'), i * 120);
                });
            }, 50);
        }
    }
}
</script>
