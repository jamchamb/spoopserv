<?php
/**
 * Connect to MongoDB.
 * @author James Chambers <jameschambers2@gmail.com>
 * @package spoopserv
 */
$m = new MongoClient();
$db = $m->spoopdb;

/**
 * Transform MongoDB ID object into simple "id" field.
 * @param Object $doc MongoDB document
 */
function transform_id(&$doc) {
  $doc["id"] = $doc["_id"]->{'$id'};
  unset($doc["_id"]);
}

/**
 * Format Ghost for output.
 * @param Object $ghost Ghost to format
 */
function transform_ghost(&$ghost) {
  /* Put the object ID into "id" field */
  transform_id($ghost);

  /* Convert the GeoJSON field to what the client expects
   * right now (temporary?) */
  $ghost["location"] = array(
    "longitude" => $ghost["loc"]["coordinates"][0],
    "latitude" => $ghost["loc"]["coordinates"][1]
  );
  unset($ghost["loc"]);
}

?>

