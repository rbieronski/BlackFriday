<?php

$xml = file_get_contents("sampleData/black_friday_2020.xml");
$xml = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

$result = [];
$arrLength = array_sum(array_map("count", $array));

for( $x = 0; $x < $arrLength; $x++ ) {
    $result[$array['promotion'][$x]['sku']] = $array['promotion'][$x]['discount_value'];
}


echo 'ok';
echo '<pre>';

//$my_array = (array)$xmlFile;


print_r($result);
echo '</pre>';
echo '-------------';
echo $array['promotion'][3]['sku'];



//
//$arr = [];
//$array = json_decode(json_encode(simplexml_load_string($xml)),true);
//if ( ! empty($array)) {
//    $i=0;
//    foreach ($array['promotion'] as $elem) {
//        $arr[$i]['sku'] = $elem['promotion']['sku'];
//        $arr[$i]['discount_value'] = $elem['promotion']['discount_value'];
//        ++$i;
//    }
//}
//echo '<pre>';print_r($arr);echo '</pre>';


//echo '<pre>';
//echo xml2array($xmlFile);
//echo '</pre>';

