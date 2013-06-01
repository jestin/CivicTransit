<?php
	require_once "scraper.php";

	class KcMetroRealtimeScraper implements scraper {
		public $scraperId = "kc-ata-vehicles-realtime";

		public function getData(){
			$startTime = microtime(true);
			//$baseURL = "http://tmweb.pacebus.com/TMWebWatch/";
			$baseURL = "http://www.kc-metro.com/tmwebwatch/";

			$routeListGetter = curl_init();
			curl_setopt($routeListGetter, CURLOPT_URL, $baseURL."Arrivals.aspx/getRoutes");
			curl_setopt($routeListGetter, CURLOPT_POST, true);
			curl_setopt($routeListGetter, CURLOPT_HTTPHEADER, array(
				'Content-Length:0',
				'Content-Type:application/json;	charset=UTF-8'));
			curl_setopt($routeListGetter, CURLOPT_RETURNTRANSFER, true);
			$response = json_decode(curl_exec($routeListGetter),true);
			curl_close($routeListGetter);
			$routeList = $response["d"];

			ob_start();
			$theMessage = array();
			$theMessage["message"] = array();
			$theMessage["message"]["header"] = array("gtfs_realtime_version"=>"1.0","incrementality"=>"FULL_DATASET");

			/*for($i = 0; $i<sizeof($routeList); $i++){
				echo "<h1>".$routeList[$i]["name"]."</h1>";
				$data_string = '{routeID: '.$routeList[$i]["id"].'}';
				echo $data_string;
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $baseURL."GoogleMap.aspx/getVehicles");
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type:application/json;	charset=UTF-8'
					));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$theRoute = json_decode(curl_exec($ch),true);
				echo "<pre>";
				print_r($theRoute);
				echo "</pre>";
				curl_close($ch);
			}
			$endTime = microtime(true);
			$pageTime = $endTime-$startTime;
			echo "<h1>".$pageTime."</h1>";*/
			
			print_r($theMessage);

			return ob_get_clean();
		}
	}
?>
