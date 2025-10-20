(function() {
    const twoColImg = document.querySelector('.js-two-col-img');
    if (!twoColImg) return;

    const wrapper = twoColImg.querySelector('.js-two-col-img__wrapper');

    wrapper.style.transition = 'transform 0.5s ease-out';
    wrapper.style.willChange = 'transform';

    function handleScroll() {
        const rect = twoColImg.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        const maxTranslateX = wrapper.scrollWidth - twoColImg.clientWidth;
        const startScroll = windowHeight - rect.height;
        const endScroll = 0;
        const totalScrollDistance = startScroll - endScroll;
        let progress = (startScroll - rect.top) / totalScrollDistance;
        progress = Math.min(Math.max(progress, 0), 1);
        const translateX = progress * maxTranslateX;
        wrapper.style.transform = `translateX(-${translateX}px)`;
    }

    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resize', handleScroll);
    handleScroll();

})();