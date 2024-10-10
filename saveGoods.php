<?php
header('Content-Type: application/xml');

// Specify the path to your XML file
$xmlFile = 'data/goods.xml';

// Get the XML data from the POST request
$xmlData = file_get_contents("php://input");

// Check if the file is writable and then save the XML
if (is_writable($xmlFile)) {
    // Save the XML data to the file
    if (file_put_contents($xmlFile, $xmlData)) {
        echo 'XML file updated successfully.';
    } else {
        echo 'Error saving XML file.';
    }
} else {
    echo 'The XML file is not writable.';
}
?>
