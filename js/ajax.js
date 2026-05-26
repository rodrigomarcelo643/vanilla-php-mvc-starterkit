/**
 * Ajax — lightweight fetch wrapper with automatic CSRF protection
 */
const Ajax = {
    /**
     * Read the session CSRF token injected by the server via <meta name="csrf-token">
     * @returns {string}
     */
    _csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    },

    /**
     * POST form data to a URL — automatically includes X-CSRF-Token header
     * @param {string} url
     * @param {FormData|object} data
     * @returns {Promise<object>}
     */
    post(url, data) {
        const body = data instanceof FormData ? data : (() => {
            const fd = new FormData();
            Object.entries(data).forEach(([k, v]) => fd.append(k, v));
            return fd;
        })();

        return fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-Token': this._csrfToken(),
            },
            body,
        }).then(res => res.json());
    },

    /**
     * GET request
     * @param {string} url
     * @returns {Promise<object>}
     */
    get(url) {
        return fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        }).then(res => res.json());
    },
};
