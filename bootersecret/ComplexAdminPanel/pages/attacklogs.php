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
        $CheckUserIP = $CheckUserSQL -> fetch(PDO::FETCH_ASSOC);
        
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
                            
                          <table class="table table-bordered table-vcenter">
                                  <thead>
                                      <tr>
                                       <th class="hidden-phone">User</th>
                      <th class="hidden-phone">IP</th>
                      <th class="hidden-phone">Port</th>
                      <th class="hidden-phone">Time</th>
                      <th class="hidden-phone">Method</th>
                      <th class="hidden-phone">Status</th>
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
          $time = $getInfo['otime'];
          $stoppedk = $getInfo['stopped'];
          $method = $getInfo['method'];
          $date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
        
if($stoppedk == "1"){
$stopped = '<div class="badge badge-red text-danger"/>Stopped</div>';
}else{
$stopped = '<div class="badge badge text-success"/>Completed</div>';
}

          					echo '<tr class="odd gradeX">
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$user.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$IP.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$port.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$time.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$method.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$stopped.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$date.'</td>
                                                  </tr>';
        }
          
        ?>







                              </tbody>
                             </table>
                        </center>
                            </div>
                            <!-- END Normal Pricing Tables Content -->
                        </div>
                        <!-- END Normal Pricing Tables Block -->
                    
        
        
           
