<?php 
    // Plugin.

    // Shared Java Script.
    $this->load->view('template/sharedJs_v');
    
    // My Java Script.
    echo js_asset('eventImage/eventImage.js');
?>