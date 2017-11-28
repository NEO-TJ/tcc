<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IccCard_m extends CI_Model {
// Constructor.
	public function __construct() {
        parent::__construct();
    }
// End Constructor.




// Public function.
// -------------------------------------------------------------------------------------------- Get
// +++ To view ++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function GetDataForViewDisplay($rFilter=null) {
		$result["dsView"] = $this->GetIccCardList($rFilter);
		$result["rIccCardStatus"] = $this->GetArrayIccCardStatus();
		//$result["dsIccCardStatus"] = $this->GetDsIccCardStatus();

		$result['dsProvince'] = $this->GetDsProvince();
		$result['dsAmphur'] = $this->GetDsAmphur();
		$result['dsGarbageType'] = $this->GetDsGarbageType();
		$result['dsProjectName'] = $this->GetDsProjectName();
		$result['dsOrg'] = $this->GetDsOrg();

		return $result;
	}
	public function GetFullIccCardList($rFilter=null) {
		$result['dsIccCardList'] = $this->GetIccCardList($rFilter);
		$result["rIccCardStatus"] = $this->GetArrayIccCardStatus();
		//$result["dsIccCardStatus"] = $this->GetDsIccCardStatus();
		$result['userAuthenLevel'] = ( ($this->session->userdata('level')) ? $this->session->userdata('level') : 0 );

		return $result;
	}
	private function GetIccCardList($rFilter=null) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/cleanupType_d');
		$this->load->model('dataclass/iccCardStatus_d');
		$this->load->model('dataclass/province_d');
		$this->load->model('dataclass/amphur_d');

    	// Prepare Filter.
		$sqlExtend = $this->CreateSqlWhereAndJoinTbl($rFilter);

		// Create sql string.
		$sqlStr = "SELECT DISTINCT(c." . $this->iccCard_d->colId .")"
				. ", ct." . $this->cleanupType_d->colName . " พื้นที่เก็บขยะ"
				. ", c." . $this->iccCard_d->colProjectName . " ชื่อโครงการ"
				. ", c." . $this->iccCard_d->colEventPlaceName . " ชื่อสถานที่ทำกิจกรรม"
				. ", a." . $this->amphur_d->colAmphurName . " อำเภอ"
				. ", p." . $this->province_d->colProvinceName . " จังหวัด"
				. ", DATE_FORMAT(c." . $this->iccCard_d->colEventDate . ",'%Y-%b-%d') วันที่ทำกิจกรรม"
				. ", c." . $this->iccCard_d->colFkIccCardStatus . " สถานะของโครงการ"

				. " FROM " . $this->iccCard_d->tableName . " AS c"

				. " LEFT JOIN " . $this->cleanupType_d->tableName . " AS ct"
				. " ON c." . $this->iccCard_d->colFkCleanupType
				. "=ct." . $this->cleanupType_d->colId

				. " LEFT JOIN " . $this->iccCardStatus_d->tableName . " AS cs"
				. " ON c." . $this->iccCard_d->colFkIccCardStatus
				. "=cs." . $this->iccCardStatus_d->colId

				. " LEFT JOIN " . $this->province_d->tableName . " AS p"
				. " ON c." . $this->iccCard_d->colFkProvinceCode
				. "=p." . $this->province_d->colProvinceCode

				. " LEFT JOIN " . $this->amphur_d->tableName . " AS a"
				. " ON c." . $this->iccCard_d->colFkAmphurCode
				. "=a." . $this->amphur_d->colAmphurCode
				
				. $sqlExtend
				
				. " ORDER BY p." . $this->province_d->colProvinceName
				. ", a." . $this->amphur_d->colAmphurName
				. ", c." . $this->iccCard_d->colEventDate
				. ", c." . $this->iccCard_d->colProjectName
				. ", ct." . $this->cleanupType_d->colName;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
	}
// +++ End To view ++++++++++++++++++++++++++++++++++++++++++++++++++

// +++ To input +++++++++++++++++++++++++++++++++++++++++++++++++++++
	// ///////////////// From Database ///////////////////////////////////
    public function GetDataForInputDisplay($id=null) {
		$result['dsIccCardMaster'] = $this->GetIccCardMasterForInputDisplay($id);
		$result['dsContactInfo'] = $this->GetIccCardContactInfoForInputDisplay($id);
		$result['dsEntangeledAnimal'] = $this->GetEntangeledAnimalForInputDisplay($id);
		$result['dsGarbageTransaction'] = $this->GetGarbageTransactionForInputDisplay($id);

		$result['dsGeoLocation'] = $this->GetIccCardGeoLocationForInputDisplay($id);

		return $result;
	}
	private function GetIccCardMasterForInputDisplay($id=null) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('helper_m');

		// Create sql string.
		$sqlStr = "SELECT c." . $this->iccCard_d->colId
					. ", c." . $this->iccCard_d->colProjectName
					. ", c." . $this->iccCard_d->colFkCleanupType
					. ", c." . $this->iccCard_d->colEventPlaceName
					. ", c." . $this->iccCard_d->colFkAmphurCode
					. ", c." . $this->iccCard_d->colFkProvinceCode
					. ", c." . $this->iccCard_d->colEventDate
					. ", c." . $this->iccCard_d->colFkOrg
					. ", c." . $this->iccCard_d->colCoordinatorName
					. ", c." . $this->iccCard_d->colVolunteerQty

					. ", c." . $this->iccCard_d->colEventTime
					. ", c." . $this->iccCard_d->colEventDistance
					. ", c." . $this->iccCard_d->colFkDistanceUnit
					. ", c." . $this->iccCard_d->colGarbageBagQty
					. ", c." . $this->iccCard_d->colGarbageWeight
					. ", c." . $this->iccCard_d->colFkWeightUnit
					. ", c." . $this->iccCard_d->colFkIccCardStatus

					. " FROM " . $this->iccCard_d->tableName . " AS c"

					. " WHERE c." . $this->iccCard_d->colActive . "=1"
					. " AND c." . $this->iccCard_d->colId . "=" . $id;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
	}
	private function GetIccCardContactInfoForInputDisplay($fkIccCardId=null) {
		$this->load->model('dataclass/contactInfo_d');
		$this->load->model('helper_m');

		// Create sql string.
		$sqlStr = "SELECT ci." . $this->contactInfo_d->colId
					. ", ci." . $this->contactInfo_d->colName
					. ", ci." . $this->contactInfo_d->colEmail
					. ", ci." . $this->contactInfo_d->colFkIccCard

					. " FROM " . $this->contactInfo_d->tableName . " AS ci"

					. " WHERE ci." . $this->contactInfo_d->colActive . "=1"
					. " AND ci." . $this->contactInfo_d->colFkIccCard . "=" . $fkIccCardId;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);
		$result = ( (count($result) < 1) ? Array($this->GetTemplateContactInfoForInputDisplay()) : $result );

    	return $result;
	}
	private function GetEntangeledAnimalForInputDisplay($fkIccCardId=null) {
		$this->load->model('dataclass/entangledAnimal_d');
		$this->load->model('helper_m');

		// Create sql string.
		$sqlStr = "SELECT ea." . $this->entangledAnimal_d->colId
					. ", ea." . $this->entangledAnimal_d->colName
					. ", ea." . $this->entangledAnimal_d->colFkAnimalStatus
					. ", ea." . $this->entangledAnimal_d->colEntangledFlag
					. ", ea." . $this->entangledAnimal_d->colEntangledDebris
					. ", ea." . $this->entangledAnimal_d->colFkIccCard

					. " FROM " . $this->entangledAnimal_d->tableName . " AS ea"

					. " WHERE ea." . $this->entangledAnimal_d->colActive . "=1"
					. " AND ea." . $this->entangledAnimal_d->colFkIccCard . "=" . $fkIccCardId;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);
		$result = ( (count($result) < 1) ? Array($this->GetTemplateEntangledAnimalForInputDisplay()) : $result );

    	return $result;
	}
	private function GetGarbageTransactionForInputDisplay($fkIccCardId=null) {
		$result = $this->GetDsGarbageIncludeTransactionAndTypeGrouping($fkIccCardId);

		return $result;
	}
	private function GetIccCardGeoLocationForInputDisplay($fkIccCardId=null) {
		$this->load->model('dataclass/geoLocation_d');
		$this->load->model('helper_m');

		// Create sql string.
		$sqlStr = "SELECT m." . $this->geoLocation_d->colId
					. ", m." . $this->geoLocation_d->colLatitude
					. ", m." . $this->geoLocation_d->colLongitude
					. ", m." . $this->geoLocation_d->colFkIccCard

					. " FROM " . $this->geoLocation_d->tableName . " AS m"

					. " WHERE m." . $this->geoLocation_d->colActive . "=1"
					. " AND m." . $this->geoLocation_d->colFkIccCard . "=" . $fkIccCardId;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);
		$result = ( (count($result) < 1) ? Array($this->GetTemplateGeoLocationForInputDisplay()) : $result );

    	return $result;
	}


	// ///////////////// From Template ///////////////////////////////////
    public function GetTemplateForInputDisplay() {
		// ICC Card - Master.
		$this->load->model('dataclass/iccCard_d');
		$result['dsIccCardMaster'][0] = [
				$this->iccCard_d->colId						=> 0,
				$this->iccCard_d->colProjectName			=> '',
				$this->iccCard_d->colFkCleanupType			=> 1,
				$this->iccCard_d->colEventPlaceName			=> '',
				$this->iccCard_d->colFkAmphurCode			=> 0,
				$this->iccCard_d->colFkProvinceCode			=> 0,
				$this->iccCard_d->colEventDate				=> 0,
				$this->iccCard_d->colFkOrg					=> 0,
				$this->iccCard_d->colCoordinatorName		=> '',
				$this->iccCard_d->colVolunteerQty			=> 0,

				$this->iccCard_d->colEventTime				=> '',
				$this->iccCard_d->colEventDistance			=> 0.25,		// Minimum.
				$this->iccCard_d->colFkDistanceUnit			=> '',
				$this->iccCard_d->colGarbageBagQty			=> 0,
				$this->iccCard_d->colGarbageWeight			=> 0,
				$this->iccCard_d->colFkWeightUnit			=> '',
				$this->iccCard_d->colFkIccCardStatus		=> 1,
    	];
		// ICC Card - Contact Info.
		$result['dsContactInfo'][0] = $this->GetTemplateContactInfoForInputDisplay();
		// ICC Card - Entangled Animal.
		$result['dsEntangeledAnimal'][0] = $this->GetTemplateEntangledAnimalForInputDisplay();
		// ICC Card - Garbage Qty.
		$result['dsGarbageTransaction'] = $this->GetDsGarbageIncludeTransactionAndTypeGrouping(0);

		// ICC Card - Geo-Location.
		$result['dsGeoLocation'][0] = $this->GetTemplateGeoLocationForInputDisplay();

    	return $result;
	}
	private function GetTemplateContactInfoForInputDisplay() {
		// ICC Card - Contact Info
		$this->load->model('dataclass/contactInfo_d');
		$result = [
			$this->contactInfo_d->colId			=> 0,
			$this->contactInfo_d->colName		=> '',
			$this->contactInfo_d->colEmail		=> '',
			$this->contactInfo_d->colFkIccCard	=> 0,
		];

		return $result;
	}
	private function GetTemplateEntangledAnimalForInputDisplay() {
		$this->load->model('dataclass/entangledAnimal_d');
		$result = [
			$this->entangledAnimal_d->colId					=> 0,
			$this->entangledAnimal_d->colName				=> '',
			$this->entangledAnimal_d->colFkAnimalStatus		=> 0,
			$this->entangledAnimal_d->colEntangledFlag		=> 0,
			$this->entangledAnimal_d->colEntangledDebris	=> '',
			$this->entangledAnimal_d->colFkIccCard			=> 0,
		];

		return $result;
	}
	private function GetTemplateGeoLocationForInputDisplay() {
		// ICC Card - Contact Info
		$this->load->model('dataclass/geoLocation_d');
		$result = [
			$this->geoLocation_d->colId			=> 0,
			$this->geoLocation_d->colLatitude	=> '',
			$this->geoLocation_d->colLongitude	=> '',
			$this->geoLocation_d->colFkIccCard	=> 0,
		];

		return $result;
	}
// +++ End To input +++++++++++++++++++++++++++++++++++++++++++++++++


// -------------------------------------------------------------------------------------------- Get For Combobox
	public function GetDataForComboBox($fkProvinceCode=null) {
		$result['dsCleanupType'] = $this->GetDsCleanupType();
		$result['dsOrg'] = $this->GetDsOrg();
		$result['dsDistanceUnit'] = $this->GetDsDistanceUnit();
		$result['dsWeightUnit'] = $this->GetDsWeightUnit();
		$result['dsAnimalStatus'] = $this->GetDsAnimalStatus();

		$result['dsProvince'] = $this->GetDsProvince();
		$result['dsAmphur'] = $this->GetDsAmphurByProvinceCode($fkProvinceCode);

		$result["rIccCardStatus"] = $this->GetArrayIccCardStatus();

		return $result;
	}

	
	public function GetPlaceByDaterange($strDateStart=null, $strDateEnd=null) {
		$sqlWhere = $this->CreateSqlWhereDaterangeFilter($strDateStart, $strDateEnd);

		$result['dsProvince'] = $this->GetDsProvinceByDaterange($sqlWhere);
		$result['dsAmphur'] = $this->GetDsAmphurByDaterange($sqlWhere);
		$result['dsProjectName'] = $this->GetDsProjectNameByDaterange($sqlWhere);

		return $result;
	}
	public function GetFullSubProvince($strDateStart=null, $strDateEnd=null, $provinceCode=null) {
		$sqlWhere = $this->CreateSqlWhereDaterangeFilter($strDateStart, $strDateEnd, $provinceCode);

		$result['dsAmphur'] = $this->GetDsAmphurByDaterange($sqlWhere);
		$result['dsProjectName'] = $this->GetDsProjectNameByDaterange($sqlWhere);

		return $result;
	}
	public function GetOnlyAmphurSubProvince($provinceCode=null) {
		$result['dsAmphur'] = $this->GetDsAmphurByProvinceCode($provinceCode);

		return $result;
	}
// -------------------------------------------------------------------------------------------- End Get For Combobox
// -------------------------------------------------------------------------------------------- End Get



// -------------------------------------------------------------------------------------------- Save
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Process Save
    public function Save($idMaster, $dsData) {
		$dsMaster = $this->PrepareDataMasterTable($dsData['dsIccCardMaster']);

		$dsDetail[0] = $this->PrepareDataContactInfoDetailTable($dsData['dsContactInfo']);
		$dsDetail[1] = $this->PrepareDataEntangledAnimalDetailTable($dsData['dsEntangledAnimal']);
		$dsDetail[2] = $this->PrepareDataGarbageTransactionDetailTable($dsData['dsGarbageTransaction'], $idMaster);
		$dsDetail[3] = $this->PrepareDataGeoLocationDetailTable($dsData['dsIccCardMaster']);

		$this->load->model('db_m');
		$result = $this->SaveMasterDetail($idMaster, $dsMaster, $dsDetail, $this->contactInfo_d->colFkIccCard);

		return $result;
	}
	public function SaveMasterDetail($idMaster, $dsMaster, $dsDetail, $colFkId) {
		$result = false;
		$resultMaster = false;
		$this->load->model('db_m');
		// Start transcation.
		$this->db_m->TransStart();

		if( (count($dsMaster) > 0) && (count($dsDetail) > 0) ) {			// validate have data to save.

		// Master table.
			$dsDataMaster = $dsMaster['data'];
			$this->db_m->tableName = $dsMaster['tableName'];
			$resultMaster = $this->db_m->Save($idMaster, $dsDataMaster, $dsMaster['objCreateBy']);
		// End Master table

			if($resultMaster) {
				if($idMaster <= 0) {
					$idMaster = $this->db_m->insertId;
				}

			// Detail table.
				$r = 0;
				foreach($dsDetail as $dsOneTableDetail) {
				// One by One Detail Table.
					$tableNameDetail = $dsOneTableDetail['tableName'];
					$this->db_m->tableName = $tableNameDetail;

					if( !empty($dsOneTableDetail['data']) ) {
						$dsDataDetail = $dsOneTableDetail['data'];
						$arrIdDetailExist = Array();
						foreach($dsDataDetail as $rowDataDetail) {
						// One by One Record Detail Table.
							$rowIdDetail = $rowDataDetail['id'];
							unset($rowDataDetail['id']);
							$rowDataDetail[$colFkId] = $idMaster;

						// Find record in Database.
							if( isset($dsOneTableDetail['arrWhereForFind']) ) {
								$dsOneTableDetail['arrWhereForFind'][$this->garbageTransaction_d->colFkGarbage]
															= $rowDataDetail[$this->garbageTransaction_d->colFkGarbage];
								$dsOneTableDetail['arrWhereForFind'][$this->garbageTransaction_d->colFkIccCard] = $idMaster;

								$exist = $this->db_m->Find( $dsOneTableDetail['arrWhereForFind'] );
								if($exist && isset($this->db_m->dataSet)) {
									$rowIdDetail = $this->db_m->dataSet[0]['id'];
								}
							} else {
								$exist = $this->db_m->Find( ['id' => $rowIdDetail] );
							}
						// Manipulate Record.
							if($exist) {
								if( $this->db_m->UpdateRow($rowIdDetail, $rowDataDetail) ) {
									$arrResultDetail[$r++] = true;
								} else {
									$arrResultDetail[$r++] = false;
									break 2;
								}
							} else {
								if( $this->db_m->CreateRow($rowDataDetail) ) {
									$arrResultDetail[$r++] = true;
									$rowIdDetail = $this->db_m->insertId;
								} else {
									$arrResultDetail[$r++] = false;
									break 2;
								}
							}

						// Special update column point.
							if( isset($dsOneTableDetail['sqlUpdateGeolocationPoint']) ) {
								if( $this->db_m->UpdateRowPointColumn($idMaster
								, $dsOneTableDetail['sqlUpdateGeolocationPoint'])) {
									$arrResultDetail[$r++] = true;
								} else {
									$arrResultDetail[$r++] = false;
									break 2;
								}
							}
							array_push($arrIdDetailExist, $rowIdDetail);
						}
					}
				
				// Inactive transaction at row not used of table.
					$arrIdDetailExist = ( isset($arrIdDetailExist) ? $arrIdDetailExist : Array(-1) );
					if( $this->db_m->InactiveTransactionRow($idMaster, $arrIdDetailExist) ) {
						$arrResultDetail[$r++] = true;
					} else {
						$arrResultDetail[$r++] = false;
						break 1;
					}
				}
			}

		// Check all result status
			if (isset($arrResultDetail)) {
				$resultDetail = true;
				foreach($arrResultDetail as $rowResultDetail) {
					if(!$rowResultDetail) {
						$resultDetail = false;
						break 1;
					}
					$result = $resultMaster && $resultDetail;
				}
			}
		}

		// Last Transaction For Check commit or rollback.
		if ($this->db_m->TransStatus() && $result) {
			$this->db_m->TransComplete();
		} else {
			$this->db_m->TransRollback();
		}
		// End Transaction.

		return $result;
	}
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ End Process Save

	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Prepare Data
	private function PrepareDataMasterTable($dsData) {
		$this->load->model('dataclass/iccCard_d');

		$dsResult['data'] = $dsData;
		unset($dsResult['data']['geoLocationId']);
		unset($dsResult['data']['Lat']);
		unset($dsResult['data']['Lon']);
		$dsResult['data']['Event_Date'] = date('Y-m-d H:i:s', strtotime($dsResult['data']['Event_Date']));
		$dsResult['data'][$this->iccCard_d->colUpdateBy] = $this->session->userdata['id'];


		$dsResult['tableName'] = $this->iccCard_d->tableName;
		$dsResult['objCreateBy'] = [$this->iccCard_d->colCreateBy => $this->session->userdata['id']];

		return $dsResult;
	}
	private function PrepareDataContactInfoDetailTable($dsData) {
		$this->load->model('dataclass/contactInfo_d');
		$dsResult['data'] = $dsData;
		$dsResult['tableName'] = $this->contactInfo_d->tableName;

		return $dsResult;
	}
	private function PrepareDataEntangledAnimalDetailTable($dsData) {
		$this->load->model('dataclass/entangledAnimal_d');
		$dsResult['data'] = $dsData;
		$dsResult['tableName'] = $this->entangledAnimal_d->tableName;

		return $dsResult;
	}
	private function PrepareDataGarbageTransactionDetailTable($dsData, $idMaster) {
		$this->load->model('dataclass/garbageTransaction_d');
		$dsResult['data'] = $dsData;
		$dsResult['tableName'] = $this->garbageTransaction_d->tableName;
		$dsResult['arrWhereForFind'] = [
			$this->garbageTransaction_d->colFkGarbage	=>	0,
			$this->garbageTransaction_d->colFkIccCard	=>	$idMaster
		];
		
		return $dsResult;
	}
	private function PrepareDataGeoLocationDetailTable($dsData) {
		$this->load->model('dataclass/geoLocation_d');
		$dsResult['data'][0] = [
			$this->geoLocation_d->colId => $dsData['geoLocationId'],
			$this->geoLocation_d->colLatitude 		=> $dsData[$this->geoLocation_d->colLatitude],
			$this->geoLocation_d->colLongitude 		=> $dsData[$this->geoLocation_d->colLongitude],
		];
		$dsResult['tableName'] = $this->geoLocation_d->tableName;
		$dsResult['sqlUpdateGeolocationPoint'] = "UPDATE "
											. $this->geoLocation_d->tableName . " SET " 
											. $this->geoLocation_d->colGeolocation . " = point("
											. $this->geoLocation_d->colLongitude . ", "
											. $this->geoLocation_d->colLatitude . ") WHERE "
											. $this->geoLocation_d->colFkIccCard . "=";

		return $dsResult;
	}
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ End Prepare Data

// -------------------------------------------------------------------------------------------- End Save


// -------------------------------------------------------------------------------------------- Inactive
	public function DeleteFullIccCard($iccCardId) {
		$result = false;
		$resultDetail = true;
		$this->load->model("dataclass/iccCard_d");
		$this->load->model("dataclass/contactInfo_d");
		$this->load->model("dataclass/entangledAnimal_d");
		$this->load->model("dataclass/garbageTransaction_d");
		$this->load->model("dataclass/geoLocation_d");
		$this->load->model("dataclass/eventImage_d");
		$this->load->model("dataclass/eventMedia_d");
		$this->load->model("db_m");

		// Start transcation.
		$this->db_m->TransStart();

		// Update at Master tbl (Icc_Card).
		$this->db_m->tableName = $this->iccCard_d->tableName;
		$data = array($this->iccCard_d->colActive => 0
				, $this->iccCard_d->colDeleteBy => $this->session->userdata['id']);
		if( $this->db_m->UpdateRow($iccCardId, $data, null) ) {
			// Start update detail tbl.

			// Inactive Contact_Info tbl.
			$this->db_m->tableName = $this->contactInfo_d->tableName;
			if( $this->db_m->InactiveTransactionRow($iccCardId, Array(-1)) ) {
				$resultDetail &= true;
			} else { $this->db_m->TransRollback(); }

			// Inactive Entangled_Animal tbl.
			$this->db_m->tableName = $this->entangledAnimal_d->tableName;
			if( $this->db_m->InactiveTransactionRow($iccCardId, Array(-1)) ) {
				$resultDetail &= true;
			} else { $this->db_m->TransRollback(); }

			// Inactive Garbang_Transaction tbl.
			$this->db_m->tableName = $this->garbageTransaction_d->tableName;
			if( $this->db_m->InactiveTransactionRow($iccCardId, Array(-1)) ) {
				$resultDetail &= true;
			} else { $this->db_m->TransRollback(); }

			// Inactive Geo_Location tbl.
			$this->db_m->tableName = $this->geoLocation_d->tableName;
			if( $this->db_m->InactiveTransactionRow($iccCardId, Array(-1)) ) {
				$resultDetail &= true;
			} else { $this->db_m->TransRollback(); }

			// Inactive Event_Image tbl.
			$this->db_m->tableName = $this->eventImage_d->tableName;
			if( $this->db_m->InactiveTransactionRow($iccCardId, Array(-1)) ) {
				$resultDetail &= true;
			} else { $this->db_m->TransRollback(); }

			// Inactive Event_Media tbl.
			$this->db_m->tableName = $this->eventMedia_d->tableName;
			if( $this->db_m->InactiveTransactionRow($iccCardId, Array(-1)) ) {
				$resultDetail &= true;
			} else { $this->db_m->TransRollback(); }
		} else { $this->db_m->TransRollback(); }
		$result  = $resultDetail;


		// Last Transaction For Check commit or rollback.
		if ($this->db_m->TransStatus() && $result) {
			$this->db_m->TransComplete();
		} else {
			$this->db_m->TransRollback();
		}
		// End Transaction.

		return $result;
	}
// -------------------------------------------------------------------------------------------- End Inactive


// -------------------------------------------------------------------------------------------- Approve
	public function ApproveIccCard($iccCardId) {
		$result = false;
		$this->load->model("dataclass/iccCard_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->iccCard_d->tableName;
		$data = array($this->iccCard_d->colFkIccCardStatus => 2
				, $this->iccCard_d->colApproveDate => date('Y-m-d H:i:s', now())
				, $this->iccCard_d->colApproveBy => $this->session->userdata['id'] );
		if( $this->db_m->UpdateRow($iccCardId, $data, null) ) { $result = true; }

		return $result;
	}
// -------------------------------------------------------------------------------------------- End Approve


// -------------------------------------------------------------------------------------------- Done
	public function DoneIccCard($iccCardId) {
		$result = false;
		$this->load->model("dataclass/iccCard_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->iccCard_d->tableName;
		$data = array($this->iccCard_d->colFkIccCardStatus => 3
				, $this->iccCard_d->colDoneDate => date('Y-m-d H:i:s', now())
				, $this->iccCard_d->colDoneBy => $this->session->userdata['id'] );
		if( $this->db_m->UpdateRow($iccCardId, $data, null) ) { $result = true; }

		return $result;
	}
// -------------------------------------------------------------------------------------------- End Done
// End Public function.





// Private function.
// -------------------------------------------------------------------------------------------- Load model file
	private function LoadModelGarbageForSetInputDisplay() {
		$this->load->model('dataclass/garbageTransaction_d');
		$this->load->model('dataclass/garbage_d');
		$this->load->model('dataclass/garbageType_d');
	}
// -------------------------------------------------------------------------------------------- End Load model file

// -------------------------------------------------------------------------------------------- Get DB to combobox
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ICC Card Child
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Cleanup_Type table
    private function GetDsCleanupType($id=null) {
		$this->load->model("dataclass/cleanupType_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->cleanupType_d->tableName;
		$this->db_m->sequenceColumn = $this->cleanupType_d->colName;
		$dataSet = $this->db_m->GetRowById($id, null);
    
    	return $dataSet;
	}
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Icc Card Status table
	private function GetDsIccCardStatus($id=null) {
		$this->load->model("dataclass/iccCardStatus_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->iccCardStatus_d->tableName;
		$this->db_m->sequenceColumn = $this->iccCardStatus_d->colId;
		$dataSet = $this->db_m->GetRowById($id, null);

    	return $dataSet;
	}		
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Department (Org)Table
    private function GetDsOrg($id=null) {
		$this->load->model("dataclass/org_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->org_d->tableName;
		$this->db_m->sequenceColumn = $this->org_d->colDepartment;
		$strSelect = $this->org_d->colId . ', ' . $this->org_d->colDepartment;
		$dataSet = $this->db_m->GetRowById($id, null, $strSelect);
    
    	return $dataSet;
    }
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Distance Unit table
    private function GetDsDistanceUnit($id=null) {
		$this->load->model("dataclass/distanceUnit_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->distanceUnit_d->tableName;
		$this->db_m->sequenceColumn = $this->distanceUnit_d->colName;
		$dataSet = $this->db_m->GetRowById($id, null);
    
    	return $dataSet;
    }
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Weight Unit table
    private function GetDsWeightUnit($id=null) {
		$this->load->model("dataclass/weightUnit_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->weightUnit_d->tableName;
		$this->db_m->sequenceColumn = $this->weightUnit_d->colName;
		$dataSet = $this->db_m->GetRowById($id, null);
    
    	return $dataSet;
	}
	
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Animal Status table
    private function GetDsAnimalStatus($id=null) {
		$this->load->model("dataclass/animalStatus_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->animalStatus_d->tableName;
		$this->db_m->sequenceColumn = $this->animalStatus_d->colName;
		$dataSet = $this->db_m->GetRowById($id, null);
    
    	return $dataSet;
    }

	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Garbage Type Table
    private function GetDsGarbageType($id=null) {
		$this->load->model("dataclass/garbageType_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->garbageType_d->tableName;
		$this->db_m->sequenceColumn = $this->garbageType_d->colName;
		$strSelect = $this->garbageType_d->colId . ', ' . $this->garbageType_d->colName;
		$dataSet = $this->db_m->GetRowById(null, null, $strSelect);
    
    	return $dataSet;
    }
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ End ICC Card Child

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Place data
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Province Table
    private function GetDsProvince($id=null) {
		$this->load->model("dataclass/province_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->province_d->tableName;
		$this->db_m->sequenceColumn = $this->province_d->colProvinceName;
		$dataSet = $this->db_m->GetRowById(null, null);
    
    	return $dataSet;
	}
	private function GetDsProvinceByDaterange($sqlWhere=null) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model("dataclass/province_d");
		$this->load->model("db_m");

		// Create sql string.
		$sqlStr = "SELECT DISTINCT p." . $this->province_d->colProvinceCode
				. ", p." . $this->province_d->colProvinceName
				. " FROM " . $this->iccCard_d->tableName . " AS c"
				. " LEFT JOIN " . $this->province_d->tableName . " AS p"
				. " ON c." . $this->iccCard_d->colFkProvinceCode
				. "=p." . $this->province_d->colProvinceCode
				. $sqlWhere
				. " ORDER BY p." . $this->province_d->colProvinceName;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
	}
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Amphur Table
    private function GetDsAmphur($amphurCode=null) {
		$this->load->model("dataclass/amphur_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->amphur_d->tableName;
		$this->db_m->sequenceColumn = $this->amphur_d->colAmphurName;
		$this->db_m->colId = $this->amphur_d->colAmphurCode;
		$strSelect = $this->amphur_d->colAmphurName;
		$dataSet = $this->db_m->GetRowById($amphurCode, null, $strSelect);
    
    	return $dataSet;
    }
    private function GetDsAmphurByProvinceCode($fkProvinceCode=null) {
		$this->load->model("dataclass/amphur_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->amphur_d->tableName;
		$this->db_m->sequenceColumn = $this->amphur_d->colAmphurName;
		$this->db_m->colId = $this->amphur_d->colProvinceCode;
		$strSelect = $this->amphur_d->colAmphurCode . ", " . $this->amphur_d->colAmphurName;
		$fkProvinceCode = ( ($fkProvinceCode < 1) ? null : $fkProvinceCode);

		$dataSet = $this->db_m->GetRowById($fkProvinceCode, null, $strSelect);

    	return $dataSet;
    }
	private function GetDsAmphurByDaterange($sqlWhere=null) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model("dataclass/amphur_d");
		$this->load->model("db_m");

		// Create sql string.
		$sqlStr = "SELECT DISTINCT c." . $this->iccCard_d->colFkAmphurCode
				. ", a." . $this->amphur_d->colAmphurName
				. " FROM " . $this->iccCard_d->tableName . " AS c"
				. " LEFT JOIN " . $this->amphur_d->tableName . " AS a"
				. " ON c." . $this->iccCard_d->colFkAmphurCode
				. "=a." . $this->amphur_d->colAmphurCode
				. $sqlWhere
				. " ORDER BY a." . $this->amphur_d->colAmphurName;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
	}
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Project Name (ICC_Card)Table
    private function GetDsProjectName($id=null) {
		$this->load->model("dataclass/iccCard_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->iccCard_d->tableName;
		$this->db_m->sequenceColumn = $this->iccCard_d->colProjectName;
		$strSelect = $this->iccCard_d->colProjectName;
		$rWhere = array($this->iccCard_d->colActive => "1");
		$dataSet = $this->db_m->GetRowById($id, $rWhere, $strSelect);
    
    	return $dataSet;
    }
    private function GetDsProjectNameByProvinceCode($fkProvinceCode=null) {
		$this->load->model("dataclass/iccCard_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->iccCard_d->tableName;
		$this->db_m->sequenceColumn = $this->iccCard_d->colProjectName;
		$this->db_m->colId = $this->iccCard_d->colFkProvinceCode;
		$strSelect = $this->iccCard_d->colProjectName;
		$rWhere = array($this->iccCard_d->colActive => "1");
		$fkProvinceCode = ( ($fkProvinceCode < 1) ? null : $fkProvinceCode);
		
		$dataSet = $this->db_m->GetRowById($fkProvinceCode, $rWhere, $strSelect);
    
    	return $dataSet;
    }
	private function GetDsProjectNameByDaterange($sqlWhere=null) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model("db_m");

		// Create sql string.
		$sqlStr = "SELECT DISTINCT c." . $this->iccCard_d->colProjectName
				. " FROM " . $this->iccCard_d->tableName . " AS c"
				. $sqlWhere
				. " ORDER BY c." . $this->iccCard_d->colProjectName;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
	}
// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ End Place data
// -------------------------------------------------------------------------------------------- End Get DB to combobox


// -------------------------------------------------------------------------------------------- Get For Advance Combobox
	// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ ICC Card Staus array
	private function GetArrayIccCardStatus($id=null) {
		$this->load->model("dataclass/iccCardStatus_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->iccCardStatus_d->tableName;
		$this->db_m->sequenceColumn = $this->iccCardStatus_d->colId;
		$dsResult = $this->db_m->GetRowById($id, null);

		foreach($dsResult as $row) {
			$rIccCardStatus[$row['id']] = $row['Name'];
		}

    	return $rIccCardStatus;
	}		
// -------------------------------------------------------------------------------------------- End Get For Advance Combobox


// -------------------------------------------------------------------------------------------- Get DB for render garbage
	private function GetDsGarbageIncludeTransactionAndTypeGrouping($fkIccCardId=null) {
		$this->LoadModelGarbageForSetInputDisplay();
		$this->load->model('helper_m');

		// Group.
		$sqlStrGroup = "SELECT gt." . $this->garbageType_d->colPriority
						. " FROM " . $this->garbageType_d->tableName . " AS gt"
						. " ORDER BY gt." . $this->garbageType_d->colPriority;
		// Execute sql.
		$this->load->model('db_m');
		$resultGroup = $this->db_m->GetRow($sqlStrGroup);


		// Loop.
		$i = 0;
		foreach($resultGroup as $row) {
			// Create sql string.
			$sqlStr = "SELECT g." . $this->garbage_d->colId
					. ", gt." . $this->garbageType_d->colName . " AS garbageTypeName"
					. ", g." . $this->garbage_d->colName
					. ", gs." . $this->garbageTransaction_d->colId . " AS GarbageTransactionId"
					. ", gs." . $this->garbageTransaction_d->colGarbageQty

					. " FROM " . $this->garbageType_d->tableName . " AS gt"
					
					. " LEFT JOIN " . $this->garbage_d->tableName . " AS g"
					. " ON gt." . $this->garbageType_d->colId
					. "=g." . $this->garbage_d->colFkGarbageType

					. " LEFT JOIN " . $this->garbageTransaction_d->tableName . " AS gs"
					. " ON g." . $this->garbage_d->colId
					. "=gs." . $this->garbageTransaction_d->colFkGarbage
					. " AND gs." . $this->garbageTransaction_d->colActive . "=1"
					. " AND gs." . $this->garbageTransaction_d->colFkIccCard . "=" . $fkIccCardId

					. " WHERE gt." . $this->garbageType_d->colPriority
					. "=" . $row[$this->garbageType_d->colPriority]

					. " ORDER BY gt." . $this->garbageType_d->colPriority
					. ", g." . $this->garbage_d->colName;
			// Execute sql.
			$this->load->model('db_m');
			$result[$i++] = $this->db_m->GetRow($sqlStr);
		}
	
    	return $result;
	}
// -------------------------------------------------------------------------------------------- End Get DB for render garbage


// -------------------------------------------------------------------------------------------- Gen Sql
	private function CreateSqlWhereAndJoinTbl($rFilter=null) {
		$this->load->model('dataclass/iccCard_d');
		$this->load->model('dataclass/garbageTransaction_d');
		$this->load->model('dataclass/garbage_d');
		$this->load->model('dataclass/garbageType_d');

		// Create sql string join table.
		$sqlJoin = " LEFT JOIN " . $this->garbageTransaction_d->tableName . " AS gt"
				. " ON c." . $this->iccCard_d->colId
				. "=gt." . $this->garbageTransaction_d->colFkIccCard

				. " LEFT JOIN " . $this->garbage_d->tableName . " AS g"
				. " ON gt." . $this->garbageTransaction_d->colFkGarbage
				. "=g." . $this->garbage_d->colId

				. " LEFT JOIN " . $this->garbageType_d->tableName . " AS gy"
				. " ON g." . $this->garbage_d->colFkGarbageType
				. "=gy." . $this->garbageType_d->colId;

		// Create sql string where.
		$sqlWhere = " WHERE c." . $this->iccCard_d->colActive . "=1";
		if($rFilter !== NULL) {
			$sqlWhere .= (($rFilter['provinceCode'] !== NULL) && ($rFilter['provinceCode'] > 0)
					? " AND c." . $this->iccCard_d->colFkProvinceCode . "=" . $rFilter['provinceCode']
					: NULL );
			$sqlWhere .= (($rFilter['amphurCode'] !== NULL) && ($rFilter['amphurCode'] > 0)
					? " AND c." . $this->iccCard_d->colFkAmphurCode . "=" . $rFilter['amphurCode']
					: NULL );
			$sqlWhere .= (($rFilter['projectName'] !== NULL) && ($rFilter['projectName'] != '0')
					? " AND c." . $this->iccCard_d->colProjectName . "='" . $rFilter['projectName'] . "'"
					: NULL );
			$sqlWhere .= (($rFilter['orgId'] !== NULL) && ($rFilter['orgId'] > 0)
					? " AND c." . $this->iccCard_d->colFkOrg . "=" . $rFilter['orgId']
					: NULL );
			$sqlWhere .= (($rFilter['garbageTypeId'] !== NULL) && ($rFilter['garbageTypeId'] > 0)
					? " AND g." . $this->garbage_d->colFkGarbageType . "=" . $rFilter['garbageTypeId']
					: NULL );
			$sqlWhere .= (($rFilter['iccCardStatusCode'] !== NULL) && ($rFilter['iccCardStatusCode'] > 0)
					? " AND c." . $this->iccCard_d->colFkIccCardStatus . "=" . $rFilter['iccCardStatusCode']
					: NULL );
			$sqlWhere .= " AND c." . $this->iccCard_d->colEventDate;
			$sqlWhere .= " BETWEEN '" . $rFilter['strDateStart'] . "%' AND '" . $rFilter['strDateEnd'] . "%'";
		}

		return ($sqlJoin . $sqlWhere);
	}

	private function CreateSqlWhereDaterangeFilter($strDateStart=null, $strDateEnd=null, $provinceCode=null) {
		$this->load->model('dataclass/iccCard_d');

		// Create sql string where.
		$sqlWhere = " WHERE c." . $this->iccCard_d->colActive . "=1"
			. (($provinceCode !== NULL) && ($provinceCode > 0)
				? " AND c." . $this->iccCard_d->colFkProvinceCode . "=" . $provinceCode 
				: NULL )
			. " AND c." . $this->iccCard_d->colEventDate
			. " BETWEEN '" . $strDateStart . "%' AND '" . $strDateEnd . "%'";

		return $sqlWhere;
	}
// -------------------------------------------------------------------------------------------- End Gen Sql
// End Private function.
}