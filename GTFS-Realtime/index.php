<?php
require_once('DrSlump/Protobuf.php');
\DrSlump\Protobuf::autoload();

require_once('gtfs-realtime-proto.php');

$jsonFileContents = file_get_contents('realtimeData.json');

$theData = json_decode($jsonFileContents, true);
$theMessage = $theData["message"];

echo "Here's jsonFileContents.";
echo $jsonFileContents;
echo "Here's theData.";
print_r($theData);
//print_r($theMessage);

/*$codec = new DrSlump\Protobuf\Codec\Json();

$buf = new transit_realtime\FeedMessage();

	$bufHeader = new transit_realtime\FeedHeader();
		$bufHeader->setGtfsRealtimeVersion($theMessage["header"]["gtfs_realtime_version"]);
		$bufHeader->setIncrementality(0);
		$bufHeader->setTimestamp($theMessage["header"]["timestamp"]);
	$buf->setHeader($bufHeader);

	$bufEntity = new transit_realtime\FeedEntity();
		$bufEntity->setId($theMessage["entity"]["id"]);
		$bufVehicle = new transit_realtime\VehiclePosition();
			//$bufVehicle->setVehicle()
		$bufEntity->setVehicle($bufVehicle);
	$buf->setEntity($bufEntity);

$output = $codec->encode($buf);
echo $output;*/
?>