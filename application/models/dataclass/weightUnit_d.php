<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WeightUnit_d extends CI_Model {
	// Property.
	public $tableName = "weight_unit";
	public $colId = "id";
	public $colName = "Name";


    // Constructor.
    public function __construct() {
        parent::__construct();
    }
}
?>	
