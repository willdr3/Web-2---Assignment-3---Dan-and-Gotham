<?php
SESSION_start();
 include '../includeFiles/AccessControl.php';
  session_unset();
  session_destroy();
  
  header('Location: ../index.php');
  die();
?>