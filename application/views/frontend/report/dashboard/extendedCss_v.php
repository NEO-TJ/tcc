<?php 
    // Plugin.
    echo my_css_asset("plugins/bootstrap-daterangepicker-master/css/daterangepicker.css");
    // Shared Css.
    $this->load->view('template/sharedCss_v');
    // My Css.
    echo css_asset("report/style.css");
?>