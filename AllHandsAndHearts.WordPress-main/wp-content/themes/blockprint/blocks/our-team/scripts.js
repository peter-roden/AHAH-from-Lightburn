
const containers = document.querySelectorAll('.js-our-team');

containers.forEach((container) => {
    const cardTriggers = container.querySelectorAll('.js-our-team__trigger');
    const slideout = container.querySelector('.js-our-team__slideout');
    const close = container.querySelectorAll('.js-our-team__close');
    let content = container.querySelector('.js-our-team__content');

    const handleCardTriggerClick = (e) => {
        e.preventDefault();
        const id = e.currentTarget.dataset.id;
        const member = team[id];

        if (slideout) {
            if (slideout.dataset.state === 'closed') {
                slideout.dataset.state = 'open';
            } else {
                slideout.dataset.state = 'closed';
                setTimeout(() => {
                    if (content) {
                        content.innerHTML = '';
                    }
                }, 250);
            }
        }

        handleAddContent(member);
        console.log("Member id:", id);
        console.log("Member clicked:", member);
    };

    const handleClose = (e) => {
        e.preventDefault();
        if (slideout) {
            slideout.dataset.state = 'closed';
        }
        if (content) {
            setTimeout(() => {
                content.innerHTML = '';
            }, 250);
        }
    };

    const handleAddContent = (member) => {
        if (content) {
            content.innerHTML += `
                <div class="flex @xl:items-center gap-6 @xl:gap-4 mb-6 flex-col @xl:flex-row">
                    <div class="flex-shrink-1">
                        <div class="@xl:max-w-[369px] @xl:max-h-[369px] aspect-square">
                            ${member.image ? member.image : ''}
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-h4 font-bold mb-4 @xl:mb-2">${member.name}</h3>
                        <p class="text-xl mb-0">${member.job_title}</p>
                        <p class="text-xl">${member.addtl_titles}</p>
                    </div>
                </div>
            `;

            if (member.bio) {
                content.innerHTML += `<div>${member.bio}</div>`;
            }

            if (member.media) {
                let mediaHTML = '<div class="flex flex-col gap-y-4 mt-6">';

                member.media.forEach((media) => {
                    if (media.acf_fc_layout === 'video') {
                        mediaHTML += `<div class="[&_iframe]:w-full">${media.embed}</div>`;
                    } else if (media.acf_fc_layout === 'image') {
                        mediaHTML += `
                            <img src="${media.image.url}" alt="${media.image.alt}" class="aspect-square @xl:aspect-video object-cover w-full">
                        `;
                    }
                });

                mediaHTML += '</div>';
                content.innerHTML += mediaHTML;
            }

        }
    };

    cardTriggers.forEach((trigger) => {
        trigger.addEventListener('click', handleCardTriggerClick);
    });

    close.forEach((closeButton) => {
        closeButton.addEventListener('click', handleClose);
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && slideout && slideout.dataset.state === 'open') {
            handleClose(e);
        }
    });
});