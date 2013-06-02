<?php
require_once('DrSlump/Protobuf.php');
require_once('gtfs-realtime-proto.php');

\DrSlump\Protobuf::autoload();

$jsonFileContents = file_get_contents('realtimeData.json');

$theData = json_decode($jsonFileContents, true);
$theMessage = $theData["message"];

print_r($theMessage);

$codec = new \DrSlump\Protobuf\Codec\PhpArray();

$buf = new transit_realtime\FeedMessage();
$bufHeader = new transit_realtime\FeedHeader();
$bufEntity = new transit_realtime\FeedEntity();

$bufHeader->setGtfsRealtimeVersion("1.0");
$bufHeader->setIncrementality(0);
$bufHeader->setTimestamp();

$buf->setHeader($bufHeader);
$buf->setEntity($bufEntity);

?>