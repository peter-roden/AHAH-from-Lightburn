(() => {
    const filters = document.querySelector('.js-program-map .js-filters');
    const search = document.querySelector('.js-program-map .js-filters__search');
    const searchInput = search?.querySelector('.js-filters__search-input');
    const searchSuggestions = search?.querySelector('.js-filters__search-suggestions');
    const summary = document.querySelector('.js-program-summary');
    const apiKey = window.googleMapsApiKey;
    let map;
    let markers = [];
    let programs = window.programs;
    let filtersObj = {
        country: '',
        disasterType: '',
        responseType: '',
        startDate: '',
        endDate: '',
    };
    let bounds;
    const maxZoom = 5;

    const handleCloseSummary = () => {
        summary.dataset.state = 'closed';
        summary.ariaHidden = true;
    };

    summary.querySelectorAll('.js-program-summary__close').forEach(close => {
        close.addEventListener('click', handleCloseSummary);
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && summary.dataset.state === 'open') {
            handleCloseSummary();
        }
    });

    function loadGoogleMapsScript(callback) {
        if (document.getElementById('google-maps-script-js')) {
            callback();
            return;
        }

        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=geometry&callback=${callback.name}`;
        script.id = 'google-maps-script-js';
        script.async = true;
        script.defer = true;
        document.body.appendChild(script);
    }

    function clearMarkers() {
        for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }

        markers = [];
    }

    function setUpMap() {
        let { startDate, endDate } = filtersObj;
        startDate = startDate ? startDate.replaceAll('-','').slice(0,6) : '';
        endDate = endDate ? endDate.replaceAll('-','').slice(0,6) : '';

        clearMarkers();
        
        bounds = new google.maps.LatLngBounds();

        ['country', 'disasterType', 'responseType'].forEach(key => {
            if (filtersObj[key]) {
                programs = programs.filter(p => p[key].includes(filtersObj[key]));
            }
        });

        if (startDate) {
            programs = programs.filter(p => Number(p.startDateNumbers) === Number(startDate));
        }

        if (endDate) {
            programs = programs.filter(p => Number(p.endDateNumbers) === Number(endDate));
        }

        const infoWindow = new google.maps.InfoWindow({
            pixelOffset: new google.maps.Size(125,50)
        });

        programs.forEach((loc, index) => {
            const marker = new google.maps.Marker({
                position: new google.maps.LatLng(loc.lat, loc.lng),
                map,
                title: loc.title,
                icon: 'data:image/svg+xml,<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="0.5" y="0.5" width="11" height="11" rx="5.5" fill="%23b26eff"/><rect x="0.5" y="0.5" width="11" height="11" rx="5.5" stroke="white"/></svg>',
            });

            markers.push(marker);
            bounds.extend({ lat: loc.lat, lng: loc.lng });

            marker.addListener('click', () => {
                map.panTo(marker.getPosition());
            });

            ['mouseover', 'click'].forEach(event => {
                marker.addListener(event, () => {
                    infoWindow.setContent(`
                        <div class="font-manrope w-[215px] font-normal p-2 text-xs">
                            <a id="info-link" class="text-sm text-current font-semibold no-underline" href="${loc.link}">${loc.title}</a><br>
                            ${loc.startDate} ${loc.endDate ? `- ${loc.endDate}` : ''}
                        </div>
                    `);

                    infoWindow.open(map, marker);

                    google.maps.event.addListenerOnce(infoWindow, 'domready', () => {
                        document.getElementById('info-link').addEventListener('click', e => {
                            const summaryContent = summary.querySelector('.js-program-summary__content');

                            e.preventDefault();
                            summary.dataset.state = 'open';
                            summary.ariaHidden = false;
                            summaryContent.parentNode.scrollTo({ top: 0 });

                            window.setTimeout(() => infoWindow.close(), 200);

                            summaryContent.innerHTML = `
                                <div class="flex flex-col gap-y-8">
                                    <div class="relative w-full aspect-[1.8] overflow-hidden bg-purple-950">
                                        ${loc.featuredImage.url ? `<img class="size-full object-cover" src="${loc.featuredImage.url}" width="${loc.featuredImage.width}" height="${loc.featuredImage.height}" alt="${loc.featuredImage.alt}">` : ''}
                                    </div>
                                    <div class="flex flex-col @xl:flex-row gap-y-6 gap-x-8">
                                        <div class="grow">
                                            <h2 class="text-h3 mb-4">${loc.title}</h2>
                                            <ul class="list-none pl-0 opacity-70" role="presentation">
                                                <li>${loc.location}</li>
                                                <li>${loc.startDate} ${loc.endDate ? `- ${loc.endDate}` : ''}</li>
                                            </ul>
                                        </div>
                                        <div class="hidden @xl:block wp-block-buttons shrink-0">
                                            <div class="wp-block-button is-style-secondary">
                                                <a class="wp-block-button__link wp-element-button has-sm-font-size has-custom-font-size" href="${loc.link}">
                                                    Visit Program Page
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    ${loc.active && (loc.donateUrl || loc.volunteerUrl) ? `<div class="wp-block-buttons grid grid-cols-2 gap-4">
                                        ${loc.donateUrl ? `<div class="wp-block-button w-full">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.donateUrl}" target="_blank" rel="noopener noreferrer">
                                                Donate
                                            </a>
                                        </div>` : ''}
                                        ${loc.volunteerUrl ? `<div class="wp-block-button is-style-outline w-full">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.volunteerUrl}">
                                                Volunteer
                                            </a>
                                        </div>` : ''}
                                    </div>` : ''}

                                    ${!loc.active && loc.caseStudyUrl ? `<div class="wp-block-buttons grid @lg:grid-cols-2 gap-4">
                                        <div class="wp-block-button is-style-secondary w-full @xl:hidden!">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.link}">
                                                Visit Program Page
                                            </a>
                                        </div>
                                        <div class="wp-block-button is-style-outline w-full">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.caseStudyUrl}">
                                                Read Case Study
                                            </a>
                                        </div>
                                    </div>` : ''}

                                    <div class="grid @xl:grid-cols-2 gap-6">
                                        <div class="@xl:col-span-2 bg-neutral-50 p-6">
                                            <h3 class="text-h6">Summary</h3>
                                            ${loc.summary || loc.shortDescription}
                                        </div>

                                        ${loc.stats.length ? `<div class="bg-purple-950 text-white p-6 ${!loc.mediaGallery.length ? 'col-span-2' : ''}">
                                            <h3 class="text-h6 mb-3">At a Glance</h3>
                                            <ul class="flex flex-col list-none pl-0 gap-y-3 text-lg">
                                                ${loc.stats.map(stat => (
                                                    `<li>
                                                        <b class="inline-block font-futura-pt-cond text-purple-400 text-[1.75rem] leading-[1]">${stat.heading}</b>&nbsp;
                                                        ${stat.description}
                                                    </li>`
                                                )).join('')}
                                            </ul>
                                        </div>` : ''}

                                        ${loc.mediaGallery.length ? loc.mediaGallery.map((item, index) => (
                                            `<div class="bg-neutral-100 aspect-[1.8] size-full [&>*]:size-full [&>*]:object-cover ${index === 0 && loc.stats.length ? '' : '@xl:col-span-2'}">
                                                ${item.image.url ? `<img loading="lazy" src="${item.image.url}" width="${item.image.width}" height="${item.image.height}" alt="${item.image.alt}">` : ''}
                                                ${item.videoEmbed}
                                            </div>`
                                        )).join('') : ''}
                                    </div>

                                    <div class="wp-block-buttons w-full grid grid-cols-2 gap-4">
                                        ${loc.active && loc.donateUrl ? `<div class="wp-block-button w-full">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.donateUrl}" target="_blank" rel="noopener noreferrer">
                                                Donate
                                            </a>
                                        </div>` : ''}

                                        ${loc.active && loc.volunteerUrl ? `<div class="wp-block-button is-style-outline w-full">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.volunteerUrl}">
                                                Volunteer
                                            </a>
                                        </div>` : ''}

                                        <div class="wp-block-button w-full col-span-2 is-style-secondary ${!loc.active && loc.caseStudyUrl ? '@lg:col-span-1' : ''}">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.link}">
                                                Visit Program Page
                                            </a>
                                        </div>

                                        ${!loc.active && loc.caseStudyUrl ? `<div class="wp-block-button w-full is-style-outline col-span-2 @lg:col-span-1">
                                            <a class="wp-block-button__link wp-element-button w-full" href="${loc.caseStudyUrl}">
                                                Read Case Study
                                            </a>
                                        </div>` : ''}
                                    </div>
                                </div>
                            `;
                        });
                    });
                });
            });
        });

        if (markers.length) {
            if (Object.values(filtersObj).every(v => !v)) {
                if (window.innerWidth < 768) {
                    map.setCenter(new google.maps.LatLng(37.1, -95.7));
                    map.setZoom(3);
                } else {
                    map.setCenter(new google.maps.LatLng(25, 0));
                    map.setZoom(2);
                }
            } else {
                map.fitBounds(bounds);
            }
        }

        if (map.getZoom() > maxZoom) {
            map.setZoom(maxZoom);
        }

        map.addListener('click', () => {
            infoWindow.close();
        });
    }

    function initMap() {
        const mapElem = document.getElementById('map');

        const mapOptions = {
            center: new google.maps.LatLng(25, 0),
            zoom: 2,
            panControl: true,
            mapTypeControl: false,
            optimized: false,
            streetViewControl: false,
            styles: [
                {
                    'featureType': 'water',
                    'elementType': 'all',
                    'stylers': [{ 'color': '#ffffff' }]
                },
                {
                    'featureType': 'road',
                    'stylers': [{ 'visibility': 'off' }]
                },
                {
                    'featureType': 'transit',
                    'stylers': [{ 'visibility': 'off' }]
                },
                {
                    'featureType': 'administrative',
                    'stylers': [{ 'visibility': 'off' }]
                },
                {
                    'featureType': 'landscape',
                    'elementType': 'all',
                    'stylers': [{ 'color': '#120445' }]
                },
                {
                    'featureType': 'poi',
                    'stylers': [{ 'visibility': 'off' }]
                },
                {
                    'elementType': 'labels',
                    'stylers': [{ 'visibility': 'on' }]
                }
            ],
        };

        map = new google.maps.Map(mapElem, mapOptions);

        google.maps.event.addListenerOnce(map, 'idle', setUpMap);
    }

    window.initMap = initMap;

    loadGoogleMapsScript(initMap);

    filters.addEventListener('submit', e => {
        e.preventDefault();

        Object.keys(filtersObj).forEach(filter => {
            filtersObj[filter] = filters.querySelector(`[name="${filter}"]`)?.value;
        });

        programs = searchInput?.value ? window.programs.filter(p => p.title === searchInput?.value.trim()) : window.programs;

        setUpMap();
    });

    if (searchInput && searchSuggestions) {        
        searchInput.addEventListener('input', e => {
            const value = e.target.value.trim();
            searchSuggestions.innerHTML = '';

            if (value.trim() === '') {
                programs = window.programs;
                setUpMap();
            } else {
                searchSuggestions.insertAdjacentHTML('beforeend',
                    programs.filter(p => p.title.toLowerCase().includes(value.toLowerCase())).map(program => {
                        return (`
                            <button type="button" class="w-full text-left border-b p-4 cursor-pointer hover:bg-purple-100 focus:bg-purple-100">
                                ${program.title}
                            </button>
                        `);
                    }).join('')
                );
            }
        });

        searchSuggestions.addEventListener('click', e => {
            const searchText = e.target.innerText;
            searchInput.value = searchText;
            programs = window.programs.filter(p => p.title === searchText);
            searchSuggestions.innerHTML = '';
            setUpMap();
        });

        window.addEventListener('click', e => {
            if (searchSuggestions.innerHTML !== '' && e.target.closest('.js-program-map .js-filters__search') === null) {
                searchSuggestions.innerHTML = '';
                searchInput.value = '';
                programs = window.programs;
            }
        });
    }
})();