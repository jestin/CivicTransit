<?php
	require_once "scraper.php";

	class KcMetroRealtimeScraper implements scraper {

		public $scraperId = "kc-ata-vehicles-realtime";

		public function getData(){
			$startTime = microtime(true);
			
			// This scraper works with any TMWebWatch system, such as KCATA or Pace in Suburban Chicago
			$baseURL = "http://www.kc-metro.com/tmwebwatch/";
			//$baseURL = "http://tmweb.pacebus.com/TMWebWatch/";

			// Retrieve all available routes in a list, $routeList
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
			
			// Set up the message and its header information
			$theMessage = array();
			$theMessage["message"] = array();
			$theMessage["message"]["header"] = array("gtfs_realtime_version"=>"1.0","incrementality"=>"FULL_DATASET","timestamp"=>time());
			$theEntity = array();
			$theVehicle = array();
			
			for($i = 0; $i<sizeof($routeList); $i++){
			
				
				$data_string = '{routeID: '.$routeList[$i]["id"].'}';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $baseURL."GoogleMap.aspx/getVehicles");
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type:application/json;	charset=UTF-8'
					));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$theRoute = json_decode(curl_exec($ch),true);
				$theRoute = $theRoute["d"];
				//print_r($theRoute);
				curl_close($ch);
				
				// Given a route in $theRoute, iterate over the vehicles servicing each route
				for($j = 0; $j<sizeof($theRoute); $j++){
					$thisInfo = array();
					
					if(sizeof($theRoute)>1){
						// Multiple bus routes have only route_id assigned.
						$thisInfo["trip"] = array(
							"route_id"=>""
						);
					}else{
						// Single-bus routes have trip_id and route_id assigned.
						$thisInfo["trip"] = array(
							"trip_id"=>"",
							"route_id"=>""
						);
					}
					
					$thisInfo["vehicle"] = array(
						"id"=>$theRoute[$j]["propertyTag"],
						"label"=>$theRoute[$j]["propertyTag"],
						"license_plate"=>$theRoute[$j]["propertyTag"]
					);
					
					$thisInfo["position"] = array(
						"latitude"=>floatval($theRoute[$j]["lat"]),
						"longitude"=>floatval($theRoute[$j]["lon"]),
						"bearing"=>floatval($theRoute[$j]["compassDirection"])
					);
					
					$theVehicle[] = $thisInfo;
				}
			}
			
			// Complete message generation
			$theEntity["id"] = md5(serialize($theVehicle));
			$theEntity["vehicle"] = $theVehicle;
			$theMessage["message"]["entity"] = $theEntity;
			$endTime = microtime(true);
			$pageTime = $endTime-$startTime;
			$theMessage["generationTime"] = $pageTime;
			$theMessage["numberOfRoutes"] = sizeof($routeList);
			$theMessage["numberOfVehicles"] = sizeof($theVehicle);
			
			// Message output
			ob_start();
			header('Content-type: application/json');
			$returnMessage = json_encode($theMessage, JSON_PRETTY_PRINT);
			echo $returnMessage;
			return ob_get_clean();
		}
		
	}
?>
