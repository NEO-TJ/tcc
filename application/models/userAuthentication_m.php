<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserAuthentication_m extends CI_Model {
// Public Property.
    public $id;
    public $userId;
    public $password;
    public $fkIdEmployee;
    public $level;
    public $active;
    public $createDate;
    public $updateDate;
// End Public Property.



// Constructor.
	public function __construct() {
        parent::__construct();
    }
// End Constructor.


// Public function.
    // ------------------------------------------------- Validate --------------------------------------
    public function Validate() {
		$this->load->model('dataclass/user_d');
		$this->load->model('db_m');

        $this->db_m->tableName = $this->user_d->tableName;
        $arrWhere = [
					$this->user_d->colUserId   => $this->userId,
					$this->user_d->colPassword => $this->password,
					$this->user_d->colActive   => '1'
        ];
		$result = $this->db_m->GetRowWhere($arrWhere);

        return $result;
    }
// End Public function.
}
