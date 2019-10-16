<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "register";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect('localhost','root','','register');
if($conn->connect_error){
  die('Connection Failed : '.$conn->connect_error);
}

// Check if $_SESSION or $_COOKIE already set
if( isset($_SESSION['userid']) ){
 header('Location: /landing.php');
 exit;
}else if( isset($_COOKIE['rememberme'] )){

 // Decrypt cookie variable value
 $userid = decryptCookie($_COOKIE['rememberme']);

 $sql_query = "select count(*) as cntUser,id from users where id='".$userid."'";
 $result = mysqli_query($conn,$sql_query);
 $row = mysqli_fetch_array($result);

 $count = $row['cntUser'];

 if( $count > 0 ){
  $_SESSION['userid'] = $userid;
  header('Location: /landing.html');
  exit;
 }
}

// Encrypt cookie
function encryptCookie( $value ) {
 $key = 'youkey';
 $newvalue = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $key ), $value, MCRYPT_MODE_CBC, md5( md5( $key ) ) ) );
 return( $newvalue );
}

// Decrypt cookie
function decryptCookie( $value ) {
 $key = 'youkey';
 $newvalue = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $key ), base64_decode( $value ), MCRYPT_MODE_CBC, md5( md5( $key ) ) ), "\0");
 return( $newvalue );
}

// On submit
if(isset($_POST['signup'])){

 $username = mysqli_real_escape_string($conn,$_POST['username']);
 $password = mysqli_real_escape_string($conn,$_POST['password']);

 if ($username != "" && $password != ""){

  $sql_query = "select count(*) as cntUser,id from users where username='".$username."' and password='".$password."'";
  $result = mysqli_query($conn,$sql_query);
  $row = mysqli_fetch_array($result);

  $count = $row['cntUser'];

  if($count > 0){
   $userid = $row['id'];
   if( isset($_POST['rememberme']) ){

    // Set cookie variables
    $days = 30;
    $value = encryptCookie($userid);
    setcookie ("rememberme",$value,time()+ ($days * 24 * 60 * 60 * 1000));
   }

   $_SESSION['userid'] = $userid;
   header('Location: /landing.html');
   exit;
  }else{
   echo "Invalid username and password";
  }

 }

}
?>
