<?php

require('helpers/functions.php');
require('helpers/connection.php');
require('helpers/auth.php');

$id = get_safe_value($con, $_GET['id']);
$target_dir = __DIR__ . "/../upload/image_gallery/";

$res = $con->query("SELECT id, filename FROM gallery WHERE id = '$id'");

$image = new stdClass();
while ($row = $res->fetch_assoc()) {
  foreach ($row as $key => $value) {
    $image->$key = $value;
  }
}
if (!unlink($target_dir . $image->filename)) {
  $result->error = true;
  $result->msg = "Could not Delete Image";
  response($result);
} else {
  $res = $con->query("DELETE FROM gallery WHERE id = '$image->id'");
  if ($res) {
    $result->error = false;
    $result->msg = "Image Deleted";
    response($result);
  }
}
