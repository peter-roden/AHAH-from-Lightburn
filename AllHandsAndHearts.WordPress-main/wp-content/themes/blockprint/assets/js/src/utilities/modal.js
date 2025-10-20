const modal = props => {
    const {
        target,
		allowClose = true,
        onOpen = () => null,
        onClose = () => null
    } = props;

    const modalElem = typeof target === 'string' ? document.querySelector(target) : target;
	const video = modalElem.querySelector('video');

    const handleOpen = () => {
		// Set ARIA attributes and apply necessary classes for modal opening animation
		modalElem.ariaModal = true;
		modalElem.setAttribute('role', 'dialog');
		modalElem.removeAttribute('aria-hidden');
		modalElem.classList.add('fade');
		modalElem.classList.remove('collapse');
		global.setTimeout(() => {
			modalElem.classList.add('show');
			onOpen();
		});
    };

    const handeClose = () => {
		// Set ARIA attributes and apply necessary classes for modal closing animation
		modalElem.setAttribute('aria-hidden', 'true');
		modalElem.removeAttribute('aria-modal');
		modalElem.removeAttribute('role');
        modalElem.classList.remove('show');

		if (video) {
			video.pause();
			video.currentTime = 0;
		}

		// Trigger the collapse animation after a short delay
		global.setTimeout(() => {
			modalElem.classList.add('collapse');
			modalElem.classList.remove('fade');
			onClose();
		}, 150);
    };

	const handleEscape = e => {
		// Close the modal on Escape key press, if allowed
		if (allowClose && e.key === 'Escape') {
			handeClose();
			document.removeEventListener('keydown', handleEscape);
		}
	};

	const handleCloseElemClick = e => {
		// Close the modal on close button click, if allowed
		if (allowClose) {
			e.preventDefault();
			handeClose();
		}
	};

	// Trigger the modal opening logic
	handleOpen();

	// Attach event listeners to close buttons within the modal
	modalElem.querySelectorAll('.js-modal-close').forEach(item => {
		item.addEventListener('click', handleCloseElemClick);
	});

	// Attach event listener for Escape key press
	document.addEventListener('keydown', handleEscape);
};

export default modal;