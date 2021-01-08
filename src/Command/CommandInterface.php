<?php

namespace Anguis\BlackFriday\Command;

/**
 *  Interface for implementation by commands
 *  @author rbieronski <bluenow@gmail.com>
 */
Interface CommandInterface {

    public function Run(): string;
}

