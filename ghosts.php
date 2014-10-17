<?php
include("mongo.php");

// JSON content header
header('Content-Type: application/json');

// Get 'ghosts' collection and add them all to an array
$collection = $db->ghosts;

$result = array();
$cursor = $collection->find();
foreach($cursor as $ghost) {
  // Put the object ID into "id" field
  $ghost["id"] = $ghost["_id"]->{'$id'};
  unset($ghost["_id"]);
  
  // Convert the GeoJSON field to what the client expects right now (temporary?)
  $ghost["location"] = array(
    "longitude" => $ghost["loc"]["coordinates"][0],
    "latitude" => $ghost["loc"]["coordinates"][1]
  );
  unset($ghost["loc"]);

  $result[] = $ghost;
}

// Output them all in JSend format
$out = array(
  "status" => "success",
  "data" => array(
    "ghosts" => $result
  )
);

echo json_encode($out);

?>

