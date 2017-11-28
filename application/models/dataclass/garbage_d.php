<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Garbage_d extends CI_Model {
	// Property.
    public $tableName = "garbage";
	public $colId = "id";
    public $colFkGarbageType = "FK_Garbage_Type";
    public $colName = "Name";
    

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
