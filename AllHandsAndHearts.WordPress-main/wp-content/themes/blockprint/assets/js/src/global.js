import filters from './components/filters';
import header from './components/header';
import mobileNav from './components/mobile-nav';
import modal from './components/modal';
import share from './components/share';
import statCards from './components/stat-cards';
import swiper from './components/swiper';
import videos from './components/videos';

import setScrollbarWidth from './utilities/set-scrollbar-width';

// components
filters();
header();
mobileNav();
modal();
share();
statCards();
swiper();
videos();

// utilities
setScrollbarWidth();