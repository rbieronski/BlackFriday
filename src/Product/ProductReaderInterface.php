<?php

namespace Anguis\BlackFriday\Product;

/**
 *  Read data from source
 *  and prepare for use by ?????
 *  @author rbieronski <bluenow@gmail.com>
 */
interface ProductReaderInterface {

	/*
	 * return all products
	 * @return array[]
	 */
	public function findAll(): array;
}
