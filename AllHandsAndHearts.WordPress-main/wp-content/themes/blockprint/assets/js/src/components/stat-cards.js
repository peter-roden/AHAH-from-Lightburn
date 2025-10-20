export default () => {
    document.querySelectorAll('.js-stat-card').forEach(card => {
        const overlay = card.querySelector('.js-stat-card__overlay');
        const overlayToggle = card.querySelector('.js-stat-card__overlay-toggle');

        overlayToggle.setAttribute('aria-controls', overlay.id);

        card.addEventListener('click', () => {
            const isOpen = card.classList.toggle('is-open');
            overlayToggle.classList.toggle('is-active', isOpen);
            overlayToggle.setAttribute('aria-expanded', isOpen);
            overlay.setAttribute('aria-hidden', !isOpen);
        });

        overlay.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', e => {
                e.stopPropagation();
            });
        });
    });
};