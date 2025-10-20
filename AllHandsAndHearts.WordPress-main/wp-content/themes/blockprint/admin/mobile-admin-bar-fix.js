(global => {
    'use strict';
    const adminbar = document.getElementById('wpadminbar');

    if (adminbar) {
        adminbar.querySelectorAll('a[aria-haspopup="true"]').forEach(item => {
            item.addEventListener('click', () => {
                if (global.matchMedia('(max-width:600px)').matches) {
                    location = item.href;
                }
            });
        });
    }
})(window);