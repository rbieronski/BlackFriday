<?php

namespace Anguis\BlackFriday\Output;

use League\CLImate\CLImate;


class CliClimateOutput implements OutputInterface
{
    protected CLImate $climate;

    // default separators to explode string
    protected string $inlineSeparator = " ";
    protected string $rowSeparator = PHP_EOL;

    function __construct()
    {
        $this->climate = new CLImate();
    }

    public function setCustomSplitSeparators(
        string $inlineSeparator,
        string $rowSeparator
    ) {
        $this->inlineSeparator = $inlineSeparator;
        $this->rowSeparator = $rowSeparator;
    }

    public function output($string)
    {
        // prepare array to show
        $array  = explode(
            $this->rowSeparator,
            $string
        );

        foreach ($array as $key=>$value) {
            $array[$key] = explode(
                $this->inlineSeparator,
                $value
            );
        }

        // remove last unnecessary empty row
        unset($array[count($array)-1]);

        // print to console
        $this->climate->lightCyan()->table($array);
    }
}