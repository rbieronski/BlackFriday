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
use Anguis\BlackFriday\Command\PromoStrategyCommand;

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
      $productJson = New JsonProductReader($productsFile);
      $products = New ProductsCollection($productJson);
      $productsCollection = $products->getColl();
//    $coll = New \Anguis\BlackFriday\Collection\Collection();
//    $coll = $productCollection->prepare();
    //echo $coll->keyExists('P11');


$promosXml = New XmlPromoReader($promosFile);
$promos = New PromosCollection($promosXml);
$promosCollection = $promos->getColl();

$command = New PromoStrategyCommand($productsCollection, $promosCollection);
$result = $command->Run();

print $result;



print_r2($productsCollection->getKeys());
print_r2($promosCollection->getKeys());

//$promosCollection = New PromosCollection($promosXml);
//$coll = New \Anguis\BlackFriday\Collection\Collection();
//$coll = $promosCollection->prepare();
//echo $coll->keyExists('P1');
echo 'finished';



function print_r2($obj) {
    echo '------------------------------------------';
    echo PHP_EOL . '<pre>';
    print_r($obj);
    echo '</pre>' . PHP_EOL;
}

