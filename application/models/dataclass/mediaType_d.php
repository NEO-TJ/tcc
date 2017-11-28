<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MediaType_d extends CI_Model {
	// Property.
    public $tableName = "media_type";
	public $colId = "id";
	public $colName = "Name";


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
