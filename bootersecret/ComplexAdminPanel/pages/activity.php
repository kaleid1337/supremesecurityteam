<?php

  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
if (!($user -> LoggedIn()))
{
    header('location: ../index.php?page=Login');
    die();
}
if (!($user->isAdmin($odb)))
{
  header('location: ../notadmin.php');
  die();
}
if (!($user -> notBanned($odb)))
{
    header('location: ../index.php?page=logout');
    die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
        

$link1 = "Viewing Admin Panel Activity Page";
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));
include("header.php");
?>

  <!-- Page content -->
                    <div id="page-content">
                        <!-- Pricing Tables Header -->
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1>Admin Panel Activity</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Activity</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <div class="block">
                            <!-- Normal Pricing Tables Title -->
                            <div class="block-title">
                                <h2>Admin Panel Activity</h2>
                            </div>
                            <!-- END Normal Pricing Tables Title -->
                          <!-- Normal Pricing Tables Content -->
                           

                          <div class="panel-body">
                     <center>

                           <table class="table table-striped table-bordered table-">
                                  <thead>
                                      <tr>
                                     <th class="hidden-phone">Username</th>
                                            <th class="hidden-phone">Result</th>
                                            <th class="hidden-phone">IP Address</th>
                                                <th class="hidden-phone">Date</th>
                                           
                                      </tr>
                                  </thead>   
                                <tbody>
                                <tbody id="live_page">
  </tbody>
                             </table>
                        </center>
                            </div>
                            <!-- END Normal Pricing Tables Content -->
                        </div>
                        <!-- END Normal Pricing Tables Block -->
                                            </div>

        
        
           
