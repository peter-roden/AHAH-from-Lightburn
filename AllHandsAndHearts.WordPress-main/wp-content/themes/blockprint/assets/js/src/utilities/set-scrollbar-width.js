// calculate scrollbar width and set the value in a css var
export default () => {
    ['load', 'resize'].forEach(event => {
        global.addEventListener(event, () => {
            const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
            document.documentElement.style.setProperty('--scrollbar-width', `${scrollbarWidth}px`);
        });
    });
};