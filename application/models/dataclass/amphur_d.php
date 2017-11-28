<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amphur_d extends CI_Model {
// Property.
    public $tableName = "amphur";
    
    public $colAmphurCode = "AmphurCode";
    public $colAmphurName = "AmphurName";
    public $colProvinceCode = "ProvinceCode";

    public $colCreateDate = "CreateDate";
    public $colCreateBy = "CreateBy";
    public $colUpdateDate = "UpdateDate";
    public $colUpdateBy = "UpdateBy";

    public $colAmphurLatitude = "AmphurLat";
    public $colAmphurLongitude = "AmphurLong";
// End Property

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
