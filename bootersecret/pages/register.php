<?php

   require_once('captcha/sweetcaptcha.php');
if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


unset($_SESSION['captcha']);
$_SESSION['captcha'] = rand(1, 100);
$x1 = rand(2,10);
$x2 = rand(1,10);
$x = SHA1(($x1 + $x2).$_SESSION['captcha']);
              ?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo $settings['bootername_1'] ?></title>

        <meta name="description" content="Edit's By @HexedFull">
        <meta name="@HexedFull" content="Edited By @HexedFull">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/plugins.css">
        <link rel="stylesheet" href="css/main.css" title="red">
        <link rel="alternate stylesheet" href="css/main2.css" title="blue">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="js/vendor/modernizr-2.8.3.js"></script>
        <script type='text/javascript' src='js/ajax/reg.js'></script>
        <script>
            var answer="<?php echo $x; ?>";
        </script>
        
        <style>
        .block {
            background-color: black;
        }
        .block-title {
        	background-color: black;
        	border-color: #9D6595;
        }
        
        .title-text {
            color: #9D6595;
        }
        
        .fa-user {
            color: white;
        }
        
        .btn-primary {
            background-color: #9D6595;
        }
        
        .form-control {
            background-color: black;
            color: #9D6595;
            border-color: black;
        }
        
        .form-horizontal {
            background-color: black;
        }
        </style>
    </head>
    <body background="img/Horse.png" alt="Image" height="42" width="42">
    <?php
require('FireWall.php'); // Before all your code starts.
$xWAF = new xWAF();
$xWAF->start();
// FireWall Is Now Enabled
?>


        <?php

$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `website` = :page");
              $SQLCheckPage -> execute(array(':page' => "1"));
              $CheckPage = $SQLCheckPage -> fetchColumn(0);
              if ($CheckPage > 0)
              {
echo ' <div id="error-container">
            <div class="row text-center">
                <div class="col-md-6 col-md-offset-3">
                    <h1 class="text-light animation-fadeInQuick"><strong>Under Construction</strong></h1>
                    <h2 class="text-muted animation-fadeInQuickInv"><em>Please Try Again Later, This Page Is Under Construction</em></h2>
                </div>
                
            </div>
        </div>';
  die();
              }

              $SQLCheckBlacklist = $odb -> prepare("SELECT COUNT(*) FROM `registerlogs` WHERE `ip` = ?");
              $SQLCheckBlacklist -> execute(array($ip));
              $countBlacklist = $SQLCheckBlacklist -> fetchColumn(0);
              if ($countBlacklist > 0)
              {
                echo '<div id="error-container">
            <div class="row text-center">
                <div class="col-md-6 col-md-offset-3">
                    <h1 class="text-light animation-fadeInQuick"><strong>Sorry</strong></h1>
                    <h2 class="text-light animation-fadeInQuick"><strong>Members cannot register twice with the same IP Address<strong></h2>
                </div>
                
            </div>
        </div>';
  die();
              }

        ?>
        <!-- Register Container -->
    <div id="login-container">
        <!-- Register Header -->
         <h1 class="h2 text-light text-center push-top-bottom animation-slideDown" style="animation: pulse 2.3s infinite;">
                <i style="color:white" class="fa fa-globe"></i> <strong style="color:white"><?php echo $settings['bootername_1']; ?></strong>
            </h1>
            <!-- END Register Header -->
            
<div id="alert" style="display:none"></div>

			<!-- Captcha shit -->
			<script>

			
			</script>

            <!-- Register Form -->
            <div class="block animation-fadeInQuickInv" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                <!-- Register Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="?page=login" style="background-color: #9D6595;" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Back to login"><i class="fa fa-user"></i></a>
                    </div>
                    <h2 class="title-text">Register <i class="fa fa-spinner fa-2x fa-spin text-danger" id="loader" style="display:none"></i></h2>
                </div>
                <!-- END Register Title -->

                <!-- Register Form -->
                <div class="form-horizontal">
                <h3 class="modal-title text-center"><font size="2" color="white">Make Sure To Use A Valid Email</font></h3>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="username" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" id="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" id="rpassword" class="form-control" placeholder="Verify Password">
                        </div>
                    </div>
        <div class="form-group">
            <div class="col-xs-12">
                    <script src='https://www.google.com/recaptcha/api.js'></script>
					<center><div class="g-recaptcha" data-theme="dark" data-sitekey="6LeI6XwUAAAAAFwRiQKQTq97Ky4l5xBzQTB8S6WU"></div></center>
           </div>
       </div>

                    <div class="form-group form-actions">
                        <div class="col-xs-6">
                            <label class="csscheckbox csscheckbox-primary" data-toggle="tooltip" title="I Agree To The Terms Of Service">
                                <input type="checkbox" id="register-terms" checked disabled>
                                <span></span>
                            </label>
                            <a style="color:white" href="#modal-terms" data-toggle="modal">Terms of service</a>
                        </div>
						<form action="" method="post" id="frmVerifyCaptcha">
						
						</form>
                        <div class="col-xs-6 text-right">
                            <button class="btn btn-effect-ripple btn-primary" onclick="register()"><i class="fa fa-plus"></i> Create Account</button>
                        </div>
                    </div>
                </div>
                <!-- END Register Form -->
            </div>
            <!-- END Register Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a style="color:white" href="javascript:void(0)" target="_blank"><?php echo $settings['bootername_1'] ?></a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->

        <!-- Modal Terms -->
        <div id="modal-terms" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center"><strong>Terms and Conditions</strong></h3>
                    </div>
                    <div class="modal-body">
                       <?php echo $settings['tos']; ?>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button type="button" class="btn btn-effect-ripple btn-sm btn-primary" data-dismiss="modal">I've read them!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal Terms -->

        <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL)-->
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="js/pages/readyRegister.js"></script>
        <script>$(function(){ ReadyRegister.init(); });</script>
    </body>
</html>