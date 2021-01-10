<?php

namespace Anguis\BlackFriday\Collection;

/**
 * Class Collection
 * Wrapper for array object
 * allowing to easy manipulation such as add/remove
 * using 'keys' specified for each item in collection
 *
 * @package Anguis\BlackFriday\Collection
 */
final class Collection
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

    /**
     * @param $key
     * @return mixed
     */
    public function getItem($key)
    {
        if (!$this->keyExists($key)) {
            throw new KeyNotExitsException(
                "There is no item in collection with specified key " . $key);
        }
        return $this->items[$key];
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