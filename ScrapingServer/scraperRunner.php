<?php
	require_once "kcMetroRealtimeScraper.php";
	require_once "kcMetroRealtimeDestination.php";

	class scraperRunner {
		public function runScraper($scraperId) {
			switch($scraperId) {
				case "kc-ata-vehicles-realtime":
					$scraper = new kcMetroRealtimeScraper();
					$destination = new kcMetroRealtimeDestination();
					break;
				default:
					throw new Exception("unknown scraper");
					break;
			}

			if (class_exists('Mongo')) {
				$m = new MongoClient(); // connect
				$db = $m->selectDB("transit");
				
				$cursor = $db->RawScrapes->find(array('scraperId' => $scraperId))->sort(array('timestamp' => -1))->limit(1);
				$curtime = time();
				foreach($cursor as $doc) {
					$timestamp = strtotime($doc['timestamp']);
					$timesince = $curtime - $timestamp;
					if(date("s",$timesince) < 15 ){
						return json_encode($doc['raw'], JSON_PRETTY_PRINT); 
					}
				}
			}
			
			
			$data = $scraper->getData();
			$destination->send($data);
			
			return $data;
		}
	}
?>
