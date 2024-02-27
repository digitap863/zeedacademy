<?php

require('helpers/functions.php');
require('helpers/connection.php');

try {
  $res = $con->query('SELECT id, filename FROM gallery');
  $data = [];

  while ($row = $res->fetch_assoc()) {
    $image = new stdClass();
    foreach ($row as $key => $value) {
      $image->$key = $value;
    }
    array_push($data, $image);
  }

  $result->error = false;
  $result->data = $data;
  response($result);
} catch (\Throwable $th) {
  $result->error = true;
  $result->msg = "Error fetching Images";
  response($result);
}
