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
$domain_name=$_POST['new_domain'];
$result = $client->checkDomainAvailability([
    'DomainName' => $_POST['new_domain'], // REQUIRED
    'IdnLangCode' => ''
    ]);
	//}
	//$result=is_domain_available($_POST['new_domain']);
if(!empty($result)){
	$result=$result->toArray();
	if(!empty($result)){
		$_SESSION['rdomain']=array("status"=>$result['Availability'],"domain"=>$domain_name);
	}
}
else{
	$_SESSION['rdomain']=array("status"=>"Some thing went wrong!","domain"=>$domain_name);
}

header("Location: /aws_r53/home.php");


// }
?>