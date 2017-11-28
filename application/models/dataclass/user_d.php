<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_d extends CI_Model {
	// Property.
    public $tableName = "user";
	public $colId = "id";
	public $colUserId = "UserId";
	public $colPassword = "Password";
	public $colEmail = "Email";
	public $colFkIdEmployee = "FK_ID_Employee";
	public $colLevel = "Level";
	public $colActive = "Active";
	public $colCreateDate = "Create_Date";
	public $colUpdateDate = "Update_Date";


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
