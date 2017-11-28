<?php 
    // Plugin.
    echo my_js_asset("plugins/bootstrap-daterangepicker-master/js/moment.min.js");
    echo my_js_asset("plugins/bootstrap-daterangepicker-master/js/daterangepicker.js");
    // Shared Java Script.
    $this->load->view('template/sharedJs_v');
    // My Java Script.
    echo js_asset('iccCard/iccCardList.js');
    echo js_asset('iccCard/iccCardfilterRelation.js');
    echo js_asset('iccCard/iccCardStatus.js');
?>