<?php
	require_once "dataDestination.php";
	
	class kcMetroRealtimeDestination implements dataDestination {
		public function send($data) {
			/*** write to database ***/
			if (class_exists('Mongo')) {
				$m = new MongoClient(); // connect
				$db = $m->selectDB("transit");
			} else {
				error_log('Mongo not installed');
			}
		}
	}
?>
