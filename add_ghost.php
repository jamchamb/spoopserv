<?php
include("mongo.php");

// JSON content header
header('Content-Type: application/json');

// Get ghosts collection
$collection = $db->ghosts;

if(!
   (isset($_POST['name']) &&
    isset($_POST['user']) &&
    isset($_POST['longitude']) &&
    isset($_POST['latitude']) &&
    isset($_POST['drawable'])
    )
   ) {
  $result = 
    array(
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
    $result =
      array("status" => "fail",
	    "data" => array(
			    "message" => "Name taken"
			    )
	    );

    echo json_encode($result);
  } else {
    $doc =
      array(
	    "name" => $_POST['name'], 
	    "user" => $_POST['user'],
	    "drawable" => $_POST['drawable'],
	    "loc" => array(
			   "type" => "Point",
			   "coordinates" => array(floatval($_POST['longitude']), floatval($_POST['latitude']))
		  )
	    );

    $collection->insert($doc);

    $result =
      array("status" => "success",
	    "data" => array(
			    "message" => "Ghost added"
			    )
	    );

    echo json_encode($result);
  }
}

?>