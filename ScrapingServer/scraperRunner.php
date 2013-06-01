<?php
	require_once "kcMetroScraper.php";

	class scraperRunner{
		public function runScraper($scraperId){
			switch($scraperId) {
				case "kc-ata-vehicles-realtime":
					$scraper = new kcMetroScraper;
					$scraper->getData();
					break;
			}
		}
	}
?>
