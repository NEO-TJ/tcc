<?php 
    // Plugin.
    echo css_asset('plugin/bootstrap/bootstrap-datetimepicker.min.css');
    echo css_asset('plugin/prettify.css');

    // Shared Css.
    $this->load->view('template/sharedCss_v');
    // My Css.
    echo css_asset('iccCard/stylesheet.css');
?>