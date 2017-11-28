<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MapPlace_m extends CI_Model
{
// Constructor.
	public function __construct() {
        parent::__construct();
    }
// End Constructor.


// Public Method.
    // ---------------------------------------------------- Get  To view -----------------------------------------
    public function GetDataForViewDisplay($arrId=null, $sqlWhere=null) {
		$criteria ='';
		$this->load->model('dataclass/geoLocation_d');
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/weightUnit_d');
    	// Prepare Criteria.
		$this->load->model('helper_m');
		if($arrId != null){
			$criteria = $this->helper_m->CreateCriteriaIn("m." . $this->colId, $arrId, $criteria, ' AND ');
		}
		// Prepare Where.
		$criteria = $this->helper_m->CreateSqlWhere($criteria, $sqlWhere);

		// Create sql string.
		$sqlStr = "SELECT m." . $this->geoLocation_d->colId . ", c." . $this->iccCard_d->colProjectName
					. ", m." . $this->geoLocation_d->colLatitude . ", m." . $this->geoLocation_d->colLongitude
					. ", CONCAT(c." . $this->iccCard_d->colGarbageWeight
					. ",' ',wu." . $this->weightUnit_d->colName . ") AS totalGarbageQty"
					. ", m." . $this->geoLocation_d->colImagePath

					. " FROM " . $this->geoLocation_d->tableName . " AS m"
					. " LEFT JOIN " . $this->iccCard_d->tableName . " AS c"
					. " ON m." . $this->geoLocation_d->colFkIccCard
					. "=c." . $this->iccCard_d->colId
					. " AND c." . $this->iccCard_d->colActive . "=1"

					. " LEFT JOIN " . $this->weightUnit_d->tableName . " AS wu"
					. " ON c." . $this->iccCard_d->colFkWeightUnit
					. "=wu." . $this->weightUnit_d->colId

					. " WHERE m." . $this->geoLocation_d->colActive . "=1"
					. $criteria;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }
// End Public Method.
}
