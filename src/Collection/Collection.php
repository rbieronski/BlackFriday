<?php

namespace Anguis\BlackFriday\Collection;

/**
 * Class Collection
 * @package Anguis\BlackFriday\Collection
 */
class Collection
{
    private $items = array();

    public function addItem($obj, $key)
    {
        // add exception if not key given?
        $this->items[$key] = $obj;
    }

    public function deleteItem($key)
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    public function keyExists($key): bool
    {
        return isset($this->items[$key]);
    }

    public function debugEcho
    {
        foreach ($this->items as $item) {
            echo
        }
    }
}