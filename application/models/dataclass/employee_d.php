<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_d extends CI_Model {
	// Property.
	public $tableName = "employee";
	public $colId = "id";
	public $colFirstName = "First_Name";
	public $colLastName = "Last_Name";
	public $colJobTitle = "Job_Title";
	public $colDepartment = "Department";
	public $colWorkshop = "Workshop";
	public $colGender = "Gender";
	public $colAge = "Age";
	public $colIdCardNumber = "ID_Card_Number";
	public $colStatus = "Status";


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
?>	
