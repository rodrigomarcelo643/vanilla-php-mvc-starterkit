/**
 * Skeleton — global skeleton loader
 *
 * Usage:
 *   Skeleton.show('#my-container', 'card', { count: 4 })
 *   Skeleton.show('#my-table tbody', 'table', { rows: 5, cols: 4 })
 *   Skeleton.show('#my-pagination', 'pagination', { pages: 5 })
 *   Skeleton.show('#my-select', 'select')
 *   Skeleton.hide('#my-container')
 *
 * Types: 'card' | 'table' | 'pagination' | 'select'
 */
const Skeleton = (() => {
    const ATTR = 'data-skeleton-original';

    function shimmer(cls) {
        return `skeleton-base ${cls}`;
    }

    function card() {
        return `
        <div class="sk-card">
            <div class="flex items-center gap-3">
                <div class="${shimmer('sk-icon')}"></div>
                <div class="flex-1 flex flex-col gap-2">
                    <div class="${shimmer('sk-title')}"></div>
                    <div class="${shimmer('sk-line short')}"></div>
                </div>
            </div>
            <div class="${shimmer('sk-value')}"></div>
            <div class="${shimmer('sk-line medium')}"></div>
            <div class="${shimmer('sk-line full')}"></div>
        </div>`;
    }

    function tableRows(rows, cols) {
        const widths = ['w-1/4', 'w-1/3', 'w-1/2', 'w-2/3', 'w-3/4', 'w-full'];
        return Array.from({ length: rows }, () =>
            `<tr class="sk-row">${Array.from({ length: cols }, (_, i) =>
                `<td><div class="${shimmer('sk-cell')} ${widths[i % widths.length]}"></div></td>`
            ).join('')}</tr>`
        ).join('');
    }

    function pagination(pages) {
        const btns = Array.from({ length: pages }, () =>
            `<div class="${shimmer('sk-btn')}"></div>`
        ).join('');
        return `<div class="sk-pagination">${btns}<div class="${shimmer('sk-text')}"></div></div>`;
    }

    function select() {
        return `<div class="${shimmer('sk-select')}"></div>`;
    }

    function build(type, opts = {}) {
        switch (type) {
            case 'card':
                return Array.from({ length: opts.count ?? 1 }, card).join('');
            case 'table':
                return tableRows(opts.rows ?? 5, opts.cols ?? 4);
            case 'pagination':
                return pagination(opts.pages ?? 5);
            case 'select':
                return select();
            default:
                return '';
        }
    }

    return {
        show(selector, type, opts = {}) {
            const el = typeof selector === 'string' ? document.querySelector(selector) : selector;
            if (!el) return;
            el.setAttribute(ATTR, el.innerHTML);
            el.innerHTML = build(type, opts);
        },

        hide(selector) {
            const el = typeof selector === 'string' ? document.querySelector(selector) : selector;
            if (!el || !el.hasAttribute(ATTR)) return;
            el.innerHTML = el.getAttribute(ATTR);
            el.removeAttribute(ATTR);
        },
    };
})();
