<?php 
    // Plugin.
    echo js_asset('plugin/tinymce/tinymce.min.js');
    echo js_asset('plugin/tinymce/jquery.tinymce.min.js');
    echo js_asset('plugin/moment/moment.min.js');
    echo js_asset('plugin/bootstrap/bootstrap-datetimepicker.min.js');

    // Shared Java Script.
    $this->load->view('template/sharedJs_v');
    // My Java Script.
    echo js_asset('cms/cmsEditor.js');
    ?>