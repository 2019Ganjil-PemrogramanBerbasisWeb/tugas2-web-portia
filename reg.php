<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
//dbx_connect
if (!empty($username)){
  if (!empty($password)){
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli('localhost','root','','register');
    if($conn->connect_error){
      die('Connection Failed : '.$conn->connect_error);
      }else
      { $stmt = $conn->prepare("Insert into users(username, password, email)
        values(?, ?, ?)");
        $stmt->bind_param('sss',$username, $password, $email);
        $stmt->execute();
        $stmt->close();
        $conn->close();
      }
  }
    else{
      echo "Password should not be empty";
      die();
        }
}
    else{
    echo "Username should not be empty";
    die();
  }
header('Location: ./regland.php');
 ?>
