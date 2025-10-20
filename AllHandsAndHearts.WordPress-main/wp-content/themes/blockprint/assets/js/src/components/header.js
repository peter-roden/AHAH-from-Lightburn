export default () => {
    const header = document.querySelector('.js-header');
    const headerSearchOverlay = document.querySelector('.js-header__search-overlay');    
    const headerSearchOverlayToggle = document.querySelector('.js-header__search-overlay-toggle');
    const headerSearchOverlayClose = document.querySelector('.js-header__search-overlay-close');
    const adminBarHeight = document.getElementById('wpadminbar')?.clientHeight || 0;

    if (!header) return;

    header.querySelectorAll('a[href="#"]').forEach(anchor => {
        anchor.addEventListener('click', e => {
            e.preventDefault();
        });
    });

    const setHeaderHeightCSSVar = () => {
        document.documentElement.style.setProperty('--header-height', `${header.clientHeight}px`);
    };

    setHeaderHeightCSSVar();
    window.addEventListener('resize', setHeaderHeightCSSVar);

    if (header.classList.contains('js-header--sticky') || header.classList.contains('js-header--sticky-scroll-up')) {
        header.classList.add('top-[var(--wp-admin--admin-bar--height,0px)]', 'z-999', 'transition-transform', 'duration-250');
    }

    if (header.classList.contains('js-header--sticky-scroll-up')) {
        let lastScrollTop = window.scrollY;
        let ticking = false;

        const onScroll = () => {
            const currentScrollTop = window.scrollY;
            const scrollDelta = currentScrollTop - lastScrollTop;
            const isSticky = header.classList.contains('sticky');

            const handleScrollTop = () => {
                header.dataset.top = true;

                if (isSticky) {
                    header.classList.remove('sticky');
                    header.classList.remove('-translate-y-full');
                    header.style.transform = '';
                }
            };

            const handleScrollUp = () => {
                if (!isSticky) {
                    header.classList.add('sticky');
                    header.classList.add('-translate-y-full');
                    header.style.transition = 'none';

                    // Force reflow before transition
                    void header.offsetWidth;

                    window.setTimeout(() => {
                        header.style.transition = '';
                        header.classList.remove('-translate-y-full');
                    });
                }
            };

            const handleScrollDown = () => {
                header.dataset.top = false;

                if (isSticky && !header.classList.contains('-translate-y-full')) {
                    header.classList.add('-translate-y-full');

                    setTimeout(() => {
                        header.classList.remove('sticky');
                    }, 250);
                }
            };

            if (currentScrollTop <= 10) {
                handleScrollTop();
            } else if (scrollDelta < -20) {
                handleScrollUp();
            } else if (scrollDelta > 20) {
                handleScrollDown();
            }

            lastScrollTop = currentScrollTop;
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(onScroll);
                ticking = true;
            }
        });
    } else if (header.classList.contains('js-header--sticky')) {
        header.classList.add('sticky');

        window.addEventListener('scroll', () => {
            const { top } = document.body.getBoundingClientRect();
            if (Math.round(top) >= adminBarHeight) {
                header.dataset.top = true;
            } else {
                header.dataset.top = false;
            }
        });
    }

    window.addEventListener('DOMContentLoaded', () => {
        const { top } = document.body.getBoundingClientRect();
        
        if (Math.round(top) >= adminBarHeight) {
            header.dataset.top = true;
        } else {
            header.dataset.top = false;
        }
    });

    if (!headerSearchOverlay || !headerSearchOverlayToggle || !headerSearchOverlayClose ) return;

    const toggleSearchOverlay = () => {
        const isOpen = headerSearchOverlayToggle.dataset.state === 'open';
        const newState = isOpen ? 'closed' : 'open';

        headerSearchOverlay.setAttribute('aria-hidden', isOpen);
        headerSearchOverlay.dataset.state = newState;
        headerSearchOverlayToggle.setAttribute('aria-expanded', !isOpen);
        headerSearchOverlayToggle.dataset.state = newState;
    };

    headerSearchOverlayToggle.addEventListener('click', toggleSearchOverlay);
    headerSearchOverlayClose.addEventListener('click', toggleSearchOverlay);

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && headerSearchOverlayToggle.dataset.state === 'open') {
            toggleSearchOverlay();
        }
    });
};