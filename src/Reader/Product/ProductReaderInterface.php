<?php

namespace Anguis\BlackFriday\Reader\Product;

/**
 *  Read data from source
 *  @author rbieronski <bluenow@gmail.com>
 */
interface ProductReaderInterface
{
	/*
	 * return all products
	 * @return array[]
	 */
	public function findAll(): array;
}
