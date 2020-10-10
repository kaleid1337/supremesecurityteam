<?php

  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
if (!($user -> LoggedIn()))
{
    header('location: index.php?page=Login');
    die();
}
$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `fe` = ?");
$admin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `rank` = ? AND `id` = ?");
$admin->execute(array("2", $_SESSION['ID']));
$checkadmin = $admin->fetchcolumn(0);
$SQLCheckPage -> execute(array("1"));
$CheckPage = $SQLCheckPage -> fetchColumn(0);
if ($CheckPage > 0 && $checkadmin < 1)
{
    header('location: index.php?page=Construction');
    die();
}
if (!($user -> notBanned($odb)))
{
    header('location: index.php?page=logout');
    die();
}
if (!($user->isVerified($odb)))
{
  header('location: index.php?page=Verify');
  die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
$CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
$CheckUserIP = $CheckUserSQL -> fetch(PDO::FETCH_ASSOC);


include("header.php");
?>

                    <div id="page-content">
                        <img src="img/black.jpg" class="full-bg animation-pulseSlow"></img>
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1 style="color: white;">Server Status</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li style="color: white;">Index</li>
                                            <li style="color: #ff2828;"><a href="">Server Status</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if (isset($_POST['updatePassBtn']))
                        {
                            $cpassword = $_POST['cpassword'];
                            $npassword = $_POST['npassword'];
                            $rpassword = $_POST['rpassword'];
                
                            $shac = hash('sha512',$cpassword);
                            $shan = hash('sha512',$npassword);
                
                            if (!empty($cpassword) && !empty($npassword) && !empty($rpassword))
                            {
                                if ($npassword == $rpassword)
                                {
                                    $SQLCheckCurrent = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `ID` = ? AND `password` = ?");
                                    $SQLCheckCurrent -> execute(array($_SESSION['ID'], $shac));
                                    $countCurrent = $SQLCheckCurrent -> fetchColumn(0);
                                    if ($countCurrent == 1)
                                    {
                                        $SQLUpdate = $odb -> prepare("UPDATE `users` SET `password` = ? WHERE `username` = ? AND `ID` = ?");
                                        $SQLUpdate -> execute(array($shan, $_SESSION['username'], $_SESSION['ID']));
                                        echo '<div class="alert alert-success"><p><strong>SUCCESS: </strong>Password Has Been Updated</p></div>';
                                    }
                                    else
                                    {
                                        echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Current Password is incorrect.</p></div>';
                                    }
                                }
                                else
                                {
                                    echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>New Passwords Did Not Match.</p></div>';
                                }
                            }
                            else
                            {
                                echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Please fill in all fields</p></div>';
                            }
                        }
                        ?>
                        <?php 
                        if (isset($_POST['updateSMBtn']))
                        {
                            // Change
                            $step = $_POST['2step'];
                            $apis = $_POST['apis'];
                            $email = $_POST['email'];
                            // Check
                            $ccode = $_POST['currentcode'];
                            $currnetpass = $_POST['checkpassword'];
                            $shapass = hash('sha512',$currnetpass);
                            if (!empty($email) && !empty($ccode) && !empty($currnetpass))
                            {
                                $SQLCheckCurrent = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `ID` = ? AND `password` = ?");
                                $SQLCheckCurrent -> execute(array($_SESSION['ID'], $shapass));
                                $countCurrent = $SQLCheckCurrent -> fetchColumn(0);
                
                                $SQLCheckCode = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `ID` = ? AND `code_account` = ?");
                                $SQLCheckCode -> execute(array($_SESSION['ID'], $ccode));
                                $countCode = $SQLCheckCode -> fetchColumn(0);
                                if ($countCode == 1)
                                {
                                    if ($countCurrent == 1)
                                    {
                                        // Code
                                        $SQLUpdate = $odb -> prepare("UPDATE `users` SET `email` = ? WHERE `username` = ? AND `ID` = ?");
                                        $SQLUpdate -> execute(array($email, $_SESSION['username'], $_SESSION['ID']));
                                        // 2 Step
                                        $SQLUpdate = $odb -> prepare("UPDATE `users` SET `ip_address` = ? WHERE `username` = ? AND `ID` = ?");
                                        $SQLUpdate -> execute(array($step, $_SESSION['username'], $_SESSION['ID']));
                                        // Api
                                        $SQLUpdate = $odb -> prepare("UPDATE `users` SET `ip_address_api` = ? WHERE `username` = ? AND `ID` = ?");
                                        $SQLUpdate -> execute(array($apis, $_SESSION['username'], $_SESSION['ID']));
                                        echo '<div class="alert alert-success"><p><strong>SUCCESS: </strong>Settings Has Been Updated</p></div>';
                                    }
                                    else
                                    {
                                        echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Current Password is incorrect.</p></div>';
                                    }
                                }
                                else
                                {
                                    echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Current Code is incorrect.</p></div>';
                                }
                            }
                            else
                            {
                                echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Please fill in all fields</p></div>';
                            }
                        }
                        $getuserinfo = $odb -> prepare("SELECT * FROM `users` WHERE `username` = ? AND `ID` = ?");
                        $getuserinfo -> execute(array($_SESSION['username'], $_SESSION['ID']));
                        $userInfo = $getuserinfo -> fetch(PDO::FETCH_ASSOC);
                        if($userInfo['ip_address'] == "OFF")
                        {
                            $stepcheck = '<option value="1">On</option>
                            <option value="OFF" selected="selected">Off</option>';
                        }
                        else
                        {
                            $stepcheck = '<option value="1" selected="selected">On</option>
                            <option value="OFF">Off</option>';
                        }
                        if($userInfo['ip_address_api'] == "OFF")
                        {
                            $apicheck = '<option value="1">On</option>
                            <option value="OFF" selected="selected">Off</option>';
                        }
                        else
                        {
                            $apicheck = '<option value="1" selected="selected">On</option>
                            <option value="OFF">Off</option>';
                        }
                        ?>
                        <div class="col-sm-6 col-lg-6">
                            <div class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                                <div class="widget-content widget-content-mini themed-background text-light-op">
    								<span class="pull-right"><?php echo $settings['bootername_1']; ?></span>
    								<i style="color: black;" class="fa fa-user"></i> <b style="color: black;">Profile Management</b>
    							</div>
    							<div class="widget-content main-stats-content text-right clearfix">
                                    <form action="" method="post" class="form-bordered" >
                                        <hr style="border-color: black;">
                                        
                                        <center>
                                            <label class="title-text" for="cpassword">Current Password</label>
                                        </center>
                                        <div class="col-md-12">
                                            <input type="password" placeholder="Current Password" name="cpassword" class="form-control">
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <p></p>
                                        </div>
                                        
                                        <center>
                                            <label class="title-text" for="npassword">New Password</label>
                                        </center>
                                        <div class="col-md-12">
                                            <input type="password" placeholder="New Password" name="npassword" class="form-control">
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <p></p>
                                        </div>
                                        
                                        <center>
                                            <label class="title-text" for="rpassword">Repeat New Password</label>
                                        </center>
                                        <div class="col-md-12">
                                            <input type="password" placeholder="Repeat Password" name="rpassword" class="form-control">
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <p></p>
                                        </div>
                                        <center>
                                            <button type="submit" name="updatePassBtn" class="btn btn-effect-ripple btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-effect-ripple btn-primary">Reset</button>
                                        </center>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6">
                            <div class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                                <div class="widget-content widget-content-mini themed-background text-light-op">
    								<span class="pull-right"><?php echo $settings['bootername_1']; ?></span>
    								<i style="color: black;" class="fa fa-lock"></i> <b style="color: black;">Security Management</b>
    							</div>
    							<div class="widget-content main-stats-content text-right clearfix">
                                    <form action="" method="post" class="form-bordered" >
                                            <hr style="border-color: black;">
                                            
                                            <center>
                                                <label class="title-text">2 Step Verification</label>
                                            </center>
                                            <div class="col-md-12">
                                                <select name="2step" class="form-control"><?php echo $stepcheck; ?></select>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                        
                                            <center>
                                                <label class="title-text">API Security</label>
                                            </center>
                                            <div class="col-md-12">
                                                <select name="apis" class="form-control"><?php echo $apicheck; ?></select>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            
                                            <center>
                                                <label class="title-text">Email Address</label>
                                            </center>
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span style="background-color: #ff2828; border-color: #ff2828;" class="input-group-addon">
                                                        <i style="color: white;" class="fa fa-envelope-o"></i>
                                                    </span>
                                                    <input type="email" name="email" placeholder="Email Address" class="form-control" value="<?php echo $userInfo['email']; ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            
                                            <center>
                                                <label class="title-text">Change Secuirty Code</label>
                                            </center>
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span style="background-color: #ff2828; border-color: #ff2828;" class="input-group-addon">
                                                        <i style="color: white;" class="fa fa-shield"></i>
                                                    </span>
                                                    <input type="text" name="currentcode" placeholder="5 Digit Code" class="form-control" maxlength="5">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            
                                            <center>
                                                <label class="title-text">Current Password</label>
                                            </center>
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span style="background-color: #ff2828; border-color: #ff2828;" class="input-group-addon">
                                                        <i style="color: white;" class="fa fa-lock"></i>
                                                    </span>
                                                    <input type="password" name="checkpassword" placeholder="Account password" class="form-control">
                                                </div>
                                            </div>

                                        <div class="col-md-12">
                                            <p></p>
                                        </div>
                                        <center>
                                            <button type="submit" name="updateSMBtn" class="btn btn-effect-ripple btn-primary">Update</button>
                                        </center>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--<div class="row">
                        <div class="col-sm-6 col-lg-6">
                            <div class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                                <div class="widget-content widget-content-mini themed-background text-light-op">
    								<span class="pull-right"><?php echo $settings['bootername_1']; ?></span>
    								<i style="color: black;" class="fa fa-user"></i> <b style="color: black;">Site Theme</b>
    							</div>
    							<div class="widget-content main-stats-content text-right clearfix">
                                    <form action="" method="post" class="form-bordered" >
                                        <hr style="border-color: black;">
                                        <div class="col-md-12">
                                            <p></p>
                                        </div>
                                        <center>
                                            <input type="submit" onclick="switch_style('red');return false;" name="theme" value="Red Theme" id="red">Red</input>
                                            <input type="submit" onclick="switch_style('blue');return false;" name="theme" value="Blue Theme" id="blue">Blue</input>
                                        </center>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>-->
                    </div>
<script>
// *** TO BE CUSTOMISED ***

var style_cookie_name = "style" ;
var style_cookie_duration = 30 ;
var style_domain = "ooooooooooof.dashstresser.xyz" ;

// *** END OF CUSTOMISABLE SECTION ***
// You do not need to customise anything below this line

function switch_style ( css_title )
{
// You may use this script on your site free of charge provided
// you do not remove this notice or the URL below. Script from
// https://www.thesitewizard.com/javascripts/change-style-sheets.shtml
  var i, link_tag ;
  for (i = 0, link_tag = document.getElementsByTagName("link") ;
    i < link_tag.length ; i++ ) {
    if ((link_tag[i].rel.indexOf( "stylesheet" ) != -1) &&
      link_tag[i].title) {
      link_tag[i].disabled = true ;
      if (link_tag[i].title == css_title) {
        link_tag[i].disabled = false ;
      }
    }
    set_cookie( style_cookie_name, css_title,
      style_cookie_duration, style_domain );
  }
}
function set_style_from_cookie()
{
  var css_title = get_cookie( style_cookie_name );
  if (css_title.length) {
    switch_style( css_title );
  }
}
function set_cookie ( cookie_name, cookie_value,
    lifespan_in_days, valid_domain )
{
    // https://www.thesitewizard.com/javascripts/cookies.shtml
    var domain_string = valid_domain ?
                       ("; domain=" + valid_domain) : '' ;
    document.cookie = cookie_name +
                       "=" + encodeURIComponent( cookie_value ) +
                       "; max-age=" + 60 * 60 *
                       24 * lifespan_in_days +
                       "; path=/" + domain_string ;
}
function get_cookie ( cookie_name )
{
    // https://www.thesitewizard.com/javascripts/cookies.shtml
	var cookie_string = document.cookie ;
	if (cookie_string.length != 0) {
		var cookie_array = cookie_string.split( '; ' );
		for (i = 0 ; i < cookie_array.length ; i++) {
			cookie_value = cookie_array[i].match ( cookie_name + '=(.*)' );
			if (cookie_value != null) {
				return decodeURIComponent ( cookie_value[1] ) ;
			}
		}
	}
	return '' ;
}
</script>