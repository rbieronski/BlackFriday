<?php

namespace Anguis\BlackFriday\details;

/**
 *  Read data from source
 *  and prepare for use by ?????
 *  @author rbieronski <bluenow@gmail.com>
 */
interface DetailsReaderInterface {

	/*
	 * return all rows with sku
	 * @return array[]
	 */
	public function findAll(): array;

	/*
	 * return specified row-sku
	 * @return array[]
	 */
	public function findBySku(string $sku): array();
}
