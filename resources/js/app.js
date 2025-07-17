import './bootstrap';
import './configs';

import Alpine from 'alpinejs';
import Toastify from 'toastify-js';

window.Alpine = Alpine;

window.showSuccess = function(message) {
    Toastify({
        text: message,
        duration: 3000,
        gravity: 'top',
        position: 'center',
        style: {
            background: "rgba(28, 33, 55, 0.9)",
        },
        stopOnFocus: true,
        close: true,
        onClick: function(){},
        className: "error-toast",
    }).showToast();
};

window.showError = function(message) {
    Toastify({
        text: message,
        duration: 3000,
        gravity: 'top',
        position: 'right',
        style: {
            background: "rgba(199, 0, 57, 0.9)",
        },
        stopOnFocus: true,
        close: true,
        onClick: function(){},
        className: "error-toast",
    }).showToast();
};

Alpine.start();
