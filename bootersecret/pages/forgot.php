<?php

?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo $settings['bootername_1']; ?></title>

        <meta name="description" content="Edit's By @HexedFull">
        <meta name="@HexedFull" content="@HexedFull">
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
        
        <style>
        .block {
            background-color: black;
        }
        .block-title {
        	background-color: black;
        	border-color: #9D6595;
        }
        
        .btn-primary {
            background-color: #9D6595;
        }
    
        .title-text {
            color: #9D6595;
        }
        
        .fa-user {
            color: white;
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
    <body background="img/matrix-red.gif">
        <!-- Reminder Container -->
    <div id="login-container">
        <!-- Login Header -->
         <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
                <i style="color:white" class="fa fa-question-circle"></i> <strong style="color:white"><?php echo $settings['bootername_1']; ?></strong>
            </h1>
            <!-- END Reminder Header -->

<?php
if(isset($_GET['c'])){
    $c = $_GET['c'];
    $checkcode = $odb->prepare("SELECT COUNT(*) FROM users WHERE code = ?");
    $checkcode->execute(array($c));
    if($checkcode->fetchColumn() == 1){
        $checktime = $odb->prepare("SELECT * FROM users WHERE code = ?");
        $checktime->execute(array($c));
        while($time = $checktime->fetch(PDO::FETCH_ASSOC)){
            if(time() - $time['reset'] < 900){
                if(isset($_POST['submitpass'])){
                    $password = $_POST['password'];
                    $confirm = $_POST['confirm'];
                    if($password == $confirm){
                        $pass = hash('sha512',$password);
                         $update = $odb->prepare("UPDATE users SET password = ?, reset = ? WHERE code = ?");
                        $update->execute(array($pass, "0", $c));
                        echo '<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </i>Password Successfuly Changed</strong>
                             </div>';
                    }
                    else
                    { 
                        echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </i>New Password and Confirm Password dont match</strong>
                             </div>';
                    }

                }
                else
                {
                    echo '<div class="block animation-fadeInQuickInv">
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="https://criticalstresser.com/Panel/index.php?page=Login" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Back to login"><i class="fa fa-user"></i></a>
                    </div>
                    <h2>New Password</h2>
                </div>
                <form action="" method="POST" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" name="password" class="form-control" placeholder="New Password" required>
                            <br>
                            <input type="password" name="confirm" class="form-control" placeholder="Re-Enter New Password" required>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="submit" name="submitpass" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-key"></i> Change Password</button>
                        </div>
                    </div>
                </form>
            </div>';
                   
            }
        }
        else
        {
          //time expired 
          echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </i>Your Code Has Expired </strong>
                             </div>';
        }
    }
    }else{

        echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </i>Code '.$c.' is invalid</strong>
                             </div>';
    }
    
    die;
}
if(isset($_POST['submit'])){
    if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}


    $email = $_POST['email'];
    $username = $_POST['username'];

      $checkprior = $odb->prepare("SELECT COUNT(*) FROM forgot_logs WHERE ip = ? AND `date` > ?");
        $checkprior->execute(array($ip, time() - 900));
        if($checkprior->fetchColumn() > 1){
              $omega = "OMEGA IS SEXY";
            echo '<div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            </i>Please wait 15min to send another request.
            </div>';

        }
    if(empty($omega)){
    $check = $odb->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND email = ?");
    $check->execute(array($username, $email));
    if($check->fetchColumn() == 1){

     function random($length){
                $str = "";
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                for($x=0; $x<$length;$x++){
                    $str .= $chars[mt_rand(0, strlen($chars) - 1)];
                }
                return $str;
            }
            $code = random(10);
            $addcode = $odb->prepare("UPDATE users SET code = ?, reset = ? WHERE username = ?");
            $addcode->execute(array($code, time(), $username));
            $site = "https://criticalstresser.com/";
    
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $to = $email;
            $subject = "".$settings['subject_forgot']."";
            $headers.= "From: criticalstresser.com \n criticalteam@admin.com";
            $message = '<header>
  <style type="text/css">
    body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
    .ExternalClass {width:100%;}
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
body {
    color: #fcf9f9;
} 
p {
    color: #fcf9f9;
}
center {
    color: #fcf9f9;
}
strong {
    color: #fcf9f9;
}
h3 {
    color: #fcf9f9;
}
h1 {
    color: #fcf9f9;
}
      
</style>      
        </header>
<body bgcolor="#fcfcfc" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table width="100%" height="auto" border="0" cellpadding="0" cellspacing="0" style="color:#fcf9f9">
         <tr>
              <td width="100%" height="auto" valign="top" align="center" bgcolor="#050404">
                  <center>
                   <h1 style="color:#fcf9f9">Password Request</h1>
                   <h3 style="color:#fcf9f9">Hello '.$username.'<br></h3>    
    <p><strong style="color:#fcf9f9">This email is for a password reset on your account!</strong><br>
    
    <center><img src="https://criticalstresser.com/Panel/img/image" width="72px" height="72px"/></center><br>
        <br>
                <center><strong style="color:#fcf9f9">Password Request for  account :<strong style="color:#0caf03">'.$username.'</strong>, <br> This request was from ip: <strong style="color:#0074d3">'.$ip.'</strong> <br><strong style="color:#009dc9"></strong> <strong style="color:#009dc9"></strong> <strong style="color:#009dc9"></strong> <br><br> Visit <a href="https://supremesecurityteam.com" style="color:red; text-decoration:none;">SupremeSecurity</a> to secure your account if this wasnt you.  <br><br>Remember to visit <a href="https://supremesecurityteam.com" style="color:red; text-decoration:none;">SUPREMESECURITYCZ</a><br> to purchase our $5 MONTHLY VPN.<br><br>Thanks For Using SupremeSecurity.<br><br><br><a href="https://tawk.to/chat/5a8462434b401e45400cee66/default" style="color:red; text-decoration:none;">Contact Support</a></strong></center>
        </p></center>
		you can set a new password <a href="https://criticalstresser.com/Panel/index.php?page=Forgot&c='.$code.'" target="_blank">here</a>:<br><br><center><a style="border-radius:3px;box-shadow:inset 0 1px 0 #6db3e6, inset 1px 0 0 #48a1e2;color:white;font-size:15px;padding:14px 7px 14px 7px;max-width:210px;font-family:proxima_nova, Open Sans, lucida grande, Segoe UI, arial, verdana, lucida sans unicode, tahoma, sans-serif;border:1px #1373b5 solid;text-align:center;text-decoration:none;width:210px;display:block;background-color:#007ee6;" href="https://supremesecurityteam.com/Home/index.php?page=Forgot&c='.$code.'" target="_blank" class="">Reset password</a></center>
                  <br>
                  <br>
                  <br>
                  <center><h6 style="color:#fcf9f9">2018 &copy; CriticalTeam</h6></center>
                  <br>
              </td>
        </tr>
';
            mail($to,$subject,$message,$headers);
            echo '<div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </i> Request has been sent</strong>
                             </div>';

                        $SQL = $odb -> prepare('INSERT INTO `forgot_logs` VALUES(NULL, ?, ?, ?, UNIX_TIMESTAMP())');
                        $SQL -> execute(array($username, $email, $ip));
    }
    else{

        echo '<div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                </i> Username & Email not found in the database</strong>
                             </div>';
    }
}
}
?>


            <!-- Reminder Block -->
            <div class="block animation-fadeInQuickInv" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                <!-- Reminder Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="index.php?page=Login" style="background-color: #9D6595;" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Back to login"><i class="fa fa-user"></i></a>
                    </div>
                    <h2 class="title-text">Forgot Password</h2>
                </div>
                <!-- END Reminder Title -->

                <!-- Reminder Form -->
                <form action="" method="POST" class="form-horizontal">
                    <div class="form-group">
                    <h3 class="modal-title text-center"><font size="2" color="white">You Will Receive The Email In 5 mins</font></h3>
                        <div class="col-xs-12">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                            <br>
                            <input type="text" id="reminder-email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="submit" name="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-key"></i> Send Request</button>
                        </div>
                    </div>
                </form>
                <!-- END Reminder Form -->
            </div>
            <!-- END Reminder Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a href="javascript:void(0)" target="_blank"><?php echo $settings['bootername_1']; ?> </a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->

        <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="js/pages/readyReminder.js"></script>
        <script>$(function(){ ReadyReminder.init(); });</script>
    </body>
</html>