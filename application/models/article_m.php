<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_m extends CI_Model {
// Constructor.
	public function __construct() {
        parent::__construct();
	}
// End Constructor.


// Public function.
	// CRUD - R.
	public function GetArticle($articleTypeId=null, $articleCategoryId=null, $articleId=null
								, $limitCount=null, $limitStart=0) {
		$this->load->model("dataclass/article_d");
		$this->load->model("dataclass/articleCategory_d");
		$this->load->model("dataclass/articleType_d");
		$this->load->model("db_m");

		// Create sql Where.
		$sqlWhere = $this->CreateSqlWhere($articleTypeId, $articleCategoryId, $articleId);
		
		// Create sql Limit.
		$sqlLimit = $this->CreateSqlLimit($limitCount, $limitStart);
		
		// Create sql query.
		$sqlStr = "SELECT a." . $this->article_d->colId
				. ", a." . $this->article_d->colTitle
				. ", a." . $this->article_d->colCaption
				. ", a." . $this->article_d->colHeader
				. ( ($limitCount == 1) ? (", a." . $this->article_d->colContent) : "" )
				. ", a." . $this->article_d->colThumbnailUrl
				. ", a." . $this->article_d->colPublishDate
				. " FROM " . $this->article_d->tableName . " AS a"

				. " LEFT JOIN " . $this->articleCategory_d->tableName . " AS ac"
				. " ON a." . $this->article_d->colFkArticleCategory . "=ac." . $this->articleCategory_d->colId

				. " LEFT JOIN " . $this->articleType_d->tableName . " AS at"
				. " ON ac." . $this->articleCategory_d->colFkArticleType . "=at." . $this->articleType_d->colId


				. $sqlWhere
				. " ORDER BY a." . $this->article_d->colPublishDate
				. ", at." . $this->articleType_d->colName
				. ", ac." . $this->articleCategory_d->colName
				. ", a." . $this->article_d->colTitle
				. $sqlLimit;
		// Execute sql.
		$this->load->model('db_m');
		$dataSet = $this->db_m->GetRow($sqlStr);

    	return $dataSet;
	}

	public function GetDataForComboBox($articleTypeId=null) {
		$result['dsArticleCategory'] = $this->GetArticleCategoryToList($articleTypeId);

		return $result;
	}
	// End CRUD - R.

// End Public function.



// Private function.
	private function GetArticleCategoryToList($articleTypeId=null) {
		$this->load->model("dataclass/articleCategory_d");
		$this->load->model("db_m");

		// Create sql Where.
		$sqlWhere = ( (is_null($articleTypeId) || ($articleTypeId==0)) 
					? "" : " WHERE " . $this->articleCategory_d->colFkArticleType . "=" . $articleTypeId );

		// Create sql query.
		$sqlStr = "SELECT " . $this->articleCategory_d->colId
				. ", " . $this->articleCategory_d->colTitle
				. ", " . $this->articleCategory_d->colName
				. ", " . $this->articleCategory_d->colFkArticleType

				. " FROM " . $this->articleCategory_d->tableName

				. $sqlWhere
				. " ORDER BY " . $this->articleCategory_d->colName;
		// Execute sql.
		$this->load->model('db_m');
		$dataSet = $this->db_m->GetRow($sqlStr);

		return $dataSet;
	}


	private function CreateSqlWhere($articleTypeId=null, $articleCategoryId=null, $articleId=null) {
		$this->load->model("dataclass/article_d");
		$this->load->model("dataclass/articleCategory_d");
		$this->load->model("dataclass/articleType_d");

		// Create sql Where.
		$sqlWhere = " WHERE a." . $this->article_d->colPublishDate . " < NOW()";

		$sqlWhere .= ( (is_null($articleTypeId) || ($articleTypeId==0)) 
					? "" : " AND at." . $this->articleType_d->colId . "=" . $articleTypeId );
		
		$sqlWhere .= ( (is_null($articleCategoryId) || ($articleCategoryId==0)) 
					? "" : " AND ac." . $this->articleCategory_d->colId . "=" . $articleCategoryId );

		$sqlWhere .= ( (is_null($articleId) || ($articleId==0)) 
					? "" : " AND a." . $this->article_d->colId . "=" . $articleId );

		return $sqlWhere;
	}

	private function CreateSqlLimit($limitCount=null, $limitStart=0) {
		$sqlLimit = ( !is_null($limitCount) ? (" LIMIT " . $limitStart . ", " .$limitCount) : "" );

		return $sqlLimit;
	}
// End Private function.
}