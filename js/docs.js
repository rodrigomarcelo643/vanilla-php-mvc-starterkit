function copyCode(btn) {
    const block = btn.closest('.relative').querySelector('.bg-zinc-950');
    const lines = block.innerText.trim().split('\n');
    const code = lines
        .filter(l => { const t = l.trim(); return t && !t.startsWith('#') && !t.startsWith('//'); })
        .join('\n');
    navigator.clipboard.writeText(code).then(() => {
        btn.querySelector('.icon-copy').classList.add('hidden');
        btn.querySelector('.icon-check').classList.remove('hidden');
        btn.querySelector('.label-copy').classList.add('hidden');
        btn.querySelector('.label-check').classList.remove('hidden');
        setTimeout(() => {
            btn.querySelector('.icon-copy').classList.remove('hidden');
            btn.querySelector('.icon-check').classList.add('hidden');
            btn.querySelector('.label-copy').classList.remove('hidden');
            btn.querySelector('.label-check').classList.add('hidden');
        }, 2000);
    });
}
