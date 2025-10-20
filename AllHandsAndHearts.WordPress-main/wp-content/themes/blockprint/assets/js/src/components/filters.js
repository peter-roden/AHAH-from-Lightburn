export default () => {
    // Helper to set the custom CSS property for height
    const setContentHeightProp = (elem, height) => {
        elem.style.setProperty('--height', height);
    };

    document.querySelectorAll('.js-filters__date').forEach(filter => {
        const button = filter.querySelector('button');
        const buttonLabel = button.querySelector('span');
        const input = filter.querySelector('input');

        // fallback to type date if month is not supported
        input.type = input.type === 'month' ? 'month' : 'date';

        button.addEventListener('click', () => {
           input.focus();
            if (typeof input.showPicker === 'function') {
                input.showPicker();
            }
        });

        input.addEventListener('input', e => {
            const value = e.target.value;

            if (!value) {
                buttonLabel.textContent = button.dataset.label;
                return;
            }

            // Parse as UTC-safe date using YYYY-MM or YYYY-MM-DD
            const [year, month] = value.split('-');
            const date = new Date(Date.UTC(+year, +month - 1, 1));

            const dateFormatted = new Intl.DateTimeFormat('en-US', {
                month: 'short',
                year: 'numeric',
                timeZone: 'UTC'
            }).format(date);

            buttonLabel.textContent = `${button.dataset.prefix} ${dateFormatted}`;
        });
    });

    document.querySelectorAll('.js-filters').forEach(filters => {
        const toggles = filters.querySelectorAll('.js-filters__toggle');
        const togglePanel = filters.querySelector('.js-filters__toggle-panel');
        const duration = 150;

        // Function to toggle the filter panel open/closed
        const handleToggle = () => {
            const prevState = togglePanel.dataset.state;

            togglePanel.dataset.state = 'indeterminate';
            togglePanel.ariaHidden = prevState === 'open';

            // Animate height transition
            setContentHeightProp(filters, prevState === 'open' ? 0 : `${togglePanel.children[0].clientHeight}px`);

            // After duration (if closing), set final state
            window.setTimeout(() => {
                filters.dataset.state = prevState === 'open' ? 'closed' : 'open';
                togglePanel.dataset.state = prevState === 'open' ? 'closed' : 'open';
            }, prevState === 'open' ? duration : 0);

            // Update ARIA attributes for all toggle buttons
            toggles.forEach(toggle => {
                const prevAriaExpanded = toggle.ariaExpanded;
                toggle.ariaExpanded = prevAriaExpanded === 'true' ? false : true;
            });
        };

        // Handle layout on initial load
        if (togglePanel.parentNode.clientWidth >= 896) {
            // Set height based on whether panel is open or closed
            setContentHeightProp(filters, togglePanel.dataset.state === 'open' ? `${togglePanel.children[0].clientHeight}px` : 0);

            // If the panel is marked closed, trigger the toggle logic to adjust layout
            if (togglePanel.dataset.state === 'closed') {
                handleToggle();
            }
        }

        // Responsive behavior on resize
        window.addEventListener('resize', () => {
            // Update the height to match the current open/closed state
            setContentHeightProp(filters, togglePanel.dataset.state === 'open' ? `${togglePanel.children[0].clientHeight}px` : 0);

            // If the viewport shrinks below 896px and panel is open, close it
            if (togglePanel.parentNode.clientWidth < 896 && togglePanel.dataset.state === 'open') {
                handleToggle();
            }
        });

        // Add click listeners to all toggle buttons
        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                handleToggle();
            });
        });

        filters.addEventListener('input', e => {
            const filter = e.target;
            const checkedFilters = filters.querySelectorAll('input[type=checkbox]:checked');
            const grouped = {};

            filter.parentNode.dataset.active = filter.checked ?? Boolean(filter.value);

            checkedFilters.forEach(cb => {
                // Group checked checkboxes by name
                if (!grouped[cb.name]) grouped[cb.name] = [];
                grouped[cb.name].push(cb.value);

                // Remove name to prevent checkbox values from being submitted
                cb.removeAttribute('name');
            });

            // Inject hidden inputs with combined values
            for (const [name, values] of Object.entries(grouped)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.className = 'injected';
                input.name = name;
                input.value = values.join(',');
                filters.appendChild(input);
            }

            if (filter.type !== 'search') {
                filters.requestSubmit();
            }

            // Add back name to checked inputs
            checkedFilters.forEach(checkbox => checkbox.name = checkbox.dataset.name);

            // Remove hidden inputs
            filters.querySelectorAll('input[type=hidden].injected').forEach(el => el.remove());
        });
    });
};