import modal from '../utilities/modal';

const modals = () => {
    document.querySelectorAll('.js-modal').forEach(modalElem => {
        const { id, dataset } = modalElem;
        const showOnPageLoad = dataset.showOnPageLoad === 'true';

        if (id) {
            const modalTriggers = document.querySelectorAll(`[href="#${id}"]`);

            modalTriggers.forEach(modalTrigger => {
                modalTrigger.addEventListener('click', e => {
                    e.preventDefault();
                    modal({ target: modalElem });
                });
            });

            if (showOnPageLoad) {
                const openDelay = dataset.openDelay ? +dataset.openDelay : 0;
                const cookieExpiresDays = dataset.cookieExpiresDays ? +dataset.cookieExpiresDays : 0;
                const setCookieOnClose = cookieExpiresDays > 0;
                const cookieName = `disable_modal_${id}`;
                const date = new Date();
                const cookieExpires = new Date(date.setDate(date.getDate() + cookieExpiresDays));
                const cookiePath = global.location.pathname;
                const cookieExists = document.cookie.includes(`${cookieName}=true`);
                const videoChild = modalElem.querySelector('video');
                
                if (!cookieExists) {
                    global.addEventListener('load', () => {
                        global.setTimeout(() => {
                            modal({
                                target: modalElem,
                                onClose: () => {
                                    if (setCookieOnClose) {
                                        document.cookie = `${cookieName}=true;expires=${cookieExpires.toUTCString()};path=${cookiePath}`;
                                    }
                                }
                            });
                        }, openDelay);
                    });
                }
            }
        }
        
    });
};

export default modals;