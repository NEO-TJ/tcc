<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IccCard_d extends CI_Model {
// Property.
    public $tableName = "icc_card";
    
    public $colId = "id";
    public $colProjectName = "Project_Name";
    public $colFkCleanupType = "FK_Cleanup_Type";
    public $colEventPlaceName = "Event_Place_Name";
    public $colFkAmphurCode = "FK_Amphur_Code";
    public $colFkProvinceCode = "FK_Province_Code";
    public $colEventDate = "Event_Date";
    public $colCoordinatorName = "Coordinator_Name";
    public $colFkOrg = "FK_Org";
    public $colVolunteerQty = "Volunteer_Qty";
    public $colEventTime = "Event_Time";
    public $colEventDistance = "Event_Distance";
    public $colFkDistanceUnit = "FK_Distance_Unit";
    public $colGarbageBagQty = "Garbage_Bag_Qty";
    public $colGarbageWeight = "Garbage_Weight";
    public $colFkWeightUnit = "FK_Weight_Unit";
    public $colFkIccCardStatus = "FK_ICC_Card_Status";
    public $colApproveDate = "Approve_Date";
    public $colApproveBy = "Approve_By";
    public $colDoneDate = "Done_Date";
    public $colDoneBy = "Done_By";

    public $colActive = "Active";
    public $colCreateDate = "Create_Date";
    public $colCreateBy = "Create_By";
    public $colUpdateDate = "Update_Date";
    public $colUpdateBy = "Update_By";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";
// End Property

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
