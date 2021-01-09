<?php


namespace Anguis\BlackFriday\Command\BlackFridayPrices;

use Anguis\BlackFriday\Command\CommandInterface;
use Anguis\BlackFriday\Output\OutputInterface;

/**
 * Class ShowPricesCommand
 * @package Anguis\BlackFriday\Command
 */
class ShowPricesCommand implements CommandInterface
{
    protected $outputMsg;
    protected $outputType;

    function __construct(string $outputMsg, OutputInterface $outputType) {
        $this->outputMsg = $outputMsg;
        $this->outputType = $outputType;
    }

    public function Run()
    {
        $this->outputType->output($this->outputMsg);
    }
}