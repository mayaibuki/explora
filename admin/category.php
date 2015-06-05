<?php
include_once('../functions.php');
include_once 'db_con.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
	if(!$_POST['id']){
		$name = $link->real_escape_string($_POST['name']);
		$description = $link->real_escape_string($_POST['description']);
		$slug = slugify($name);
		upload_file('../media/category/', 'img');
		$img = '/media/category/'.basename($_FILES['img']["name"]);

		$query = "INSERT INTO category SET name='$name', description='$description', slug='$slug', img='$img'";
		$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));
	}
} else{
	if($_GET['id']) {
		$id = $_GET['id'];
		if($_GET['delete']){
			$query = "DELETE FROM category WHERE category_id='$id'";
			$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));

		} else {

		}
	}
}

if ($result) {
	header("location: index.php");
}