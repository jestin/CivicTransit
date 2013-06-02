<?php
require_once('DrSlump/Protobuf.php');
\DrSlump\Protobuf::autoload();

require_once('gtfs-realtime-proto.php');

$json = file_get_contents('realtimeData.json');
$theData = json_decode($json, true);

$theMessage = $theData["message"];
print_r($theMessage);

$codec = new DrSlump\Protobuf\Codec\Json();

$buf = new transit_realtime\FeedMessage();

	$bufHeader = new transit_realtime\FeedHeader();
		$bufHeader->setGtfsRealtimeVersion($theMessage["header"]["gtfs_realtime_version"]);
		$bufHeader->setIncrementality(0);
		$bufHeader->setTimestamp($theMessage["header"]["timestamp"]);
	$buf->setHeader($bufHeader);

	for($i = 0; $i<sizeof($theMessage["entities"]); $i++){
		$bufEntity = new transit_realtime\FeedEntity();
			$bufEntity->clearIsDeleted();
			$bufEntity->setId($theMessage["entities"][$i]["id"]);
			$bufVehiclePosition = new transit_realtime\VehiclePosition();
				$bufVehiclePosition->clearCurrentStatus();
				$bufVehicleDescriptor = new transit_realtime\VehicleDescriptor();
					$bufVehicleDescriptor->setId($theMessage["entities"][$i]["vehicle"]["vehicle"]["id"]);
					$bufVehicleDescriptor->setLabel($theMessage["entities"][$i]["vehicle"]["vehicle"]["label"]);
					$bufVehicleDescriptor->setLicensePlate($theMessage["entities"][$i]["vehicle"]["vehicle"]["license_plate"]);
				$bufVehiclePosition->setVehicle($bufVehicleDescriptor);
				$bufVehicleLatLon = new transit_realtime\Position();
					$bufVehicleLatLon->setLatitude($theMessage["entities"][$i]["vehicle"]["position"]["latitude"]);
					$bufVehicleLatLon->setLongitude($theMessage["entities"][$i]["vehicle"]["position"]["longitude"]);
					$bufVehicleLatLon->setBearing($theMessage["entities"][$i]["vehicle"]["position"]["bearing"]);
				$bufVehiclePosition->setPosition($bufVehicleLatLon);
			$bufEntity->setVehicle($bufVehiclePosition);
		$buf->addEntity($bufEntity);
	}

$output = $codec->encode($buf);
echo $output;
?>