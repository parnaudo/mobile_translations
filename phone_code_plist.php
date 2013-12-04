<?php

$file ='ios/PhoneCodes.plist'; 

if (!isset($argv[1])) 
{
	echo "Please enter a country code. eg: 'it'";
	exit;  
}

$out = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<array>';

$a = (simplexml_load_file($file, null, LIBXML_NOCDATA)); 
$obj = get_object_vars($a);

$phone_codes = array(); 
foreach($obj['array'] as $obj) 
{
	$a = (get_object_vars($obj)); 
	$phone_codes[$a['string'][1]] = $a['string'][0]; 
}

$file = 'ios/country_'.$argv[1].".txt"; 
$handle = @fopen($file, "r");

if (!$handle) 
{
	echo $file. " does not exist"; 
}

while (($line = fgets($handle, 4096)) !== false) {
	$exp = explode("=", $line); 
	$country = trim(str_replace("\"", "", $exp[0])); 
	$lang_country = str_replace("\"", "", $exp[0]); 
	$lang_country = str_replace(";", "", $lang_country ); 

	$str = "
	<dict>
           <key>code</key>
           <string>".$phone_codes[$country]."</string>
           <key>country<key>
           <string>".trim($lang_country)."</string>
        </dict>"; 
	$out .= $str; 	
}

$out .= '</array>
	</plist>'; 

$out_file = 'ios/PhoneCodes_'.$argv[1].'.plist';
file_put_contents($out_file, $out);
?>
