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
        echo 'Showing result output...:' . PHP_EOL
             . str_repeat("-", 50)
             . PHP_EOL . $string . PHP_EOL;
    }
}