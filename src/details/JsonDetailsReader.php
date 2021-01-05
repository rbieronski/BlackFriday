<?php

namespace Anguis\BlackFriday\details;

/**
 *  Read data directly from .json file
 *  and prepare by use by ???
 *  @author rbieronski <bluenow@gmail.com>
 */
class JsonDetailsReder implements DetailsReaderInterface {

	protected string $jsonPath;

	function __construct(string $jsonPath) {
		$this->jsonPath = $jsonPath;
	}

	/**
	 *  read all rows
	 *  @return array[]
	 */
	public function findAll(): array {
		return json_decode(file_get_contents($this->jsonPath), true);
	}

	/**
	 *  read specified row
	 *  @return array[];
	 */
	public function findBySku(string $sku): array {
 		$result = [];
 		$allRecords = $this->findAll();
 		foreach ($all as $val) {
 			if ($val['sku'] == $sku) {
 				$result;
 				// break or continue2?
 			}
 			return $result;
 		}
	}
}