/**
 * avatar.js — avatar uploader: hover reveal, drag & drop, XHR upload with progress
 */

const AvatarUI = (() => {
    const dropzone = document.getElementById('avatar-dropzone');
    const overlay  = document.getElementById('avatar-overlay');
    const ring     = document.getElementById('avatar-ring');
    let hideTimer  = null;

    function show() {
        if (!dropzone) return;
        clearTimeout(hideTimer);
        overlay.style.opacity = '1';
        ring.classList.replace('ring-zinc-200', 'ring-zinc-400');
        dropzone.style.maxHeight = '160px';
        dropzone.style.opacity   = '1';
    }

    function hide() {
        if (!dropzone) return;
        hideTimer = setTimeout(() => {
            overlay.style.opacity = '0';
            ring.classList.replace('ring-zinc-400', 'ring-zinc-200');
            dropzone.style.maxHeight = '0';
            dropzone.style.opacity   = '0';
        }, 120);
    }

    return { show, hide };
})();

function applyAvatarToAll(url) {
    document.querySelectorAll('[data-avatar-img]').forEach(el => {
        el.src = url;
        el.classList.remove('hidden');
    });
    document.querySelectorAll('[data-avatar-initials]').forEach(el => el.classList.add('hidden'));
}

(function () {
    const input    = document.getElementById('avatar-file-input');
    if (!input) return;

    const dzInner  = document.getElementById('dz-inner');
    const dzIdle   = document.getElementById('dz-idle');
    const dzOver   = document.getElementById('dz-over');
    const status   = document.getElementById('avatar-status');
    const progWrap = document.getElementById('avatar-progress-wrap');
    const progBar  = document.getElementById('avatar-progress-bar');
    const imgEl    = document.getElementById('avatar-img');
    const initials = document.getElementById('avatar-initials');
    const avatarWrap = document.getElementById('avatar-wrap');

    function showStatus(msg, type) {
        status.textContent = msg;
        status.className   = 'w-full mt-2 px-3 py-2.5 rounded-lg text-sm text-center ' +
            (type === 'error'
                ? 'bg-red-50 text-red-600 border border-red-200'
                : 'bg-green-50 text-green-700 border border-green-200');
        status.classList.remove('hidden');
    }

    function upload(file) {
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            showStatus('Image must be under 2 MB.', 'error');
            return;
        }

        // Instant local preview
        const reader = new FileReader();
        reader.onload = e => {
            imgEl.src = e.target.result;
            imgEl.classList.remove('hidden');
            if (initials) initials.classList.add('hidden');
        };
        reader.readAsDataURL(file);

        const fd = new FormData();
        fd.append('avatar', file);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', BASE_URL + '/ajax/avatar');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        progWrap.classList.remove('hidden');
        progBar.style.width = '0%';
        status.classList.add('hidden');

        xhr.upload.onprogress = e => {
            if (e.lengthComputable) {
                progBar.style.width = Math.round((e.loaded / e.total) * 100) + '%';
            }
        };

        xhr.onload = () => {
            progWrap.classList.add('hidden');
            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success) {
                    imgEl.src = res.avatar;
                    applyAvatarToAll(res.avatar);
                    showStatus('Profile picture updated!', 'success');
                } else {
                    showStatus(res.message ?? 'Upload failed.', 'error');
                }
            } catch {
                showStatus('Unexpected error. Please try again.', 'error');
            }
        };

        xhr.onerror = () => {
            progWrap.classList.add('hidden');
            showStatus('Network error. Please try again.', 'error');
        };

        xhr.send(fd);
    }

    input.addEventListener('change', () => upload(input.files[0]));

    dzInner.addEventListener('dragover', e => {
        e.preventDefault();
        dzInner.classList.add('border-zinc-500', 'bg-zinc-50');
        dzIdle.classList.add('hidden');
        dzOver.classList.remove('hidden');
    });

    dzInner.addEventListener('dragleave', () => {
        dzInner.classList.remove('border-zinc-500', 'bg-zinc-50');
        dzIdle.classList.remove('hidden');
        dzOver.classList.add('hidden');
    });

    dzInner.addEventListener('drop', e => {
        e.preventDefault();
        dzInner.classList.remove('border-zinc-500', 'bg-zinc-50');
        dzIdle.classList.remove('hidden');
        dzOver.classList.add('hidden');
        const file = e.dataTransfer.files[0];
        if (file) upload(file);
    });

    avatarWrap.addEventListener('dragover', e => { e.preventDefault(); AvatarUI.show(); });
    avatarWrap.addEventListener('drop', e => {
        e.preventDefault();
        const file = e.dataTransfer.files[0];
        if (file) upload(file);
    });
})();
