<?php

require_once('vendor/autoload.php');
use Anguis\BlackFriday\Repository\{
    ProductsRepository,
    PromosRepository
};
use Anguis\BlackFriday\Reader\{
    Product\JsonProductReader,
    Promo\XmlPromoReader
};

use Anguis\BlackFriday\Command\PromoStrategyCommand;

// check if parameters given
//If(count($argv) < 3) {
//    echo 'give path to products (.json file) and promos (xml file)' . PHP_EOL;
//    echo 'sample: php app.php products.json black_friday_2020.xml' . PHP_EOL;
//    die();
//}

// get files paths
$productsFile = $argv[1];
$promosFile =$argv[2];

// for debug only
//      $productsFile = "products.json";
//      $promosFile = "black_friday_2020.xml";

// read files and prepare collections
$productsJson = New JsonProductReader($productsFile);
$productsRep = New ProductsRepository($productsJson);
$productsCollection = $productsRep->getColl();

$promosXml = New XmlPromoReader($promosFile);
$promosRep = New PromosRepository($promosXml);
$promosCollection = $promosRep->getColl();

//
$command = New PromoStrategyCommand(
    $productsCollection,
    $promosCollection
);

$command->Run();
$result = $command->getResult();

echo $result;


function print_r2($obj) {
    echo '------------------------------------------';
    echo PHP_EOL . '<pre>';
    print_r($obj);
    echo '</pre>' . PHP_EOL;
}

