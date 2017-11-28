<?php 
    // Plugin.
    echo my_js_asset("plugins/fusioncharts/js/fusioncharts.js");
    echo my_js_asset("plugins/fusioncharts/js/themes/fusioncharts.theme.fint.js");
    // Shared Java Script.
    $this->load->view('template/sharedJs_v');
    // My Java Script.
    echo js_asset('report/detailReport.js');
?>