<?php
// Required: $user array, $headingInfo string, $headingPassword string (optional)
$headingInfo     = $headingInfo     ?? 'Account Information';
$headingPassword = $headingPassword ?? 'Change Password';
?>

<!-- ── Profile Info Card ──────────────────────────────────── -->
<div class="bg-white border border-zinc-200 rounded-xl shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100">
        <h2 class="text-sm font-semibold text-zinc-900"><?= $headingInfo ?></h2>
        <button id="profile-edit-btn" type="button"
            class="inline-flex items-center gap-1.5 h-7 px-3 text-xs font-medium border border-zinc-200 rounded-md text-zinc-600 hover:bg-zinc-50 hover:border-zinc-300 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-1.414.586H9v-2a2 2 0 01.586-1.414z"/>
            </svg>
            Edit
        </button>
    </div>

    <!-- View mode -->
    <div id="profile-view" class="divide-y divide-zinc-100">
        <?php foreach ([
            ['label' => 'Full name', 'key' => 'name'],
            ['label' => 'Email',     'key' => 'email'],
            ['label' => 'Role',      'key' => 'role',   'format' => 'ucfirst'],
            ['label' => 'Status',    'key' => 'status', 'format' => 'ucfirst'],
        ] as $f): ?>
        <div class="flex items-center px-5 py-3.5 gap-4">
            <span class="text-xs font-medium text-zinc-400 w-28 shrink-0"><?= $f['label'] ?></span>
            <span class="text-sm text-zinc-900" data-profile-key="<?= $f['key'] ?>">
                <?php
                $val = $user[$f['key']] ?? '—';
                echo htmlspecialchars(isset($f['format']) ? ucfirst($val) : $val);
                ?>
            </span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Edit mode -->
    <form id="profile-edit-form" class="hidden px-5 py-4 space-y-4">
        <div id="profile-alert" class="hidden px-3.5 py-3 rounded-lg text-sm"></div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-zinc-500">Full name</label>
                <input type="text" name="name" id="profile-name"
                    value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                    class="w-full h-9 px-3 text-sm border border-zinc-300 rounded-lg bg-white text-zinc-900
                           focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition"
                    required>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-zinc-500">Email address</label>
                <input type="email" name="email" id="profile-email"
                    value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                    class="w-full h-9 px-3 text-sm border border-zinc-300 rounded-lg bg-white text-zinc-900
                           focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition"
                    required>
            </div>
        </div>
        <div class="flex items-center gap-2 pt-1">
            <button type="submit" id="profile-save-btn"
                class="inline-flex items-center gap-1.5 h-8 px-4 text-xs font-medium bg-zinc-900 text-white rounded-lg hover:bg-zinc-700 transition-colors disabled:opacity-50">
                <span id="profile-save-text">Save changes</span>
                <svg id="profile-save-spinner" class="hidden w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
            </button>
            <button type="button" id="profile-cancel-btn"
                class="inline-flex items-center h-8 px-4 text-xs font-medium border border-zinc-200 rounded-lg text-zinc-600 hover:bg-zinc-50 transition-colors">
                Cancel
            </button>
        </div>
    </form>
</div>

<!-- ── Change Password Card ───────────────────────────────── -->
<div class="bg-white border border-zinc-200 rounded-xl shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-zinc-100">
        <h2 class="text-sm font-semibold text-zinc-900"><?= $headingPassword ?></h2>
        <button id="pw-toggle-btn" type="button"
            class="inline-flex items-center gap-1.5 h-7 px-3 text-xs font-medium border border-zinc-200 rounded-md text-zinc-600 hover:bg-zinc-50 hover:border-zinc-300 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
            Change
        </button>
    </div>

    <div id="pw-hint" class="px-5 py-3.5">
        <p class="text-sm text-zinc-400">••••••••••••</p>
    </div>

    <form id="pw-form" class="hidden px-5 py-4 space-y-4">
        <div id="pw-alert" class="hidden px-3.5 py-3 rounded-lg text-sm"></div>
        <div class="space-y-3">
            <?php foreach ([
                ['id' => 'pw-current', 'name' => 'current_password', 'label' => 'Current password'],
                ['id' => 'pw-new',     'name' => 'new_password',     'label' => 'New password'],
                ['id' => 'pw-confirm', 'name' => 'confirm_password', 'label' => 'Confirm new password'],
            ] as $f): ?>
            <div class="space-y-1.5">
                <label class="block text-xs font-medium text-zinc-500"><?= $f['label'] ?></label>
                <div class="relative">
                    <input type="password" name="<?= $f['name'] ?>" id="<?= $f['id'] ?>"
                        class="w-full h-9 px-3 pr-9 text-sm border border-zinc-300 rounded-lg bg-white text-zinc-900
                               focus:outline-none focus:ring-2 focus:ring-zinc-900 focus:border-transparent transition"
                        placeholder="••••••••" required>
                    <button type="button" onclick="Auth.togglePassword('<?= $f['id'] ?>', this)"
                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Strength meter -->
        <div>
            <div class="flex gap-1 mb-1">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                <div id="pw-str-<?= $i ?>" class="h-1 flex-1 rounded-full bg-zinc-200 transition-colors duration-300"></div>
                <?php endfor; ?>
            </div>
            <p id="pw-str-label" class="text-xs text-zinc-400"></p>
        </div>

        <div class="flex items-center gap-2 pt-1">
            <button type="submit" id="pw-save-btn"
                class="inline-flex items-center gap-1.5 h-8 px-4 text-xs font-medium bg-zinc-900 text-white rounded-lg hover:bg-zinc-700 transition-colors disabled:opacity-50">
                <span id="pw-save-text">Update password</span>
                <svg id="pw-save-spinner" class="hidden w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
            </button>
            <button type="button" id="pw-cancel-btn"
                class="inline-flex items-center h-8 px-4 text-xs font-medium border border-zinc-200 rounded-lg text-zinc-600 hover:bg-zinc-50 transition-colors">
                Cancel
            </button>
        </div>
    </form>
</div>
