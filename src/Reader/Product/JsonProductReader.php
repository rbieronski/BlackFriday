<?php

namespace Anguis\BlackFriday\Reader\Product;

/**
 * Read data directly from .json file
 * to array
 * @author rbieronski <bluenow@gmail.com>
 */
class JsonProductReader implements ProductReaderInterface
{
	protected string $jsonPath;

	function __construct(string $jsonPath)
    {
		$this->jsonPath = $jsonPath;
	}

	/**
	 *  read all rows
	 *  @return array[]
	 */
	public function findAll(): array
    {
        return json_decode(file_get_contents($this->jsonPath), true);
	}
}