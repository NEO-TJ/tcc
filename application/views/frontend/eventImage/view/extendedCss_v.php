<?php 
    // Plugin.
    foreach($gallery['css_files'] as $file) {
        echo '<link type="text/css" rel="stylesheet" href="' . $file . '" /><p>';
    }
    foreach($gallery['js_files'] as $file) {
        echo '<script src="' . $file . '"></script><p>';
    }

    // Shared Css.
    $this->load->view('template/sharedCss_v');
    // My Css.
    echo css_asset('iccCard/stylesheet.css') . '<p>';
?>