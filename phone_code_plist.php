<?php
$file ='ios/PhoneCodes.plist'; 

if (!isset($argv[1]) 
{
	echo "Please enter a country code. eg: 'it'";
	exit;  
}

$a = (simplexml_load_file($file, null, LIBXML_NOCDATA)); 
$obj = get_object_vars($a);

$phone_codes = array(); 
foreach($obj['array'] as $obj) 
{
	$a = (get_object_vars($obj)); 
	$phone_codes[$a['string'][1]] = $a['string'][0]; 
}



print_r($phone_codes);
echo "\n"; 
?>
