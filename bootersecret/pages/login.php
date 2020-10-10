<?php
if (isset($_GET['session'])){
    if($_GET['session'] == "signout"){

unset($_SESSION['username']);
unset($_SESSION['ID']);
session_destroy();
header('location: index.php?page=Login&session=inactive');
    }
}
?>

<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $settings['bootername_1']; ?></title>
    <meta name="description" content=" Edits By @HexedFull">
    <meta name="author" content="@HexedFull">
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
    <script src="js/vendor/modernizr-2.8.3.js"></script>
    <script type='text/javascript' src='js/jquery/jquery.min.js'></script>
    <script type='text/javascript' src='js/jquery/jquery-ui-1.10.3.custom.min.js'></script>
    <script type='text/javascript' src='js/jquery/jquery-migrate.min.js'></script>
    <script type='text/javascript' src='js/jquery/globalize.js'></script>
    <script type='text/javascript' src='js/bootstrap/bootstrap.min.js'></script>
    <script type='text/javascript' src='js/cookies/jquery.cookies.2.2.0.min.js'></script>
    <script type='text/javascript' src='js/scrollup/jquery.scrollUp.min.js'></script>
    <script type='text/javascript' src='js/plugins.js'></script>    
    <script type='text/javascript' src='js/actions.js'></script>
    <script type='text/javascript' src='js/ajax/login.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    .block {
        background-color:     #000000;
    }
    .block-title {
    	background-color: black;
    	border-color: #ffffff;
    }
    
    .title-text {
        color: #ff2828;
    }
    
    .fa-key {
        color: white;
    }
    
    .fa-plus {
        color: white;
    }
    
    .fa-exclamation-triangle {
        color: white;
    }
    
    .btn-primary {
        background-color: ;
    }
    
    .form-control {
        background-color:  white;
        color: #000000;
        border-color:  white;
    }
    
    .form-horizontal {
        background-color:      #000000;
    }
    </style>
</head>
<body background="img/giphy.gif"

<?php
require('FireWall.php'); // Before all your code starts.
$xWAF = new xWAF();
$xWAF->start();
?>
// FireWall Is Now Enabled
    
    <!-- Login Container -->
    <div id="login-container">
        <!-- Login Header -->
         <h1 class="h2 text-light text-center push-top-bottom animation-slideDown" style="animation: pulse 2.3s infinite;">
                <i class="fa fa-globe" style="position: relative; bottom: 1px;"></i> <strong style="color:white"><?php echo $settings['bootername_1']; ?></strong>
            </h1>

        <div id="logindiv" style="display:none"></div>
        <?php
        if (isset($_GET['username'])) 
        {
            $username = $_GET['username'];
            $SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `website` = ?");
            $admin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `rank` = ? AND `username` = ?");
            $admin->execute(array("2", $_GET['username']));
            $checkadmin = $admin->fetchcolumn(0);
            
            $SQLCheckPage -> execute(array("1"));
            $CheckPage = $SQLCheckPage -> fetchColumn(0);
            if ($CheckPage > 0 && $checkadmin < 1)
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
        } 
        else
        {
            $SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `website` = ?");
            $admin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `rank` = ? AND `username` = ?  ");
            $admin->execute(array("2", ""));
            $checkadmin = $admin->fetchcolumn(0);
            
            $SQLCheckPage -> execute(array("1"));
            $CheckPage = $SQLCheckPage -> fetchColumn(0);
            if ($CheckPage > 0 && $checkadmin < 1)
            {
                            
                echo ' <div id="error-container">
                            <div class="row text-center">
                                <div class="col-md-6 col-md-offset-3">
                                    <h1 class="text-light animation-fadeInQuick"><strong>Under Construction</strong></h1>
                                    <h2 class="text-muted animation-fadeInQuickInv"><em>Please Try Again Later This. Page Is Under Construction</em></h2>
                                </div>
                                
                            </div>
                        </div>';
                  die();
            }
        }
        ?>
        <?php
        if (isset($_GET['session']))
        {
            if($_GET['session'] == "inactive")
            {
                echo '<div class="alert alert-warning"> <p><font color="#9D6595">Your Session Has Expired.
                </font></p></center></div>';

            }
        }
        ?>
        <div id="alert" style="display:none"></div>
            <!-- Login Block -->
            <div class="block animation-fadeInQuickInv" style="-webkit-box-shadow:0px 0px 30px 2px  #F973E7;  -moz-box-shadow:0px 0px 30px 2px  #F973E7;  box-shadow:0px 0px 30px 2px  #F973E7;">
                <!-- Login Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="index.php?page=Forgot" style="background-color:  #a883f8;" class="btn btn-effect-ripple" data-toggle="tooltip" data-placement="left" title="Forgot Password?"><i style="color:black" class="fa fa-key text-black"></i></a>
                        <a href="index.php?page=Register" style="background-color:  #a883f8;" class="btn btn-effect-ripple" data-toggle="tooltip" data-placement="left" title="Create new account"><i style="color:black" class="fa fa-plus text-black"></i></a>
                    </div>
                    <h2 style="color:white" class="title-text">Login</h2>
                </div>
                <div  class="form-horizontal">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="username" class="form-control" placeholder="Username" onkeydown="if (event.keyCode == 13) document.getElementById('login').click()">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" id="password" class="form-control" placeholder="Password"  onkeydown="if (event.keyCode == 13) document.getElementById('login').click()">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-8">
                            <label class="csscheckbox csscheckbox-primary" for="rememberme">
                                <input type="checkbox" id="rememberme" checked disabled>
                                <span data-toggle="tooltip" data-placement="bottom" title="Be Sure To Go Over And Read TOS"></span>
                            </label>
                            <font style="color:white" class="title-text">I Agree & Accept TOS</font>
                        </div>
                        <div class="col-xs-4 text-right">
                        <div id="loader" style="display:none">
                            <button class="btn btn-effect-ripple btn-md btn-danger" onclick="login()">   <i class="fa fa-spinner fa-1x fa-spin text-black" ></i> Loading.....</button>
                        </div>
                            <div id="hidebtn" ><button style="color:white" class="btn btn-effect-ripple btn-md btn-primary" id="login" onclick="login()"><i class="fa fa-sign-in"></i> Login</button></div>
                        </div>
                    </div>
                </div>
                </form>
                <!-- END Login Form -->
            </div>
            <!-- END Login Block -->
            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a href="javascript:void(0)" target="_blank"><?php echo $settings['bootername_1']; ?></a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->
        <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>
        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>
        <script src="js/pages/formsWizard.js"></script>
        <script>$(function(){ FormsWizard.init(); });</script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>
        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>
        <!-- Load and execute javascript code used only in this page -->
        <script src="js/pages/readyLogin.js"></script>
        <script>$(function(){ ReadyLogin.init(); });</script>
        <body oncontextmenu ="return false;"></body>
    </body>
</html>
<iframe width="0%" height="0" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/537550962&color=%23ff5500&auto_play=true&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe>