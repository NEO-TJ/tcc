<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MasterdataGarbageType_m extends CI_Model {
// Constructor.
	public function __construct() {
        parent::__construct();

		// Global var.
		$this->load->model("dataclass/garbageType_d", "oMaster");
    }
// End Constructor.



// Public function.
    // ------------------------------------------------------------ Get ------------------------------------------
	// ___________________________________________________ Zipper Tape Color Code ________________________________
	// +++ To view +++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function GetDataForViewDisplay($arrId=null, $sqlWhere=null) {
    	$criteria ='';
    	// Prepare Criteria.
		$this->load->model('helper_m');
		if($arrId != null){
			$criteria = $this->helper_m->CreateCriteriaIn("d." . $this->colId, $arrId, $criteria, ' WHERE ');
		}
		// Prepare Where.
		$criteria = $this->helper_m->CreateSqlWhere($criteria, $sqlWhere);

		// Create sql string.
		$sqlStr = "SELECT * FROM " . $this->oMaster->tableName
					. $criteria
   					. " ORDER BY " . $this->oMaster->colPriority;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

	// +++ To input ++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function GetDataForInputDisplay($id=null) {
		// Create sql string.
		$sqlStr = "SELECT * FROM " . $this->oMaster->tableName
   					." WHERE " . $this->oMaster->colId . "=" . $id;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

		return $result;
    }

    public function GetTemplateForInputDisplay() {
		$result = [
				$this->oMaster->colId		=> 0,
				$this->oMaster->colPriority	=> 0,
				$this->oMaster->colName		=> '',
		];

    	return $result;
    }

	public function GetDataForComboBox() {
		return null;
	}


    // ----------------------------------------------------------- Save ------------------------------------------
    public function Save($id=null, $data) {
		$this->load->model('db_m');
		$this->db_m->tableName = $this->oMaster->tableName;
		// Check custom duplication.
		$rChkDuplication = [
			$this->oMaster->colName => $data[$this->oMaster->colName],
			$this->oMaster->colId . " !=" => ( ($id == null) ? 0 : $id)
		];
		$this->db_m->rChkDuplication = $rChkDuplication;
		// End Check custom duplication.

		$result = $this->db_m->Save($id, $data);
		$this->db_m->rChkDuplication = null;
		
		return $result;
    }
// End Public function.



// Private function.
    // ---------------------------------------------------- Get DB to combobox -----------------------------------
    // ^^^^******^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Unit table ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^****
    private function GetDsGarbageType($id=0) {
		$this->load->model("db_m");

		$this->db_m->tableName = $this->oMaster->tableName;
		$dataSet = $this->db_m->GetRowById($id, null);
    
    	return $dataSet;
    }
// End Private function.
}
