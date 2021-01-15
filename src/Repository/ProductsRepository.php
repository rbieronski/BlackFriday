<?php

namespace Anguis\BlackFriday\Repository;
use Anguis\BlackFriday\Collection\Collection;
use Anguis\BlackFriday\Entity\ProductEntity;
use Anguis\BlackFriday\Reader\Product\ProductReaderInterface;


/**
 * Class ProductsRepository
 * @package Anguis\BlackFriday\Product
 */
class ProductsRepository
{
    protected ProductReaderInterface $productReaderInterface;
    protected Collection $coll;

    /**
     * ProductsRepository constructor
     * creates Collection of ProductEntity's
     * @param ProductReaderInterface $productReaderInterface
     */
    function __construct(ProductReaderInterface $productReaderInterface)
    {
        $this->productReaderInterface = $productReaderInterface;
        $this->coll = New Collection();
        $allRecords = $this->productReaderInterface->findAll();

        foreach ($allRecords as $item) {
            $obj = New ProductEntity(
                $item['sku'],
                $item['name'],
                $item['base_price_net'],
                $item['minimal_price']
            );
            $this->coll->addItem($obj, $item['sku']);
        }
    }

    public function getColl(): Collection
    {
        return $this->coll;
    }
}