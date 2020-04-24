require('../vendor/kevinpapst/adminlte-bundle/Resources/assets/admin-lte');
require('admin-lte/dist/css/AdminLTE.min.css');
require('./css/app.scss');
require('./css/bootstrap-editable.css');
require('sweetalert2/dist/sweetalert2.css');
require('../public/style.css');
require('@fortawesome/fontawesome-free');
require('bootstrap-sweetalert/dist/sweetalert.css');
global.$.AdminLTE={};
global.$.AdminLTE.options={};
require('admin-lte/dist/js/adminlte.min');
require('./js/bootstrap-editable.min');
require('../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js');
require('bootstrap-sweetalert/dist/sweetalert');
const routes = require('../public/js/fos_js_routes.json');
Routing.setRoutingData(routes);
// ------ for charts ------
const Chart = require('chart.js/dist/Chart.min');
global.Chart = Chart;

$(document).ready(
    function ()
    {
        $('[data-datepickerenable="on"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: "YYYY-MM-DD",
                firstDay: 1
            }
        });
        $('jqtable_contrat').hide();
    }
);
