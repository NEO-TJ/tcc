<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Db_m extends CI_Model {
// Property.
    public $tableName = '';
    public $colId = "id";
    public $sequenceColumn = "id";
	public $sequenceType = " Asc ";
	public $sequenceOrder;
	public $insertId = 0;
	public $affectedRows = -1;
	public $dataSet;
	public $rChkDuplication = null;

	private $colFkTransaction = "FK_ICC_Card";
	private $colActive = "Active";
	private $colDeleteBy = "Delete_By";
// End Property.



// Transaction.
	public function TransBegin() {
    	return $this->db->trans_begin();
    }
	public function TransCommit() {
    	return $this->db->trans_commit();
    }
	public function TransRollback() {
    	return $this->db->trans_rollback();
	}
	
	public function TransStart() {
		return $this->db->trans_start();
	}
	public function TransStartTestMode() {
		return $this->db->trans_start(TRUE);
	}
	public function TransComplete() {
		return $this->db->trans_complete(TRUE);
	}

	public function TransStatus() {
    	return  ($this->db->trans_status() === FALSE) ? false : true;
    }
// End Transaction.


// Save.
	public function Save($id, $data, $extendForInsert=null) {
		$result = false;
 
		// check in database
		$exist = $this->GetRowById($id);
		$ce = count($exist);

		$result = (($ce > 0) ? $this->UpdateRow($id, $data) 
				: $this->CreateRow( 
					(isset($extendForInsert) ? array_merge($data, $extendForInsert) : $data) ) );

		return $result;
	}
// End Save.


// Find.
    public function Find($rWhere=[]) {
		$result = null;

        $dataSet = $this->db->get_where($this->tableName, $rWhere)->result_array();
        if(count($dataSet) > 0) {
			$this->dataSet = $dataSet;
			$result = TRUE;
		} else {
			$result = FALSE;
		}

		return $result;
    }

    public function FindById($id=null) {
		$result = $this->Find([$this->colId => $id]);
		return $result;
    }
// End Find.





// CRUD without table name.
	// __________________________________________________________ Get _______________________________________________
	public function GetRow($sqlStr) {
		$query = $this->db->query($sqlStr);
		$result = $query->result_array();

    	return $result;
	}

    public function GetRowWhere($rWhere=[]) {
		$query = $this->db->get_where($this->tableName, $rWhere)->result_array();

		return $query;
    }

    public function GetRowById($id=null, $rWhere=null, $strSelect=null) {
		$this->db->select( (($strSelect !== NULL) ? $strSelect : '*') );

		$this->db->from($this->tableName);

		if($id != null){
			$this->db->where($this->colId, $id);
		}
		if($rWhere != null){
			if(count($rWhere) > 0) {
				$this->db->where($rWhere);
			}
		}

		if ($this->sequenceOrder) {
			$this->db->order_by($this->sequenceOrder);
		} else if(($this->sequenceColumn) && ($this->sequenceType)){
			$this->db->order_by($this->sequenceColumn, $this->sequenceType);
		}

		$query = $this->db->get();

		return $query->result_array();
    }

    public function GetRowLimit($searchColumn=null, $searchString=null, $sequenceColumn=null
                        , $sequenceType=null, $limitStart=null, $limitEnd=null) {
	    
		$this->db->select('*');
		$this->db->from($this->tableName);

		if(($searchColumn) && ($searchString)){
			$this->db->like($searchColumn, $searchString);
		}
		$this->db->group_by($this->colId);

		if ($this->sequenceOrder) {
			$this->db->order_by($this->sequenceOrder);
		} else if(($this->sequenceColumn) && ($sequenceType)){
			$this->db->order_by($this->sequenceColumn, $sequenceType);
		}

        if($limitStart && $limitEnd){
          $this->db->limit($limitStart, $limitEnd);	
        }

        if($limitStart != null){
          $this->db->limit($limitStart, $limitEnd);    
        }
        
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

	// ________________________________________________________ Create ______________________________________________
    public function CreateRow($data) {
		// Check custom duplication.
		if($this->rChkDuplication != null) { if( $this->db_m->Find($this->rChkDuplication) ) { return false; } }
		// End Check custom duplication.

		$result = $this->db->insert($this->tableName, $data);

		$this->affectedRows = $this->db->affected_rows();
		if($this->affectedRows > 0) {
			$this->insertId = $this->db->insert_id();
			$result = true;
		} else { 
			$this->insertId = 0;
			$result = false;
		}

	    return $result;
	}

	// ________________________________________________________ Update ______________________________________________
    public function UpdateRow($id, $data, $rWhere=null) {
		// Check custom duplication.
		if($this->rChkDuplication != null) { if( $this->db_m->Find($this->rChkDuplication) ) { return false; } }
		// End Check custom duplication.

		if(isset($rWhere)) {
			$this->db->where($rWhere);
		} else {
			$this->db->where($this->colId, $id);
		}
		$this->db->update($this->tableName, $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			$this->affectedRows = $this->db->affected_rows();
			return true;
		}else{
			$this->affectedRows = -1;
			return false;
		}
	}
    public function UpdateRowPointColumn($id, $sqlUpdateColumnPoint) {
		// Check custom duplication.
		if($this->rChkDuplication != null) { if( $this->db_m->Find($this->rChkDuplication) ) { return false; } }
		// End Check custom duplication.

		$sqlUpdate = $sqlUpdateColumnPoint . $id;
		$query = $this->db->query($sqlUpdate);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			$this->affectedRows = $this->db->affected_rows();
			return true;
		}else{
			$this->affectedRows = -1;
			return false;
		}
	}

	// ________________________________________________________ Delete ______________________________________________
	public function DeleteRow($id) {
		$this->db->where($this->colId, $id);
		$result = $this->db->delete($this->tableName);
		
		return $result;
	}
// CRUD without table name.


// CRUD with table name.
    public function CreateRowWithTable($tableName, $data) {
		$this->tableName = $tableName;
		// Check custom duplication.
		if($this->rChkDuplication != null) { if( $this->db_m->Find($this->rChkDuplication) ) { return false; } }
		// End Check custom duplication.

		$result = $this->db->insert($tableName, $data);

		$this->affectedRows = $this->db->affected_rows();
		if($this->affectedRows > 0) {
			$this->insertId = $this->db->insert_id();
			$result = true;
		} else { 
			$this->insertId = 0;
			$result = false;
		}

	    return $result;
	}

    public function UpdateRowWithTable($tableName, $id, $data) {
		$this->tableName = $tableName;
		// Check custom duplication.
		if($this->rChkDuplication != null) { if( $this->db_m->Find($this->rChkDuplication) ) { return false; } }
		// End Check custom duplication.

		$this->db->where($this->colId, $id);
		$this->db->update($tableName, $data);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			$this->affectedRows = $this->db->affected_rows();
			return true;
		}else{
			$this->affectedRows = -1;
			return false;
		}
	}

	public function DeleteRowWithTable($tableName, $id) {
		$this->db->where($this->colId, $id);
		$result = $this->db->delete($tableName);
		
		return $result;
	}
// End CRUD with table name.





// Basic Command.
	// ----------------------------------------------------- SQL Command -----------------------------------------
	public function ExecuteSql($sqlStr, $commandType) {
		$query = $this->db->query($sqlStr);

		if($commandType == 1) {					// SELECT command
			$result = $query->result_array();
		} else if ($commandType == 2) {			// INSERT, UPDATE command
			$result = $query->affected_rows();
		} else {
			$result = isset($query);
		}

		return $result;
	}

	// ------------------------------------------------------- Utility -------------------------------------------
	public function GetLastQuery() {
		return $this->db->last_query();
	}

	public function CountRow($searchColumn=null, $searchString=null, $sequenceColumn=null, $sequenceType=null) {
		$this->db->select('*');
		$this->db->from($this->tableName);
		if(($searchColumn) && ($searchString)){
			$this->db->like($searchColumn, $searchString);
		}
		if(($searchColumn) && ($searchString)){
			$this->db->like($searchColumn, $searchString);
		}
		$query = $this->db->get();
		
        return $query->num_rows();        
    }
// End Basic Command.



// Advance Tool.
	public function InactiveTransactionRow($fkId, $rId=[0]) {
		$this->db->where($this->colFkTransaction, $fkId);
		$this->db->where_not_in($this->colId, $rId);
		$this->db->update($this->tableName
						, [$this->colActive => 0, $this->colDeleteBy => $this->session->userdata['id']]);
		
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			$this->affectedRows = $this->db->affected_rows();
			return true;
		}else{
			$this->affectedRows = -1;
			return false;
		}
	}

	public function SaveMasterDetail($idMaster, $dataMaster, $tableNameMaster, $colFkIdNameDetail
	, $dataDetail, $tableNameDetail, $rWhere=null) {
		$result = false;
		$resultMaster = false;
		$resultDetail = false;
		// Start transcation.
		$this->db->trans_begin();

		if(count($dataDetail) > 0) {									// validate have data to save.
			// Detail table.
			$this->tableName = $tableNameDetail;
			$idDetail = $dataMaster[$colFkIdNameDetail];

			if( ($idDetail != null) && ($idDetail > 0) ) {
				// check in database
				$exist = $this->GetRowById($idDetail);
				$ce = count($exist);

				if($ce > 0) {
					$resultDetail = $this->UpdateRow($idDetail, $dataDetail);
				} else {
					$resultDetail = $this->CreateRow($dataDetail);
					$idDetail = $this->insertId;
				}
			} else {
				$resultDetail = $this->CreateRow($dataDetail);
				$idDetail = $this->insertId;
			}

			// Master table.
			$this->tableName = $tableNameMaster;
			$dataMaster[$colFkIdNameDetail] = $idDetail;
			$resultMaster = $this->Save($idMaster, $dataMaster, $rWhere);

			$result = ($resultMaster && $resultDetail);
		}


		// Check status of transaction progress.
		if ( !($this->db->trans_status() === FALSE) && $result ) {
			$this->db->trans_commit();
			$result = true;
		} else {
			$this->db->trans_rollback();
			$result = false;
		}

		return $result;
	}

// End Advance Tool.
}
?>
