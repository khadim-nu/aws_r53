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
                    <a class="btn btn-primary" href="<?php echo $base_url; ?>domain_home.php">Manage Domains</a>
                </div>
            </div>
            <div class="left-block col-md-10">
                <form action="<?php echo $base_url; ?>route53.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Already Have a Hosted Zone?</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input class="form-control" id="old_domain" name="zone_id" placeholder="Hosted Zone ID"  type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="submit" id="old_domain_btn" class="btn btn-primary pull-right" value="Get NS" />
                        </div>
                    </div>
                </form>
                <form action="<?php echo $base_url; ?>create_hosted_zone.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Register New Hosted Zone</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="domain" placeholder="example.com"  type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Get Served" />
                        </div>
                    </div>
                </form>

                <form action="<?php echo $base_url; ?>health_check_get.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Already have a Health Check?</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="id" name="id" placeholder="Health check ID"  type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Check" />
                        </div>
                    </div>
                </form>
                <form action="<?php echo $base_url; ?>health_check_create.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Create Health Check Status</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="domain" placeholder="example.com"  type="text" required autofocus />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="type" placeholder="Type i.e. TCP, HTTP, HTTPS, HTTP_STR_MATCH, and HTTPS_STR_MATCH"  type="text" required autofocus />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="ip" placeholder="IP address of instance"  type="text" required autofocus />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="port" placeholder="Port"  type="number" min="10" max="1000"  required autofocus />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="RequestInterval" placeholder="Request Interval. 10 or 30" min="10" max="30"  type="number" required autofocus />
                        </div>
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="domain" name="FailureThreshold" placeholder="Failure Threshold"  type="number" min="1" max="10" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Create Health check" />
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
                            if(isset($_SESSION['health_check']) && !empty($_SESSION['health_check'])){
                                $health_check=$_SESSION['health_check'];
                                if($health_check['status']){
                                    echo "<p> Domain: ".$health_check['domain']."</p>";
                                    echo "<p> Helth check ID: ".$health_check['id']." </p>";
                                    echo "<p> IP: ".$health_check['ip']."</p>";
                                    echo "<p> Port: ".$health_check['port']."</p>";
                                    echo "<p> Type: ".$health_check['type']."</p>";
                                    echo "<p> RequestInterval: ".$health_check['RequestInterval']."</p>";
                                    echo "<p> FailureThreshold: ".$health_check['FailureThreshold']."</p>";
                                }
                                else{
                                 echo "<p> Something went wrong!...:(</p>";
                             }
                             $_SESSION['health_check']="";
                         } 
                         elseif (isset($_SESSION['hosted_zone']) && !empty($_SESSION['hosted_zone'])) {
                           $hosted_zone=$_SESSION['hosted_zone'];
                           echo "<p> Zone ID: ".$hosted_zone['id']."</p>";
                           echo "<p> Name: ".$hosted_zone['name']." </p>";
                           foreach ($hosted_zone['ns'] as $key => $value) {
                              echo "<p> NS ".$key." : ".$value."</p>";

                              $_SESSION['hosted_zone']="";
                          }
                      }
                      elseif(isset($_SESSION['health_check_get']) && !empty($_SESSION['health_check_get'])){
                        $health_check=$_SESSION['health_check_get'];
                        if($health_check['status']){
                            echo "<p> IP: ".$health_check['ip']."</p>";
                            echo "<p> Status: ".$health_check['health_status']."</p>";
                        }
                        else{
                           echo "<p> Something went wrong!...:(</p>";
                       }
                       $_SESSION['health_check_get']="";
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

