<?php
// Start the session
session_start();

// Check if the customer is logged in
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    
    // Destroy the session
    session_destroy();
    
    // Redirect to logout page
    header("Location: customer_logout.htm?customer_id=" . urlencode($customer_id));
    exit();
} else {
    // If no user is logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>
