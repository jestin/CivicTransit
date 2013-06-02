<?php
	include("kcMetroRealtimeScraper.php");
	$myScraper = new KcMetroRealtimeScraper();
	$theData = $myScraper->getData();
	echo $theData;
	$outputFile = fopen('../GTFS-Realtime/realtimeData.json', 'c');
	flock($outputFile, 'LOCK_EX');
	fwrite($outputFile, $theData);
	flock($outputFile, 'LOCK_UN');
	fclose($outputFile);
	//file_put_contents('../GTFS-Realtime/realtimeData.json',$theData);
?>