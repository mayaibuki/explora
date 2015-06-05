<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('../functions.php');
include_once 'db_con.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
	$id = $_POST['id'];
	$link->query("UPDATE orders SET hidden=True WHERE order_id='$id'") or die("Error in the consult.." . mysqli_error($link));
	header("location: index.php");
}