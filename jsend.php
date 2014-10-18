<?php
/**
 * Send JSend responses.
 * @author James Chambers <jameschambers2@gmail.com>
 * @package spoopserv
 */

/* JSON content header - must be declared before any output */
header('Content-Type: application/json');

/* JSend status constants */
define("JSEND_SUCCESS", "success");
define("JSEND_FAIL", "fail");
define("JSEND_ERROR", "error");

/** 
 * Send JSON response.
 * @param String $status The JSend status (success, fail, error)
 * @param Array $data Associative array with response data
 */
function jsend_response($status, $data) {
  $response = array();
  $response["status"] = $status;
  $response["data"] = $data;

  echo json_encode($response);
}

/**
 * Send JSON response that just contains a message.
 * @param String $status The JSend status (success, fail, error)
 * @param Array $data Associative array with response data
 */
function jsend_message($status, $message) {
  $data = array();
  $data["message"] = $message;
  jsend_response($status, $data);
}

?>