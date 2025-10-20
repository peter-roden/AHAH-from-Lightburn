import Swiper from 'swiper';
import { A11y, Autoplay, Navigation, Pagination, Scrollbar, EffectFade } from 'swiper/modules';

export default () => {
    document.querySelectorAll('.js-swiper').forEach(item => {
        let options = {};
        
        if (item.dataset.options) {
            options = item.dataset.options.replace(/'/g, '"').replace(/,\s*([\]}])/g, '$1');
            options = JSON.parse(options);
        }

        options.modules = [A11y, Autoplay, Navigation, Pagination, Scrollbar, EffectFade];

        new Swiper(item, options);
    });

    // custom swiper: carousel hero
    document.querySelectorAll('.js-carousel-hero-swiper').forEach(item => {
        const paginationBtns = item.querySelectorAll('.js-carousel-hero-swiper__pagination button');
        const pauseBtn = item.querySelector('.js-carousel-hero-swiper__pause-button');
        const playBtn = item.querySelector('.js-carousel-hero-swiper__play-button');

        const autoplayDelay = 7000;
        let startTime = null;
        let elapsedBeforePause = 0;
        let animationFrameId = null;
        let isPaused = false;

        const swiper = new Swiper(item, {
            allowTouchMove: false,
            loop: true,
            autoplay: {
                delay: autoplayDelay,
            },
            speed: 800,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                bulletElement: 'button',
                clickable: true,
            },
            modules: [A11y, Autoplay, Navigation, Pagination],
            on: {
                init: swiper => {
                    startTime = performance.now();
                    resetAllPaginationProgress();
                    animateActiveButtonProgress(swiper);
                },
                slideChange: swiper => {
                    paginationBtns.forEach(btn => btn.ariaCurrent = null);
                    paginationBtns[swiper.realIndex].ariaCurrent = true;
                    item.dataset.swiperAutoplay = true;
                    startTime = performance.now();
                    elapsedBeforePause = 0;
                    resetAllPaginationProgress();
                    animateActiveButtonProgress(swiper);
                },
            },
        });

        function resetAllPaginationProgress() {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;
            document.querySelectorAll('.js-carousel-hero-swiper__pagination-button-progress-bar').forEach(bar => {
                bar.style.width = '0%';
            });
        }

        function animateActiveButtonProgress(swiper) {
            const activeIndex = swiper.realIndex;
            const activeButton = paginationBtns[activeIndex];

            if (!activeButton) return;

            const progressBar = activeButton.querySelector('.js-carousel-hero-swiper__pagination-button-progress-bar');

            if (!progressBar) return;

            function update() {
                if (isPaused) return;

                const now = performance.now();
                const elapsed = now - startTime + elapsedBeforePause;
                const progress = Math.min(elapsed / autoplayDelay, 1);

                progressBar.style.width = `${progress * 100}%`;

                if (progress < 1) {
                    animationFrameId = requestAnimationFrame(update);
                }
            }

            animationFrameId = requestAnimationFrame(update);
        }

        paginationBtns.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                item.querySelectorAll('.swiper-pagination-bullet')[index].click();
                isPaused = false;
            });
        });

        pauseBtn.addEventListener('click', () => {
            if (isPaused) return;

            isPaused = true;
            swiper.autoplay.pause();
            swiper.el.dataset.swiperAutoplay = false;

            // Save elapsed time so we can resume accurately
            elapsedBeforePause += performance.now() - startTime;
            cancelAnimationFrame(animationFrameId);
        });

        playBtn.addEventListener('click', () => {
            if (!isPaused) return;

            isPaused = false;
            swiper.autoplay.resume();
            swiper.el.dataset.swiperAutoplay = true;

            // Adjust start time based on already elapsed duration
            startTime = performance.now();
            animateActiveButtonProgress(swiper);
        });
    });
};