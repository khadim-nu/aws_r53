<?php
session_start();
// if(!empty($_SESSION['user'])){
require 'vendor/autoload.php';
use Aws\Route53\Route53Client;

$access_key='AKIAJCE4ZDY4NPCMCZMA';
$secret_key='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';

$client = Route53Client::factory(
	array(
		'version' => 'latest',
		'region'  => "us-east-1",
		'credentials' => array(
			'key' => $access_key,
			'secret'  => $secret_key,
			)
		)
	);

	//$result = $client->getHostedZoneCount(array());
$result = $client->getHostedZone([
    'Id' => $_POST['zone_id']   //'ZTGQ8LFNF8MB3', // REQUIRED
    ]);
if(!empty($result)){
	$result=$result->toArray();
	$_SESSION['hosted_zone']=array("ns"=>$result['DelegationSet']['NameServers'],"id"=>$result['HostedZone']['Id'],"name"=>$result['HostedZone']['Name'],"Config"=>$result['HostedZone']['Config'],"rrc"=>$result['HostedZone']['ResourceRecordSetCount'],"status"=>true);
}
else{
	$_SESSION['hosted_zone']=array("ns"=>array(),"status"=>false);
}
header("Location: /aws_r53/home.php");

// }
