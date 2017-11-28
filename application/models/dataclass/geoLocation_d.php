<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GeoLocation_d extends CI_Model {
	// Property.
    public $tableName = "geo_location";
    public $colId = "id";
    public $colLatitude = "Lat";
    public $colLongitude = "Lon";
    public $colGeolocation = "Geolocation";
    public $colImagePath = "Image_Path";
    public $colFkIccCard = "FK_ICC_Card";
    public $colActive = "Active";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";
    

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
