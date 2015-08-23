<?php
session_start();
$base_dir  = __DIR__; // Absolute path to your installation, ex: /var/www/mywebsite
$doc_root  = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']); # ex: /var/www
$base_url  = preg_replace("!^${doc_root}!", '', $base_dir); # ex: '' or '/mywebsite'
$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$port      = $_SERVER['SERVER_PORT'];
$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
$domain    = $_SERVER['SERVER_NAME'];
$base_url  = "${protocol}://${domain}${disp_port}${base_url}/";

if(empty($_SESSION['user'])){
    header("Location: /aws_r53/index.php");
}

$country_codes='AD|AE|AF|AG|AI|AL|AM|AN|AO|AQ|AR|AS|AT|AU|AW|AZ|BA|BB|BD|BE|BF|BG|BH|BI|BJ|BL|BM|BN|BO|BR|BS|BT|BW|BY|BZ|CA|CC|CD|CF|CG|CH|CI|CK|CL|CM|CN|CO|CR|CU|CV|CX|CY|CZ|DE|DJ|DK|DM|DO|DZ|EC|EE|EG|ER|ES|ET|FI|FJ|FK|FM|FO|FR|GA|GB|GD|GE|GH|GI|GL|GM|GN|GQ|GR|GT|GU|GW|GY|HK|HN|HR|HT|HU|ID|IE|IL|IM|IN|IQ|IR|IS|IT|JM|JO|JP|KE|KG|KH|KI|KM|KN|KP|KR|KW|KY|KZ|LA|LB|LC|LI|LK|LR|LS|LT|LU|LV|LY|MA|MC|MD|ME|MF|MG|MH|MK|ML|MM|MN|MO|MP|MR|MS|MT|MU|MV|MW|MX|MY|MZ|NA|NC|NE|NG|NI|NL|NO|NP|NR|NU|NZ|OM|PA|PE|PF|PG|PH|PK|PL|PM|PN|PR|PT|PW|PY|QA|RO|RS|RU|RW|SA|SB|SC|SD|SE|SG|SH|SI|SK|SL|SM|SN|SO|SR|ST|SV|SY|SZ|TC|TD|TG|TH|TJ|TK|TL|TM|TN|TO|TR|TT|TV|TW|TZ|UA|UG|US|UY|UZ|VA|VC|VE|VG|VI|VN|VU|WF|WS|YE|YT|ZA|ZM|ZW';
$country_codes=explode('|', $country_codes);
$contact_types='PERSON|COMPANY|ASSOCIATION|PUBLIC_BODY|RESELLER';
$contact_types=explode('|', $contact_types);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AWS</title>

    <link href="<?php echo $base_url; ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>assets/css/all.css" rel="stylesheet">

    <script type="text/javascript" src="<?php echo $base_url; ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $base_url; ?>assets/js/all.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <div class="col-md-8 pull-left top-header">
                <h1 class="title">Amazon Web Services</h1>
                <h4 class="title">Amazon Route 53</h4>
            </div>
            <div class="col-md-2">
                <p>Logged in as <strong>dropigee</strong></p>
                <p class="text-center"><a href="<?php echo $base_url; ?>logout.php"><strong>Logout</strong></a></p>
            </div>
        </div>
        <div class="container ">
            <div class="row">
                <div class="col-md-12 form-group">
                    <a class="btn btn-primary" href="<?php echo $base_url; ?>home.php">Manage Hosted Zone</a>
                </div>
            </div>
            <div class="left-block col-md-10">


                <form action="<?php echo $base_url; ?>route53_domain.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Is Domain Name Available?</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="new_domain" placeholder="example.com"  type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Check" />
                        </div>
                    </div>
                </form>
                <form action="<?php echo $base_url; ?>route53_domain_check_status.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Check Status for registered Domain</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="OperationId" name="OperationId" placeholder="Operation Id"  type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Check Status" />
                        </div>
                    </div>
                </form>
                <form action="<?php echo $base_url; ?>route53_domain_register.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                        <h3>Register New Domain</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <input class="form-control" name="domain" placeholder="example.com"  type="text" required autofocus />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input name="fname" placeholder="First Name"  type="text" required  class="form-control" />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input name="lname" placeholder="Last Name"  type="text" required  class="form-control" />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input name="phone" placeholder="Phone Number i.e. +1.1234567890"  type="text" required  class="form-control" />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input name="email" placeholder="email"  type="email" required  class="form-control" />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input name="address" placeholder="Address"  type="text" required  class="form-control" />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input name="city" placeholder="City"  type="text" required  class="form-control" />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input name="zip" placeholder="zip code"  type="text" required  class="form-control" />
                        </div>
                        <div class=" col-md-12 form-group">
                           Country Code 
                           <select name="country_code" required>
                            <?php 
                            foreach ($country_codes as $key => $value) {
                             ?>
                             <option><?php echo $value; ?></option>
                             <?php
                         }
                         ?>
                     </select>
                 </div>
                 <div class=" col-md-12 form-group">
                    Contact Type 
                    <select name="contact_type" required>
                        <?php 
                        foreach ($contact_types as $key => $value) {
                         ?>
                         <option><?php echo $value; ?></option>
                         <?php
                     }
                     ?>
                 </select>
             </div>
             <div class=" col-md-12 form-group">
               Birth Country Code 
               <select name="birth_country_code" required>
                <?php 
                foreach ($country_codes as $key => $value) {
                 ?>
                 <option><?php echo $value; ?></option>
                 <?php
             }
             ?>
         </select>
     </div>
     <div class=" col-md-12 form-group">
        <input name="duration" placeholder="Duration in years"  type="number" min="1" maxlength="100" required  class="form-control" />
    </div>
    <div class=" col-md-12 form-group">
        Auto Renew
        <select name="renew" required>
            <option value="1">True</option>
            <option value="0">False</option>
        </select>
    </div>
    <div class=" col-md-12 form-group">
        Privacy Protect Admin Contact
        <select name="PrivacyProtectAdminContact" required>
            <option value="1">True</option>
            <option value="0">False</option>
        </select>
    </div>
    <div class=" col-md-12 form-group">
        Privacy Protect Registrant Contact
        <select name="PrivacyProtectRegistrantContact" required>
            <option value="1">True</option>
            <option value="0">False</option>
        </select>
    </div>
    <div class=" col-md-12 form-group">
        Privacy Protect Tech Contact
        <select name="PrivacyProtectTechContact" required>
            <option value="1">True</option>
            <option value="0">False</option>
        </select>
    </div>

</div>
<div class="row">
    <div class="col-md-12 form-group">
        <input type="submit" class="btn btn-primary pull-right" value="Register" />
    </div>
</div>
</form>
</div>
<div class="right-block col-md-4">
    <div class="row">
        <div>
            <h2> Result:</h2>
            <div>
                <?php
                if(isset($_SESSION['rdomain']) && !empty($_SESSION['rdomain'])){
                    $rdomain=$_SESSION['rdomain'];
                    echo "<p> Domain: ".$rdomain['domain']."</p>";
                    echo "<p> Status: ".$rdomain['status']." </p>";
                    $_SESSION['rdomain']="";
                }
                elseif (isset($_SESSION['new_domain']) && !empty($_SESSION['new_domain'])) {
                 $new_domain=$_SESSION['new_domain'];
                 if($new_domain['status']){
                    echo "<p> Opperation ID: ".$new_domain['opperation_id']."</p>";
                    echo "<p> Status: Pending for approval </p>";
                    $_SESSION['new_domain']="";
                }
                else{
                   echo "<p> Something went wrong!..:( </p>";

               }
           }
           elseif(isset($_SESSION['sdomain']) && !empty($_SESSION['sdomain'])){
                    $sdomain=$_SESSION['sdomain'];
                    echo "<p> Operation Id: ".$sdomain['operation_id']."</p>";
                    echo "<p> Domain: ".$sdomain['domain']."</p>";
                    echo "<p> Type: ".$sdomain['type']."</p>";
                    echo "<p> Status: ".$sdomain['status']." </p>";
                    $_SESSION['sdomain']="";
                }
           ?>

       </div>
   </div>
</div>
<div class="row">
    <div id="result">
    </div>
</div>
</div>
</div>

</div>

</body>
</html>

