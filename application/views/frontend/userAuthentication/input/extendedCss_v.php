<?php 
    // Plugin.
    echo css_asset('jquery.multiselect.css');
    echo css_asset('jquery.multiselect.filter.css');
    // Shared Css.
    $this->load->view('template/sharedCss_v');
    // My Css.
    echo css_asset('masterdata/stylesheet.css');
?>