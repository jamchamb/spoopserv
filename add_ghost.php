<?php
include("mongo.php");

// JSON content header
header('Content-Type: application/json');

/*
echo $_POST["name"]."\n";
echo $_POST["user"]."\n";
echo $_POST["longitude"]."\n";
echo $_POST["latitude"]."\n";
*/

// Get ghosts collection
$collection = $db->ghosts;

if(!(isset($_POST['name']) && isset($_POST['user']) && isset($_POST['longitude']) && isset($_POST['latitude']))) {
    $result = array(
		    "status" => "fail",
		    "data" => array(
				    "message" => "Not all fields were supplied"
				    )
		    );
    echo json_encode($result);
  } else {

  $findme = array("name" => $_POST['name']);
  $cursor = $collection->find($findme);
  if($cursor->count(true) > 0) {
    $result = array("status" => "fail",
		    "data" => array(
				    "message" => "Name taken"
				    )
		    );
    echo json_encode($result);
  } else {

  $doc = array("name" => $_POST['name'], "user" => $_POST['user'], "location" => array("longitude"=>$_POST['longitude'], "latitude"=>$_POST['latitude']));
  $collection->insert($doc);
    $result = array("status" => "success",
		    "data" => array(
				    "message" => "Ghost added"
				    )
		    );
    echo json_encode($result);
  }
}

?>
