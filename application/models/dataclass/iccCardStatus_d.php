<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IccCardStatus_d extends CI_Model {
	// Property.
    public $tableName = "icc_card_status";
	public $colId = "id";
	public $colName = "Name";


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
