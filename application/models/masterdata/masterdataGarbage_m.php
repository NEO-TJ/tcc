<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MasterdataGarbage_m extends CI_Model {
// Constructor.
	public function __construct() {
        parent::__construct();

		// Global var.
		$this->load->model('dataclass/garbageType_d', "oMaster");
		$this->load->model('dataclass/garbage_d', 'oDetail');
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
		$sqlStr = "SELECT d." . $this->oDetail->colId
					. ", m." . $this->oMaster->colName . " ประเภทของขยะ"
					. ", d." . $this->oDetail->colName . " ชื่อของขยะ"
					
					. " FROM " . $this->oDetail->tableName . " d"
					. " LEFT JOIN " . $this->oMaster->tableName . " m"
					. " ON d." . $this->oDetail->colFkGarbageType . "=m." . $this->oMaster->colId
   					
					. $criteria
   					. " ORDER BY m." . $this->oMaster->colName . ", d." . $this->oDetail->colName;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

	// +++ To input ++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function GetDataForInputDisplay($id=null) {
		// Create sql string.
		$sqlStr = "SELECT * FROM " . $this->oDetail->tableName
   					." WHERE " . $this->oDetail->colId . "=" . $id;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

    public function GetTemplateForInputDisplay() {
		$result = [
				$this->oDetail->colId				=> 0,
				$this->oDetail->colName				=> '',
				$this->oDetail->colFkGarbageType	=> 0,
		];

    	return $result;
    }

	public function GetDataForComboBox() {
		$result['dsGarbageType'] = $this->GetDsGarbageType();

		return $result;
	}


    // ----------------------------------------------------------- Save ------------------------------------------
    public function Save($id=null, $data) {
		$this->load->model('db_m');
		$this->db_m->tableName = $this->oDetail->tableName;
		// Check custom duplication.
		$rChkDuplication = [
			$this->oDetail->colName => $data[$this->oDetail->colName],
			$this->oDetail->colId . " !=" => ( ($id == null) ? 0 : $id)
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
