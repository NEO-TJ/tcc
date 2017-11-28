<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_d extends CI_Model {
// Property.
    public $tableName = "article";
    
    public $colId = "id";
    public $colTitle = "Title";
    public $colCaption = "Caption";
    public $colHeader = "Header";
    public $colContent = "Content";
    public $colThumbnailUrl = "Thumbnail_Url";
    public $colFkArticleCategory = "FK_Article_Category";
    public $colMataTagTitle = "Mata_Tag_Title";
    public $colMataTagDescription = "Mata_Tag_Description";
    public $colMataTagKeywords = "Mata_Tag_Keywords";
    public $colPublishDate = "Publish_Date";

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
