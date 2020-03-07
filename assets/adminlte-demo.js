require('../vendor/kevinpapst/adminlte-bundle/Resources/assets/admin-lte');
require('admin-lte/dist/css/AdminLTE.min.css');
require('./css/app.scss');
require('@fortawesome/fontawesome-free');
global.$.AdminLTE={};
global.$.AdminLTE.options={};
require('admin-lte/dist/js/adminlte.min');
require('../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js');
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
