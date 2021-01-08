<?php

namespace Anguis\BlackFriday\Collection;

/**
 * Class Collection
 * @package Anguis\BlackFriday\Collection
 */
class Collection
{
    private $items = array();


    public function addItem($obj, $key = null)
    {
        if ($key == null) {
            echo 'NotKeyGiven';
            // add exception NotKeyGiven;
        } elseif ($this->keyExists($key)) {
            echo 'KeyAlreadyInUse';
            // add exception KeyAlreadyInUse;
        } else {
            $this->items[$key] = $obj;
        }
    }

    public function deleteItem($key)
    {
        if ($this->keyExists($key)) {
            unset($this->items[$key]);
        } else {
            echo 'KeyNotExists';
            // add exception KeyNotExists;
        }
    }

    public function keyExists($key): bool
    {
        return isset($this->items[$key]);
    }

    public function getItem($key): object
    {
        if ($this->keyExists($key)) {
            return $this->items[$key];
        } else {
            echo 'KeyNotExists';
            // add exception KeyNotExists;
        }
    }

    public function getKeys(): array
    {
        $keys = [];
        $arr = $this->items;
        foreach ($arr as $key=>$value) {
            $keys[] = $key;
        }
        return $keys;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}