<?php

namespace Anguis\BlackFriday\Promo;
use Anguis\BlackFriday\Collection\Collection;

class PromosCollection
{
    protected PromoReaderInterface $promoReaderInterface;
    protected Collection $coll;

    function __construct(PromoReaderInterface $promoReaderInterface) {
        $this->promoReaderInterface = $promoReaderInterface;
        $this->coll = New Collection();
    }

    public function prepare(): Collection {
        $allRecords = $this->promoReaderInterface->findAll();
        foreach ($allRecords as $item) {
            $obj = New PromoEntity(
                $item['sku'],
                $item['discount_value']
            );
            $this->coll->addItem(
                $obj, $item['sku']
            );
        }
        return $this->coll;
    }
}