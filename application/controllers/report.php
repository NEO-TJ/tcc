<?php
class Report extends MY_Controller {
// Property.
	private $captionPage = [1 => "รายงานข้อมูลขยะทะเลในประเทศไทย"];
// End Property.


// Constructor.
    public function __construct() {
		parent::__construct();
		$this->routingCode = 1;
    }
// End Constructor.




// Method start.
    public function index() {
		$this->dashboardReport();
	}
// End Method start.



// Routing function.
    // ------------------------------------- For display ovarview report.
	private function dashboardReport() {
		// Prepare data of view.
		$this->data = $this->GetInitialDashboardReportData();
		

		// Prepare Template.
		$this->extendedCss = 'frontend/report/dashboard/extendedCss_v';
		$this->body = 'frontend/report/dashboard/body_v';
		$this->extendedJs = 'frontend/report/dashboard/extendedJs_v';
		$this->footer = 'frontend/report/dashboard/footer_v';
		$this->renderWithTemplate();
	}
// End Routing function.


///////////////////////////////////////////////// AJAX function.
// Dashboard Report.
	public function ajaxGetDashboardReportData() {
    	if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$rankingLimit = $this->input->post('rankingLimit');
			$strDateStart = $this->input->post('strDateStart');
    		$strDateEnd = $this->input->post('strDateEnd');
			$provinceCode = $this->input->post('provinceCode');
			$provinceCode = ( ($provinceCode > 0 ) ? $provinceCode : null);
			$iccCardId = $this->input->post('iccCardId');
			$iccCardId = ((($iccCardId == "0" ) || ($iccCardId == 0 )) ? null : $iccCardId);

			$this->load->model("report_m");
			$result = $this->report_m->GetDashboardReportData(
				$rankingLimit, $strDateStart, $strDateEnd, $provinceCode, $iccCardId);

    		echo json_encode($result);
    	}
	}
// End Dashboard Report.

// Get data to ComboBox filtered.
	public function ajaxGetProjectFiltered() {
    	if ($this->input->server('REQUEST_METHOD') === 'POST')
    	{
			$provinceCode = $this->input->post('provinceCode');
			$provinceCode = ( ($provinceCode > 0 ) ? $provinceCode : null);
			
			$this->load->model("report_m");
			$dsData = $this->report_m->GetDsProject($provinceCode);

			echo json_encode($dsData);
    	}
	}
// End Get data to ComboBox filtered.
///////////////////////////////////////////////// End AJAX function.


// Private function.
    // ---------------------------------------------- Dashboard Report ----------------------------------
	private function GetInitialDashboardReportData() {
		$this->load->model("report_m");
		$data = $this->report_m->GetDataForComboBox();
		$data["map"] = $this->CreateMap()["map"];

		return $data;
	}

	private function CreateMap($dsMapTransaction=array()) {
		$this->load->library('googlemaps');
		// Config.
		$config['apiKey'] = 'AIzaSyClagICh6L2KDnt5-14byUhE-wBRnjiYeg';
		$config['center'] = '10.3,101';
		$config['zoom'] = '6';
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

		$data['map'] = $this->googlemaps->create_map();

		return $data;
	}
// End Private function.
}