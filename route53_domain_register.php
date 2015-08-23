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


$result = $client->registerDomain([
    'AdminContact' => [ // REQUIRED
        'AddressLine1' => $_POST['address'], //required
        // 'AddressLine2' => '<string>',
        'City' => $_POST['city'], ////required
        'ContactType' =>$_POST['contact_type'], //'PERSON|COMPANY|ASSOCIATION|PUBLIC_BODY|RESELLER', //required
        'CountryCode' =>$_POST['country_code'], //'AD|AE|AF|AG|AI|AL|AM|AN|AO|AQ|AR|AS|AT|AU|AW|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BR|BS|BT|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GH|GI|GL|GM|GN|GQ|GR|GT|GU|GW|GY|HK|HN|HR|HT|HU|ID|IE|IL|IM|IN|IQ|IR|IS|IT|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PT|PW|PY|QA|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SK|SL|SM|SN|SO|SR|ST|SV|SY|SZ|TC|TD|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|YE|YT|ZA|ZM|ZW',
        'Email' => $_POST['email'], //required
        'ExtraParams' => [ 
        [
                'Name' =>'BIRTH_COUNTRY', //'DUNS_NUMBER|BRAND_NUMBER|BIRTH_DEPARTMENT|BIRTH_DATE_IN_YYYY_MM_DD|BIRTH_COUNTRY|BIRTH_CITY|DOCUMENT_NUMBER|AU_ID_NUMBER|AU_ID_TYPE|CA_LEGAL_TYPE|ES_IDENTIFICATION|ES_IDENTIFICATION_TYPE|ES_LEGAL_FORM|FI_BUSINESS_NUMBER|FI_ID_NUMBER|IT_PIN|RU_PASSPORT_DATA|SE_ID_NUMBER|SG_ID_NUMBER|VAT_NUMBER', // REQUIRED
                'Value' => $_POST['birth_country_code'], // REQUIRED
                ]
                ],
        // 'Fax' => '<string>', 
        'FirstName' => $_POST['fname'], //required
        'LastName' => $_POST['lname'], //required
        // 'OrganizationName' => '<string>',
        'PhoneNumber' => $_POST['phone'], //required
        // 'State' => $_POST['state'], 
        'ZipCode' => $_POST['zip'],//
        ],
    'AutoRenew' => ($_POST['renew']=="1")? true:false,//true || false,
    'DomainName' => $_POST['domain'], // REQUIRED
    'DurationInYears' => intval($_POST['duration']), // REQUIRED
    // 'IdnLangCode' => '<string>',
    'PrivacyProtectAdminContact' => ($_POST['PrivacyProtectAdminContact']=="1")? true:false, //true || false,
    'PrivacyProtectRegistrantContact' =>($_POST['PrivacyProtectRegistrantContact']=="1")? true:false, //true || false,
    'PrivacyProtectTechContact' =>($_POST['PrivacyProtectTechContact']=="1")? true:false, //true || false,
    'RegistrantContact' => [ // REQUIRED
        'AddressLine1' => $_POST['address'], //required
        // 'AddressLine2' => '<string>',
        'City' => $_POST['city'], ////required
        'ContactType' =>$_POST['contact_type'], //'PERSON|COMPANY|ASSOCIATION|PUBLIC_BODY|RESELLER', //required
        'CountryCode' =>$_POST['country_code'], //'AD|AE|AF|AG|AI|AL|AM|AN|AO|AQ|AR|AS|AT|AU|AW|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BR|BS|BT|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GH|GI|GL|GM|GN|GQ|GR|GT|GU|GW|GY|HK|HN|HR|HT|HU|ID|IE|IL|IM|IN|IQ|IR|IS|IT|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PT|PW|PY|QA|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SK|SL|SM|SN|SO|SR|ST|SV|SY|SZ|TC|TD|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|YE|YT|ZA|ZM|ZW',
        'Email' => $_POST['email'], //required
        'ExtraParams' => [ 
        [
                'Name' =>'BIRTH_COUNTRY', //'DUNS_NUMBER|BRAND_NUMBER|BIRTH_DEPARTMENT|BIRTH_DATE_IN_YYYY_MM_DD|BIRTH_COUNTRY|BIRTH_CITY|DOCUMENT_NUMBER|AU_ID_NUMBER|AU_ID_TYPE|CA_LEGAL_TYPE|ES_IDENTIFICATION|ES_IDENTIFICATION_TYPE|ES_LEGAL_FORM|FI_BUSINESS_NUMBER|FI_ID_NUMBER|IT_PIN|RU_PASSPORT_DATA|SE_ID_NUMBER|SG_ID_NUMBER|VAT_NUMBER', // REQUIRED
                'Value' => $_POST['birth_country_code'], // REQUIRED
                ]
                ],
        // 'Fax' => '<string>', 
        'FirstName' => $_POST['fname'], //required
        'LastName' => $_POST['lname'], //required
        // 'OrganizationName' => '<string>',
        'PhoneNumber' => $_POST['phone'], //required
        // 'State' => $_POST['state'], 
        'ZipCode' =>$_POST['zip'],//
        ],
    'TechContact' => [ // REQUIRED
        'AddressLine1' => $_POST['address'], //required
        // 'AddressLine2' => '<string>',
        'City' => $_POST['city'], ////required
        'ContactType' =>$_POST['contact_type'], //'PERSON|COMPANY|ASSOCIATION|PUBLIC_BODY|RESELLER', //required
        'CountryCode' =>$_POST['country_code'], //'AD|AE|AF|AG|AI|AL|AM|AN|AO|AQ|AR|AS|AT|AU|AW|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BR|BS|BT|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GH|GI|GL|GM|GN|GQ|GR|GT|GU|GW|GY|HK|HN|HR|HT|HU|ID|IE|IL|IM|IN|IQ|IR|IS|IT|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PT|PW|PY|QA|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SK|SL|SM|SN|SO|SR|ST|SV|SY|SZ|TC|TD|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|YE|YT|ZA|ZM|ZW',
        'Email' => $_POST['email'], //required
        'ExtraParams' => [ 
        [
                'Name' =>'BIRTH_COUNTRY', //'DUNS_NUMBER|BRAND_NUMBER|BIRTH_DEPARTMENT|BIRTH_DATE_IN_YYYY_MM_DD|BIRTH_COUNTRY|BIRTH_CITY|DOCUMENT_NUMBER|AU_ID_NUMBER|AU_ID_TYPE|CA_LEGAL_TYPE|ES_IDENTIFICATION|ES_IDENTIFICATION_TYPE|ES_LEGAL_FORM|FI_BUSINESS_NUMBER|FI_ID_NUMBER|IT_PIN|RU_PASSPORT_DATA|SE_ID_NUMBER|SG_ID_NUMBER|VAT_NUMBER', // REQUIRED
                'Value' => $_POST['birth_country_code'], // REQUIRED
                ]
                ],
        // 'Fax' => '<string>', 
        'FirstName' => $_POST['fname'], //required
        'LastName' => $_POST['lname'], //required
        // 'OrganizationName' => '<string>',
        'PhoneNumber' => $_POST['phone'], //required
        // 'State' => $_POST['state'], 
        'ZipCode' => $_POST['zip'],//
        ],
        ]);

if(!empty($result)){
	$result=$result->toArray();
	if(!empty($result)){
		$_SESSION['new_domain']=array("opperation_id"=>$result['OperationId'],"status"=>true);
	}
}
else{
$_SESSION['new_domain']=array("opperation_id"=>"","status"=>false);
}


header("Location: /aws_r53/domain_home.php");


// }
?>