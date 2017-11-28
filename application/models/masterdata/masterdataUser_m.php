<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MasterdataUser_m extends CI_Model {
// Constructor.
	public function __construct() {
        parent::__construct();
    }
// End Constructor.



// Public function.
    // ------------------------------------------------------------ Get ------------------------------------------
	// +++ To view +++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function GetDataForViewDisplay($arrId=null, $sqlWhere=null) {
		$this->load->model('dataclass/user_d');
		$this->load->model('dataclass/employee_d');

    	$criteria ='';
    	// Prepare Criteria.
		$this->load->model('helper_m');
		if($arrId != null){
			$criteria = $this->helper_m->CreateCriteriaIn('u.'.$this->user_d->colId, $arrId, $criteria, ' WHERE ');
		}
		// Prepare Where.
		$criteria = $this->helper_m->CreateSqlWhere($criteria, $sqlWhere);

		// Create sql string.
		$sqlStr = "SELECT u." . $this->user_d->colId
					. ", u." . $this->user_d->colUserId
					. ", e." . $this->employee_d->colFirstName
					. ", e." . $this->employee_d->colLastName

					. ", CASE WHEN e." . $this->employee_d->colGender
					. "=1 THEN 'Male' ELSE 'Female' END as " . $this->employee_d->colGender

					. ", CASE WHEN u." . $this->user_d->colLevel . "=1 THEN 'Admin'"
					. " WHEN u." . $this->user_d->colLevel . "=2 THEN 'Superviser/Engineer'"
					. " WHEN u." . $this->user_d->colLevel . "=3 THEN 'Staff'"
					. " ELSE 'Temporary' END as " . $this->user_d->colLevel

					. ", e." . $this->employee_d->colDepartment
					. ", e." . $this->employee_d->colWorkshop
					. ", e." . $this->employee_d->colJobTitle
					. ", u." . $this->user_d->colUserId

					. ", CASE WHEN u." . $this->user_d->colActive
					. "=1 THEN 'Active' ELSE 'Terminate' END as " . $this->user_d->colActive

	    			. " FROM " . $this->user_d->tableName . " u"
					. " LEFT JOIN " . $this->employee_d->tableName . " e ON u."
					. $this->user_d->colFkIdEmployee . "=e." . $this->employee_d->colId

   					. $criteria
   					. " ORDER BY u." . $this->user_d->colLevel.", u." . $this->user_d->colActive
					. ", u." . $this->user_d->colUserId;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

	// +++ To input ++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function GetDataForInputDisplay($id=null) {
		$this->load->model('dataclass/user_d');
		$this->load->model('dataclass/employee_d');

		// Create sql string.
		$sqlStr = "SELECT *, u." . $this->user_d->colId . " masterId"
	    			. " FROM " . $this->user_d->tableName . " u"
					. " LEFT JOIN " . $this->employee_d->tableName . " e ON u."
					. $this->user_d->colFkIdEmployee . "=e." . $this->employee_d->colId
   					. " WHERE u." . $this->user_d->colId . "=" . $id;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

	public function GetTemplateForInputDisplay() {
		$this->load->model('dataclass/user_d');
		$this->load->model('dataclass/employee_d');

		$result = [
				'masterId'							=> 0,
				$this->user_d->colUserId			=> '',
				$this->user_d->colPassword			=> '',
				$this->user_d->colEmail				=> '',
				$this->user_d->colFkIdEmployee		=> 0,
				$this->user_d->colLevel				=> 3,
				$this->user_d->colActive			=> 1,

				$this->employee_d->colFirstName		=> '',
				$this->employee_d->colLastName		=> '',
				$this->employee_d->colJobTitle		=> '',
				$this->employee_d->colDepartment	=> '',
				$this->employee_d->colWorkshop		=> '',
				$this->employee_d->colGender		=> 0,
				$this->employee_d->colAge			=> 0,
				$this->employee_d->colIdCardNumber	=> '',
				$this->employee_d->colStatus		=> 1,
		];

    	return $result;
    }

	public function GetDataForComboBox() {
		return null;
	}


    // ----------------------------------------------------------- Save ------------------------------------------
    public function Save($id=null, $dsData) {
		$dsUser = $this->PrepareDataUserTable($dsData);
		$dsEmployee = $this->PrepareDataEmployeeTable($dsData);

		$tableNameUser = $this->user_d->tableName;
		$tableNameEmployee = $this->employee_d->tableName;

		$this->load->model('db_m');
		// Check custom duplication.
		$this->db_m->tableName = $tableNameUser;
		$rChkDuplication = [
			$this->user_d->colUserId => $dsData[$this->user_d->colUserId],
			$this->user_d->colId . " !=" => ( ($id == null) ? 0 : $id)
		];
		if($rChkDuplication != null) { if( $this->db_m->Find($rChkDuplication) ) { return false; } }
		// End Check custom duplication.

		$result = $this->db_m->SaveMasterDetail($id, $dsUser, $tableNameUser
				, $this->user_d->colFkIdEmployee, $dsEmployee, $tableNameEmployee);

		return $result;
    }
// Public function.



// Private function.
	private function PrepareDataUserTable($dsData) {
		$this->load->model('dataclass/user_d');

    	$dsSave = [
				$this->user_d->colUserId		=> $dsData[$this->user_d->colUserId],
				$this->user_d->colPassword		=> $dsData[$this->user_d->colPassword],
				$this->user_d->colEmail			=> $dsData[$this->user_d->colEmail],
				$this->user_d->colFkIdEmployee	=> $dsData[$this->user_d->colFkIdEmployee],
				$this->user_d->colLevel			=> $dsData[$this->user_d->colLevel],
				$this->user_d->colActive		=> $dsData[$this->user_d->colActive],
		];

		return $dsSave;
	}

	private function PrepareDataEmployeeTable($dsData) {
		$this->load->model('dataclass/employee_d');

		if($dsData[$this->user_d->colLevel] > 2) {
			$dsSave = [
					$this->employee_d->colFirstName			=> $dsData[$this->employee_d->colFirstName],
					$this->employee_d->colLastName			=> $dsData[$this->employee_d->colLastName],
					$this->employee_d->colGender 			=> $dsData[$this->employee_d->colGender],
					$this->employee_d->colAge 				=> $dsData[$this->employee_d->colAge],
					$this->employee_d->colIdCardNumber		=> $dsData[$this->employee_d->colIdCardNumber],
					$this->employee_d->colStatus 			=> 1,
			];
		} else {
			$dsSave = [
					$this->employee_d->colFirstName			=> $dsData[$this->employee_d->colFirstName],
					$this->employee_d->colLastName			=> $dsData[$this->employee_d->colLastName],
					$this->employee_d->colJobTitle			=> $dsData[$this->employee_d->colJobTitle],
					$this->employee_d->colDepartment		=> $dsData[$this->employee_d->colDepartment],
					$this->employee_d->colWorkshop 			=> $dsData[$this->employee_d->colWorkshop],
					$this->employee_d->colGender 			=> $dsData[$this->employee_d->colGender],
					$this->employee_d->colAge 				=> $dsData[$this->employee_d->colAge],
					$this->employee_d->colIdCardNumber		=> $dsData[$this->employee_d->colIdCardNumber],
					$this->employee_d->colStatus 			=> 1,
			];
		}

		return $dsSave;
	}
// End Private function.
}
