<?php
class Masterdata extends MY_Controller {
// Property.
	private $commonName = false;			// For select view file.
	private $commonQtyUnit = false;			// For select view file.
	private $dataTypeCaption = ['0' 	=> 'User',
								'1' 	=> 'Cleanup Type',

								'2' 	=> 'Distance Unit',
								
								'3' 	=> 'Weight Unit', 
								
								'4' 	=> 'Animal Status',
								
								'5' 	=> 'Garbage',								
								'6' 	=> 'Garbage Type',
								
								'7' 	=> 'Media Type',
							];
	private $inputModeName = [ 1 => 'เพิ่มข้อมูล', 2 => 'แก้ไขข้อมูล' ];
// End Property.




// Constructor.
    public function __construct() {
        parent::__construct();

		$this->is_logged();
    }
// End  Constructor.



// Method start.
    public function index() {
    	if(!($this->is_logged())) {exit(0);}

    	$this->view(0);
    }
// End Method start.
    
    
    
// Public function.
    // ------------------------------------------------- For display -----------------------------------
    public function view($dataType=1) {
    	if(!($this->is_logged())) {exit(0);}

		// Prepare data of view.
		$this->data = $this->GetDataForViewDisplay($dataType);

		// Prepare Template.
		$this->extendedCss = 'backend/masterdata/list/extendedCss_v';
		$this->body = 'backend/masterdata/list/body_v';
		$this->extendedJs = 'backend/masterdata/list/extendedJs_v';
		$this->renderWithTemplate();
    }
    public function addNew() {
    	if(!($this->is_logged())) {exit(0);}
    	
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$dataType = $this->input->post('dataType');
			$inputMode = 1;
			$rowID = null;

			$this->SetInputDisplay($dataType, $inputMode, $rowID);
		}
    }
    public function edit() {
    	if(!($this->is_logged())) {exit(0);}
    	
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$dataType = $this->input->post('dataType');
			$inputMode = 2;
			$rowID = $this->input->post('rowID');

			$this->SetInputDisplay($dataType, $inputMode, $rowID);
		}
    }
// End Public function.


// AJAX function.
    // ---------------------------------------------- Save data to DB ----------------------------------
    public function ajaxSaveInputData() {
		if(!($this->is_logged())) {exit(0);}

		$result = 1;
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$allDataPost = $this->input->post(NULL, TRUE);
			
			$result = $this->SaveDataToDB($allDataPost);
		}

		$result = (($result) ? 0 : 1);
		echo $result;
    }
// End AJAX function.



// Private function.
    // ------------------------------------------- Select masterdata object ----------------------------
	private function SelectMasterdataObject($dataType=1) {
		$this->commonName = false;
		$this->commonQtyUnit = false;

		// User.
		if($dataType == '0') {
			$this->load->model('masterdata/masterdataUser_m', 'oMasterdata_m');
    	}

		// Cleanup Type.
    	else if($dataType == '1') {		// ID & Name #.
			$this->load->model('masterdata/masterdataCommonName_m', 'oMasterdata_m');
			$this->load->model('dataclass/cleanupType_d');
			$this->oMasterdata_m->tableName = $this->cleanupType_d->tableName;
			$this->commonName = true;
    	}

		// Distance Unit.
    	else if($dataType == '2') {		// ID & Name #.
			$this->load->model('masterdata/masterdataCommonName_m', 'oMasterdata_m');
			$this->load->model('dataclass/distanceUnit_d');
			$this->oMasterdata_m->tableName = $this->distanceUnit_d->tableName;
			$this->commonName = true;
    	}

		// Weight Unit.
    	else if($dataType == '3') {		// ID & Name #.
			$this->load->model('masterdata/masterdataCommonName_m', 'oMasterdata_m');
			$this->load->model('dataclass/weightUnit_d');
			$this->oMasterdata_m->tableName = $this->weightUnit_d->tableName;
			$this->commonName = true;
    	}

		// Animal Status.
    	else if($dataType == '4') {		// ID & Name #.
			$this->load->model('masterdata/masterdataCommonName_m', 'oMasterdata_m');
			$this->load->model('dataclass/animalStatus_d');
			$this->oMasterdata_m->tableName = $this->animalStatus_d->tableName;
			$this->commonName = true;
    	}

		// Garbage Detail.
    	else if($dataType == '5') {
			$this->load->model('masterdata/masterdataGarbage_m', 'oMasterdata_m');
    	}
		// Garbage Type.
    	else if($dataType == '6') {
			$this->load->model('masterdata/masterdataGarbageType_m', 'oMasterdata_m');
    	}

		// Media Type.
    	else if($dataType == '7') {		// ID & Name #.
			$this->load->model('masterdata/masterdataCommonName_m', 'oMasterdata_m');
			$this->load->model('dataclass/mediaType_d');
			$this->oMasterdata_m->tableName = $this->mediaType_d->tableName;
			$this->commonName = true;
    	}

		// Not match.
		else{
			exit(0);
		}

		return $this->oMasterdata_m;
	}






    // ---------------------------------------------- Initial view mode --------------------------------
    private function GetDataForViewDisplay($dataType=1) {
		// Selection for masterdata object.
		$this->SelectMasterdataObject($dataType);

		// Set array data for View part.
		$data['dataType'] = $dataType;
    	$data['dataTypeCaption'] = $this->dataTypeCaption[$dataType];
		$data['dsView'] = $this->oMasterdata_m->GetDataForViewDisplay(null, null);

    	return $data;
    }


    // -------------------------------------------- Set input display mode -----------------------------
    protected function SetInputDisplay($dataType=1, $inputMode=1, $rowID=null) {
		$this->data = $this->GetDataForInputDisplay($dataType, $rowID);
		// Caption.
    	$this->data['dataType'] = $dataType;
    	$this->data['dataTypeCaption'] = $this->dataTypeCaption[$dataType];
    	$this->data['inputModeName'] = $this->inputModeName[$inputMode];
		// Set body section file view.
		$bodyView = ( ($this->commonName) ? 'CommonName' 
							: ( ($this->commonQtyUnit) ? 'CommonQtyUnit' 
								: str_replace(' ', '', $this->dataTypeCaption[$dataType]) ) );

		// Prepare Template.
		$this->extendedCss = 'backend/masterdata/input/extendedCss_v';
		$this->header = 'backend/masterdata/input/header_v';
		$this->body = 'backend/masterdata/input/body' . $bodyView . '_v';
		$this->footer = 'backend/masterdata/input/footer_v';
		$this->extendedJs = 'backend/masterdata/input/extendedJs_v';
		$this->renderWithTemplate();
    }
    // ---------------------------------------------- Initial input mode -------------------------------
    private function GetDataForInputDisplay($dataType=1, $rowID=null) {
		// Selection for masterdata object.
		$this->SelectMasterdataObject($dataType);

		// Set array data for View part.
		if(($rowID == null) || ($rowID == 0)) {
			$result['dsInput'] = $this->oMasterdata_m->GetTemplateForInputDisplay();
		} else {
			$dataSet = $this->oMasterdata_m->GetDataForInputDisplay($rowID);
			$result['dsInput'] = ((count($dataSet) > 0) ? $dataSet[0] 
								: $this->oMasterdata_m->GetTemplateForInputDisplay());
		}

		// Get DataSet to combobox.
		$dsComboBox = $this->oMasterdata_m->GetDataForComboBox();
		if($dsComboBox != null) {
			foreach($dsComboBox as $key => $value) {
				$result[$key] = $value;
			}
		}

    	return $result;
    }
    

    // -------------------------------------------------- Save input mode ------------------------------
    private function SaveDataToDB($dsSave) {
    	$result = false;
    	
    	$dataType = $dsSave['dataType'];
    	unset($dsSave['dataType']);
    	
    	$rowID = $dsSave['rowID'];
    	unset($dsSave['rowID']);
    	
		// Selection for masterdata object.
		$this->SelectMasterdataObject($dataType);

		// Save data to DB.
		$result = $this->oMasterdata_m->Save($rowID, $dsSave);
    	
    	return $result;
	}
// End Private function.
}