<?php
mysql_connect("localhost","root",""); //sesuaikan dengan password dan username mysql anda
mysql_select_db("register"); //nama database yang kita gunakan
?>
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $_POST['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_object();
if (mysqli_num_rows($result) > 0){
if ($_POST['password'] == $user->password){
    $_SESSION['username'] = $user->username;
    $_SESSION['password'] = $user->password;
    $_SESSION['user_id'] = $user->id;
