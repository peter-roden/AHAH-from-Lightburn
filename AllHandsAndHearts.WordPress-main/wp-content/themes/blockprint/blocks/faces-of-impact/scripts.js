const cards = document.querySelectorAll('.js-faces-of-impact-card');

if (cards.length) {
    cards.forEach(card => {
        const content = card.querySelector('.js-faces-of-impact-card__content');
        const toggle = card.querySelector('.js-faces-of-impact-card__content-toggle');
        if (content && toggle) {
            toggle.addEventListener('click', () => {
                content.classList.toggle('is-open');
                toggle.classList.toggle('is-active');

                if (card.classList.contains('is-open')) {
                    content.setAttribute('aria-hidden', 'false');
                } else {
                    content.setAttribute('aria-hidden', 'true');
                }

                if (toggle.classList.contains('is-open')) {
                    toggle.setAttribute('aria-expanded', 'true');
                } else {
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });

            window.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && content.classList.contains('is-open')) {
                    content.classList.remove('is-open');
                    toggle.classList.remove('is-active');
                    content.setAttribute('aria-hidden', 'true');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });

            window.addEventListener('click', (event) => {
                if (!card.contains(event.target) && content.classList.contains('is-open')) {
                    content.classList.remove('is-open');
                    toggle.classList.remove('is-active');
                    content.setAttribute('aria-hidden', 'true');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });
}