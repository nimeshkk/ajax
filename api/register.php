<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $phone = $_POST['phone'];

    if ($password !== $repassword) {
        echo "<div style='color: red; font-weight: bold; font-size: 3.2rem; text-align: center; margin-top: 220px;'>Passwords do not match!</div>";
        exit();
    }

    $xml_file = 'data/customer.xml';

    // Check if the XML file exists, if not, create it
    if (!file_exists($xml_file)) {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;
        $root = $xml->createElement('customers');
        $xml->appendChild($root);
        $xml->save($xml_file);
    } else {
        $xml = new DOMDocument();
        $xml->load($xml_file);
    }

    // Check for existing email
    foreach ($xml->getElementsByTagName('customer') as $customer) {
        if ($customer instanceof DOMElement && $customer->getElementsByTagName('email')->item(0)->nodeValue == $email) {
            echo "<div style='color: red; font-weight: bold; font-size: 3.2rem; text-align: center; margin-top: 220px;'>Email already exists!</div>";
            exit();
        }
    }

    if (!defined('PASSWORD_BCRYPT')) {
        define('PASSWORD_BCRYPT', 1);
    }

    $customers = $xml->getElementsByTagName('customers')->item(0);
    if (!$customers) {
        $customers = $xml->createElement('customers');
        $xml->appendChild($customers);
    }

    $newCustomer = $xml->createElement('customer');
    $newCustomer->appendChild($xml->createElement('id', uniqid()));
    $newCustomer->appendChild($xml->createElement('email', htmlspecialchars($email)));
    $newCustomer->appendChild($xml->createElement('fname', htmlspecialchars($fname)));
    $newCustomer->appendChild($xml->createElement('lname', htmlspecialchars($lname)));
    $newCustomer->appendChild($xml->createElement('password', crypt($password, PASSWORD_BCRYPT)));
    $newCustomer->appendChild($xml->createElement('phone', htmlspecialchars($phone)));
    $customers->appendChild($newCustomer);

    $xml->save($xml_file);

    echo "<div style='color: green; font-weight: bold; font-size: 3.2rem; text-align: center; margin-top: 220px;'> Registration successful! Redirecting to BuyOnline page... </div>";
    echo "<script> setTimeout(function() { window.location.href = 'buyonline.htm'; }, 2000); </script>";
    exit();
}
?>