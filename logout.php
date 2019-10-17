<?php
  session_start();
  #unset session, bkn destroy session
  session_unset();
  header("location: ./login.php");
?>
