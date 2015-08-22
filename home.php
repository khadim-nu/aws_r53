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
            <div class="left-block col-md-10">
                <form action="<?php echo $base_url; ?>authenticate.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Already have a Domain Name?</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input class="form-control" id="old_domain" name="old_domain" placeholder="example.com"  type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <input type="submit" id="old_domain_btn" class="btn btn-primary pull-right" value="Get NS" />
                        </div>
                    </div>
                </form>
                <form action="<?php echo $base_url; ?>route53_domain.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>Register new Domain and get served</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <input class="form-control" id="new_domain" name="new_domain" placeholder="example.com"  type="text" required autofocus />
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

