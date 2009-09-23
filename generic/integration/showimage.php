<?php
include 'libwiris.php';

function createImage($config, $formulaPath, $imagePath) {
	if (is_file($formulaPath) && ($handle = fopen($formulaPath, 'r')) !== false) {
		if (($line = fgets($handle)) !== false) {
			$mathml = $line;
			
			if (($line = fgets($handle)) !== false) {
				$config['wirisimagebgcolor'] = $line;
				
				if (($line = fgets($handle)) !== false) {
					$config['wirisimagesymbolcolor'] = $line;
					
					if (($line = fgets($handle)) !== false) {
						$config['wiristransparency'] = $line;
						
						if (($line = fgets($handle)) !== false) {
							$config['wirisimagefontsize'] = $line;
							
							if (($line = fgets($handle)) !== false) {
								$config['wirisimagenumbercolor'] = $line;
								
								if (($line = fgets($handle)) !== false) {
									$config['wirisimageidentcolor'] = $line;
								}
							}
						}
					}
				}
			}
		}
		
		fclose($handle);
		
		// Retrocompatibility: when wirisimagenumbercolor is not defined
		
		if (!isset($config['wirisimagenumbercolor'])) {
			$config['wirisimagenumbercolor'] = $config['wirisimagesymbolcolor'];
		}
		
		// Retrocompatibility: when wirisimageidentcolor is not defined
		
		if (!isset($config['wirisimageidentcolor'])) {
			$config['wirisimageidentcolor'] = $config['wirisimagesymbolcolor'];
		}

		$postdata = http_build_query(
			array(
				'mml' => $mathml,
				'bgColor' => $config['wirisimagebgcolor'],
				'symbolColor' => $config['wirisimagesymbolcolor'],
				'numberColor' => $config['wirisimagenumbercolor'],
				'identColor' => $config['wirisimageidentcolor'],
				'transparency' => $config['wiristransparency'],
				'fontSize' => $config['wirisimagefontsize']
			)
		);
		
		$contextArray = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'content' => $postdata
			)
		);

		if (isset($config['wirisproxy']) && $config['wirisproxy'] == 'true') {
			$contextArray['http']['proxy'] = 'tcp://' . $config['wirisproxy_host'] . ':' . $config['wirisproxy_port'];
			$contextArray['http']['request_fulluri'] = true;
		}

		$context = stream_context_create($contextArray);

		if (($response = file_get_contents('http://' . $config['wirisimageservicehost'] . ':' . $config['wirisimageserviceport'] . $config['wirisimageservicepath'], false, $context)) === false) {
			return false;
		}

		file_put_contents($imagePath, $response);
		return true;
	}
	
	return false;
}

if (empty($_GET['formula'])) {
	echo 'Error: no image name has been sended.';
}
else {
	$formula = rtrim(basename($_GET['formula']), '.png');
	$imagePath = $cacheDirectory . '/' . $formula . '.png';
	$config = parse_ini_file(WRS_CONFIG_FILE);
	
	if (is_file($imagePath) || createImage($config, $formulaDirectory . '/' . $formula . '.xml', $imagePath)) {
		header('Content-Type: image/png');
		readfile($imagePath);
	}
	else {
		echo 'Error creating the image.';
	}
}
