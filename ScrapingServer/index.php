<?php
	include("kcMetroRealtimeScraper.php");
	$myScraper = new KcMetroRealtimeScraper();
	echo $myScraper->getData();
?>