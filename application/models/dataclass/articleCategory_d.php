<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ArticleCategory_d extends CI_Model {
// Property.
    public $tableName = "article_category";
    
    public $colId = "id";
    public $colTitle = "Title";
    public $colName = "Name";
    public $colFkArticleType = "FK_Article_Type";

    public $colCreateDate = "Create_Date";
    public $colCreateBy = "Create_By";
    public $colUpdateDate = "Update_Date";
    public $colUpdateBy = "Update_By";
    public $colActive = "Active";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";
// End Property

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
