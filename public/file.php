<?php
require_once '../app/bootstrap.php';

$path = $_GET["path"];
$search = 'uploads' ;
$pathnew = str_replace($search, '', $path) ;

if( isset($_SESSION['logged_in'])){
	header('X-Accel-Redirect: /uploads/' . $pathnew);
	header('Content-Type:');
}

else{
	header("Location: ");
}
?>
