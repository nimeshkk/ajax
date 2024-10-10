<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manager_id = $_POST['mid'];
    $password = $_POST['mpassword'];
    
    // Read manager.txt file
    $managers = file('data/manager.txt');
    $is_valid = false;
    
    foreach ($managers as $manager) {
        list($id, $pass) = explode(",", trim($manager));
        if ($id == $manager_id && $pass == $password) {
            $is_valid = true;
            break;
        }
    }
    
    if ($is_valid) {
        $_SESSION['manager_id'] = $manager_id;
        error_log("Login successful. Manager ID set to: " . $manager_id);
        error_log("Session data after login: " . print_r($_SESSION, true));
        header("Location: listing.htm");
        exit();
    } else {
        error_log("Login failed for Manager ID: " . $manager_id);
        echo "Invalid Manager ID or Password.";
    }
}
?>