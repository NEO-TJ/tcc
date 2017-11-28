<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GarbageTransaction_d extends CI_Model {
	// Property.
    public $tableName = "garbage_transaction";
	public $colId = "id";
    public $colFkGarbage = "FK_Garbage";
    public $colGarbageQty = "Garbage_Qty";
    public $colFkIccCard = "FK_ICC_Card";
    public $colActive = "Active";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
