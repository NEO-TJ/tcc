<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventImage extends MY_Controller {
// Property.
	private $dataTypeName = "ภาพกิจกรรม";
	private $inputModeName = [1 => 'เพิ่มข้อมูล', 2 => 'แก้ไข'];

	private $iccCardId = -1;
	private $imageUploadPath = "uploads/Event_Images";
	private $hasIccCardId = true;
// End property.




// Constructor.
	function __construct() {
		parent::__construct();
		$this->routingCode = 4;
		
		/* Standard Libraries */
		//$this->load->database();
		/* ------------------ */
		
		//$this->load->library('image_CRUD');
	}
// End Constructor.



// Method start.
	function index() {
		$this->gallery();
	}	
// End Method start.




// Routing function.
    // ---------------------------------------------------------------------------------------- For display
	public function gallery() {
		// Prepare data of view.
		$this->data = $this->GetDataForRenderViewPage();

		// Set data and template config for render.
		$this->RenderGalleryWithTemplate();
	}
	public function manipulate() {
		if(!($this->is_logged())) {exit(0);}

		//		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			// Prepare data of view.
		//	$iccCardId = $this->input->post('iccCardId');
		
			// Prepare data of view.
		//	$this->data = $this->GetDataForRenderManagePage();

			// Breadcrumb.
			$this->routingCode = 4.1;
			// Set data and template config for render.
		//	$this->RenderGalleryWithTemplate();
		//}
	}
// End Routing function.




// Private function.
	// ---------------------------------------------------------------------------------------- Upload Image.
	public function upload_multiple($iccCardId=null) {
		// Upload multiply.
		if(isset($_FILES['userfile']) && $_FILES['userfile']['error'] != '4') {
            $files = $_FILES;
            $count = count($_FILES['userfile']['name']); // count element 
            for($i=0; $i<$count; $i++) {
			// Initial file obj.
                $_FILES['userfile']['name']= $files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
				$_FILES['userfile']['size']= $files['userfile']['size'][$i];
			// Initial path file&folder.
                $config['upload_path'] = './uploads/Event_Images/';
				$target_path = './uploads/Event_Images/thumbs/';
			// Config file type, size save method.
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '20000'; //limit 1 mb
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $config['max_width'] = '2560';// image max width 
				$config['max_height'] = '1440';
			// Push Config to library.
                $this->load->library('upload', $config);
				$this->upload->initialize($config);
			// Upload file.
				$resultUpload = $this->upload->do_upload('userfile');
			// Validate upload file.
                if(!$resultUpload) {
			// Can't upload file : send UI for inform user.
					$error = array('upload_error' => $this->upload->display_errors());
					$this->session->set_flashdata('error',  $error['upload_error']); 
					echo $files['userfile']['name'][$i].' '.$error['upload_error']; exit;
				} else {
			// Success upload file : Prepare upload file info for insert to database.
            	    $fileName = $_FILES['userfile']['name'];
					$data = array('upload_data' => $this->upload->data()); 

			// Thumnail : Resize Image.
				// Thumpnail : Initial path file&folder.
					$path=$data['upload_data']['full_path'];
					$q['name']=$data['upload_data']['file_name'];
				// Thumpnail : Config file type, size save method.
					$configi['image_library'] = 'gd2';
					$configi['source_image']   = $path;
					$configi['new_image']   = $target_path;
					$configi['maintain_ratio'] = TRUE;
					$configi['width']  = 250; // new size
					$configi['height'] = 250;
				// Thumpnail : Push Config to library.
					$this->load->library('image_lib');
					$this->image_lib->initialize($configi);
				// Thumpnail : Resize file.
					$this->image_lib->resize();
				// I don't know.
					$images[] = $fileName;

				// Save info to.
					$image_upload = array('priority' => 0, 'FK_ICC_Card' => 20, 'image_URL' => $fileName);
					$this ->db->insert('event_image',$image_upload); 
				}			
            }
        }
        redirect(site_url('eventImage'));
	}

	private function GetDataForRenderViewPage() {
		// Get Event image Form Post Method.
		$this->load->model("eventImage_m");
		$data['all_image'] = $this->eventImage_m->GetEventImage(null, 20);

		return $data;
	}
	// ---------------------------------------------------------------------------------------- End Upload Image.











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

	private function GetDataForRenderViewPage1() {
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
//var_dump($this->data);exit(0);
		// Prepare Template.
		$this->extendedCss = 'backend/eventImage/view/extendedCss_v';
		$this->body = 'backend/eventImage/view/body_v';
		$this->footer = 'backend/eventImage/view/footer_v';
		$this->extendedJs = 'backend/eventImage/view/extendedJs_v';
		$this->renderWithTemplate();
	}
// End Private function.
}