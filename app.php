<?php

require_once('vendor/autoload.php');
use Anguis\BlackFriday\Product\{
                JsonProductReader,
                ProductsCollection
};
use Anguis\BlackFriday\Promo\{
                PromosCollection,
                XmlPromoReader
};

// check if parameters given
//If(count($argv) < 3) {
//    echo 'give path to products (.json file) and promos (xml file)' . PHP_EOL;
//    echo 'sample: php app.php products.json black_friday_2020.xml' . PHP_EOL;
//    die();
//}

// get files paths
//$productsFile = $argv[1];
//$promosFile =$argv[2];
    // for debug only
        $productsFile = "sampleData/products.json";
        $promosFile = "sampleData/black_friday_2020.xml";

// read files


// working ok!
//    $productJson = New JsonProductReader($productsFile);
//    $productCollection = New ProductsCollection($productJson);
//    $coll = New \Anguis\BlackFriday\Collection\Collection();
//    $coll = $productCollection->prepare();
    //echo $coll->keyExists('P11');

$promosXml = New XmlPromoReader($promosFile);
$promosCollection = New PromosCollection($promosXml);
$coll = New \Anguis\BlackFriday\Collection\Collection();
$coll = $promosCollection->prepare();
//echo $coll->keyExists('P1');




//echo 'ccccc';
//echo '<pre>';
//print_r($productJson);
//echo '</pre>';
//echo PHP_EOL . '------------------------------------------------------------------------------' . PHP_EOL;
//echo '<pre>';
//print_r($promosXml);
//echo '</pre>';
//echo PHP_EOL;
