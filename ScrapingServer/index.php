<?php
	include("kcMetroRealtimeScraper.php");
	$myScraper = new KcMetroRealtimeScraper();
	$theData = $myScraper->getData();
	echo $theData;
?>