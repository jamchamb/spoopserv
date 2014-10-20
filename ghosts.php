<?php
/**
 * List all ghosts.
 * @author James Chambers <jameschambers2@gmail.com>
 * @package spoopserv
 */
require 'jsend.php';
require 'mongo.php';

/* Get ghosts collection */
$collection = $db->ghosts;

/* Add all ghosts to an array */
$result = array();
$cursor = $collection->find();
foreach($cursor as $ghost) {
  /* Put the object ID into "id" field */
  $ghost["id"] = $ghost["_id"]->{'$id'};
  unset($ghost["_id"]);
  
  /* Convert the GeoJSON field to what the client expects
   * right now (temporary?)  */
  $ghost["location"] = array(
    "longitude" => $ghost["loc"]["coordinates"][0],
    "latitude" => $ghost["loc"]["coordinates"][1]
  );
  unset($ghost["loc"]);

  $result[] = $ghost;
}

/* Output them all in JSend format */
$data = array("ghosts" => $result);
jsend_response(JSEND_SUCCESS, $data);

?>

