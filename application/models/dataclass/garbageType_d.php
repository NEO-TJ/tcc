<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GarbageType_d extends CI_Model {
	// Property.
    public $tableName = "garbage_type";
	public $colId = "id";
    public $colPriority = "Priority";
    public $colName = "Name";


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
