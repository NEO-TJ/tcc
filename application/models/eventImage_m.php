<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventImage_m extends CI_Model {
    // Constructor.
	public function __construct() {
        parent::__construct();
    }


// ******************************************************************************************** Method
	// ---------------------------------------------------------------------------------------- Get Dataset Image info.
	public function GetDsEventImage($id=null, $fkIccCardId=null) {
		$this->load->model("dataclass/eventImage_d");
		$this->load->model("db_m");

		$sqlStr = "SELECT " . $this->eventImage_d->colId
				. ", " .$this->eventImage_d->colImageUrl
				. ", " .$this->eventImage_d->colPriority
				. " FROM " . $this->eventImage_d->tableName . " e"
				. " WHERE e." . $this->eventImage_d->colActive . "=1"
				. ( (($id !== NULL) || ($id > 0)) 
					? " AND " . $this->eventImage_d->colId . "=" . $id : "")
				. ( (($fkIccCardId !== NULL) || ($fkIccCardId > 0)) 
					? " AND " . $this->eventImage_d->colFkIccCard . "=" . $fkIccCardId : "")
				. " ORDER BY " . $this->eventImage_d->colPriority;
		// Execute sql.
		$this->load->model('db_m');
		$dataSet = $this->db_m->GetRow($sqlStr);

    	return $dataSet;
	}
	// ---------------------------------------------------------------------------------------- Get Image info.
	public function GetDsIccCard($id=null) {
		$this->load->model("dataclass/iccCard_d");
		$this->load->model("dataclass/province_d");
		$this->load->model("dataclass/amphur_d");
		$this->load->model("db_m");

		$sqlStr = "SELECT c." . $this->iccCard_d->colId
				. ", c." .$this->iccCard_d->colProjectName
				. ", c." .$this->iccCard_d->colEventDate
				. ", p." .$this->province_d->colProvinceName
				. ", a." .$this->amphur_d->colAmphurName

				. " FROM " . $this->iccCard_d->tableName . " c"

				. " LEFT JOIN " . $this->province_d->tableName . " AS p"
				. " ON c." . $this->iccCard_d->colFkProvinceCode
				. "=p." . $this->province_d->colProvinceCode

				. " LEFT JOIN " . $this->amphur_d->tableName . " AS a"
				. " ON c." . $this->iccCard_d->colFkAmphurCode
				. "=a." . $this->amphur_d->colAmphurCode
				
				. " WHERE c." . $this->iccCard_d->colActive . "=1"
				. ( (($id !== NULL) || ($id > 0)) 
					? " AND " . $this->iccCard_d->colId . "=" . $id : "");
		// Execute sql.
		$this->load->model('db_m');
		$dataSet = $this->db_m->GetRow($sqlStr);

    	return $dataSet;
	}

	// ---------------------------------------------------------------------------------------- Get For Combobox
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
	// ---------------------------------------------------------------------------------------- End Get For Combobox
// ******************************************************************************************** End Method
}