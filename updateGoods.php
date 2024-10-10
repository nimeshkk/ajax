<?php
// updateGoods.php

header('Content-Type: application/json');

// Get the input JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data) || empty($data)) {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
    exit;
}

// Load the existing XML file
$xml = simplexml_load_file('data/goods.xml');

// Loop through the sold items and update the XML
foreach ($data as $soldItem) {
    $itemName = $soldItem['name'];
    $quantitySold = $soldItem['quantity'];

    // Find the item in the XML
    foreach ($xml->item as $item) {
        if ($item->name == $itemName) {
            // Update the sold quantity and available quantity
            
            $item->quantity = (int)$item->quantity;
            break;
        }
    }
}

// Save the updated XML file
$xml->asXML('data/goods.xml');

// Return a success response
echo json_encode(['status' => 'success', 'message' => 'XML updated successfully']);
?>
