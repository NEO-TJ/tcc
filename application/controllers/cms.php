<?php
class Cms extends MY_Controller {
// Property.
	private $dataTypeName = [1 => "ข่าวสารโครงการ"];
	private $inputModeName = [1 => 'เพิ่มข้อมูล', 2 => 'แก้ไข'];
	private $paginationLimit = 20;

	private $articleTypeId = 1;
	private $articleCategoryId = 0;
// End Property.


// Constructor.
    public function __construct() {
        parent::__construct();
    }
// End Constructor.




// Method start.
    public function index() {
		if(!($this->is_logged())) {exit(0);}

		$this->View();
	}
// End Method start.



// Public function.
    // ------------------------------------------------- For display -----------------------------------
	public function view() {
		if(!($this->is_logged())) {exit(0);}

		// Prepare data of view.
		$this->data = $this->GetDataForViewDisplay();
		// Caption.
		$this->data['dataTypeName'] = $this->dataTypeName[$this->articleTypeId];;
		
		// Prepare Template.
		$this->extendedCss = 'backend/cms/list/extendedCss_v';
		$this->body = 'backend/cms/list/body_v';
		$this->extendedJs = 'backend/cms/list/extendedJs_v';
		$this->renderWithTemplate();
	}
	public function addNew() {
		if(!($this->is_logged())) {exit(0);}

		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$inputMode = 1;
			$rowID = null;

			$this->SetInputDisplay($inputMode, $rowID);
		}
	}
	public function edit() {
		if(!($this->is_logged())) {exit(0);}

		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$rowID = $this->input->post('rowID');
			$inputMode = 2;

			$this->SetInputDisplay($inputMode, $rowID);
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
    // ---------------------------------------------- Initial view mode --------------------------------
	private function GetDataForViewDisplay() {
		$this->load->model("cms_m");
		$data['dsView'] = $this->cms_m->GetDataForViewDisplay();

		return $data;
	}

    // -------------------------------------------- Set input display mode -----------------------------
	private function SetInputDisplay($inputMode=1, $rowID=null) {
		// Prepare data of view.
		$this->data = $this->GetDataForInputDisplay($rowID);
		// Caption.
		$this->data['dataTypeName'] = $this->dataTypeName[$this->articleTypeId];;
		$this->data['inputModeName'] = $this->inputModeName[$inputMode];
		// Input Mode.
		$this->data['inputMode'] = $inputMode;

		// Prepare Template.
		$this->extendedCss = 'backend/cms/input/extendedCss_v';
		$this->header = 'backend/cms/input/header_v';
		$this->body = 'backend/cms/input/body_v';
		$this->footer = 'backend/cms/input/footer_v';
		$this->extendedJs = 'backend/cms/input/extendedJs_v';
		$this->renderWithTemplate();
	}
    // ---------------------------------------------- Initial input mode -------------------------------
	private function GetDataForInputDisplay($rowID=null) {
		$this->load->model('cms_m');

		// Set array data for View part.
		if(($rowID == null) || ($rowID == 0)) {
			$result['dsInput'] = $this->cms_m->GetTemplateForInputDisplay();
		} else {
			$dataSet = $this->cms_m->GetDataForInputDisplay($rowID);
			$result['dsInput'] = ((count($dataSet) > 0) ? $dataSet 
								: $this->cms_m->GetTemplateForInputDisplay());
		}

		// Get DataSet to combobox.
		$this->load->model('dataclass/article_d');
		$dsComboBox = $this->cms_m->GetDataForComboBox();
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

    	$rowID = $dsSave['rowID'];
    	unset($dsSave['rowID']);

		// Selection for masterdata object.
		$this->load->model('cms_m');

		// Save data to DB.
		$result = $this->cms_m->Save($rowID, $dsSave);
    	
    	return $result;
	}




	private function GetSpecialChar($articleId=1) {
		$this->load->model('article_m');
		$result = $this->article_m->GetArticle(null, null, $articleId, 1);
		$data["article"] = ( (count($result) > 0) ? $result[0] : null );

		return $data;
	}

// End Private function.
}