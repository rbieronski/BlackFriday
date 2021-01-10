<?php

namespace Anguis\BlackFriday\Output;

use League\CLImate\CLImate;


class CliClimateOutput implements OutputInterface
{
    protected CLImate $climate;
    protected string $inlineSeparator = ", ";
    protected string $rowSeparator = ", " . PHP_EOL;

    function __construct()
    {
        $this->climate = new CLImate();
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

//public function output($string)
//{
//    echo 'showing output in terminal:' . PHP_EOL
//        . "---------------------------------------"
//        . PHP_EOL
//        . $string
//        . PHP_EOL;
//}