document.querySelectorAll('.js-program-history-list').forEach((list, index) => {
    const filters = list.querySelectorAll('.js-program-history-list__filter');
    const query = list.querySelector('.js-program-history-list__query');

    if (!query) return;

    const handleFetch = async (url) => {
        try {
            const response = await fetch(url);
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newQuery = doc.querySelectorAll('.js-program-history-list')[index]?.querySelector('.js-program-history-list__query');

            if (newQuery) {
                query.innerHTML = newQuery.innerHTML;
            }
        } catch (error) {
            console.error('Fetch failed:', error);
        }
    };

    filters.forEach(filter => {
        filter.addEventListener('change', (e) => {
            const params = new URLSearchParams(window.location.search);
            params.set('programHistorySortBy', e.target.value);
            handleFetch(`${window.location.pathname}?${params.toString()}`);
        });
    });
});