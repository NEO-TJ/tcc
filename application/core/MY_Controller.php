<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
// Set the class variable.
    private $dataTemplate = array();
    public $data = array();
    public $routingCode = 0;
// End Set the class variable.

// Set default variable.
    public $extendedCss = '';
    public $header = '';
    public $body = '';
    public $footer = '';
    public $extendedJs = '';
// End Set default variable.

// Set default condition variable.
    public $useCssTemplate = true;
    public $useJsTemplate = true;
    public $useJsTemplateHeadTag = false;

    public $isHomePage = false;
// Set default condition variable.


// public method.
    // ************************************************* Load template *********************************
    protected function renderWithTemplate() {
        // Set Breadcrumb.
        $breadcrumb = $this->CreateBreadcrumb();
        // Set default data.
        $this->data['level'] = ( ($this->session->userdata('level')) ? $this->session->userdata('level') : 0 );
        // making temlate and send data to view.
        $this->dataTemplate['breadcrumb'] = $breadcrumb;
        $this->dataTemplate['useCssTemplate'] = $this->useCssTemplate;
        $this->dataTemplate['useJsTemplate'] = $this->useJsTemplate;
        $this->dataTemplate['useJsTemplateHeadTag'] = $this->useJsTemplateHeadTag;

        $this->dataTemplate['extendedCss'] = ((($this->extendedCss != null) && ($this->extendedCss != ''))
            ? $this->load->view($this->extendedCss, $this->data, true) : '');

        $this->dataTemplate['header'] = ((($this->header != null) && ($this->header != ''))
            ? $this->load->view($this->header, $this->data, true) : '');

        $this->dataTemplate['body'] = ((($this->body != null) && ($this->body != ''))
            ? $this->load->view($this->body, $this->data, true) : '');

        $this->dataTemplate['footer'] = ((($this->footer != null) && ($this->footer != ''))
            ? $this->load->view($this->footer, $this->data, true) : '');

        $this->dataTemplate['extendedJs'] = ((($this->extendedJs != null) && ($this->extendedJs != ''))
            ? $this->load->view($this->extendedJs, $this->data, true) : '');

        if($this->isHomePage) {
            $this->load->view('template/index_v', $this->dataTemplate);
        } else {
            $this->load->view('template/index_v', $this->dataTemplate);
        }
    }


	// *************************************************** Check logged ********************************
	protected function is_logged() {
		if(!$this->session->userdata('id')){
			$this->logout();
			return false;
		} else {
			return true;
		}
	}
	protected function logout() {
        $this->session->sess_destroy();
        redirect("index");
    }
    // **************************************************** End logged *********************************
// End public method.

// Private method.
    private function CreateBreadcrumb() {
        $breadcrumb = NULL;
        if($this->routingCode === 1) {                   // Report/index
            $breadcrumb = array(
                [
                    "caption"   => "รายงานข้อมูลขยะทะเล",
                    "link"      => null,
                ],
            );
        } else if($this->routingCode === 1.1) {          // Report/mapPlace
            $breadcrumb = array(
                [
                    "caption"   => "รายงานข้อมูลขยะทะเล",
                    "link"      => "report",
                ],
                [
                    "caption"   => "แผนที่แสดงตำแหน่งกิจกรรม",
                    "link"      => null,
                ]
            );
        } else if($this->routingCode === 2) {            // publicRelations/[index||articleCategory]
            $breadcrumb = array(
                [
                    "caption"   => "ข่าวสารโครงการ",
                    "link"      => null,
                ]
             );
        } else if($this->routingCode === 2.1) {          // publicRelations/fullContent
            $breadcrumb = array(
                [
                    "caption"   => "ข่าวสารโครงการ",
                    "link"      => "publicRelations/articleCategory/1/0",
                ],
                [
                    "caption"   => "เนื้อหา",
                    "link"      => null,
                ]
             );
        } else if($this->routingCode == 4) {             // eventImage/index
            $breadcrumb = array(
                [
                    "caption"   => "ภาพกิจกรรม",
                    "link"      => null,    
                ]
            );
        } else {
            $breadcrumb = NULL;
        }

        return $breadcrumb;
    }
// End private method.
}