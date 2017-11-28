<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MyHook {
    public function __construct() {
    echo "Construct"."<br/>";

    }

    public function checkLogin() {
        if(!$this->session->userdata('id')) {
            $this->logout();
            return false;
        } else {
            return true;
        }
        echo "Check Login";
    }
}
?>