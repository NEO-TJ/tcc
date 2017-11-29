<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventImage_d extends CI_Model {
	// Property.
    public $tableName = "event_image";
	public $colId = "id";
    public $colImageUrl = "Image_URL";
    public $colCaption = "Caption";
    public $colPriority = "Priority";
    public $colFkIccCard = "FK_ICC_Card";
    public $colActive = "Active";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";
    

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
