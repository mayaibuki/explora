<?php
include_once 'admin-class.php';
$admin = new itg_admin();
$admin->_authenticate();
include_once '../functions.php';

$id = $_GET['id'];
$pid = $_GET['rid'];
$return_url = base64_decode($_GET["return_url"]);
$result = $mysqli->query("DELETE FROM related_product WHERE (product_id='$id' AND product_id_r='$pid') OR (product_id='$pid' AND product_id_r='$id')") or die('Could not query:' . mysqli_error());

header('Location:'.$return_url);