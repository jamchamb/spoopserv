<?php
/**
 * Get ghosts near a location.
 * @author James Chambers <jameschambers2@gmail.com>
 * @package spoopserv
 */
require 'jsend.php';
require 'mongo.php';

/* Get ghosts collection */
$collection = $db->ghosts;

/* Cast all POST values to strings to prevent query injection */
$cleanPOST = params_to_string($_POST);

/* Check that coordinate parameters are set */
$params = array($cleanPOST['longitude'], $cleanPOST['latitude']);
foreach($params as $param) {
  if(!isset($param)) {
    jsend_message(JSEND_FAIL, "Must supply coordinates");
    exit();
  } elseif(!is_numeric($param)) {
    jsend_message(JSEND_FAIL, "Invalid coordinates");
    exit();
  }
}

/* Build nearSphere query - get ghosts within 25 meters*/
$query = array();
$query["loc"] = array();
$query["loc"]['$nearSphere'] = array();
$query["loc"]['$nearSphere']['$geometry'] =
  array("type" => "Point",
	"coordinates" => [floatval($cleanPOST['longitude']),
			  floatval($cleanPOST['latitude'])]);
$query["loc"]['$nearSphere']['$maxDistance'] = 25;

/* Format ghosts and put them in an array */
$result = array();
$cursor = $collection->find($query);
foreach($cursor as $ghost) {
  /* Format the ghost for output */
  transform_ghost($ghost);

  $result[] = $ghost;
}

/* Output the ghost array in JSend format */
$data = array("ghosts" => $result);
jsend_response(JSEND_SUCCESS, $data);

?>