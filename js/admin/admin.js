/**
 * Admin — admin panel utilities
 */
const Admin = {
    saveSettings(btn) {
        const original = btn.textContent;
        btn.disabled = true;
        btn.textContent = 'Saving…';

        // Simulate async save
        setTimeout(() => {
            btn.disabled = false;
            btn.textContent = original;
            App.toast('Settings saved successfully!', 'success');
        }, 800);
    },
};
