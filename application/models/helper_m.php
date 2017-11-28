<?php
class Helper_m extends CI_Model {
    // Property
    public $count;


    // *************************************************** Helper ************************************************
    // _________________________________________________ Array Tool ______________________________________________
    public function myJsonDecode($serializeArray) {     // convertSerializeArrayToPairArray
        $result = array_combine(array_column($serializeArray, 'name'), array_column($serializeArray, 'value'));

        return $result;
    }




    // _______________________________________________ ICC Card Master ___________________________________________
    public function CreateJoinTableIccCardMaster() {
        $sqlStr = " LEFT JOIN " . $this->cleanupType_d->tableName . " AS ct"
                . " ON c." . $this->iccCard_d->colFkCleanupType
                . "=ct." . $this->cleanupType_d->colId

                . " LEFT JOIN " . $this->distanceUnit_d->tableName . " AS du"
                . " ON c." . $this->iccCard_d->colFkDistanceUnit
                . "=du." . $this->distanceUnit_d->colId

                . " LEFT JOIN " . $this->weightUnit_d->tableName . " AS wu"
                . " ON c." . $this->iccCard_d->colFkWeightUnit
                . "=wu." . $this->weightUnit_d->colId;

        return $sqlStr;
    }


    // __________________________________________________ Criteria _______________________________________________
    public function CreateCriteriaIn($columnName, $arrayDataIN, $criteria, $criteriaPrefix) {
        if(count($arrayDataIN) > 0) {
            $criteria = $this->GenSqlCriteriaIn($columnName, $arrayDataIN, $criteria);
        
            if(strlen($criteria) > 4) {
                $criteria = substr($criteria, 4, strlen($criteria) - 4);
        
                $criteria = $criteriaPrefix.$criteria;
            }
        }
    	
        return $criteria;
    }

    public function GenSqlCriteriaIn($columnName, $arrayDataIN, $criteria) {
    	$criteria = $criteria.' && '.$columnName.' IN (';
    	 
    	for($i=0 ; $i < count($arrayDataIN) ; $i++) {
    		$criteria = $criteria.$arrayDataIN[$i].',';
    	}
    	$criteria = substr($criteria, 0, strlen($criteria) - 1);
    	$criteria = $criteria.')';
    	 
    	return $criteria;
	}


    // ____________________________________________________ Where ________________________________________________
    public function CreateSqlWhere($criteria, $sqlWhere){
		if(($sqlWhere != null) ||  ($sqlWhere != '')) {
			if($criteria == '')	{
				$criteria = ' WHERE '.$sqlWhere;
			} else {
				$criteria = $criteria.' AND '.$sqlWhere;
			}
		}

        return $criteria;
    }

    public function CreateCriteriaWhere($criteria, $colName, $opertor, $value) {
		if(($value != null) || ($value > 0) ||  ($value != '')) {
            $sqlWhere = $colName . $opertor . $value;

			if($criteria == '')	{
				$criteria = ' WHERE '. $sqlWhere;
			} else {
				$criteria = $criteria.' AND '.$sqlWhere;
			}
		}

        return $criteria;
    }
}
?>
