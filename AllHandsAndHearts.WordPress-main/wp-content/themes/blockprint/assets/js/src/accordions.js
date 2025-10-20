// JS is only deferred on front-end - admin needs to wait for page load
// if the document is still loading, wait for the full window 'load' event;
// otherwise, if the DOM is already parsed, use 'DOMContentLoaded' for faster response
const loadEvent = document.readyState === 'loading' ? 'load' : 'DOMContentLoaded';

window.addEventListener(loadEvent, () => {
    const duration = 150;

    // Set the --height CSS custom property on an element
    const setContentHeightProp = (elem, height) => {
        elem.style.setProperty('--height', height);
    };

    // Remove the --height CSS custom property from an element
    const removeContentHeightProp = elem => {
        elem.style.removeProperty('--height');
    };

    // Close a specific accordion
    const handleClose = accordion => {
        const trigger = accordion.querySelector('.js-accordion__trigger');
        const content = accordion.querySelector('.js-accordion__content');

        // Set current height for transition
        setContentHeightProp(content, `${content.children[0].clientHeight}px`);

        window.setTimeout(() => {
            // Collapse content
            setContentHeightProp(content, 0);
            trigger.ariaExpanded = false;
            accordion.dataset.state = 'closed';

            window.setTimeout(() => {
                // Clean up styles and mark as closed
                removeContentHeightProp(content);
                accordion.open = false;
            }, duration);
        });
    };

    // Open a specific accordion
    const handleOpen = accordion => {
        const trigger = accordion.querySelector('.js-accordion__trigger');
        const content = accordion.querySelector('.js-accordion__content');
        const accordions = accordion.closest('.js-accordions');

        // Start from height 0 for transition
        setContentHeightProp(content, 0);

        window.setTimeout(() => {
            // Expand content
            setContentHeightProp(content, `${content.children[0].clientHeight}px`);
            trigger.ariaExpanded = true;
            accordion.dataset.state = 'open';

            window.setTimeout(() => {
                // Clean up styles
                removeContentHeightProp(content);
            }, duration);
        });

        // If multi-expand is disabled, close all other accordions in the group
        if (accordions && accordions.dataset.multiExpand === 'false') {
            Array.from(accordions.querySelectorAll('.js-accordion')).filter(x => x !== accordion).forEach(accordion2 => {
                handleClose(accordion2);
            });
        }
    };

    // Initialize all accordions
    window.addEventListener('click', e => {
        if (e.target.closest('.js-accordion__trigger')) {
            const trigger = e.target.closest('.js-accordion__trigger');
            const accordion = trigger.parentNode;

            if (accordion.open) {
                e.preventDefault();
                handleClose(accordion);
            } else {
                handleOpen(accordion);
            }
        }
    });

    // If there's a hash in the URL and a matching accordion element exists, open accordion on load
    if (location.hash && document.querySelector(`.js-accordion${location.hash}`)) {
        document.querySelector(`.js-accordion${location.hash} .js-accordion__trigger`).click();
    }
});