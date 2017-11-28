<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ContactInfo_d extends CI_Model {
	// Property.
    public $tableName = "contact_info";
	public $colId = "id";
    public $colName = "Name";
    public $colEmail = "Email";
    public $colFkIccCard = "FK_ICC_Card";
    public $colActive = "Active";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";
    

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
