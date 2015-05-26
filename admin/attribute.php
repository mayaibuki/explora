<?php
include_once('../functions.php');
include_once 'db_con.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
	if(!$_POST['id']){
		$name = $_POST['name'];
		$description = $_POST['description'];
		upload_file('../media/attributes/', 'icon');
		$img = '/media/attributes/'.basename($_FILES['icon']["name"]);

		$query = "INSERT INTO attributes SET name='$name', description='$description', icon='$img'";
		$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));
	}
} else{
	if($_GET['id']) {
		$id = $_GET['id'];
		if($_GET['delete']){
			$query = "DELETE FROM attributes WHERE attribute_id='$id'";
			$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));

		} else {

		}
	}
}

if ($result) {
	header("location: index.php");
}