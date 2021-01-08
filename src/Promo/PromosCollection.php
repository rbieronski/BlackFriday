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
        foreach ($allRecords as $key=>$value) {
            $obj = New PromoEntity(
                $key,
                $value
            );
            $this->coll->addItem(
                $obj, $key
            );
        }
        return $this->coll;
    }
}