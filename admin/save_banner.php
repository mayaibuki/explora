<?php
include_once('db_con.php');

if($_SERVER['REQUEST_METHOD']==='POST'){
	$name = $_POST['name'];
	$price = $_POST['price'];
	$price_promo = $_POST['price_promo'];
	$stock = $_POST['stock'];
	$category_id = $_POST['category_id'];
	$attributes_id = $_POST['attribute_id'];

	$query = "INSERT INTO product SET name='$name', price='$price', price_promo='$price_promo', category_id='$category_id', stock='$stock'";
	$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));

	if ($result) {
	    header("location: index.php?success");
	} else{
		header("location: index.php?error");
	}
}