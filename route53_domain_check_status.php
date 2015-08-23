<?php
session_start();
// if(!empty($_SESSION['user'])){

require 'vendor/autoload.php';
use Aws\Route53Domains\Route53DomainsClient;
$access_key='AKIAJCE4ZDY4NPCMCZMA';
$secret_key='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';

$client = Route53DomainsClient::factory(
	array(
		'version' => 'latest',
		'region'  => "us-east-1",
		'credentials' => array(
			'key' => $access_key,
			'secret'  => $secret_key,
			)
		)
	);
	//public function is_domain_available($domain)
	//{
$result = $client->getOperationDetail([
    'OperationId' => $_POST['OperationId'], // REQUIRED //39f70360-cbc8-4637-8c44-9835c0eef1c4
    ]);
	//}
	//$result=is_domain_available($_POST['new_domain']);
if(!empty($result)){
	$result=$result->toArray();
	if(!empty($result)){
		$data=array("status"=>$result['Status'],"domain"=>$result['DomainName']);
		$data['operation_id']=$result['OperationId'];
		$data['type']=$result['Type'];
		$data['msg']=$result['Message'];
		$_SESSION['sdomain']=$data;
	}
}
else{
	$_SESSION['sdomain']=array("flag"=>false);
}
header("Location: /aws_r53/domain_home.php");


// }
?>