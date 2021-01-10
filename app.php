<?php

require_once __DIR__ . '/vendor/autoload.php';

define('DEFAULT_PROMOS_FILE', 'black_friday_2020.xml');
define('DEFAULT_PRODUCTS_FILE', 'products.json');

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


// check if file paths given
if(count($argv) <> 3) {
    // show short help message
    echo 'Please give 2 parameters to execute program:'. PHP_EOL;
    echo '  (1) path to products - .json file'. PHP_EOL;
    echo '  (2) path to promos - .xml file' . PHP_EOL ;
    echo 'sample use with default paths:' . PHP_EOL;
    echo '$ php app.php ' . DEFAULT_PRODUCTS_FILE . ' ' . DEFAULT_PROMOS_FILE. PHP_EOL . PHP_EOL;

    // suggest default paths
    $useDefaultParameters = readline('Run script with default parameters [Y]es/[n]o: ');
    if (strtolower($useDefaultParameters) <> "y") {
        die();
    } else {
        $productsFile = DEFAULT_PRODUCTS_FILE;
        $promosFile = DEFAULT_PROMOS_FILE;
    }
} else {
    // get files paths
    $productsFile = $argv[1];
    $promosFile =$argv[2];
}

// prepare repositories
$productsRep = New ProductsRepository(
    New JsonProductReader($productsFile)
);
$promosRep = New PromosRepository(
    new XmlPromoReader($promosFile)
);

// prepare new prices
$pricesObj = New PricesCalculation(
    $productsRep->getColl(),
    $promosRep->getColl()
);

// choose CLI output object depending on installed package
if (\Composer\InstalledVersions::isInstalled('league/climate')) {
    $outputTo = new CliClimateOutput();
} else {
    $outputTo = new CliOutput();
}

// send to output
$pricesCommand = New ShowPricesCommand(
    $pricesObj ->getResult(),
    $outputTo
);
$pricesCommand->Run();