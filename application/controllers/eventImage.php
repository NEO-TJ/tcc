<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EventImage extends MY_Controller {
// Property.
	private $dataTypeName = "ภาพกิจกรรม";
	private $inputModeName = [1 => 'เพิ่มข้อมูล', 2 => 'แก้ไข'];
// End property.




// Constructor.
	function __construct() {
		parent::__construct();
		$this->routingCode = 4;
	}
// End Constructor.



// Method start.
	function index() {
	}	
// End Method start.




// Routing function.
    // ---------------------------------------------------------------------------------------- For display
	public function manipulate() {
		if(!($this->is_logged())) {exit(0);}

		//if ($this->input->server('REQUEST_METHOD') === 'POST'){
			// Prepare data of view.
			$iccCardId = 18;
			$this->data = $this->GetDataForRenderManipulatePage($iccCardId);
	
			// Breadcrumb.
			$this->routingCode = 4.1;
			// Caption.
			$this->data['dataTypeName'] = $this->dataTypeName;

			// Prepare Template.
			$this->extendedCss = 'backend/eventImage/view/extendedCss_v';
			$this->body = 'backend/eventImage/view/body_v';
			$this->footer = 'backend/eventImage/view/footer_v';
			$this->extendedJs = 'backend/eventImage/view/extendedJs_v';
			$this->renderWithTemplate();
		//}
	}
	// ---------------------------------------------------------------------------------------- Upload Image.
	public function uploadImage() {
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			$iccCardId = $this->input->post('iccCardId');

			$this->uploadImageAndCreateThumpnail($iccCardId);
		}
	}
	// ---------------------------------------------------------------------------------------- End Upload Image.
// End Routing function.



// AJAX function.
// End AJAX function.


// Private function.
	private function GetDataForRenderManipulatePage($iccCardId=null) {
		// Get Event image Form Post Method.
		$this->load->model("eventImage_m");
		$data['dsImage'] = $this->eventImage_m->GetDsEventImage(null, $iccCardId);
		$dsIccCard = $this->eventImage_m->GetDsIccCard($iccCardId);
		$data['iccCardId'] = $iccCardId;
		$data['dsIccCard'] = $dsIccCard;

		return $data;
	}

	private function uploadImageAndCreateThumpnail($iccCardId=null) {
		// Upload multiply.
		if(isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] != '4') {
            $files = $_FILES;
            $count = count($_FILES['imageFile']['name']); // count element 
            for($i=0; $i<$count; $i++) {
			// Initial file obj.
                $_FILES['imageFile']['name']= $files['imageFile']['name'][$i];
                $_FILES['imageFile']['type']= $files['imageFile']['type'][$i];
                $_FILES['imageFile']['tmp_name']= $files['imageFile']['tmp_name'][$i];
                $_FILES['imageFile']['error']= $files['imageFile']['error'][$i];
				$_FILES['imageFile']['size']= $files['imageFile']['size'][$i];
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
				$resultUpload = $this->upload->do_upload('imageFile');
			// Validate upload file.
                if(!$resultUpload) {
			// Can't upload file : send UI for inform user.
					$error = array('upload_error' => $this->upload->display_errors());
					$this->session->set_flashdata('error',  $error['upload_error']); 
					echo $files['imageFile']['name'][$i].' '.$error['upload_error']; exit;
				} else {
			// Success upload file : Prepare upload file info for insert to database.
            	    $fileName = $_FILES['imageFile']['name'];
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
					$image_upload = array('priority' => 0, 'FK_ICC_Card' => $iccCardId, 'image_URL' => $fileName);
					$this ->db->insert('event_image',$image_upload); 
				}			
            }
        }
        redirect(site_url('eventImage/manipulate'));
	}
// End Private function.
}