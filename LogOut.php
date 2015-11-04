<?php
SESSION_start();
 include 'AccessControl.php';
  session_unset();
  session_destroy();
  
  header('Location: index.php');
  die();
?>