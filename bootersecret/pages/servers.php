<?php
if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `servers` = ?");
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
if (!($user -> LoggedIn()))
{
    header('location: index.php?page=Login');
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
if($CheckUserIP['ip_address'] == "OFF")
{
}
elseif($CheckUserIP['ip_address'] != $ip)
{
    header('location: index.php?page=Check');
    die();
}
include("header.php");
?>
                    <div id="page-content">
                        <div class="content-header" style="background-color: black; border-color: black;">
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
                        <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                            <div class="block-title">
                                <h2 class="main-stats-text-dark">Server Status</h2>
                            </div>
                            <div class="panel-body">
                                <center>
                                <table style="color: #ff2828; background-color: black; border-color: black;" class="table table-striped table-bordered table-vcenter">
                                    <thead>
                                        <tr style="border-color: black;">
                                            <th style="color: #ff2828; background-color: black; border-color: black;">Name</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;">Status</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;">Attacks</th>
                                            <center>
                                            <th class="text-center" style="color: #ff2828; background-color: black; border-color: black; width: 75px;"><i class="gi gi-server"></i></th>
                                            <center>
                                        </tr>
                                    </thead>   
                                    <tbody style="color: black; background-color: #ff2828; border-color: #ff2828;" id="live_servers">
    
                                    </tbody>
                                </table>
                                </center>
                            </div>
                        </div>
                        <script src="js/jquery.js"></script> <!-- jQuery -->
                       <script src="js/funcs.js"></script> <!-- jQuery -->
                     <script>run_servers(0);</script>
                        
                        