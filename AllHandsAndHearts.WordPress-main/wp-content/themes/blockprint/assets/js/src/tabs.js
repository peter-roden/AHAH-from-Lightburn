import AccordionTabs from 'a11y-accordion-tabs';

// JS is only deferred on front-end - admin needs to wait for page load
// if the document is still loading, wait for the full window 'load' event;
// otherwise, if the DOM is already parsed, use 'DOMContentLoaded' for faster response
const loadEvent = document.readyState === 'loading' ? 'load' : 'DOMContentLoaded';

window.addEventListener(loadEvent, () => {
    if (document.querySelector('.js-tabs')) {
        document.querySelectorAll('.js-tabs').forEach(tabs => {
            const tabsList = tabs.querySelector('.js-tabs-list');
            const tabsPanels = tabs.querySelectorAll('.js-tabs-panel');
            const tabsDropdown = tabs.querySelector('.js-tabs-dropdown');

            // build tab triggers dynamically
            if (tabsList.children.length === 0) {
                tabsPanels.forEach(panel => {
                    const {tabName} = panel.dataset;
                    const panelId = panel.id;
                    const triggerId = panel.getAttribute('aria-labelledby');
                    const trigger = document.createElement('a');

                    trigger.role = 'tab';
                    trigger.setAttribute('aria-controls', panelId);
                    trigger.classList.add('js-tabs-trigger');
                    trigger.id = triggerId;
                    trigger.href = `#${panelId}`;
                    trigger.innerHTML = tabName;

                    tabsList.appendChild(trigger);

                    if (tabsDropdown) {
                        const option = document.createElement('option');
                        option.value = `#${panelId}`;
                        option.textContent = tabName;
                        tabsDropdown.appendChild(option);
                    }
                });

                // init tabs
                new AccordionTabs(tabs);
            }

            if (tabsDropdown) {
                tabsDropdown.addEventListener('change', e => {
                    const targetTrigger = tabs.querySelector(`.js-tabs-trigger[href="${e.target.value}"]`);
                    if (targetTrigger) targetTrigger.click();
                });

                tabs.querySelectorAll('.js-tabs-trigger').forEach(trigger => {
                    trigger.addEventListener('click', () => {
                        tabsDropdown.value = trigger.getAttribute('href');
                    });
                });
            }
        });

        // update hash
        document.querySelectorAll('.js-tabs[data-update-hash="true"] .js-tabs-trigger').forEach(trigger => {
            trigger.addEventListener('click', () => {
                window.history.pushState('', '', `#${trigger.getAttribute('aria-controls')}`);
            });
        });

        if (window.location.hash) {
            const targetTrigger = document.querySelector(`.js-tabs[data-update-hash="true"] .js-tabs-trigger[href="${window.location.hash}"]`);

            if (targetTrigger) {
                targetTrigger.click();
                targetTrigger.blur();
            }
        }
    }
});