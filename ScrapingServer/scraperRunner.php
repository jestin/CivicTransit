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

			$data = $scraper->getData();
			$destination->send($data);
			return $data;
		}
	}
?>
