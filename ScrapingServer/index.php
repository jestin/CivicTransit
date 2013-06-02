<?php
	$loopTime = 10;
	require_once("scraperRunner.php");
	$runner = new scraperRunner();
	if($_GET["loop"]==true){
		for($i = 0; $i<60/(($i+1)*$loopTime); $i++){
			$theData = $runner->runScraper("kc-ata-vehicles-realtime");
			file_put_contents('../GTFS-Realtime/realtimeData.json',$theData);
			sleep($loopTime);
		}
	}else{
		header('Content-type: application/json');
		$theData = $runner->runScraper("kc-ata-vehicles-realtime");
		echo $theData;
		file_put_contents('../GTFS-Realtime/realtimeData.json',$theData);
	}
?>
