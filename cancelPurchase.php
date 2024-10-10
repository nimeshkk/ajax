<?php
header("Content-Type: application/json");

$xmlFile = 'data/goods.xml';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $items = json_decode(file_get_contents('php://input'), true);

    $xml = new DOMDocument();
    $xml->load($xmlFile);

    $xpath = new DOMXPath($xml);

    foreach ($items as $item) {
        $itemName = $item['name'];
        $quantity = $item['quantity'];

        $itemNode = $xpath->query("//item[name='$itemName']")->item(0);

        if ($itemNode) {
            $quantityNode = $itemNode->getElementsByTagName('quantity')->item(0);
            $onHoldNode = $itemNode->getElementsByTagName('onHold')->item(0);

            $currentQuantity = (int)$quantityNode->textContent;
            $currentOnHold = (int)$onHoldNode->textContent;

            $newQuantity = $currentQuantity + $quantity;
            $newOnHold = $currentOnHold - $quantity;

            $quantityNode->textContent = $newQuantity;
            $onHoldNode->textContent = $newOnHold;
        }
    }

    $xml->save($xmlFile);

    echo json_encode(['success' => true, 'message' => 'Purchase cancelled and quantities updated']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>