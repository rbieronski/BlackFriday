<?php

namespace Anguis\BlackFriday\Command\BlackFridayPrices;

use Anguis\BlackFriday\Command\CommandInterface;

interface CommandFactoryInterface
{
    public function create(bool $sort): ShowPricesCommand;
}