window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require('tether');

    require('angular');
    require('angular-ui-router');
    require('ngstorage');
    require('angular-ui-bootstrap');

    window.swal = require('sweetalert2');
    require('swangular');

    require('datatables.net');
    require('datatables.net-dt');
    require('angular-datatables');

    require('angular-moment');
} catch (e) {
}
