<?php 
    // Plugin.
    echo my_js_asset("plugins/bootstrap-daterangepicker-master/js/moment.min.js");
    echo my_js_asset("plugins/bootstrap-daterangepicker-master/js/daterangepicker.js");
    echo my_js_asset("plugins/fusioncharts/js/fusioncharts.js");
    echo my_js_asset("plugins/fusioncharts/js/themes/fusioncharts.theme.fint.js");
    // Shared Java Script.
    $this->load->view('template/sharedJs_v');
    // My Java Script.
    echo $map['js'];
    echo js_asset('report/dashboardReport.js');
?>