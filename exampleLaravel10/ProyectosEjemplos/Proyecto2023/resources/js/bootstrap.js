import lodash from 'lodash';
window._ = lodash;

import 'bootstrap';

import {Tooltip,Modal} from 'bootstrap';
window.Modal = Modal;

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl)
})

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

import {v4 as uuid} from 'uuid';
window.uuid = uuid;

import IMask from 'imask';
window.imask=IMask;

import Chart from 'chart.js/auto';
window.Chart = Chart;

import TomSelect from 'tom-select';
window.TomSelect = TomSelect;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import tinymce from 'tinymce';
window.tinyMCE = tinymce;

import BigNumber from 'bignumber.js';
window.BigNumber = BigNumber;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import moment from 'moment';
window.moment = moment;
import Utils from "moment";
window.Utils = Utils;

import {DateRangePicker} from './vendor/datetimerange-picker';
window.DateRangePicker=DateRangePicker;






// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
