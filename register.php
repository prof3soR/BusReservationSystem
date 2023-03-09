<?php
session_start();
$errors = array();
// Connect to MySQL database
$db = mysqli_connect('localhost', 'root', '', 'bus_reservation_system');

// If the registration button is clicked
if (isset($_POST['register-btn'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm-password'];

  // Ensure that form fields are filled correctly
  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }
  if ($password !== $confirm_password) {
    array_push($errors, "The two passwords do not match");
  }

  // If there are no errors, save user to database
  if (count($errors) == 0) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT); // Encrypt password before storing in database
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hash')";
    mysqli_query($db, $sql);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php'); // Redirect to homepage
  }
}
?>
