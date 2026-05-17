/**
 * Ajax — lightweight fetch wrapper
 */
const Ajax = {
    /**
     * POST form data to a URL
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
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
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
