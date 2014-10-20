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

/* Format ghosts and put them in an array */
$result = array();
$cursor = $collection->find();
foreach($cursor as $ghost) {
  /* Format the ghost for output */
  transform_ghost($ghost);

  $result[] = $ghost;
}

/* Output the ghost array in JSend format */
$data = array("ghosts" => $result);
jsend_response(JSEND_SUCCESS, $data);

?>

