<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Org_d extends CI_Model {
	// Property.
    public $tableName = "org";
    public $colId = "id";
    public $colDeglon = "deglon";
    public $colDeglat = "deglat";

    public $colUtmx = "utmx";
    public $colUtmy = "utmy";
    public $colUtmz = "utmz";
    public $colUtmp = "utmp";

    public $colGmaplon = "gmaplon";
    public $colGmaplat = "gmaplat";

    public $colDepartment = "department";
    public $colLocation = "location";
    

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
