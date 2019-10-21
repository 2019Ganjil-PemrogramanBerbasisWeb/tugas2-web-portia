<?php

if (!isset($_POST['username']) || !isset($_POST['password'])); {
  header("Location: ./login.html");
}
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
//dbx_connect

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect('localhost','root','','register');
if($conn->connect_error){
  die('Connection Failed : '.$conn->connect_error);
}else {
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_object();
if (mysqli_num_rows($result) > 0){
if ($_POST['password'] == $user->password){
    $_SESSION['username'] = $user->username;
    $_SESSION['email'] = $user->email;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['loggedIn'] = true;

header('Location: ./landing.php');
}
  }
  else{
  echo "Password/Username wrong or empty";
  die();
    }
}

?>
