const animatedHero = document.querySelector('.js-scroll-animation-hero');

if (animatedHero) {
    const scrollContent = animatedHero.querySelector('.js-scroll-animation-hero__scroll-content');
    const background = animatedHero.querySelector('.js-scroll-animation-hero__background');
    const MAX_OPACITY = 0.65;

    const updateOpacity = () => {
        const { top, bottom, height } = scrollContent.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const visibleTop = Math.max(top, 0);
        const visibleBottom = Math.min(bottom, windowHeight);
        const visibleHeight = Math.max(visibleBottom - visibleTop, 0);
        const percentVisible = visibleHeight / height;

        background.style.opacity = top <= 0 ? MAX_OPACITY : Math.min(MAX_OPACITY, percentVisible * MAX_OPACITY);
    };

    const onEnterViewport = (entry) => {
        if (entry.isIntersecting) {
            window.addEventListener('scroll', updateOpacity, { passive: true });
            window.addEventListener('resize', updateOpacity);
        } else {
            window.removeEventListener('scroll', updateOpacity);
            window.removeEventListener('resize', updateOpacity);
        }
    };

    // Initial call
    updateOpacity();

    // Observe visibility of hero section
    const observer = new IntersectionObserver(([entry]) => onEnterViewport(entry));

    observer.observe(animatedHero);
}
