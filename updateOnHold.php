<?php
header("Content-Type: application/json");

$xmlFile = 'data/goods.xml';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $itemName = $data['name'];
    $quantityChange = $data['quantity'];

    $xml = new DOMDocument();
    $xml->load($xmlFile);

    $xpath = new DOMXPath($xml);
    $item = $xpath->query("//item[name='$itemName']")->item(0);

    if ($item) {
        $quantityNode = $item->getElementsByTagName('quantity')->item(0);
        $onHoldNode = $item->getElementsByTagName('onHold')->item(0);

        if (!$onHoldNode) {
            $onHoldNode = $xml->createElement('onHold', '0');
            $item->appendChild($onHoldNode);
        }

        $currentQuantity = (int)$quantityNode->textContent;
        $currentOnHold = (int)$onHoldNode->textContent;

        $newQuantity = $currentQuantity - $quantityChange;
        $newOnHold = $currentOnHold + $quantityChange;

        $quantityNode->textContent = $newQuantity;
        $onHoldNode->textContent = $newOnHold;

        $xml->save($xmlFile);

        echo json_encode(['success' => true, 'message' => 'On hold quantity updated']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>