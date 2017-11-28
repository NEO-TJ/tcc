<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EntangledAnimal_d extends CI_Model {
	// Property.
    public $tableName = "entangled_animal";
	public $colId = "id";
    public $colName = "Name";
    public $colFkAnimalStatus = "FK_Animal_Status";
    public $colEntangledFlag = "Entangled_Flag";
    public $colEntangledDebris = "Entangled_Debris";
    public $colFkIccCard = "FK_ICC_Card";
    public $colActive = "Active";
    public $colDeleteDate = "Delete_Date";
    public $colDeleteBy = "Delete_By";
    

    // Constructor.
	public function __construct() {
        parent::__construct();
    }
}
