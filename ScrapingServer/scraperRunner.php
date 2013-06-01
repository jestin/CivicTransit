<?php
	require_once "kcMetroScraper.php";
	require_once "kcMetroDestination.php";

	class scraperRunner {
		public function runScraper($scraperId) {
			switch($scraperId) {
				case "kc-ata-vehicles-realtime":
					$scraper = new kcMetroScraper();
					$destination = new kcMetroDestination();
					break;
				default:
					throw new Exception("unknown scraper");
					break;
			}

			$data = $scraper->getData();
			$destination->send($data);
		}
	}
?>
