<?php
   if (!defined('PASSWORD_BCRYPT')) {
    define('PASSWORD_BCRYPT', 1);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hased_password = crypt($password, PASSWORD_BCRYPT);

    $xml = new DOMDocument();
    $xml->load('data/customer.xml');

    $is_valid = false;
    foreach ($xml->getElementsByTagName('customer') as $customer) {
        if ($customer instanceof DOMElement &&
            $customer->getElementsByTagName('email')->item(0)->nodeValue == $email &&
            $customer->getElementsByTagName('password')->item(0)->nodeValue == $hased_password) {
            $is_valid = true;
            $customer_id = $customer->getElementsByTagName('id')->item(0)->nodeValue;
            break;
        }
    }

    if ($is_valid) {
        session_start();
        $_SESSION['customer_id'] = $customer_id;
        header("Location: buying.htm");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>
