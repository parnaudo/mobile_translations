<?php 
require "smartlingDownloadClass.php";
function get_locales($key,$project){
	$ch = curl_init();
	$curlConfig = array(
			CURLOPT_URL            => "https://api.smartling.com/v1/project/locale/list",
			CURLOPT_POST           => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS     => array(
					'apiKey' => $key,
					'projectId' => $project
			),
	);
	curl_setopt_array($ch, $curlConfig);
	$result = curl_exec($ch);
	$result=json_decode($result,1);        
	foreach($result as $response){
		foreach($response as $data){
			foreach($data as $locales){
				foreach($locales as $locale){   
					//echo $locale["name"]." code is : ".$locale["locale"]."<BR>";
					$languages[$locale["name"]]=$locale["locale"];
					
				}

			}
	
		}
	
	}
	curl_close($ch);
	return $languages;
}

function get_uris($key,$project){
	$ch = curl_init();
	$curlConfig = array(
			CURLOPT_URL            => "https://api.smartling.com/v1/file/list",
			CURLOPT_POST           => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POSTFIELDS     => array(
					'apiKey' => $key,
					'projectId' => $project
			),
	);
	curl_setopt_array($ch, $curlConfig);
	$result = curl_exec($ch);
	$result=json_decode($result,1);
		foreach($result as $response){
			foreach($response as $data){
				foreach($data as $filelist){
					foreach($filelist as $file){
						$file_uris[$file["fileType"]]=$file['fileUri'];
					}
				}
			}
		}		
	curl_close($ch);
	return $file_uris;
}


function get_translations($uris,$languages,$key,$project){
	foreach($uris as $type=>$file){
		foreach ($languages as $language){
			$ch = curl_init();
			$curlConfig = array(
					CURLOPT_URL            => "https://api.smartling.com/v1/file/get",
					CURLOPT_POST           => true,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING       => "",
					CURLOPT_POSTFIELDS     => array(
							'apiKey' => $key,
							'projectId' => $project,
							'fileUri'=>$file,
							'locale'=>$language
					),
			);
			//var_dump($curlConfig);
			curl_setopt_array($ch, $curlConfig);
			$result = curl_exec($ch);
			$filename=format_filename($type,$language,$file);
			file_put_contents($filename,$result);
			//$result=json_decode($result,1);
			print "Creating ".$filename." file translation for this language: $language \n";
		}
	}
	
}

function format_filename($type,$language,$file){
	$base="translations/$type/";
	if($type=="yaml"){
		$language=str_replace("-en","",$language);
		$filename=$base."$language.yml";
	}
	else{
		$file=str_replace("/files/","$language-",$file);
		$filename=$base."$file";
	}
	return $filename;
}



//$test=new smartling_downloader($key,$project);


$uris = get_uris ( $key, $project );
$languages = get_locales ( $key, $project );
get_translations ( $uris, $languages, $key, $project );

?>
