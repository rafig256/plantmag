import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';

document.addEventListener('DOMContentLoaded', () => {

    new Swiper('.test-swiper', {

        modules: [Navigation],

        direction: 'rtl',

        slidesPerView: 4,

        spaceBetween: 20,

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },

        breakpoints: {

            0: {
                slidesPerView: 1,
            },

            640: {
                slidesPerView: 2,
            },

            1024: {
                slidesPerView: 4,
            }

        }

    });

});