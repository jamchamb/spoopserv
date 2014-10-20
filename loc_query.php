<?php
/**
 * Get ghosts near a location.
 * @author James Chambers <jameschambers2@gmail.com>
 * @package spoopserv
 */
require 'jsend.php';
require 'mongo.php';

/* Get ghosts collection */
$collection = $db->ghosts;

?>