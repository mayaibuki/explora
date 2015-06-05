<?php

include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';

$id = $_GET['id'];
$table = $_GET['type'];
$return_url = base64_decode($_GET["return_url"]);
if($table=='product_img'){
	$result = $mysqli->query("DELETE FROM product_img WHERE img_id='$id'") or die('Could not query:' . mysqli_error());
} else{
	$result = $mysqli->query("DELETE FROM how_product_img WHERE img_id='$id'") or die('Could not query:' . mysqli_error());
}

header('Location:'.$return_url);