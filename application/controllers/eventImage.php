<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventImage extends MY_Controller {
// Property.
	private $dataTypeName = "ภาพกิจกรรม";
	private $inputModeName = [1 => 'เพิ่มข้อมูล', 2 => 'แก้ไข'];

	private $iccCardId = -1;
	private $imageUploadPath = "assets/uploads/Event_Images";
	private $hasIccCardId = true;
// End property.




// Constructor.
	function __construct() {
		parent::__construct();
		$this->routingCode = 4;
		
		/* Standard Libraries */
		$this->load->database();
		/* ------------------ */
		
		$this->load->library('image_CRUD');
	}
// End Constructor.



// Method start.
	function index() {
		$this->gallery();
	}	
// End Method start.




// Routing function.
    // ------------------------------------------------- For display -----------------------------------
	public function gallery() {
		// Get IccCardId Form Post Method.
		$this->GetIccCardIdFormPost();

		// Prepare data of view.
		$this->data = $this->GetDataForRenderViewPage();

		// Set data and template config for render.
		$this->RenderGalleryWithTemplate();
	}
	public function galleryAdmin() {
		if(!($this->is_logged())) {exit(0);}

		// Breadcrumb.
		$this->routingCode = 4.1;

		// Get IccCardId Form Post Method.
		$this->GetIccCardIdFormPost();
		
		// Prepare data of view.
		$this->data = $this->GetDataForRenderManagePage();

		// Set data and template config for render.
		$this->RenderGalleryWithTemplate();
	}
// End Routing function.




// Private function.
	private function GetIccCardIdFormPost() {
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$this->iccCardId = $this->input->post('iccCardId');

			$this->load->model('eventImage_m');
			$this->hasIccCardId = ( count($this->eventImage_m->GetIdAndNameIccCard($this->iccCardId) > 0 ) );
		}
		/*
			$path = $this->imageUploadPath;
			if(!is_dir($path)) {				//create the folder if it's not already exists
				mkdir($path, 0755, TRUE);		//  0755 is permission.
			}
		*/
	}

	private function GetDataForRenderViewPage() {
		$image_crud = new image_CRUD();
		
		// Config.
		$image_crud->unset_upload();
		$image_crud->unset_delete();
		
		$image_crud->set_primary_key_field('id');
		$image_crud->set_url_field('Image_URL');
		$image_crud->set_table('event_image')
			->set_relation_field('FK_ICC_Card')
			->set_image_path($this->imageUploadPath);

		return $this->CreateGallery($image_crud);
	}
	private function GetDataForRenderManagePage() {
		$image_crud = new image_CRUD();

		// Config.
		if(!$this->hasIccCardId) {
			$image_crud->unset_upload();
			$image_crud->unset_delete();
		}

		$image_crud->set_primary_key_field('id');
		$image_crud->set_url_field('Image_URL');
		//$image_crud->set_title_field('Caption');
		$image_crud->set_table('event_image')
			->set_relation_field('FK_ICC_Card')
			->set_ordering_field('Priority')
			->set_image_path($this->imageUploadPath);

		return $this->CreateGallery($image_crud);
	}

	private function CreateGallery($image_crud) {
		$objOutputRender = $image_crud->render();
		if(is_null($objOutputRender)){
			$objOutputRender = (object)array('output' => '' , 'js_files' => array() , 'css_files' => array());
		} else {
			$this->useJsTemplate = false;			
		}
		$data['gallery']['html'] = $objOutputRender->output;
		$data['gallery']['css_files'] = $objOutputRender->css_files;
		$data['gallery']['js_files'] = $objOutputRender->js_files;

		return $data;
	}

	private function RenderGalleryWithTemplate() {
		// Data for filter.
		$this->load->model('eventImage_m');
		$this->data['dsFilter'] = $this->eventImage_m->GetIdAndNameIccCard();
		// Data from choose.
		$this->load->model("dataclass/iccCard_d");
		$dsIccCard = $this->eventImage_m->GetIdAndNameIccCard($this->iccCardId);
		$this->data['dsIccCard'] = ( (count($dsIccCard) > 0) ? $dsIccCard
									: ["0" => [
											$this->iccCard_d->colId => -1,
											$this->iccCard_d->colProjectName => "________" 
											] 
									] );
		// Caption.
		$this->data['dataTypeName'] = $this->dataTypeName;
		
		// Prepare Template.
		$this->extendedCss = 'frontend/eventImage/view/extendedCss_v';
		$this->body = 'frontend/eventImage/view/body_v';
		$this->footer = 'frontend/eventImage/view/footer_v';
		$this->extendedJs = 'frontend/eventImage/view/extendedJs_v';
		$this->renderWithTemplate();
	}
// End Private function.
}