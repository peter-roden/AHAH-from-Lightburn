document.querySelectorAll('.js-before-after').forEach(slider => {
    const before = slider.querySelector('.js-before-after__before');
    const handle = slider.querySelector('.js-before-after__handle');    
    let isDragging = false;

    const slideIt = x => {
        const rect = slider.getBoundingClientRect();
        let offsetX = Math.max(0, Math.min(x - rect.left, rect.width));
        const percentage = (offsetX / rect.width) * 100;

        before.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
        handle.style.left = `${percentage}%`;
    };

    slider.addEventListener('mousedown', e => {
        isDragging = true;
        slideIt(e.clientX);
    });

    slider.addEventListener('mousemove', e => {
        if (!isDragging) return;
        slideIt(e.clientX);
    });

    slider.addEventListener('mouseup', () => isDragging = false);

    slider.addEventListener('mouseleave', () => isDragging = false);

    // Touch support
    slider.addEventListener('touchstart', e => {
        isDragging = true;
        slideIt(e.touches[0].clientX);
    });

    slider.addEventListener('touchmove', e => {
        if (!isDragging) return;
        slideIt(e.touches[0].clientX);
    });

    slider.addEventListener('touchend', () => isDragging = false);
});