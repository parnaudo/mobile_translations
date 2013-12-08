<?php

$file ='ios/PhoneCodes.plist'; 

$a = (simplexml_load_file($file, null, LIBXML_NOCDATA)); 
$obj = get_object_vars($a);

$phone_codes = array(); 
foreach($obj['array'] as $obj) 
{
	$a = (get_object_vars($obj)); 
	$phone_codes[$a['string'][1]] = $a['string'][0]; 
}

function cmp($a, $b)
{
    if (strlen($a) == strlen($b))
        return 0;
    if (strlen($a) > strlen($b))
        return 1;
    return -1;
}

$nametocode = $phone_codes; 


uasort($nametocode, "cmp");
$nametocode = array_reverse($nametocode);
$str = ''; 
foreach ($nametocode as $key => $value) {
    $str .= 'price_index["' . $key.'"] = 10'."\n"; 
}

echo $str;  
?>
