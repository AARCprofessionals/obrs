<?php
include('cn.php');

// you have to open the session first
session_start();

// remove all the variables in the session
session_unset();

// destroy the session
session_destroy();

echo 'You have been successfully logged out. Return to <a href="login.php">login screen</a>.';
?>