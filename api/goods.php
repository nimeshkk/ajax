<?php
header("Content-Type: text/xml");


$xmlFile = 'data/goods.xml';

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    echo $xml->asXML(); 
} else {
    echo '<error>File not found</error>';
}
?>
