<?php
require('helpers/functions.php');
require('helpers/connection.php');

try {
  unset($_SESSION['admin_id']);
  unset($_SESSION['username']);
  if (session_destroy()) {
    $result->error = false;
    $result->msg = "Succesfully Logged out";
    response($result);
  } else {
    $result->error = true;
    $result->msg = "Could not Logout";
    response($result);
  }
} catch (\Throwable $th) {
  $result->error = true;
  $result->msg = "Could not Logout";
  response($result);
}
