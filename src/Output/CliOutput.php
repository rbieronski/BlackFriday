<?php

namespace Anguis\BlackFriday\Output;

/**
 * Class CliOutput
 * @package Anguis\BlackFriday\Output
 */
class CliOutput implements OutputInterface
{
    public function output($string)
    {
        echo 'showing result output...:' . PHP_EOL
             . "---------------------------------------"
             . PHP_EOL
             . $string
             . PHP_EOL;
    }
}