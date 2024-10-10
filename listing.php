<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemName = htmlspecialchars($_POST['itemname']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $description = htmlspecialchars($_POST['description']);

    $xmlPath = 'data/goods.xml';

    // Load or create the XML file
    $xml = new DOMDocument('1.0', 'UTF-8');
    $xml->formatOutput = true;

    if (file_exists($xmlPath)) {
        $xml->load($xmlPath);
        $items = $xml->getElementsByTagName('items')->item(0);
        if (!$items) {
            $items = $xml->createElement('items');
            $xml->appendChild($items);
        }
    } else {
        $items = $xml->createElement('items');
        $xml->appendChild($items);
    }

    // Auto-generate ID starting from 1
    $lastId = 0;
    foreach ($xml->getElementsByTagName('item') as $item) {
        if ($item instanceof DOMElement) {
            $currentId = (int)$item->getElementsByTagName('id')->item(0)->nodeValue;
            if ($currentId > $lastId) {
                $lastId = $currentId;
            }
        }
    }
    $newId = $lastId + 1;

    // Create new item element with auto-generated ID
    $newItem = $xml->createElement('item');
    $newItem->appendChild($xml->createElement('id', $newId));
    $newItem->appendChild($xml->createElement('name', $itemName));
    $newItem->appendChild($xml->createElement('price', $price));
    $newItem->appendChild($xml->createElement('quantity', $quantity));
    $newItem->appendChild($xml->createElement('description', $description));
    $newItem->appendChild($xml->createElement('soldQuantity', 0));
    $newItem->appendChild($xml->createElement('onHold', 0));  

    $items->appendChild($newItem);

    // Save XML file
    if (!$xml->save($xmlPath)) {
        die("Failed to save XML file.");
    }

    // Display the success message with CSS and redirect
    echo "
    <div style='font-family: Arial, sans-serif; padding: 20px; text-align: center; background-color: #e6ffed; color: #22b95c; border: 1px solid #22b95c; border-radius: 5px; margin-top: 220px;'>
        Item added successfully with ID: " . $newId . "
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'listing.htm';
        }, 2000); // Redirect after 2 seconds
    </script>
    ";
}
?>