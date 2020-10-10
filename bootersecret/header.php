<?php
if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `website` = ?");
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
$checksession = $odb->prepare("SELECT * FROM users WHERE id = ?");
$checksession->execute(array($_SESSION['ID']));
while($session = $checksession->fetch(PDO::FETCH_ASSOC))
{
    $lastsession = $session['lastact'];
    $dif = time() - $lastsession; 
    if($dif < 600)
    {
    }
    else
    {
        header('location: index.php?page=Login&session=signout');
        die();
    }
}   
$update = $odb->prepare("UPDATE users SET lastact = ? WHERE ID = ?");
$update->execute(array(time(), $_SESSION['ID']));
$SQLCheckBlacklist = $odb -> prepare("SELECT COUNT(*) FROM `ipbanned` WHERE `IP` = :ip");
$SQLCheckBlacklist -> execute(array(':ip' => $ip));
$countBlacklist = $SQLCheckBlacklist -> fetchColumn(0);
function generateRandomKeys($length = 50) 
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) 
    {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
$Session = generateRandomKeys();
if ($countBlacklist > 0)
{
    header('location: index.php?page=Autoban&'.$ip.'='.$Session.'');
    die();
}
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php echo $settings['bootername_1'] ?> - <?php echo $page ?></title>
        <meta name="description" content="">
        <meta name="author" content="Source Edit's By @HexedFull">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.n" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/plugins.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.8.3.js"></script>
        <style>
        
            .main-stats-text-dark {
                color: black;
            }
            
            .sub-stats-text-red {
                color: #9D6595;
            }
            
            .main-stats-content {
                background-color: black;
            }
            
            .block {
                background-color: black;
            }
            
            .block-title {
            	background-color: #9D6595;
            	border-color: #9D6595;
            }
            
            .title-text {
                color: #9D6595;
            }
            
            .form-control {
                background-color: black;
                color: #9D6595;
                border-color: #9D6595;
            }
            
            .form-horizontal {
                background-color: black;
            }
            
            .form-group {
                border-color: black;
            }
        </style>
    </head>
    <body>
    <?php
require('FireWall.php'); // Before all your code starts.
$xWAF = new xWAF();
$xWAF->start();
// FireWall Is Now Enabled
?>
    
if ($settings['preloader'] == '1') 
    {
        echo '<div id="page-wrapper" class="page-loading">
                <div class="preloader">
                    <div class="inner">
                        <div class="preloader-spinner themed-background hidden-lt-ie10"></div>
                        <h3 class="text-primary visible-lt-ie10"><strong>Loading..</strong></h3>
                    </div>
                </div>';
    } 
    else 
    {
        echo "";
    }
    ?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c12c0b47a79fc1bddf0da05/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

            <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
                <div id="sidebar-alt" tabindex="-1" aria-hidden="true">
                    <a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>
                    <div id="sidebar-scroll-alt">
                        <div class="sidebar-content">
                            <?php
                            $SQLGetEmail = $odb -> prepare("SELECT `lastip` FROM `users` WHERE `ID` = :id");
                            $SQLGetEmail -> execute(array(':id' => $_SESSION['ID']));
                            $userIP = $SQLGetEmail -> fetchColumn(0);
                            $SQLGetEmail = $odb -> prepare("SELECT `email` FROM `users` WHERE `ID` = :id");
                            $SQLGetEmail -> execute(array(':id' => $_SESSION['ID']));
                            $userEmail = $SQLGetEmail -> fetchColumn(0);
                            $SQLGetEmail = $odb -> prepare("SELECT `lastlogin` FROM `users` WHERE `ID` = :id");
                            $SQLGetEmail -> execute(array(':id' => $_SESSION['ID']));
                            $userLogin = $SQLGetEmail -> fetchColumn(0);
                            $lastlogin = date("m-d-Y, h:i:s a" ,$userLogin);
                            ?>
                            <div style="background-color: black;" class="sidebar-section">
                                <h2 class="title-text"><i style="color: #ffffff;" class="fa fa-user-circle"></i> Profile</h2>
                                <form action="index.php" method="post" class="form-control-borderless" onsubmit="return false;">
                                    <div class="form-group">
                                        <label style="color:#ffffff" class="title-text" for="side-profile-name">Username: </label>
                                        <label style="color: #9D6595;" type="text" id="side-profile-name" name="side-profile-name" class="form-control"><?php echo $_SESSION['username']; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label style="color:#ffffff" class="title-text" for="side-profile-name">Email: </label>
                                        <label style="color: #9D6595;" type="email" id="side-profile-name" name="side-profile-name" class="form-control"><?php echo $userEmail; ?></label>
                                    </div>
                                     <div class="form-group">
                                        <label style="color:#ffffff" class="title-text" for="side-profile-name">Last IP Address: </label>
                                        <label style="color: #9D6595;" type="email" id="side-profile-name" name="side-profile-name" class="form-control"><?php echo $userIP; ?></label>
                                    </div>
                                    <div class="form-group">
                                        <label style="color:#ffffff" class="title-text" for="side-profile-name">Last Login: </label>
                                        <label style="color: #9D6595;" type="email" id="side-profile-name" name="side-profile-name" class="form-control"><?php echo $lastlogin; ?></label>
                                    </div>
                                    <a href="index.php?page=Profile" style="background-color: #9D6595; color: black;" class="btn btn-effect-ripple btn-block btn-primary" ><i style="color: black;" class="fa fa-user"></i> Profile</a>         
                                    <a href="index.php?page=logout" style="background-color: #9D6595; color: black;" class="btn btn-effect-ripple btn-block btn-primary" ><i style="color: black;" class="fa fa-sign-out"></i> Logout</a>
                                    <div class="block-section">
                                        <h4 class="inner-sidebar-header">
                                        <a href="index.php?page=Support" style="background-color: #9D6595;" class="btn btn-effect-ripple btn-xs btn-primary pull-right"><i style="color: black;" class="fa fa-ticket"></i></a>
                                        <font class="title-text">Support Online ( 
                                            <?php
                                            $sql = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `rank` = ? AND `lastact` > UNIX_TIMESTAMP()-300");
                                            $sql -> execute(array("2"));  
                                            $online = $sql -> fetchcolumn(0);
                                            echo $online;
                                            ?> 
                                        )</font>
                                        </h4>
                                        <ul class="nav">
                                            <?php
                                            $get = $odb->prepare("SELECT * FROM users WHERE rank = ?");
                                            $get->execute(array("2"));
                                            while($online = $get->fetch(PDO::FETCH_ASSOC))
                                            {
                                                $lastlogin = $online['lastact'];
                                                $dif = time() - $lastlogin;
                                                if ($online['rank'] > 1) 
                                                {
                                                    $rank = "Admin";
                                                } 
                                                elseif ($online['rank'] == 2) 
                                                {
                                                    $rank = "Staff";
                                                } 
                                                else 
                                                {
                                                    $rank = 'Member';
                                                }
                                                if($dif < 300)
                                                {
                                                    echo '<li>
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$rank.'">
                                                                <i style="color:green" class="fa fa-fw fa-circle icon-push text-success"></i>
                                                                <span >'.$online['username'].'</span>
                                                            </a>
                                                          </li>';
                                                }
                                                else
                                                {
                                                    echo '<li>
                                                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$rank.' - Offline">
                                                                <i class="fa fa-fw fa-circle icon-push text-danger"></i>
                                                                <span >'.$online['username'].'</span>
                                                            </a>
                                                          </li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="background-color: black; color: #9D6595;" id="sidebar">
                    <div id="sidebar-brand" class="themed-background">
                        <a href="index.php" class="sidebar-title">
                            <i class="fa fa-diamond" style="color:black"></i> <strong class="text-light" class="sidebar-nav-mini-hide" style="color:black"><?php echo  $settings['bootername_1'] ?><strong>
                        </a>
                    </div>
                    <div id="sidebar-scroll">
                        <div class="sidebar-content" style="background-color: black; color: #9D6595;">
                            <ul style="background-color: black; color: #9D6595;" class="sidebar-nav">
                                <li style="background-color: #9D6595;">
                                    <a style="color: black;" href="index.php"><i style="color: #000000;" class="fa fa-spinner sidebar-nav-icon fa-spin"></i><span style="color: black;" class="sidebar-nav-mini-hide">Dashboard</span></a>
                                </li>
                                <li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
                                <?php
                                if ($user->hasMembership($odb))
                                {
                                ?>
                                <li>
                                    <a style="color: #9D6595;" href="?page=SecuredPremiumPanel"><i class="fa fa-rocket sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Control Panel</span></a>
                                </li>
                                <li>
                                    <a style="color: #9D6595;" href="index.php?page=Api-Manager"><i class="fa fa-battery sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Api Manager</span></a>
                                </li>
                                <li>
                                    <a style="color: #9D6595;" href="index.php?page=TOS"><i class="fa fa-handshake-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">TOS</span></a>
                                </li>
                                <li>
                                    <a style="color: #9D6595;" href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-gear fa-spin sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tools</span></a>
                                    <ul style="background-color: black;">
                                        <li>
                                            <a style="color: #9D6595;" href="index.php?page=Http">HTTP Resolver</a>
                                        </li>
                                        
                                        <li>
                                            <a style="color: #9D6595;" href="index.php?page=IPLogger">IP Logger </a>
                                        </li>
                                        <li>
                                            <a style="color: #9D6595;" href="index.php?page=Friends-And-Enemies">Friends & Enemies</a>
                                        </li>
                                        
                                        
                                    </ul>
                                </li>   
                                <?php
                                }
                                ?>
                                    <a style="color: #9D6595;" href="index.php?page=Support"><i class="fa fa-ticket sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Ticket Center</span></a>
                                </li>
                                <li>
                                    <a style="color: #9D6595;" href="https://discordapp.com/invite/hSsBzx5"><i class="fa fa-desktop sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Discord</span></a>
                                </li>
                                <li>
                                    <a style="color: #9D6595;" href="index.php?page=Purchase"><i class="fa fa-shopping-cart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Purchase</span></a>
                                </li>
                                 
                                <li>
                                    <a style="color: #9D6595;" href="#"><i class="fa fa-database sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Balance: $<?php echo $user -> accountBalance($odb); ?></span></a>
                                </li>
                                <li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
                                 <?php
                                if ($user->hasMembership($odb))
                                {
                                ?>
                                
                                <?php
                                }
                                ?>
                                <li>
                                    <a style="color: #9D6595;" href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-bar-chart-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Logs</span></a>
                                    <ul style="background-color: black;">
                                        <li>
                                            <a style="color: #9D6595;" href="index.php?page=Loginlogs">Login Logs</a>
                                        </li>
                                        <li>
                                            <a style="color: #9D6595;" href="index.php?page=Attack-logs">Test Logs</a>
                                        </li>
                                    </ul>
                                    <li>
                                    <a style="color: #9D6595;" href="index.php?page=Servers"><i class="gi gi-server sidebar-nav-icon "></i><span class="sidebar-nav-mini-hide">Servers</span></a>
                                </li>
                                <?php
                                if ($user->isAdmin($odb))
                                {
                                ?>
                                <li>
                                    <a style="color: #9D6595;" href="ComplexAdminPanel/index.php"><i class="fa fa-gears sidebar-nav-icon"></i>
                                    <span class="sidebar-nav-mini-hide">Admin Panel 
                                        <?php
                                        $sql = $odb -> prepare("SELECT COUNT(*) FROM `tickets` WHERE `lastreply` = ? AND `priority` = ?");
                                        $sql -> execute(array("user", "High"));  
                                        $online = $sql -> fetchcolumn(0);
                                        if($online == "0")
                                        {
                                            echo "";
                                        }
                                        else
                                        {
                                            echo "( ". $online. " )";
                                        }
                                        ?> 
                                    </span>
                                    </a>
                                </li>
                                <?php
                                }
                                ?>
                                <?php
                                if ($user->isStaff($odb))
                                {
                                ?>
                                <li style="background-color: black; color: #9D6595;">
                                    <a style="color: #9D6595;" href="ComplexStaffPanel/index.php"><i class="fa fa-gear fa-spin text-danger sidebar-nav-icon "></i><span class="sidebar-nav-mini-hide">Staff Panel</span></a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div style="background-color: black; color: #9D6595;" id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                        <div class="push-bit">
                            <span class="pull-right">
                                <a href="javascript:void(0)" class="text-light"><i class="title-text fa fa-plus"></i></a>
                            </span>
                            <small><strong class="title-text"><?php echo $stats -> runningboots($odb) ?></strong> Running Attack(s)</small>
                        </div>
                        <div class="progress progress-mini push-bit">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="20" aria-valuemax="20" style="width: <?php echo $stats -> runningboots($odb) ?>%"></div>
                        </div>
                        <div class="text-center">
                            <small><span id="year-copy"></span> &copy; <a href="javascript:void(0)" target="_blank"> <?php echo $settings['bootername_1']; ?> </a></small>
                        </div>
                    </div>
                </div>
                <div id="main-container">
                    <header class="navbar navbar-inverse navbar-fixed-top">
                        <ul class="nav navbar-nav-custom">
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                                    <i style="color: black;" class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                    <i style="color: black;" class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                </a>
                            </li>
                            <li class="hidden-xs animation-fadeInQuick">
                                <a style="color: black;" href=""><strong style="color: black;">Welcome: </strong> <?php echo $_SESSION['username']; ?></a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav-custom pull-right">
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');">
                                    <i style="color: black;" class="gi gi-settings"></i>
                                </a>
                            </li>
                    </header>

