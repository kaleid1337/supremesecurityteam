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
if (!($user->isStaff($odb)))
{
  header('location: ../notstaff.php');
  die();
}
if (!($user -> notBanned($odb)))
{
    header('location: ../index.php?page=logout');
    die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
        $CheckUserIP = $CheckUserSQL -> fetch(PDO::FETCH_ASSOC);
         if($CheckUserIP['ip_address'] == "OFF"){
        }elseif($CheckUserIP['ip_address'] != $ip){
  header('location: ../index.php?page=Check');
  die();
        }
$link1 = "Viewing Attack Logs Page";
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
                                        <h1>Attack Logs</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Attack Logs</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <div class="block">
                            <!-- Normal Pricing Tables Title -->
                            <div class="block-title">
                                <h2>Attack Logs</h2>
                            </div>
                            <!-- END Normal Pricing Tables Title -->
                          <!-- Normal Pricing Tables Content -->
                           

                          <div class="panel-body">
                     <center>
                            
                          <table class="table table-striped table-bordered table-vcenter">
                                  <thead>
                                      <tr>
                                       <th class="hidden-phone">User</th>
                      <th class="hidden-phone">IP</th>
                      <th class="hidden-phone">Port</th>
                      <th class="hidden-phone">Time</th>
                      <th class="hidden-phone">Method</th>
                      <th class="hidden-phone">Date</th>
                                           
                                      </tr>
                                  </thead>   
                                <tbody>
                                  <?php
        $SQLGetLogs = $odb -> query("SELECT * FROM `logs` ORDER BY `date` DESC");
        while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
        {
          $user = $getInfo['user'];
          $IP = $getInfo['ip'];
          $port = $getInfo['port'];
          $time = $getInfo['time'];
          $method = $getInfo['method'];
          $date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
          echo '<tr class="odd gradeX"><td>'.$user.'</td><td>'.$IP.'<br></td><td>'.$port.'</td><td>'.$time.'</td><td>'.$method.'</td><td>'.$date.'</td></tr>';
        }
          
        ?>

                              </tbody>
                             </table>
                        </center>
                            </div>
                            <!-- END Normal Pricing Tables Content -->
                        </div>
                        <!-- END Normal Pricing Tables Block -->
                    
        
        
           
