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
      echo $string;
    }
}
