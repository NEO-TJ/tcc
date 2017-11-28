<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_m extends CI_Model {
// Constructor.
	public function __construct() {
        parent::__construct();
    }
// End Constructor.




// Public function.
///////////////////////////////////////////////// Dashboard report
	public function GetDashboardReportData($rankingLimit=10, $strDateStart=null, $strDateEnd=null
											, $provinceCode=null, $iccCardId=null) {
		$sqlStrWhere = $this->CreateSqlWhere($strDateStart, $strDateEnd, $provinceCode, $iccCardId);

		$result["dsMarineDebrisSinglePlace"] = $this->GetMarineDebrisSinglePlace($sqlStrWhere, $rankingLimit);
		$result["dsMarineDebrisEventMapPlace"] = $this->GetMarineDebrisEventMapPlace($sqlStrWhere);
		$rResult = ( ($provinceCode === NULL) 
				? $this->GetMarineDebrisProvinceGroup($sqlStrWhere, $rankingLimit) 
				: $this->GetMarineDebrisEventGroup($sqlStrWhere, $rankingLimit));
		$result["dsMarineDebrisGroupingPlace"] = $rResult["dataset"];
		$result["placeCount"] = $rResult["placeCount"];
		$result["rankingLimit"] = $rResult["rankingLimit"];
	
		return $result;
	}
	private function GetMarineDebrisEventGroup($sqlStrWhere, $rankingLimit=10) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/garbageTransaction_d');
		$this->load->model('dataclass/garbage_d');
		$this->load->model('db_m');

		$placeCount = -1;
		if($rankingLimit != 10) {
		// Query and calc count record.
			$sqlStr = "SELECT c." . $this->iccCard_d->colProjectName
					. ", COUNT(c." . $this->iccCard_d->colId . ") AS rankingLimit"
					. $this->CreateSqlJoinTableGroupPlace()
					. $sqlStrWhere
					. " GROUP BY c." . $this->iccCard_d->colId
					. " ORDER BY rankingLimit DESC";
			// Execute sql.
			$dsBoundary = $this->db_m->GetRow($sqlStr);
			$placeCount = count($dsBoundary);
			$rankingLimit = ( ($placeCount > 0) ? $dsBoundary[0]["rankingLimit"] : $rankingLimit );
		// End Query and calc count record.
		}
		$result["placeCount"] = $placeCount;
		$result["rankingLimit"] = $rankingLimit;


		///////////////////////////////
		// Query record.
		$sqlStr = "SELECT c." . $this->iccCard_d->colProjectName . " AS PlaceName"
				. ", g." . $this->garbage_d->colName
				. ", SUM(gt." . $this->garbageTransaction_d->colGarbageQty . ") AS sumQty"
				. $this->CreateSqlJoinTableGroupPlace()
				. $sqlStrWhere
				. " GROUP BY c." . $this->iccCard_d->colId
				. ", gt." . $this->garbageTransaction_d->colFkGarbage
				. " ORDER BY c." . $this->iccCard_d->colProjectName . ", sumQty desc";
		// Execute sql.
		$this->load->model('db_m');
		$result["dataset"] = $this->db_m->GetRow($sqlStr);

		return $result;
	}

	private function GetMarineDebrisProvinceGroup($sqlStrWhere, $rankingLimit=10) {
		$this->load->model('dataclass/garbageTransaction_d');
		$this->load->model('dataclass/garbage_d');
		$this->load->model('dataclass/province_d');
		$this->load->model('db_m');

		$placeCount = -1;
		if($rankingLimit != 10) {
		// Query and calc count record.
			$sqlStr = "SELECT p." . $this->province_d->colProvinceName
					. ", COUNT(p." . $this->province_d->colProvinceCode . ") AS rankingLimit"
					. $this->CreateSqlJoinTableGroupPlace()
					. $sqlStrWhere
					. " GROUP BY p." . $this->province_d->colProvinceCode
					. " ORDER BY rankingLimit DESC";
			// Execute sql.
			$dsBoundary = $this->db_m->GetRow($sqlStr);
			$placeCount = count($dsBoundary);
			$rankingLimit = ( ($placeCount > 0) ? $dsBoundary[0]["rankingLimit"] : $rankingLimit );
		// End Query and calc count record.
		}
		$result["placeCount"] = $placeCount;
		$result["rankingLimit"] = $rankingLimit;

		///////////////////////////////
		// Query record.
		$sqlStr = "SELECT p." . $this->province_d->colProvinceName . " AS PlaceName"
				. ", g." . $this->garbage_d->colName
				. ", SUM(gt." . $this->garbageTransaction_d->colGarbageQty . ") AS sumQty"
				. $this->CreateSqlJoinTableGroupPlace()
				. $sqlStrWhere
				. " GROUP BY p." . $this->province_d->colProvinceCode
				. ", gt." . $this->garbageTransaction_d->colFkGarbage
				. " ORDER BY p." . $this->province_d->colProvinceName . ", sumQty desc";
		// Execute sql.
		$this->load->model('db_m');
		$result["dataset"] = $this->db_m->GetRow($sqlStr);

		return $result;
	}



	private function GetMarineDebrisSinglePlace($sqlStrWhere, $rankingLimit=10) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/garbageTransaction_d');
		$this->load->model('dataclass/garbage_d');

		// Create sql string.
		$sqlStr = "SELECT g." . $this->garbage_d->colName . " AS label"
				. ", SUM(gt." . $this->garbageTransaction_d->colGarbageQty . ") AS value"

				. " FROM " . $this->garbageTransaction_d->tableName . " AS gt"

				. " LEFT JOIN " . $this->garbage_d->tableName . " AS g"
				. " ON gt." . $this->garbageTransaction_d->colFkGarbage
				. "=g." . $this->garbage_d->colId

				. " LEFT JOIN " . $this->iccCard_d->tableName . " AS c"
				. " ON gt." . $this->garbageTransaction_d->colFkIccCard
				. "=c." . $this->iccCard_d->colId
				
				. $sqlStrWhere

				. " GROUP BY gt." . $this->garbageTransaction_d->colFkGarbage
				. " ORDER BY value desc"
				. " LIMIT " . $rankingLimit;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

		return $result;
	}

	private function GetMarineDebrisEventMapPlace($sqlStrWhere) {
		$this->load->model('dataclass/geoLocation_d');
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/garbageTransaction_d');

		// Create sql string.
		$sqlStr = "SELECT c." . $this->iccCard_d->colProjectName
					. ", m." . $this->geoLocation_d->colLatitude
					. ", m." . $this->geoLocation_d->colLongitude
					. ", SUM(gt." . $this->garbageTransaction_d->colGarbageQty . ") AS sumQty"

					. " FROM " . $this->geoLocation_d->tableName . " AS m"
					. " LEFT JOIN " . $this->iccCard_d->tableName . " AS c"
					. " ON m." . $this->geoLocation_d->colFkIccCard
					. "=c." . $this->iccCard_d->colId
					. " AND c." . $this->iccCard_d->colActive . "=1"

					. " LEFT JOIN " . $this->garbageTransaction_d->tableName . " AS gt"
					. " ON c." . $this->iccCard_d->colId
					. "=gt." . $this->garbageTransaction_d->colFkIccCard

					. $sqlStrWhere
					. " AND m." . $this->geoLocation_d->colActive . "=1"

					. " GROUP BY c." . $this->iccCard_d->colId;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
	}
///////////////////////////////////////////////// End Dashboard report



// ---------------------------------------------- Tools
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Province Table ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	public function GetDataForComboBox() {
		$result['dsProvince'] = $this->GetDsProvince();
		$result['dsProject'] = $this->GetDsProject();
		
		return $result;
	}
    private function GetDsProvince($id=null) {
		$this->load->model("dataclass/province_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->province_d->tableName;
		$this->db_m->sequenceColumn = $this->province_d->colProvinceName;
		$dataSet = $this->db_m->GetRowById(null, null);
    
    	return $dataSet;
	}
	// Public function.
    public function GetDsProject($provinceCode=null) {
		$this->load->model("dataclass/iccCard_d");

		// sqlQuery.
		$sqlQuery = "SELECT " . $this->iccCard_d->colId
				. ", " . $this->iccCard_d->colProjectName
				. " FROM " . $this->iccCard_d->tableName
				. " WHERE " . $this->iccCard_d->colActive . "=1"
				. ( ($provinceCode !== NULL) 
					? " AND " . $this->iccCard_d->colFkProvinceCode . "=" . $provinceCode 
					: "")
				. " ORDER BY " . $this->iccCard_d->colProjectName;
		// Execute sql.
		$this->load->model('db_m');
		$dataSet = $this->db_m->GetRow($sqlQuery);

    	return $dataSet;
    }


	// ------------------------------------------ Gen Sql
	private function CreateSqlWhere($strDateStart=null, $strDateEnd=null, $provinceCode=null, $iccCardId=null) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/garbageTransaction_d');
		$this->load->model('dataclass/garbage_d');

		// Create sql string where.
		$sqlWhere = " WHERE c." . $this->iccCard_d->colActive . "=1"
			. " AND gt." . $this->garbageTransaction_d->colActive . "=1"
			. (($provinceCode!==NULL) ? " AND c." . $this->iccCard_d->colFkProvinceCode . "=" . $provinceCode : NULL )
			. (($iccCardId!==NULL) ? " AND c." . $this->iccCard_d->colId . "=" . $iccCardId : NULL )
			. " AND c." . $this->iccCard_d->colEventDate
			. " BETWEEN '" . $strDateStart . "%' AND '" . $strDateEnd . "%'";

		return $sqlWhere;
	}
	private function CreateSqlJoinTableGroupPlace() {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/garbageTransaction_d');
		$this->load->model('dataclass/garbage_d');
		$this->load->model('dataclass/province_d');

		// Create sql string where.
		$sqlJoinTable = " FROM " . $this->garbageTransaction_d->tableName . " AS gt"		
			. " LEFT JOIN " . $this->garbage_d->tableName . " AS g"
			. " ON gt." . $this->garbageTransaction_d->colFkGarbage
			. "=g." . $this->garbage_d->colId

			. " LEFT JOIN " . $this->iccCard_d->tableName . " AS c"
			. " ON gt." . $this->garbageTransaction_d->colFkIccCard
			. "=c." . $this->iccCard_d->colId

			. " LEFT JOIN " . $this->province_d->tableName . " AS p"
			. " ON c." . $this->iccCard_d->colFkProvinceCode
			. "=p." . $this->province_d->colProvinceCode;

		return $sqlJoinTable;
	}
// End Private function.
}