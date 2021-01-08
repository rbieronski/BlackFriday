<?php

namespace Anguis\BlackFriday\Reader\Promo;

/**
 * Read promo prices from xml file
 * @author rbieronski <bluenow@gmail.com>
 */
class XmlPromoReader implements PromoReaderInterface
{
    protected string $xmlPath;

    function __construct(string $xmlPath)
    {
        $this->xmlPath = $xmlPath;
    }

    public function findAll(): array
    {
        $xml = file_get_contents($this->xmlPath);
        $xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);

        $result = [];
        $arrLength = array_sum(array_map("count", $array));

        for( $x = 0; $x < $arrLength; $x++ ) {
            $result[$array['promotion'][$x]['sku']] =
                $array['promotion'][$x]['discount_value'];
        }
        return $result;
    }
}