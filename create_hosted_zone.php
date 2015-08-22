<?php
session_start();
// if(!empty($_SESSION['user'])){
require 'vendor/autoload.php';
use Aws\Route53\Route53Client;

$access_key='AKIAJCE4ZDY4NPCMCZMA';
$secret_key='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';

$unique_key = md5(microtime().rand());

// $client = Route53Client::factory(
// 	array(
// 		'version' => 'latest',
// 		'region'  => "us-east-1",
// 		'credentials' => array(
// 			'key' => $access_key,
// 			'secret'  => $secret_key,
// 			)
// 		)
// 	);

// $result = $client->createHostedZone([
//     'CallerReference' => '42424242', // REQUIRED
//     // 'DelegationSetId' => '',
//     'HostedZoneConfig' => [
//     'Comment' => 'No comment',
//     'PrivateZone' => true,
//     ],
//     'Name' => $_POST['domain'].".", // REQUIRED
//     'VPC' => [
//     'VPCId' => '',
//     'VPCRegion' => 'us-east-1|us-west-1|us-west-2|eu-west-1|eu-central-1|ap-southeast-1|ap-southeast-2|ap-northeast-1|sa-east-1|cn-north-1',
//     ],
//     ]);

// var_dump($result);


// if(!empty($result)){
// 	$result=$result->toArray();
// 	$_SESSION['hosted_zone']=array("ns"=>$result['DelegationSet']['NameServers'],"id"=>$result['HostedZone']['Id'],"name"=>$result['HostedZone']['Name'],"Config"=>$result['HostedZone']['Config'],"rrc"=>$result['HostedZone']['ResourceRecordSetCount'],"status"=>true);
// }
// else{
// 	$_SESSION['hosted_zone']=array("ns"=>array(),"status"=>false);
// }



function get_served(){
	require_once('r53.php');
	$access_key='AKIAJCE4ZDY4NPCMCZMA';
	$secret_key='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';
	$r53 = new Route53($access_key, $secret_key);
	$unique_key = md5(microtime().rand());
	$result = $r53->createHostedZone($_POST['domain'], $unique_key, 'no cooment here');
	if(!empty($result)){
		//var_dump($result);
		$_SESSION['hosted_zone']=array("ns"=>$result['NameServers'],"id"=>$result['HostedZone']['Id'],"name"=>$result['HostedZone']['Name'],"Config"=>$result['HostedZone']['Config'],"rrc"=>$result['HostedZone']['ResourceRecordSetCount'],"status"=>true);
	}
	else{
		$_SESSION['hosted_zone']=array("ns"=>array(),"status"=>false);
	}
}
get_served();
header("Location: /aws_r53/home.php");

// }
