// Reset form fields to match query
const handleUpdateFormFromQueryParams = form => {
    const params = new URLSearchParams(window.location.search);

    // If no query params, clear all form fields
    if ([...params].length === 0) {
        for (const elem of form.elements) {
            elem.parentNode.dataset.active = false;

            if (elem.tagName === 'INPUT' || elem.tagName === 'SELECT' || elem.tagName === 'TEXTAREA') {
                if (elem.type === 'checkbox' || elem.type === 'radio') {
                    elem.checked = false;
                } else {
                    elem.value = '';
                }
            }
        }

        return;
    }

    // Otherwise, set form fields from query params
    for (const elem of form.elements) {
        const name = elem.name;
        if (!name) continue;

        const value = params.get(name);
        if (value === null) {
            // If the field was not present in the query, clear it
            if (elem.type === 'checkbox' || elem.type === 'radio') {
                elem.checked = false;
            } else {
                elem.value = '';
            }

            continue;
        }

        if (elem.type === 'checkbox') {
            const checked = value.includes(elem.value);
            elem.checked = checked;
            elem.parentNode.dataset.active = checked;
        } else if (elem.type === 'radio') {
            if (elem.value === value) {
                elem.checked = true;
            }
        } else {
            elem.value = value;
            elem.parentNode.dataset.active = value !== '';
        }
    }
};

// posts list
document.querySelectorAll('.js-posts-list').forEach((list, index) => {
    const query = list.querySelector('.js-posts-list__query');
    const filters = list.querySelector('.js-filters');

    const handleFetch = url => {
        fetch(url)
            .then(res => res.text())
            .then(res => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(res, 'text/html');
                query.innerHTML = doc.querySelectorAll('.js-posts-list')[index].querySelector('.js-posts-list__query').innerHTML;
                query.hidden = false;
                list.scrollIntoView();
            });
    };

    const handleSubmit = () => {
        const formData = new FormData(filters);
        const params = new URLSearchParams(formData).toString();
        let url = location.pathname;
        url = url.replace(/\/page\/\d+\/?$/, '');
        url = `${url}?${params}`;
        
        history.pushState(null, '', url);
        handleFetch(url);
    };

    filters?.addEventListener('submit', e => {
        e.preventDefault();
        handleSubmit();
    });

    query.addEventListener('click', e => {
        if (e.target.closest('.js-posts-list__pagination') !== null && e.target.nodeName === 'A') {
            e.preventDefault();
            const url = e.target.href;
            history.pushState(null, '', url);
            handleFetch(url);
        }
    });

    window.addEventListener('popstate', () => {
        handleFetch(location.href);

        if (filters) {
            handleUpdateFormFromQueryParams(filters);
        }
    });
});