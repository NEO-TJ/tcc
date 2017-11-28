<?php
class PublicRelations extends MY_Controller {
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
		$this->routingCode = 2;
    }
// End Constructor.




// Method start.
    public function index() {
		$this->articleCategory();
	}
// End Method start.



// Routing function.
    // ------------------------------------- For display list view article -----------------------------
	public function articleCategory() {
		$this->articleTypeId = ( ($this->uri->segment(3) == '') ? $this->articleTypeId : $this->uri->segment(3) );
		$this->articleCategoryId = ( ($this->uri->segment(4) == '') ? $this->articleCategoryId : $this->uri->segment(4) );
		// Prepare data of list.
		$this->data = $this->GetDataForRenderListArticle($this->articleTypeId, $this->articleCategoryId);
		$this->data['articleTypeId'] = $this->articleTypeId;
		$this->data['articleCategoryId'] = $this->articleCategoryId;
		// Caption.
		$this->data['dataTypeName'] = $this->dataTypeName[$this->articleTypeId];
		
		// Prepare Template.
		$this->extendedCss = 'frontend/publicRelations/list/extendedCss_v';
		$this->body = 'frontend/publicRelations/list/body_v';
		$this->extendedJs = 'frontend/publicRelations/list/extendedJs_v';
		$this->renderWithTemplate();
	}

	public function fullContent() {
		$this->articleTypeId = ( ($this->uri->segment(3) == '') ? $this->articleTypeId : $this->uri->segment(3) );
		$articleId = $this->uri->segment(4);
		// Prepare data of list.
		$this->data = $this->GetDataForRenderFullArticle($articleId);
		$this->data['articleTypeId'] = $this->articleTypeId;
		$this->data["dsArticleList"] = $this->GetDataForRenderListArticle($this->articleTypeId, $this->articleCategoryId);
		// Breadcrumb.
		$this->routingCode = 2.1;
		// Caption.
		$this->data['dataTypeName'] = $this->dataTypeName[$this->articleTypeId];
		
		// Prepare Template.
		$this->extendedCss = 'frontend/publicRelations/full/extendedCss_v';
		$this->body = 'frontend/publicRelations/full/body_v';
		$this->extendedJs = 'frontend/publicRelations/full/extendedJs_v';
		$this->renderWithTemplate();
	}
// End Routing function.


// AJAX function.
// End AJAX function.


// Private function.
    // ---------------------------------------- For display list article -------------------------------
	private function GetDataForRenderListArticle($articleTypeId=1, $articleCategoryId=null) {
		$this->load->model('article_m');
		$result['dsArticle'] = $this->article_m->GetArticle($articleTypeId, $articleCategoryId, null, $this->paginationLimit);

		
		// Get DataSet to combobox.
		$dsComboBox = $this->article_m->GetDataForComboBox($articleTypeId);
		if($dsComboBox != null) {
			foreach($dsComboBox as $key => $value) {
				$result[$key] = $value;
			}
		}

		return $result;
	}


    // ---------------------------------------- For display full article -------------------------------
	private function GetDataForRenderFullArticle($articleId=1) {
		$this->load->model('article_m');
		$result = $this->article_m->GetArticle(null, null, $articleId, 1);
		$data["article"] = ( (count($result) > 0) ? $result[0] : null );

		return $data;
	}
// End Private function.
}