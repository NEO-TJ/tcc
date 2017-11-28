<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventMedia_d extends CI_Model {
	// Property.
    public $tableName = "event_media";
	public $colId = "id";
    public $colFkMediaType = "FK_Media_Type";
    public $colMediaPath = "Media_Path";
    public $colFkIccCard = "FK_ICC_Card";
    public $colActive = "Active";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";
    

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
