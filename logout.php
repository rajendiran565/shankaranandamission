<?php
session_start(); // Start the session
include_once('./includes/crud.php');
// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or any other appropriate page
header("Location: ".DOMAIN_URL);
exit();
?>
