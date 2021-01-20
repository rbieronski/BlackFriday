<?php

namespace Anguis\BlackFriday\Command\BlackFridayPrices;

use Anguis\BlackFriday\Output\OutputInterface;
use Anguis\BlackFriday\Repository\ProductsRepository;
use Anguis\BlackFriday\Repository\PromosRepository;

class CommandFactory implements CommandFactoryInterface
{
    protected EnhancedPricesCalculation $prices;
    protected ProductsRepository $products;
    protected PromosRepository $promos;
    protected OutputInterface $output;

    public function __construct(
        ProductsRepository $products,
        PromosRepository  $promos,
        OutputInterface $output
    ) {
        $this->products = $products;
        $this->promos = $promos;
        $this->output = $output;
    }


    public function create(bool $sort): ShowPricesCommand
    {
        echo PHP_EOL . $sort .PHP_EOL .PHP_EOL;
        $this->prices = new EnhancedPricesCalculation(
            $this->products,
            $this->promos,
            $sort
        );
        return new ShowPricesCommand(
            $this->prices->getResult(),
            $this->output
        );
    }
}