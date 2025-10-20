export default () => {
    const nav = document.querySelector('.js-mobile-nav');
    const toggle = document.querySelector('.js-mobile-nav-toggle');

    if (!nav) return;

    const submenus = nav.querySelectorAll('.js-mobile-nav__item');

    submenus.forEach(item => {
        const toggle = item.querySelector('.js-mobile-nav-item__toggle');
        const submenu = item.querySelector('.js-mobile-nav-item__submenu');

        if (!submenu) return;

        toggle.addEventListener('click', e => {
            console.log('submenu toggle clicked');
            e.preventDefault();
            toggle.classList.toggle('is-active');

            if (toggle.classList.contains('is-active')) {
                submenu.setAttribute('aria-hidden', 'false');
                submenu.dataset.state = 'open';
                submenu.setAttribute('aria-expanded', 'true');
                toggle.dataset.state = 'open';
            } else {
                submenu.setAttribute('aria-hidden', 'true');
                submenu.dataset.state = 'closed';
                submenu.setAttribute('aria-expanded', 'false');
                toggle.dataset.state = 'closed';
            }
        });
    });

    if (!toggle) return;

    const toggleNav = () => {
        const isOpen = toggle.dataset.state === 'open';
        const newState = isOpen ? 'closed' : 'open';

        toggle.setAttribute('aria-expanded', !isOpen);
        toggle.dataset.state = newState;
        nav.setAttribute('aria-hidden', isOpen);
        nav.dataset.state = newState;

        document.body.classList.toggle(['overflow-hidden'], !isOpen);
        document.body.classList.toggle('lg:overflow-auto', !isOpen);
    };

    toggle.addEventListener('click', toggleNav);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && toggle.dataset.state === 'open') {
            toggleNav();
        }
    });
};