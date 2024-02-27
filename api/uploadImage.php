<?php

require('helpers/functions.php');
require('helpers/connection.php');
require('helpers/auth.php');

try {
  $error = [];
  $target_dir = __DIR__ . "/../upload/image_gallery/";
  foreach ($_FILES as $file) {
    $check = getimagesize($file["tmp_name"]);
    if ($check == false) {
      array_push($error, $file['name'] . " is not an image");
    }

    $target_file = $target_dir . basename($file["name"]);
    if (file_exists($target_file)) {
      array_push($error, $file['name'] . " already exists");
    }

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      array_push($error, $file['name'] . " not JPG, JPEG, PNG & GIF file");
    }

    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
      array_push($error, $file['name'] . " not uploaded");
    } else {
      $res = $con->query(("INSERT INTO gallery (filename, created_by) VALUES ('" . $file['name'] . "', '" . $_SESSION['admin_id'] . "')"));
      if (!$res) {
        array_push($error, $file['name'] . " not uploaded");
      }
    }
  }

  if (sizeof($error)) {
    $result->error = true;
    $result->data = $error;
    response($result);
  } else {
    $result->error = false;
    $result->msg = "Upload Success";
    response($result);
  }
} catch (\Throwable $th) {
  $result->error = true;
  $result->msg = "Upload Failed";
  response($result);
}
