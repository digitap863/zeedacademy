<?php
require('helpers/functions.php');
require('helpers/connection.php');

$username = get_safe_value($con, $_POST['username']);
$password = get_safe_value($con, $_POST['password']);

try {
  $res = $con->query("SELECT * FROM admin_users WHERE username = '$username'");

  if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
      if ($row['password'] === md5($password)) {
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        $result->error = false;
        $result->msg = "Successfully logged in";
        response($result);
      } else {
        $result->error = true;
        $result->msg = "Incorrect Username or Password";
        response($result);
      }
    }
  } else {
    $result->error = true;
    $result->msg = "Incorrect Username or Password";
    response($result);
  }
} catch (\Throwable $th) {
  $result->error = true;
  $result->msg = "An error occured";
  response($result);
}
