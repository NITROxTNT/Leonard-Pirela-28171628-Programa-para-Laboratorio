<?php 
//$conexion = new mysqli ("localhost","id18687524_admin","0Y#NYtX%eRNFD60n","id18687524_bddpozos");
$conexion = new mysqli ("localhost","root","","bddlaboratorio");
if ($conexion -> connect_errno) {
    echo json_encode("Failed to connect to MySQL: " . $mysqli -> connect_error);
    exit(); die();
  }

?>