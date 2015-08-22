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

if(!empty($_SESSION['user'])){
    header("Location: /aws_r53/home.php");
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
            </div>
        </div>
        <div class="container ">
            <div class="login-block col-md-10">
                <form action="<?php echo $base_url; ?>authenticate.php" method="post">
                    <div class="row">
                        <div class=" col-md-12 form-group" class="error">
                            <?php 
                            if(!empty($_SESSION['message'])){
                                print_r($_SESSION['message']);
                                $_SESSION['message']="";
                            }
                            ?>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class=" col-md-12 form-group">
                            <h3>User Login</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <input class="form-control" name="username" placeholder="Username"  type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class=" col-md-8 form-group">
                            <input class="form-control" name="password" placeholder="Password"  type="password" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 form-group">
                            <input type="submit" class="btn btn-primary pull-right" value="Login" />
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </body>
    </html>

