<?php 
include_once '../functions.php';

$action 				= $mysqli->real_escape_string($_POST['action']); 
$updateRecordsArray 	= $_POST['recordsArray'];

if ($action == "updateRecordsListings"){
	
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE product_img SET img_order = " . $listingCounter . " WHERE img_id = " . $recordIDValue;
		$mysqli->query($query) or die("Error in the consult.." . mysqli_error($mysqli));
		$listingCounter = $listingCounter + 1;	
	}
}

if ($action == "updateAttr"){
	
	$listingCounter = 1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE attributes SET attr_order = " . $listingCounter . " WHERE attribute_id = " . $recordIDValue;
		$mysqli->query($query) or die("Error in the consult.." . mysqli_error($mysqli));
		$listingCounter = $listingCounter + 1;	
	}
}
?>