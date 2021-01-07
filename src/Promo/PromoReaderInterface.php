<?php

namespace Anguis\BlackFriday\Promo;
/*
 *  Read data from source
 *  @author rbieronski <bluenow@gmail.com>
 */
interface PromoReaderInterface {

    /*
     *  return all products
     *  @return array
     */
    public function findAll(): array;
}