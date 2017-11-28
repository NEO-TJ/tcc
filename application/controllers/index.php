<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Controller {
    public function __construct() {
		parent::__construct();
	}

    public function index() {
        $data['useCssTemplate'] = true;
        $data['useJsTemplate'] = true;
        $data['useJsTemplateHeadTag'] = false;
        $data['header'] = false;
        $data['body'] = false;
        $data['footer'] = false;

		// Prepare Template.
		$this->extendedCss = 'frontend/home/view/extendedCss_v';
		$this->body = 'frontend/home/view/body_v';
		$this->extendedJs = 'frontend/home/view/extendedJs_v';
		$this->isHomePage = true;
		$this->renderWithTemplate();	
	}
}
