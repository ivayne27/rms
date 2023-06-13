<?php
/**
* Description:	This is a class for member.
* Author:		Joken Villanueva
* Date Created:	Nov. 2, 2013
* Revised By:		
*/
require_once(LIB_PATH.DS.'database.php');
class Accomodation{
	
	protected static $tbl_name = "tblaccomodation";
	function db_fields(){
		global $mydb;
		return $mydb->getFieldsOnOneTable(self::$tbl_name);
	}
	function listOfaccomodation(){
		global $mydb;
		$mydb->setQuery("Select * from ".self::$tbl_name);
		$cur = $mydb->loadResultList();
		return $cur;
	
	}

	function listOfaccomodationNotIn($id=0){
		global $mydb;
		$mydb->setQuery("Select * from  `tblaccomodation` Where `ACCOMID` <> {$id}" );
		$cur = $mydb->loadResultList();
		return $cur;
	
	}
	function single_accomodation($id=0){
			global $mydb;
			$mydb->setQuery("SELECT * FROM ".self::$tbl_name." Where `ACCOMID`= {$id} LIMIT 1");
			$cur = $mydb->loadSingleResult();
			return $cur;
	}
	function find_all_accomodation($name=""){
			global $mydb;
			$mydb->setQuery("SELECT * 
							FROM  ".self::$tbl_name." 
							WHERE  `ACCOMODATION` ='{$name}'");
			$cur = $mydb->executeQuery();
			$row_count = $mydb->num_rows($cur);//get the number of count
			return $row_count;
	}

	function accomodationIsWholeResort($accom_id) {
		global $mydb;
			$mydb->setQuery("SELECT * FROM ".self::$tbl_name." Where `ACCOMID`= {$accom_id} LIMIT 1");
			$cur = $mydb->loadSingleResult();
			if ($cur->max_person_included >= 50) {
				return true;
			}

			return false;
			// var_dump($cur,'awews');die;
			// return $cur;
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
	echo $mydb->setQuery($sql);
	
	 if($mydb->executeQuery()) {
	    $this->id = $mydb->insert_id();
	    return true;
	  } else {
	    return false;
	  }
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
		$sql .= " WHERE ACCOMID=". $id;
	  $mydb->setQuery($sql);
	 	if(!$mydb->executeQuery()) return false; 	
		
	}

	public function delete($id=0) {
		global $mydb;
		  $sql = "DELETE FROM ".self::$tbl_name;
		  $sql .= " WHERE ACCOMID=". $id;
		  $sql .= " LIMIT 1 ";
		  $mydb->setQuery($sql);
		  
			if(!$mydb->executeQuery()) return false; 	
	
	}

	public function getAvailableServices($date) {
		global $mydb;
		// $sql = "SELECT `ACCOMID`, `ACCOMODATION`, `tblreservation`.`ARRIVAL`, `tblreservation`.`STATUS`, DATE(`tblreservation`.`ARRIVAL`) as date FROM `tblaccomodation` LEFT JOIN `tblreservation` ON `tblreservation`.`ACCOMOID` = `tblaccomodation`.`ACCOMID` WHERE `tblreservation`.`STATUS` NOT IN ('Checkedin', 'Pending', 'Confirmed') OR `tblreservation`.`STATUS` IS NULL";
		// $sql = "SELECT `ACCOMID`, `ACCOMODATION`, `tblreservation`.`ARRIVAL`, `tblreservation`.`STATUS`, DATE(`tblreservation`.`ARRIVAL`) as date_arrival FROM `tblaccomodation` LEFT JOIN `tblreservation` ON `tblreservation`.`ACCOMOID` = `tblaccomodation`.`ACCOMID` WHERE (DATE(`tblreservation`.`ARRIVAL`) != '".$date."' OR `tblreservation`.`STATUS` IN ('Cancelled','Checkedout')) OR `tblreservation`.`STATUS` IS NULL";
		$sql ="SELECT `ACCOMID`, `ACCOMODATION`, `tblreservation`.`ARRIVAL`, `tblreservation`.`STATUS`, DATE(`tblreservation`.`ARRIVAL`) as date_arrival FROM `tblaccomodation` LEFT JOIN `tblreservation` ON `tblreservation`.`ACCOMOID` = `tblaccomodation`.`ACCOMID`";
		$mydb->setQuery($sql);
		$cur = $mydb->loadResultList();
		// var_dump($cur);

		$remove = [];

		$accomodation = new Accomodation();
		$accoms = $accomodation->listOfaccomodation();
		// var_dump($accoms);

		

		$reservation = new Reservation();
		$reserved = $reservation->getReservedForToday($date);
		
		// if whole resort,
		// remove services
		$findWholeResort = array_filter($reserved, function($res) use($accomodation) {
			return $accomodation->accomodationIsWholeResort($res->ACCOMOID);
		});

		// var_dump($findWholeResort);die;

		if (!empty($findWholeResort)) {
			// remove services;
			return [];
		}

		$reserved_ids = array_column($reserved, 'ACCOMOID');
		
		
		$available_services = array_filter($accoms, function ($accom) use($reserved_ids) {
			return !in_array($accom->ACCOMID, $reserved_ids);
		});

		if (count($accoms) > count($available_services)) {
			// find whole resort
			$wholeResort = array_filter($available_services, function ($service) {
				return $service->max_person_included >= 50;
			});

			if (!empty($wholeResort)) {
				// if not whole resort,
				// remove whole resort in available services.
				$available_services = array_filter($available_services, function ($service) {
					return $service->max_person_included < 50;
				});
			}
		}
		// $available_services = array_filter($cur, function ($c) use ($date, $remove) {
			
		// 	$arrival = date_format(date_create($c->ARRIVAL), 'Y-m-d');
		// 	if ($arrival != $date || $c->STATUS == "Checkedout" || $c->STATUS == NULL) {
		// 		return $c;
		// 	} else {
		// 		array_push($remove, $c->ACCOMID);
		// 	}


		// });
		// var_dump($remove);
		// var_dump($available_services);

		return $available_services;
	
	}
		
}
?>