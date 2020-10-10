<?php


               $checksession = $odb->prepare("SELECT * FROM users WHERE id = ?");
$checksession->execute(array($_SESSION['ID']));
while($session = $checksession->fetch(PDO::FETCH_ASSOC)){
    $lastsession = $session['lastact'];
    $dif = time() - $lastsession; 

    if($dif < 7200){
      
    }
    else
    {
       header('location: ../index.php?page=Login&session=signout');

  die();
    }
}   
$update = $odb->prepare("UPDATE users SET lastact = ? WHERE ID = ?");
$update->execute(array(time(), $_SESSION['ID']));

?>

<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo $settings['bootername_1']; ?> - <?php echo $page; ?> </title>

        <meta name="description" content="">
        <meta name="SupremeSecurity" content="Source By SupremeSecurity">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="supremesecurityteam.com/Source/img/favicon.png">
        <link rel="apple-touch-icon" href="../img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="../img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="../img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="../img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="../img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="../img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="../img/icon152.png" sizes="152x152">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/plugins.css">
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/main.css">
        <script src="../js/vendor/modernizr-2.8.3.js"></script>
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
 
 
        <!-- Page Wrapper -->
        <!-- In the PHP version you can set the following options from inc/config file -->
        <!--
            Available classes:

            'page-loading'      enables page preloader
        -->
        
            <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
                <!-- Alternative Sidebar -->
                <div id="sidebar-alt" tabindex="-1" aria-hidden="true">
                    <!-- Toggle Alternative Sidebar Button (visible only in static layout) -->
                    <a href="javascript:void(0)" id="sidebar-alt-close" onclick="App.sidebar('toggle-sidebar-alt');"><i class="fa fa-times"></i></a>

                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll-alt">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">
                            <!-- Color Themes -->
                            <!-- Preview a theme on a page functionality can be found in js/app.js - colorThemePreview() -->
                          

                            <!-- Profile -->
                            <div class="sidebar-section">
              
      

                                  

 <!-- Labels -->
                                <div class="block-section">
                                    <h4 class="inner-sidebar-header">
                                        <a href="index.php?page=Members" class="btn btn-effect-ripple btn-xs btn-default pull-right"><i class="fa fa-users"></i></a>
                                     Members Online
                                    </h4>
                                    <ul class="nav nav-pills nav-stacked nav-icons">
                                                      <ul class="nav" id="live_members">
                                                        <?php
 $get = $odb->prepare("SELECT * FROM users ORDER BY `lastact` DESC");
    $get->execute(array(""));
    $data1 = '';
while($online = $get->fetch(PDO::FETCH_ASSOC)){
            
                 $lastlogin = $online['lastact'];
                  $date = date("m-d-Y, h:i:s a" ,$online['lastlogin']);
    $dif = time() - $lastlogin;
    if($dif < 300){
     echo ' <li>
                            <a href="index.php?page=Manage&id='.$online['ID'].'" data-toggle="tooltip" data-placement="top" title="'.$date.'">
                                <i style="color:#65E322" class="fa fa-fw fa-circle icon-push text-success"></i>
                               <span >'.$online['username'].'</span>
                            </a>
                        </li>';
    }
    else
    {
        echo '<li>
                            <a href="index.php?page=Manage&id='.$online['ID'].'" data-toggle="tooltip" data-placement="top" title="'.$date.'">
                                <i class="fa fa-fw fa-circle icon-push text-danger"></i>
                                <span>'.$online['username'].'</span>
                            </a>
                        </li>';
    }
}
?>
              


                                       
                                       
                                    </ul>
                                </div>
                                <!-- END Labels -->
                         

                                 
                                   




                                </form>
                            </div>
                            <!-- END Profile -->

                           
               
                        </div>
                        <!-- END Sidebar Content -->
                    </div>
                    <!-- END Wrapper for scrolling functionality -->
                </div>
                <!-- END Alternative Sidebar -->
                <!-- Main Sidebar -->
                <div id="sidebar">
                    <!-- Sidebar Brand -->
                    <div id="sidebar-brand" class="themed-background">
                        <a href="index.php" class="sidebar-title">
                            <i class="fa fa-globe"></i> <span class="sidebar-nav-mini-hide"><?php echo $settings['bootername_1']; ?><strong></strong></span>
                        </a>
                    </div>
                    <!-- END Sidebar Brand -->

                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">
                            <!-- Sidebar Navigation -->
                            <ul class="sidebar-nav">
                                <li>
                                    <a href="index.php" class=" active"><i class="gi gi-compass sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                                </li>
                                <li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
                                <li>
                                    <a href="index.php?page=Members"><i class="fa fa-users sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Members</span></a>
                               </li>
                            
                               <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cog sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Settings</span></a>
                                    <ul>
                                        <li>
                                            <a href="index.php?page=Core">CoreApplication-Settings</a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=Servers">Server Manager</a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=News">News Manager</a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=FAQ">Faq Manager</a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=Methods">Method Manager</a>
                                        </li>
                                        
                                        <li>
                                            <a href="index.php?page=TOS">T.O.S Manager</a>
                                        </li>
                                    </ul>
                                </li>  
                               <li>
                                    <a href="index.php?page=Payments"><i class="fa fa-money sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Payments</span></a>
                               </li>
                               <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-eye-slash sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">BlackListing</span></a>
                                    <ul>
                                        <li>
                                            <a href="index.php?page=Skype-BlackList">Skype Blacklist</a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=IP-BlackList">IP Blacklist</a>
                                        </li>
                                    </ul>
                                </li>  
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-bars sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Logs</span></a>
                                    <ul>
                                        <li>
                                            <a href="index.php?page=Activity">Admin Panel Activity</a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=Attack-Logs">Attack Logs</a>
                                        </li>
                                        <li>
                                            <a href="index.php?page=Login-Logs">Login Logs</a>
                                        </li>
                                     </ul>
                                </li>   
                                    <a href="index.php?page=Plans"><i class="fa fa-tag sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Plans</span></a>
                                </li>

                                 <li>
                                    <a href="index.php?page=Support"><i class="fa fa-ticket sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Ticket Center</span></a>
                                </li>
                                


                                <li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
                                <li>
                                    <a href="index.php?page=IP-Banning"><i class="gi gi-circle_minus sidebar-nav-icon text-danger"></i><span class="sidebar-nav-mini-hide">IP Banning</span></a>
                                </li>
                                <li>
                                    <a href="../index.php"><i class="gi gi-undo sidebar-nav-icon "></i><span class="sidebar-nav-mini-hide">Go Back To Client Side</span></a>
                                </li>
                                
                            </ul>
                            <!-- END Sidebar Navigation -->
                        </div>
                        <!-- END Sidebar Content -->
                    </div>
                    <!-- END Wrapper for scrolling functionality -->

                    <!-- Sidebar Extra Info -->
                    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                        <div class="push-bit">
                            <span class="pull-right">
                                <a href="javascript:void(0)" class="text-light"><i class="fa fa-plus"></i></a>
                            </span>
                            <small><strong class="text-light"><?php echo $stats -> runningboots($odb) ?></strong> Running Attacks</small>
                        </div>
                        <div class="progress progress-mini push-bit">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="20" aria-valuemax="20" style="width: <?php echo $stats -> runningboots($odb) ?>%"></div>
                        </div>
                        <div class="text-center">
                            <small><span id="year-copy"></span> &copy; <a href="javascript:void(0)" target="_blank"> <?php echo $settings['bootername_1']; ?> </a></small>
                        </div>
                    </div>
                    <!-- END Sidebar Extra Info -->
                </div>
                <!-- END Main Sidebar -->

                <!-- Main Container -->
                <div id="main-container">
                    <!-- Header -->
                    <!-- In the PHP version you can set the following options from inc/config file -->
                    <!--
                        Available header.navbar classes:

                        'navbar-default'            for the default light header
                        'navbar-inverse'            for an alternative dark header

                        'navbar-fixed-top'          for a top fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                            'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                        'navbar-fixed-bottom'       for a bottom fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                            'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
                    -->
                    <header class="navbar navbar-inverse navbar-fixed-top">
                        <!-- Left Header Navigation -->
                        <ul class="nav navbar-nav-custom">
                            <!-- Main Sidebar Toggle Button -->
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                                    <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                    <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                </a>
                            </li>
                            <!-- END Main Sidebar Toggle Button -->

                            <!-- Header Link -->
                            <li class="hidden-xs animation-fadeInQuick">
                                <a href=""><strong>WELCOME</strong> <?php echo $_SESSION['username']; ?></a>
                            </li>
                            <!-- END Header Link -->
                        </ul>
                        <!-- END Left Header Navigation -->

                        <ul class="nav navbar-nav-custom pull-right">
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar-alt');">
                                    <i class="gi gi-settings"></i>
                                </a>
                            </li>
                            <!-- END Alternative Sidebar Toggle Button -->
                            

                            
                    </header>


                
                    