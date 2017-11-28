<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Province_d extends CI_Model {
// Property.
    public $tableName = "province";
    
    public $colProvinceCode = "ProvinceCode";
    public $colProvinceName = "ProvinceName";
    public $colProvinceNameEn = "ProvinceNameEn";
    public $colProvinceShortName = "ProvinceShortName";
    public $colProvinceShortNameEn = "ProvinceShortNameEn";
    
    public $colZoneID = "ZoneID";
    public $colRegionID = "RegionID";
    public $colZoneKey = "ZoneKey";
    public $colZoneServiceKey = "ZoneServiceKey";
    public $colRegionKey = "RegionKey";
    
    public $colProvinceLatitude = "ProvinceLat";
    public $colProvinceLongitude = "ProvinceLong";
    
    public $colCreateDate = "CreateDate";
    public $colCreateBy = "CreateBy";
    public $colUpdateDate = "UpdateDate";
    public $colUpdateBy = "UpdateBy";
// End Property


    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
