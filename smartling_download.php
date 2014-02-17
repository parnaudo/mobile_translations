<?php 
//PUT IN KEYS HERE 
/*
 * curl -d "apiKey=ed1e766e-7716-4a1f-9ad6-c25f574cb683&\
fileUri=%2Ffiles%2FSmug_Description.docx&\
projectId=2dc083d42&\
locale=zh-CN"\
"https://api.smartling.com/v1/file/get"
 * 
 */
//$key="ed1e766e-7716-4a1f-9ad6-c25f574cb683";
//$project="2dc083d42";
$keys=array('ed1e766e-7716-4a1f-9ad6-c25f574cb683','fdc6e190-e855-4588-bfe0-74b7006aeab1');
$projects=array('2dc083d42','59d739850');
$key="fdc6e190-e855-4588-bfe0-74b7006aeab1";
$project="59d739850";
$test=array(
	'keys'=>$keys,
	'projects'=>$projects	
);
if(empty($key) || empty($project)){
	print "Please enter your Smartling API key and project ID above";
	exit;
}
for($i=0;$i < 2; $i++){
	$uris = get_uris ( $test['keys'][$i], $test['projects'][$i] );
	var_dump($uris);
	$languages = get_locales ( $test['keys'][$i], $test['projects'][$i] );
	get_translations ( $uris, $languages, $test['keys'][$i], $test['projects'][$i]  );
}
//$uris = get_uris ( $key, $project ); 
//$languages = get_locales ( $key, $project );
//get_translations ( $uris, $languages, $key, $project );

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
					print $locale["name"]." code is : ".$locale["locale"]."\n";
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
	$name_test='';
	curl_setopt_array($ch, $curlConfig);
	$result = curl_exec($ch);
	$result=json_decode($result,1);
		foreach($result as $response){
			foreach($response as $data){
				foreach($data as $filelist){

					foreach($filelist as $file){
						

						echo "file name is ".$file["fileType"]." name test is : $name_test";
						if($name_test==$file["fileType"]){
							echo "FILE NAME IS THE SAME!";
						}
						else{
							$file_uris[$file["fileType"]]=$file['fileUri'];
							$name_test=$file["fileType"];
						}


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


?>
