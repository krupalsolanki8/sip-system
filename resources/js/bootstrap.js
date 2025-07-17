import axios from "axios";
import jQuery from "jquery";
import Toastify from "toastify-js";
import moment from 'moment';

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.jQuery = jQuery;
window.$ = jQuery;
window.Toastify = Toastify;

window.moment = moment;

import "datatables.net-bs4";
