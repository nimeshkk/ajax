<?php
session_start();

error_log("Session data before logout: " . print_r($_SESSION, true));

$manager_id = isset($_SESSION['manager_id']) ? $_SESSION['manager_id'] : 'notavailable';
error_log("Manager ID before logout: " . $manager_id);

// Destroy the session
session_destroy();

// Use absolute path for redirection
$redirect_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/mlogout.htm";
header("Location: " . $redirect_url . "?id=" . urlencode($manager_id));
exit();
?>