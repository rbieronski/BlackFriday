<?php

namespace Anguis\BlackFriday\Repository;
use Anguis\BlackFriday\Collection\Collection;
use Anguis\BlackFriday\Entity\PromoEntity;
use Anguis\BlackFriday\Reader\Promo\PromoReaderInterface;

/**
 * Class PromosRepository
 * @package Anguis\BlackFriday\Repository
 */
class PromosRepository
{
    protected PromoReaderInterface $promoReaderInterface;
    protected Collection $coll;

    /**
     * ProductsRepository constructor
     * creates Collection of PromoEntity's
     * @param PromoReaderInterface $promoReaderInterface
     */
    function __construct(PromoReaderInterface $promoReaderInterface)
    {
        $this->promoReaderInterface = $promoReaderInterface;
        $this->coll = New Collection();
        $allRecords = $this->promoReaderInterface->findAll();

        foreach ($allRecords as $key=>$value) {
            $obj = New PromoEntity($key,$value);
            $this->coll->addItem($obj, $key);
        }
    }

    public function getColl(): Collection
    {
        return $this->coll;
    }
}