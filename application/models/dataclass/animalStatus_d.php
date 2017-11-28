<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnimalStatus_d extends CI_Model {
	// Property.
    public $tableName = "animal_status";
	public $colId = "id";
	public $colName = "Name";


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
