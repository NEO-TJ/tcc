<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ArticleType_d extends CI_Model {
// Property.
    public $tableName = "article_type";
    
    public $colId = "id";
    public $colName = "Name";
// End Property

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
