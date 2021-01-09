<?php

require_once('vendor/autoload.php');

use Anguis\BlackFriday\Repository\{
    ProductsRepository,
    PromosRepository,
};
use Anguis\BlackFriday\Reader\{
    Product\JsonProductReader,
    Promo\XmlPromoReader
};
use Anguis\BlackFriday\Command\BlackFridayPrices\{
    PricesCalculation,
    ShowPricesCommand
};
use Anguis\BlackFriday\Output\{
    CliOutput,
    CliClimateOutput
};



// check if parameters given
If(count($argv) <> 3) {
    echo 'Please give paramateres to execute program:'. PHP_EOL;
    echo '  (1) path to products - .json file'. PHP_EOL;
    echo '  (2) path to promos - .xml file' . PHP_EOL . PHP_EOL;
    echo 'sample use:' . PHP_EOL;
    echo '$ php app.php products.json black_friday_2020.xml' . PHP_EOL;
    die();
}

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


$pricesObj = New PricesCalculation(
    $productsCollection,
    $promosCollection
);

$outputTo = new CliClimateOutput();
//$outputTo = new CliOutput();

$pricesCommand = New ShowPricesCommand(
    $pricesObj ->getResult(),
    $outputTo
);
$pricesCommand->Run();