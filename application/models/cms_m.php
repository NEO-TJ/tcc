<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms_m extends CI_Model {
// Constructor.
	public function __construct() {
        parent::__construct();
    }
// End Constructor.




// Public function.
    // ------------------------------------------------------------ Get ------------------------------------------
	// +++ To view +++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function GetDataForViewDisplay($arrId=null, $sqlWhere=null) {
		$this->load->model('dataclass/article_d');
		$this->load->model('dataclass/articleCategory_d');
		$this->load->model('dataclass/articleType_d');

    	$criteria ='';
    	// Prepare Criteria.
		$this->load->model('helper_m');
		if($arrId != null){
			$criteria = $this->helper_m->CreateCriteriaIn('a.'.$this->article_d->colId, $arrId, $criteria, ' WHERE ');
		}
		// Prepare Where.
		$criteria = $this->helper_m->CreateSqlWhere($criteria, $sqlWhere);

		// Create sql string.
		$sqlStr = "SELECT a." . $this->article_d->colId
				. ", at." . $this->articleType_d->colName . " ประเภท"
				. ", ac." . $this->articleCategory_d->colName . " หมวดหมู่"
				. ", a." . $this->article_d->colCaption . " คำบรรยายบทความ"
				. ", a." . $this->article_d->colTitle . " คำอธิบายเสริม"
				. ", a." . $this->article_d->colHeader . " ย่อหน้าแรก"
				. ", DATE_FORMAT(a." . $this->article_d->colPublishDate . ",'%Y-%b-%d') วันที่เผยแพร่"

				. " FROM " . $this->article_d->tableName . " AS a"

				. " LEFT JOIN " . $this->articleCategory_d->tableName . " AS ac"
				. " ON a." . $this->article_d->colFkArticleCategory
				. "=ac." . $this->articleCategory_d->colId

				. " LEFT JOIN " . $this->articleType_d->tableName . " AS at"
				. " ON ac." . $this->articleCategory_d->colFkArticleType
				. "=at." . $this->articleType_d->colId


				. $criteria
				
				. " ORDER BY at." . $this->articleType_d->colName
				. ", ac." . $this->articleCategory_d->colName
				. ", a." . $this->article_d->colPublishDate
				. ", a." . $this->article_d->colCaption;

		// Execute sql.
		$this->load->model('db_m');
		$result = $this->db_m->GetRow($sqlStr);

    	return $result;
    }

	// +++ To input ++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// ///////////////// From Database ///////////////////////////////////
    public function GetDataForInputDisplay($id=null) {
		$this->load->model('dataclass/article_d');
		// Create sql string.
		$sqlStr = "SELECT * FROM " . $this->article_d->tableName
   					." WHERE " . $this->article_d->colId . "=" . $id;

		// Execute sql.
		$this->load->model('db_m');
		$result['dsArticle'] = $this->db_m->GetRow($sqlStr);

		return $result;
	}



	// ///////////////// From Template ///////////////////////////////////
    public function GetTemplateForInputDisplay() {
		// Article.
		$this->load->model('dataclass/article_d');
		$result['dsArticle'][0] = [
				$this->article_d->colId						=> 0,
				$this->article_d->colCaption				=> '',
				$this->article_d->colTitle					=> '',
				$this->article_d->colHeader					=> '',
				$this->article_d->colContent				=> '',
				$this->article_d->colThumbnailUrl			=> '',
				$this->article_d->colFkArticleCategory		=> 0,
				$this->article_d->colMataTagTitle			=> '',
				$this->article_d->colMataTagDescription		=> '',
				$this->article_d->colMataTagKeywords		=> '',
				$this->article_d->colPublishDate			=> 0,
    	];

    	return $result;
	}


    // ----------------------------------------------------- Get For Combobox ------------------------------------
	public function GetDataForComboBox() {
		$result['dsArticleCategory'] = $this->GetDsArticleCategory();
		//$result['dsArticleType'] = $this->GetDsArticleType();
		
		return $result;
	}



	

    // ----------------------------------------------------------- Save ------------------------------------------
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Prepare Data ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
	private function PrepareData($dsData) {
		$this->load->model('dataclass/article_d');

		$rResult['data'] = $dsData;
		$rResult['data']['Publish_Date'] = date('Y-m-d H:i:s', strtotime($rResult['data']['Publish_Date'])); ;
		$rResult['data'][$this->article_d->colUpdateBy] = $this->session->userdata['userId'];

		$rResult['tableName'] = $this->article_d->tableName;
		$rResult['objCreateBy'] = [$this->article_d->colCreateBy => $this->session->userdata['userId']];

		return $rResult;
	}

    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Process Save ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    public function Save($id, $dsData) {
		$rSave = $this->PrepareData($dsData);

		$this->load->model('db_m');
		$result = $this->SaveToDB($id, $rSave);

		return $result;
	}

	public function SaveToDB($id, $rSave) {
		$result = false;
		$this->load->model('db_m');
		if(count($rSave) > 0) {			// validate have data to save.
			$this->db_m->tableName = $rSave['tableName'];
			$result = $this->db_m->Save($id, $rSave['data'], $rSave['objCreateBy']);
		}

		return $result;
	}
// End Public function.





// Private function.
    // ---------------------------------------------------- Get DB to combobox -----------------------------------
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Article Category table ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    private function GetDsArticleCategory($id=null) {
		$this->load->model("dataclass/articleCategory_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->articleCategory_d->tableName;
		$this->db_m->sequenceColumn = $this->articleCategory_d->colName;
		$dataSet = $this->db_m->GetRowById($id, null);
    
    	return $dataSet;
    }
    // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Article Type table ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    private function GetDsArticleType($id=null) {
		$this->load->model("dataclass/articleType_d");
		$this->load->model("db_m");

		$this->db_m->tableName = $this->articleType_d->tableName;
		$this->db_m->sequenceColumn = $this->articleType_d->colName;
		$dataSet = $this->db_m->GetRowById($id, null);
    
    	return $dataSet;
    }
// End Private function.
}