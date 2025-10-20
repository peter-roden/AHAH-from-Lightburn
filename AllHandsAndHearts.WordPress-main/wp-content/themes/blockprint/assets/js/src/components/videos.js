export default () => {
    // lazy load videos
    const lazyVideos = document.querySelectorAll('video[data-src]');

    const lazyVideosObserver = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const video = entry.target;
                const { src } = video.dataset;

                if (src) {
                    video.src = src;
                    video.load();
                    video.removeAttribute('data-src');
                }

                obs.unobserve(video);
            }
        });
    });

    lazyVideos.forEach(video => lazyVideosObserver.observe(video));

    // video controls
    const videoContainers = document.querySelectorAll('.js-video-container');

    videoContainers.forEach(videoContainer => {
        const video = videoContainer.querySelector('.js-video');
        const playBtn = videoContainer.querySelector('.js-video-play');
        const pauseBtn = videoContainer.querySelector('.js-video-pause');
        const videoModalBtn = videoContainer.querySelector('.js-video-modal-btn');

        if (playBtn) {
            playBtn.addEventListener('click', () => {
                video.play();
                playBtn.dataset.state = 'hidden';
                pauseBtn.dataset.state = 'visible';
            });
        }

        if (pauseBtn) {
            pauseBtn.addEventListener('click', () => {
                video.pause();
                pauseBtn.dataset.state = 'hidden';
                playBtn.dataset.state = 'visible';
            });
        }

        if (videoModalBtn) {
            const modalVideo = document.querySelector('.js-modal-video');    
            videoModalBtn.addEventListener('click', () => {
                if (!video.paused) {
                    pauseBtn.click();
                };

                if (modalVideo) {
                    modalVideo.src = video.src;
                    modalVideo.play();
                }
            });
        }
    });
};