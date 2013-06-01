<?php
	require_once "kcMetroScraper.php";

	class scraperRunner{
		public function runScraper($scraperId){
			switch($scraperId) {
				case "kc-ata-vehicles-realtime":
					$scraper = new kcMetroScraper;
					break;
				default:
					throw new Exception("unknown scraper");
					break;
			}

			$data = $scraper->getData();

			/*** do something with the data ***/
		}
	}
?>
