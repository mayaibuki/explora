<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('../functions.php');
include_once 'db_con.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
		$code = $link->real_escape_string($_POST['code']);
		$valid_since = date('Y-m-d H:i:s', strtotime($_POST['valid_since']));
		$valid_thru = date('Y-m-d H:i:s', strtotime($_POST['valid_thru']));
		$discount_price = $_POST['discount_price'];
		$discount_percentage = $_POST['discount_percentage'];
		$query = "INSERT INTO codes SET code='$code', valid_since='$valid_since', valid_thru='$valid_thru', discount_price='$discount_price', discount_percentage='$discount_percentage'";
		$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));
} else{
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		if($_GET['delete']){
			$query = "DELETE FROM codes WHERE code_id='$id'";
			$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));

		} else {

		}
	}
}

if ($result) {
	header("location: index.php");
}