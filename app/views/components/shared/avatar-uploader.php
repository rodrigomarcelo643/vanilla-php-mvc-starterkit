<?php
// Required: $user array with 'name' and 'avatar' keys
$initials  = strtoupper(substr($user['name'] ?? 'U', 0, 1));
$avatarUrl = $user['avatar'] ?? null;
?>

<div id="avatar-uploader" class="flex flex-col items-center">

    <!-- Circle — hover reveals overlay + expands dropzone below -->
    <div id="avatar-wrap" class="relative cursor-pointer"
         onmouseenter="AvatarUI.show()"
         onmouseleave="AvatarUI.hide()"
         onclick="document.getElementById('avatar-file-input').click()">

        <!-- Avatar circle -->
        <div class="w-24 h-24 rounded-full ring-2 ring-zinc-200 ring-offset-2 overflow-hidden bg-zinc-100 flex items-center justify-center transition-all duration-200"
             id="avatar-ring">
            <?php if ($avatarUrl): ?>
                <img id="avatar-img" src="<?= htmlspecialchars($avatarUrl) ?>" alt="Avatar" class="w-full h-full object-cover">
                <span id="avatar-initials" class="text-3xl font-bold text-zinc-500 hidden"><?= $initials ?></span>
            <?php else: ?>
                <img id="avatar-img" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                <span id="avatar-initials" class="text-3xl font-bold text-zinc-500"><?= $initials ?></span>
            <?php endif; ?>
        </div>

        <!-- Camera overlay — shown on hover -->
        <div id="avatar-overlay"
             class="absolute inset-0 rounded-full bg-black/50 opacity-0 transition-opacity duration-200 flex flex-col items-center justify-center gap-1 pointer-events-none">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-white text-[10px] font-semibold tracking-wide uppercase">Change</span>
        </div>
    </div>

    <!-- Dropzone — hidden by default, revealed on hover via avatar.js -->
    <div id="avatar-dropzone"
         class="overflow-hidden transition-all duration-300 ease-in-out w-full"
         style="max-height:0; opacity:0;"
         onmouseenter="AvatarUI.show()"
         onmouseleave="AvatarUI.hide()">
        <div class="pt-3">
            <div id="dz-inner"
                 class="border-2 border-dashed border-zinc-200 rounded-xl p-4 text-center cursor-pointer transition-colors duration-200 hover:border-zinc-400 hover:bg-zinc-50"
                 onclick="document.getElementById('avatar-file-input').click()">
                <div id="dz-idle">
                    <svg class="w-6 h-6 text-zinc-300 mx-auto mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                    </svg>
                    <p class="text-xs font-medium text-zinc-600">Drag & drop or <span class="text-zinc-900 underline underline-offset-2">browse</span></p>
                    <p class="text-[11px] text-zinc-400 mt-0.5">JPG, PNG, WEBP, GIF · max 2 MB</p>
                </div>
                <div id="dz-over" class="hidden">
                    <svg class="w-6 h-6 text-zinc-500 mx-auto mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                    </svg>
                    <p class="text-xs font-medium text-zinc-700">Drop to upload</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden file input -->
    <input type="file" id="avatar-file-input" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">

    <!-- Progress bar -->
    <div id="avatar-progress-wrap" class="hidden w-full mt-3 bg-zinc-100 rounded-full h-1.5 overflow-hidden">
        <div id="avatar-progress-bar" class="h-full bg-zinc-900 rounded-full transition-all duration-300" style="width:0%"></div>
    </div>

    <!-- Status message -->
    <div id="avatar-status" class="hidden w-full mt-2 px-3 py-2.5 rounded-lg text-sm text-center"></div>

</div>
