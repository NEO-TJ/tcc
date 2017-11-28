<?php 
    // Plugin.
    echo js_asset('jquery.multiselect.js');
    echo js_asset('jquery.multiselect.filter.js');
    // Shared Java Script.
    $this->load->view('template/sharedJs_v');
    // My Java Script.
	echo js_asset('userAuthentication/userAuthentication.js');
?>