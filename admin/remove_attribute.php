<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';

$id = $_GET['id'];
$pid = $_GET['pid'];
$return_url = base64_decode($_GET["return_url"]);
$result = $mysqli->query("DELETE FROM product_attributes WHERE attribute_id='$id' AND product_id='$pid'") or die('Could not query:' . mysqli_error());

header('Location:'.$return_url);