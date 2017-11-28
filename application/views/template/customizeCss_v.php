<?php 
    // Core css of this web.
    echo css_asset('customize/site-frontend.css');
    echo css_asset('customize/frontend.css');
    echo css_asset('customize/menubar.css');
    echo css_asset('customize/breadcrumb.css');
    echo css_asset('customize/img-hover.css');
    echo css_asset('customize/bootstrap.min.my.css');		// for input-form.
    echo css_asset('customize/theme.css');
    //echo (($this->uri->segment(1) == "publicRelations") ? css_asset('customize/theme1.css') : '');
?>