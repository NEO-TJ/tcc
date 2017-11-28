<?php
class MapPlace extends MY_Controller {
// Property.
	private $dataTypeName = "แผนที่";
	private $inputModeName = [1 => 'เพิ่มข้อมูล', 2 => 'แก้ไข'];
// End Property.


// Constructor.
    public function __construct() {
		parent::__construct();
		$this->routingCode = 1.1;
    }
// End Constructor.




// Method start.
    public function index() {
		$this->View();
	}
// End Method start.



// Routing function.
    // ------------------------------------------ For display.
	private function view() {
		// Prepare data of view.
		$this->data = $this->GetDataForRenderViewPage();
		// Caption.
		$this->data['dataTypeName'] = $this->dataTypeName;
		
		// Prepare Template.
		$this->extendedCss = 'frontend/mapPlace/view/extendedCss_v';
		$this->body = 'frontend/mapPlace/view/body_v';
		$this->extendedJs = 'frontend/mapPlace/view/extendedJs_v';
		$this->renderWithTemplate();
	}
// End Routing function.




// AJAX function.
// End AJAX function.





// Private function.
    // ---------------------------------------------- Initial view mode --------------------------------
	private function GetDataForRenderViewPage() {
		$this->load->model('mapPlace_m');
		$dsMapTransaction = $this->mapPlace_m->GetDataForViewDisplay();
		$data = $this->CreateMap($dsMapTransaction);

		return $data;
	}

	// ------------------------------------------------- Initial Map -----------------------------------
	private function CreateMap($dsMapTransaction) {
		$this->load->library('googlemaps');
		// Config.
		$config['apiKey'] = 'AIzaSyClagICh6L2KDnt5-14byUhE-wBRnjiYeg';
		$config['center'] = '12.5,100';
		$config['zoom'] = '8';
		$config['cluster'] = TRUE;
			//$config['places'] = TRUE;
		$this->googlemaps->initialize($config);

		// Marker.
		foreach($dsMapTransaction as $row) {
			$marker = array();
			$marker['position'] = $row['Lat'] . "," . $row['Lon'];
			$marker['title']  = $row['Project_Name'];
			$marker['infowindow_content'] = $row['Project_Name'] . "<p>" . $row['totalGarbageQty'];
			$this->googlemaps->add_marker($marker);
		}

	/*
		// Marker.
		$marker = array();
		$marker['position'] = '13.747408,100.540244';
		$marker['title'] = 'A marker title';
		$marker['infowindow_open'] = true;
		$marker['infowindow_content'] = '1 - Hello World!';
		//$marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|9999FF|000000';
		$this->googlemaps->add_marker($marker);
		
		$marker = array();
		$marker['position'] = '13.286008,100.911000';
		$marker['draggable'] = TRUE;
		$marker['animation'] = 'DROP';
		$this->googlemaps->add_marker($marker);
	*/

	/*
		// Polygon.
		$polygon = array();
		$polygon['points'] = array('13.748263, 100.538356',
		'13.747835, 100.540662',
		'13.745126, 100.540115',
		'13.745417, 100.538034');
		$polygon['strokeColor'] = '#000099';
		$polygon['fillColor'] = '#000099';
		$this->googlemaps->add_polygon($polygon);
	*/
		$data['map'] = $this->googlemaps->create_map();

		return $data;
	}
// End Private function.
}