<?php

namespace Anguis\BlackFriday\Product;
use Anguis\BlackFriday\Collection\Collection;

/**
 * Class ProductsRepository
 * @package Anguis\BlackFriday\Product
 */
class ProductsCollection
{
    protected ProductReaderInterface $productReaderInterface;
    protected Collection $coll;

    function __construct(ProductReaderInterface $productReaderInterface) {
        $this->productReaderInterface = $productReaderInterface;
        $this->coll = New Collection();
        $this->prepare();
    }

    private function prepare() {
        $allRecords = $this->productReaderInterface->findAll();
        foreach ($allRecords as $item) {
            $obj = New ProductsEntity(
                $item['sku'],
                $item['name'],
                $item['base_price_net'],
                $item['minimal_price']
            );
            $this->coll->addItem(
                $obj, $item['sku']
            );
        }
    }

    public function getColl(): Collection {
        return $this->coll;
    }
}