<?php
session_start();
$errors = array();
// Connect to MySQL database
$db = mysqli_connect('localhost', 'root', '', 'bus_reservation_system');

// If the login button is clicked
if (isset($_POST['login-btn'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Ensure that form fields are filled correctly
  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  // If there are no errors, authenticate user
  if (count($errors) == 0) {
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
      if (password_verify($password, $user['password'])) {
        // Password is correct, log user in
        $_SESSION['username'] = $user['username'];
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php'); // Redirect to homepage
      } else {
        array_push($errors, "Wrong email or password combination");
      }
    } else {
      array_push($errors, "Wrong email or password combination");
    }
  }
}
?>
