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

$result = $client->getHealthCheckStatus([
    'HealthCheckId' => $_POST['id'] // REQUIRED
]);

$data=array();
if(!empty($result)){
	$result=$result->toArray();
	$data['status']=true;
	$data['ip']=$result['HealthCheckObservations'][0]['IPAddress'];
	$data['health_status']=$result['HealthCheckObservations'][0]['StatusReport']['Status'];
}
else{
	$data['status']=false;
}

$_SESSION['health_check_get']=$data;

header("Location: /aws_r53/home.php");

// }
