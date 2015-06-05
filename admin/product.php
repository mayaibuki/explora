<?php
include_once('../functions.php');
include_once 'db_con.php';
error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD']==='POST'){
	if(!isset($_POST['id'])){
		$name = $link->real_escape_string($_POST['name']);
		$sku = $link->real_escape_string($_POST['sku']);
		$price = $link->real_escape_string($_POST['price']);
		$color = $link->real_escape_string($_POST['color']);
		$color_code = $link->real_escape_string($_POST['color_code']);
		$how = $link->real_escape_string($_POST['how_to_use']);
		$description = $link->real_escape_string($_POST['description']);
		$stock = $link->real_escape_string($_POST['stock']);
		$category_id = $link->real_escape_string($_POST['category_id']);
		$attributes_id = $link->real_escape_string($_POST['attribute_id']);
		if($color){
			$slug = slugify($name).'-'.slugify($color);
		} else{
			$slug = slugify($name);
		}

		$query = "INSERT INTO product SET SKU='$sku', color='$color', color_code='$color_code', name='$name', price='$price', how_to_use='$how', description='$description', category_id='$category_id', stock='$stock', slug='$slug'";
		$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));
		$last_id = $link->insert_id;

		if(isset($_POST['attribute_id'])){
			foreach($_POST['attribute_id'] as $attr) {
				$link->query("INSERT INTO product_attributes SET product_id='$last_id', attribute_id='$attr'");
			}
		}

		if(isset($_POST['related'])){
			foreach($_POST['related'] as $rel) {
				$link->query("INSERT INTO related_product SET product_id='$last_id', product_id_r='$rel'");
			}
		}

		if (!file_exists('../media/product/'.$slug)) {
			mkdir('../media/product/'.$slug, 0777, true);
		}

		if(isset($_FILES["full_img"])){    
			foreach($_FILES["full_img"]['tmp_name'] as $key => $tmp){
				if($_FILES["full_img"]['name'][$key]!=''){
					$name = $_FILES["full_img"]['name'][$key];
					upload_multiple('../media/product/'.$slug.'/', $name, $tmp);
					$img = '/media/product/'.$slug.'/'.basename($name);
					$img_result = $link->query("INSERT INTO product_img SET product_id='$product_id', full_img='$img'") or die("Error in the consult.." . mysqli_error($link));
				}
			}
		}

		if(isset($_FILES["how_img"])){    
			foreach($_FILES["how_img"]['tmp_name'] as $key => $tmp){
				if($_FILES["how_img"]['name'][$key]!=''){
					$name = $_FILES["how_img"]['name'][$key];
					upload_multiple('../media/product/'.$slug.'/', $name, $tmp);
					$img = '/media/product/'.$slug.'/'.basename($name);
					$img_result = $link->query("INSERT INTO how_product_img SET product_id='$last_id', full_img='$img'") or die("Error in the consult.." . mysqli_error($link));
				}
			}
		}
	}
} else{
	if($_GET['id']) {
		$id = $_GET['id'];
		if($_GET['delete']){
			$query = "DELETE FROM product WHERE product_id='$id'";
			$result = $link->query($query) or die("Error in the consult.." . mysqli_error($link));

		} else {

		}
	}
}

if ($result) {
	header("location: index.php");
}
?>