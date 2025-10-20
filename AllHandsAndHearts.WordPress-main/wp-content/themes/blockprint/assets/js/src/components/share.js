export default () => {
    document.querySelectorAll('.js-share').forEach(share => {
        const btn = share.querySelector('.js-share__btn');
        const popup = share.querySelector('.js-share__popup');

        const handleToggle = () => {
            const prevState = share.dataset.state;
            share.dataset.state = prevState === 'open' ? 'closed' : 'open';
            btn.ariaExpanded = prevState === 'closed';
            popup.ariaHidden = prevState === 'open';
        };

        btn.addEventListener('click', () => {
            handleToggle();
        });

        document.addEventListener('click', e => {
            if (e.target.closest('.js-share') === null && share.dataset.state === 'open') {
                handleToggle();
            }
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && share.dataset.state === 'open') {
                handleToggle();
            }
        });
    });
};