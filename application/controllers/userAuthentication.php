<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserAuthentication extends MY_Controller {
// Property.
	private $commonName = false;			// For select view file.
	private $commonQtyUnit = false;			// For select view file.
	private $dataTypeCaption = ['0' => 'User'];
	private $inputModeName = [1 => 'เพิ่มข้อมูล', 2 => 'แก้ไขข้อมูล'];
// End Property.


// Constructor.
	public function __construct() {
		parent::__construct();
		// set default data to view
        $this->data = array();
	}
// End Constructor.


// Public function.
    // ------------------------------------------------- For display -----------------------------------
	public function index() {
		if($this->is_logged()) {
			edit();
		}
		register();
	}

	public function register() {
		$dataType = 0;
		$inputMode = 1;
		$rowID = null;

		$this->SetInputDisplay($dataType, $inputMode, $rowID);
	}

	public function edit() {
		if(!($this->is_logged())) {register();}
    	
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$dataType = 0;
			$inputMode = 2;
			$rowID = $this->input->post('rowID');

			$this->SetInputDisplay($dataType, $inputMode, $rowID);
		}
    }

	// -------------------------------------------------- For check ------------------------------------
	public function validate() {
		$this->load->model('userAuthentication_m');
		// get data from db
		$this->userAuthentication_m->userId   = $this->input->post('userId');
		$this->userAuthentication_m->password = $this->input->post('password');
		$user = $this->userAuthentication_m->Validate();

		$data = array();
		if(count($user) > 0) {
			foreach ($user as $u) {
				$data['id']		= $u['id'];
				$data['userId']	= $u['UserId'];
				$data['level']	= $u['Level'];
			}
			// set data to session
			$this->session->set_userdata($data);

			//check level user
			switch ($data['level']) {
				case '1':
					// redirect page to admin page
					redirect("iccCard");
					break;
				case '2':
					// redirect page to user page
					redirect("iccCard");
					break;
				default:
					// redirect page to user page
					redirect("iccCard");
					break;
			}
			
		} else {
			// redirect with session msessage
			$this->session->set_flashdata('msg',  'ข้อมูลไม่ถูกต้องกรุณาลองใหม่อีกครั้ง');
			header('Location: ../');
		}
	}
// End Public function.



// AJAX function.
    // ---------------------------------------------- Save data to DB ----------------------------------
    public function ajaxSaveInputData() {
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
    // -------------------------------------------- Set input display mode -----------------------------
    private function SetInputDisplay($dataType=0, $inputMode=1, $rowID=null) {
		$this->data = $this->GetDataForInputDisplay($dataType, $rowID);
		// Caption.
    	$this->data['dataType'] = 0;
    	$this->data['dataTypeCaption'] = "User";
    	$this->data['inputModeName'] = $this->inputModeName[$inputMode];
		// Set body section file view.
		$bodyView = ( ($this->commonName) ? 'CommonName' 
							: ( ($this->commonQtyUnit) ? 'CommonQtyUnit' 
								: str_replace(' ', '', $this->dataTypeCaption[$dataType]) ) );

		// Prepare Template.
		$this->extendedCss = 'frontend/userAuthentication/input/extendedCss_v';
		$this->header = 'frontend/userAuthentication/input/header_v';
		$this->body = 'frontend/userAuthentication/input/body' . $bodyView . '_v';
		$this->footer = 'frontend/userAuthentication/input/footer_v';
		$this->extendedJs = 'frontend/userAuthentication/input/extendedJs_v';
		$this->renderWithTemplate();
    }
    // ---------------------------------------------- Initial input mode -------------------------------
    private function GetDataForInputDisplay($dataType=1, $rowID=null) {
		// Selection for masterdata object.
		$this->load->model('masterdata/masterdataUser_m', 'oMasterdata_m');

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
		$this->load->model('masterdata/masterdataUser_m', 'oMasterdata_m');

		// Save data to DB.
		$result = $this->oMasterdata_m->Save($rowID, $dsSave);
    	
    	return $result;
	}
// End Private function.
}
