<?php
/**
* Description:	This is a class for member.
* Author:		Joken Villanueva
* Date Created:	Nov. 2, 2013
* Revised By:		
*/
require_once(LIB_PATH.DS.'database.php');
class Reservation{
	public $id;
	protected static $tbl_name = "tblreservation";
	function db_fields(){
		global $mydb;
		return $mydb->getFieldsOnOneTable(self::$tbl_name);
	}
	function listOfreservation($withAdds=false){
		global $mydb;
		if (!$withAdds) {
			$mydb->setQuery("Select * from ".self::$tbl_name);
		} else {
			$mydb->setQuery("Select * from ".self::$tbl_name . " LEFT JOIN `tblaccomodation` ON `tblaccomodation`.`ACCOMID` = `tblreservation`.`ACCOMOID` WHERE `REMARKS` = ''");
		}
		$cur = $mydb->loadResultList();
		return $cur;
	
	}
	function single_reservation($id=0){
			global $mydb;
			$mydb->setQuery("SELECT * FROM ".self::$tbl_name." Where `RESERVEID`= {$id} LIMIT 1");
			$cur = $mydb->loadSingleResult();
			return $cur;
	}
	function singleByCode( $code ) {
		global $mydb;
		$mydb->setQuery("SELECT * FROM ".self::$tbl_name." LEFT JOIN `tblaccomodation` ON `tblaccomodation`.`ACCOMID` = `tblreservation`.`ACCOMOID` WHERE `REMARKS` = '' AND `CONFIRMATIONCODE`= '".$code."' LIMIT 1");
		$cur = $mydb->loadSingleResult();
		return $cur;
	}

	function additional_reservations($code) {
		global $mydb;
		// $mydb->setQuery("SELECT * FROM ".self::$tbl_name." Where `CONFIRMATIONCODE`= '".$code."' AND `REMARKS` = 'additional'");
		$mydb->setQuery("SELECT DISTINCT `ACCOMOID`, SUM(`accom_qty`) as `qty`, (SUM(`accom_qty`) * `tblaccomodation`.`price`) as `total_price`, `tblaccomodation`.`ACCOMODATION`, `tblaccomodation`.`ACCOMDESC`, `tblaccomodation`.`max_person_included`, `tblaccomodation`.`price` from `tblreservation` LEFT JOIN `tblaccomodation` ON `tblaccomodation`.`ACCOMID` = `tblreservation`.`ACCOMOID` WHERE `tblreservation`.`CONFIRMATIONCODE` = '".$code."' AND `tblreservation`.`REMARKS` = 'additional' GROUP BY `ACCOMOID`");
		$cur = $mydb->loadResultList();
		return $cur;
	}

	function reservationsByCode( $code ) {
		global $mydb;
		$mydb->setQuery("Select * from " . self::$tbl_name . " WHERE `CONFIRMATIONCODE` = '".$code."'");
		$cur = $mydb->loadResultList();
		return $cur;
	}
	function getStatusByCode ( $code ) {
		global $mydb;
		$mydb->setQuery("Select STATUS from " . self::$tbl_name . " WHERE `CONFIRMATIONCODE` = '".$code."' LIMIT 1");
		$cur = $mydb->loadSingleResult();
		return $cur;
	}

	function getPayments ($code) {
		global $mydb;
		$mydb->setQuery("Select * from tblpay WHERE `confirmation_code` = '".$code."'");
		$cur = $mydb->loadResultList();
		return $cur;
	}

	function insertPayment ($code, $payment) {
		global $mydb;
		$mydb->setQuery("INSERT INTO `tblpay` (`confirmation_code`, `payment`) VALUES ('".$code."','".$payment."')" );
		try {
			// var_dump($sql, $mydb->insert_id());
			if($mydb->executeQuery()) {
				$this->id = $mydb->insert_id();
				return true;
			} else {
				return false;
			}
		} catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}

	function searchReports($text_search, $status, $start_date, $end_date) {
		global $mydb;
		$mydb->setQuery("Select * from tblreservation LEFT JOIN `tblaccomodation` ON `tblaccomodation`.`ACCOMID` = `tblreservation`.`ACCOMOID` WHERE `REMARKS` = '' AND DATE(`ARRIVAL`) >=  '".$start_date."' AND DATE(`DEPARTURE`) <=  '".$end_date."' AND STATUS='" .$status."' AND CONCAT( `tblaccomodation`.`ACCOMODATION`, ' ', `tblaccomodation`.`ACCOMDESC`) LIKE '%" .$text_search ."%'");
		$reserves = $mydb->loadResultList();
		foreach ($reserves as $res) {
			$reservation = new Reservation();
			$res->adds = $reservation->additional_reservations($res->CONFIRMATIONCODE);
		}
		
		return $reserves;
	}

	function markAsPaid($code) {
		global $mydb;
		$sql = "UPDATE `tblreservation` SET `paid` = 1 WHERE `CONFIRMATIONCODE` = '".$code."' AND `REMARKS` = ''";
		$mydb->setQuery($sql);
		if(!$mydb->executeQuery()) return false; 	
		return true;
	}
 	 

	
	/*---Instantiation of Object dynamically---*/
	static function instantiate($record) {
		$object = new self;

		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		} 
		return $object;
	}
	
	
	/*--Cleaning the raw data before submitting to Database--*/
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  global $mydb;
	  $attributes = array();
	  foreach($this->db_fields() as $field) {
	    if(property_exists($this, $field)) {
			$attributes[$field] = $this->$field;
		}
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $mydb;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $mydb->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	
	/*--Create,Update and Delete methods--*/
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $mydb;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".self::$tbl_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  $mydb->setQuery($sql);
	try {
		// var_dump($sql, $mydb->insert_id());
		if($mydb->executeQuery()) {
	    $this->id = $mydb->insert_id();
	    return true;
	  } else {
	    return false;
			
	  }
	} catch (\Exception $e) {
		var_dump($e->getMessage());
	}
	 

	}

	public function update_resevation($code='') {
		global $mydb;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$tbl_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE CONFIRMATIONCODE='". $code . "'";
		$mydb->setQuery($sql);
		if(!$mydb->executeQuery()) return false; 	
		
	}

	public function update($id=0) {
	  global $mydb;
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$tbl_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE RESERVEID=". $id;
	  $mydb->setQuery($sql);
	 	if(!$mydb->executeQuery()) return false; 	
		
	}

	public function delete($id=0) {
		global $mydb;
		  $sql = "DELETE FROM ".self::$tbl_name;
		  $sql .= " WHERE RESERVEID=". $id;
		  $sql .= " LIMIT 1 ";
		  $mydb->setQuery($sql);
		  
			if(!$mydb->executeQuery()) return false; 	
	
	}
		
}
?>