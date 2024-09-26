<?php
session_start();
session_destroy();
$_SESSION["loggedin"] = false;
// Redirect to login page
header("location: https://jmdormitory.000webhostapp.com/");
exit;
?>