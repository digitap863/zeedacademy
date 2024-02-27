<?php

if (!isset($_SESSION['admin_id'])) {
  $result->error = true;
  $result->msg = "User not logged in";
  response($result);
  die();
}
