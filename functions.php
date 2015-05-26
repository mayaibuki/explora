<?php

$mysqli = new mysqli("localhost", "mayaibuk_dbuser", "t-hEFG)([hUv", "mayaibuk_explora");
$mysqli->set_charset("utf8");

function slugify($text)
{ 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}


function upload_file($target_dir, $file) {
  $target_file = $target_dir . basename($_FILES[$file]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file already exists
  if (file_exists($target_file)) {
    $uploadOk = 0;
  }
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
    return $target_file;
  } else {
    echo "Sorry, there was an error uploading your file. ". $target_file ;
  }
}
}

function upload_multiple($target_dir, $filename, $filetmp) {
  $target_file = $target_dir . basename($filename);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
  $check = getimagesize($filetmp);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }
// Check if file already exists
  if (file_exists($target_file)) {
    $uploadOk = 0;
  }
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($filetmp, $target_file)) {
    return $target_file;
  } else {
    echo "Sorry, there was an error uploading your file. ". $target_file ;
  }
}
}

?>