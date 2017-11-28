<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MasterdataCommonName_m extends CI_Model
{
// Property.
	public $tableName = "Garbage_Type";
	
    private $colId = "id";
    private $colName = "Name";
// End Property.



// Constructor.
	public function __construct() {
        parent::__construct();
    }
// End Constructor.



// End Public function.
    // ------------------------------------------------------------ Get ------------------------------------------
	// __________________________________________________________ Only Name ______________________________________
	// +++ To view +++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function GetDataForViewDisplay($arrId=null, $sqlWhere=null) {
    	$criteria ='';
    	// Prepare Criteria.
		$this->load->model('helper_m');
		if($arrId != null){
			$criteria = $this->helper_m->CreateCriteriaIn($this->colId, $arrId, $criteria, ' WHERE ');
		}
		// Prepare Where.
		$criteria = $this->helper_m->CreateSqlWhere($criteria, $sqlWhere);

		// Create sql string.
		$sqlStr = "SELECT * FROM " . $this->tableName
   					.$criteria
   					." ORDER BY ".$this->colName;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

	// +++ To input ++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function GetDataForInputDisplay($id=null) {
		// Create sql string.
		$sqlStr = "SELECT * FROM " . $this->tableName
   					." WHERE " . $this->colId . "=" . $id;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

    public function GetTemplateForInputDisplay() {
		$result = [
				$this->colId		=> 0,
				$this->colName		=> '',
		];

    	return $result;
    }

	public function GetDataForComboBox() {
		return null;
	}



    // ----------------------------------------------------------- Save ------------------------------------------
    public function Save($id=null, $data) {
		$this->load->model('db_m');
		$this->db_m->tableName = $this->tableName;
		// Check custom duplication.
		$rChkDuplication = [
			$this->colName => $data[$this->colName],
			$this->colId . " !=" => ( ($id == null) ? 0 : $id)
		];
		$this->db_m->rChkDuplication = $rChkDuplication;
		// End Check custom duplication.

		$result = $this->db_m->Save($id, $data);
		$this->db_m->rChkDuplication = null;
		
		return $result;
    }
// End Public function.
}
