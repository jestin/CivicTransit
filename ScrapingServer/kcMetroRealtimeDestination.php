<?php
	require_once "dataDestination.php";
	
	class kcMetroRealtimeDestination implements dataDestination {
		public function send($data) {
			/*** write to database ***/
			if (class_exists('Mongo')) {
				$m = new MongoClient(); // connect
				$db = $m->selectDB("transit");
				$record = json_decode('{ "scraperId" : "kc-ata-vehicles-realtime", "timestamp" : ' . time() . ', "raw" : ' . $data . ' }');
				$db->RawScrapes->save($record);
			} else {
				error_log('Mongo not installed');
			}
		}
	}
?>
