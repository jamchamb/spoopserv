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

/* Make sure all fields are defined */
$params = array($_POST['name'], $_POST['user'],
	  $_POST['longitude'], $_POST['latitude'],
	  $_POST['drawable']);
foreach($params as $param) {
  if(empty(trim($param))) {
    jsend_message(JSEND_FAIL, "Not all fields were supplied");
    exit();
  }
}

/* Make sure coordinates are numeric */
if(!is_numeric($_POST['longitude']) || !is_numeric($_POST['latitude'])) {
  jsend_message(JSEND_FAIL, "Invalid coordinates");
  exit();
}

/* See if a ghost with the desired name already exists */
$query = array("name" => $_POST['name']);
$cursor = $collection->find($query);

/* Found a ghost with that name already */
if($cursor->count(true) > 0) {
  jsend_message(JSEND_FAIL, "Name taken");
  exit();
}
/* Name not taken, add the ghost */
else {
  $doc = array();
  $doc["name"] = $_POST['name'];
  $doc["user"] = $_POST['user'];
  $doc["drawable"] = $_POST['drawable'];
  $doc["loc"] = array();
  $doc["loc"]["type"] = "Point";
  $doc["loc"]["coordinates"] =
    array(floatval($_POST['longitude']), floatval($_POST['latitude']));

  $collection->insert($doc);

  jsend_message(JSEND_SUCCESS, "Ghost added");
  exit();
}

?>