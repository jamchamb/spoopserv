<?php
include("mongo.php");

// JSON content header
header('Content-Type: application/json');

/*
echo $_GET["name"]."\n";
echo $_GET["user"]."\n";
echo $_GET["longitude"]."\n";
echo $_GET["latitude"]."\n";
*/

// Get ghosts collection
$collection = $db->ghosts;

if(!(isset($_GET['name']) && isset($_GET['user']) && isset($_GET['longitude']) && isset($_GET['latitude']))) {
    $result = array(
		    "status" => "fail",
		    "data" => array(
				    "message" => "Not all fields were supplied"
				    )
		    );
    echo json_encode($result);
  } else {
  $doc = array("name" => $_GET['name'], "user" => $_GET['user'], "location" => array("longitude"=>$_GET['longitude'], "latitude"=>$_GET['latitude']));
  $collection->insert($doc);
    $result = array("status" => "success",
		    "data" => array(
				    "message" => "Ghost added"
				    )
		    );
    echo json_encode($result);
  }


?>
