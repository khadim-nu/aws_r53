<?php
session_start();
function get_served(){
	require_once('r53.php');
	
	//////////////////
	require_once('/connectivity/aws_keys.php');
	$keys=aws_keys();
	$access_key=$keys['access_key'];
	$secret_key=$keys['secret_key'];
//////////////////////////

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

