<?php

namespace Anguis\BlackFriday\Collection;

/**
 * Class Collection
 * Wrapper for array object
 * allowing to easy manipulation such as add/remove
 * using 'keys' specified for each item in collection
 * Unique keys are required
 *
 * @package Anguis\BlackFriday\Collection
 */
final class Collection
{
    private $items = array();

    /**
     * ToDo: add autoincrement option for keys
     * @param $obj
     * @param $key
     */
    public function addItem($obj, $key)
    {
        if ($this->keyExists($key)) {
            throw new KeyAlreadyInUse(
                "Key: " . $key . ' is already in use; unique key required'
            );
        }
        $this->items[$key] = $obj;
    }

    public function deleteItem($key)
    {
        if (!$this->keyExists($key)) {
            throw new KeyNotExitsException(
                "There is no item in collection with specified key " . $key);
        }
        unset($this->items[$key]);
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

    /**
     * Get list of all items keys
     * @return array
     */
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