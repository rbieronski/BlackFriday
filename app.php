<?php

require_once __DIR__ . '/vendor/autoload.php';

define('DEFAULT_PROMOS_FILE', 'black_friday_2020.xml');
define('DEFAULT_PRODUCTS_FILE', 'products.json');

use Anguis\BlackFriday\Output\{
    OutputInterface,
    CliOutput,
    CliClimateOutput
};
use Anguis\BlackFriday\Repository\{
    ProductsRepository,
    PromosRepository,
};
use Anguis\BlackFriday\Reader\{
    Product\JsonProductReader,
    Promo\XmlPromoReader
};
use Anguis\BlackFriday\Command\BlackFridayPrices\{
    CommandFactory,
    EnhancedPricesCalculation
};

// check if file paths given
if(count($argv) < 3) {
    // show short help message
    echo 'Please give at least 2 parameters to execute program:'. PHP_EOL;
    echo '  (1) path to products - .json file'. PHP_EOL;
    echo '  (2) path to promos - .xml file' . PHP_EOL ;
    echo '  (3) [optional] sort prices based on promo gross price [true/false, default false]' . PHP_EOL ;
    echo 'Sample use with default paths:' . PHP_EOL;
    echo '$ php app.php ' . DEFAULT_PRODUCTS_FILE . ' ' . DEFAULT_PROMOS_FILE .
        ' false' . PHP_EOL . PHP_EOL;

    // suggest default paths
    $useDefaultParameters = readline('Run script with default parameters [y]es/[n]o: ');
    if (strtolower($useDefaultParameters) <> "y") {
        die();
    } else {
        $productsFile = DEFAULT_PRODUCTS_FILE;
        $promosFile = DEFAULT_PROMOS_FILE;
        $sort = false;
    }
} else {
    // get files paths
    $productsFile = $argv[1];
    $promosFile = $argv[2];
    // check if sort results
    if (isset($argv[3])) {
        $sort = $argv[3] === 'true' ?: false;
    } else {
        $sort = false;
    }
}

// prepare repositories
$productsRep = new ProductsRepository(
    new JsonProductReader($productsFile)
);
$promosRep = new PromosRepository(
    new XmlPromoReader($promosFile)
);

// run command
$commandFactory = new CommandFactory(
    $productsRep,
    $promosRep,
    chooseCliOutput()
);
$commandFactory->create($sort)->Run();


// choose CLI output object automatically depending on installed package
function chooseCliOutput(): OutputInterface
{
    if (\Composer\InstalledVersions::isInstalled('league/climate')) {
        $output = new CliClimateOutput();
        $output->setCustomSplitSeparators(
            EnhancedPricesCalculation::STRING_SEPARATOR,
            EnhancedPricesCalculation::STRING_SEPARATOR .
            EnhancedPricesCalculation::NEW_LINE_SEPARATOR
        );
    } else {
        $output = new CliOutput();
    }
    return $output;
}