<?php
/**
 * Add new ghosts.
 * @author James Chambers <jameschambers2@gmail.com>
 * @package spoopserv
 */
require 'jsend.php';
require 'mongo.php';

/* Get ghosts collection from MongoDB */
$collection = $db->ghosts;

/* Cast all POST values to strings to prevent query injection */
$cleanPOST = params_to_string($_POST);

/* Make sure all fields are defined */
$params = array($cleanPOST['name'], $cleanPOST['user'],
	  $cleanPOST['longitude'], $cleanPOST['latitude'],
	  $cleanPOST['drawable']);
foreach($params as $param) {
  if(empty(trim($param))) {
    jsend_message(JSEND_FAIL, "Not all fields were supplied");
    exit();
  }
}

/* Make sure coordinates are numeric */
if(!is_numeric($cleanPOST['longitude']) || !is_numeric($cleanPOST['latitude'])) {
  jsend_message(JSEND_FAIL, "Invalid coordinates");
  exit();
}

/* See if a ghost with the desired name already exists */
$query = array("name" => $cleanPOST['name']);

$cursor = $collection->find($query);
if($cursor->count(true) > 0) {
  jsend_message(JSEND_FAIL, "Name taken");
  exit();
} else {
  $doc = array(
      "name" => $cleanPOST['name'],
      "user" => $cleanPOST['user'],
      "drawable" => $cleanPOST['drawable'],
      "loc" => array(
          "type" => "Point",
	  "coordinates" => array(
	      floatval($cleanPOST['longitude']), 
	      floatval($cleanPOST['latitude'])
	  )
      )
  );

  $collection->insert($doc);

  jsend_message(JSEND_SUCCESS, "Ghost added");
  exit();
}

?>