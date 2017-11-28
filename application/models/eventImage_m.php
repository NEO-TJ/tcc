<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventImage_m extends CI_Model {
    // Constructor.
	public function __construct() {
        parent::__construct();
    }


	// *********************************************************** Method ****************************************
	// ----------------------------------------------------- Get For Combobox ------------------------------------
	public function GetIdAndNameIccCard($id=null) {
		$this->load->model("dataclass/iccCard_d");
		$this->load->model("db_m");

		$sqlStr = "SELECT " . $this->iccCard_d->colId
				. ", " .$this->iccCard_d->colProjectName
				. " FROM " . $this->iccCard_d->tableName
				. ( (is_null($id) || ($id==0)) ? "" : " WHERE " . $this->iccCard_d->colId . "=" . $id)
				. " ORDER BY " . $this->iccCard_d->colProjectName;
		// Execute sql.
		$this->load->model('db_m');
		$dataSet = $this->db_m->GetRow($sqlStr);
    
    	return $dataSet;
	}
}