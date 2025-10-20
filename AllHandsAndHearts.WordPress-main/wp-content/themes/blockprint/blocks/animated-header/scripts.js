(() => {
    const header = document.querySelector('.js-animated-header');

    if (header) {
        const interval = parseInt(header.dataset.interval, 10) || 2000; // Fallback if interval is not set
        console.log('interval', interval);
        const items = header.querySelectorAll('.js-animated-header__text');
        let index = 0;

        (function showNext() {
            items.forEach(item => item.classList.replace('block', 'hidden'));
            items[index].classList.replace('hidden', 'block');

            index = (index + 1) % items.length;

            setTimeout(showNext, interval);
        })();
    }
})();