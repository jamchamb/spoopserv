<?php
include("mongo.php");

// JSON content header
header('Content-Type: application/json');

// Get 'ghosts' collection and add them all to an array
$collection = $db->ghosts;

$result = array();
$cursor = $collection->find();
foreach($cursor as $ghost) {
  $ghost["id"] = $ghost["_id"]->{'$id'};
  unset($ghost["_id"]);
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

