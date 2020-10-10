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

$link1 = "Viewing Payments Page";
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));
include("header.php");
?>

 <!-- Page content -->
                    <div id="page-content">
                        <!-- Widgets Header -->
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1>Payment Logs</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Home</li>
                                            <li><a href="">Payment Logs</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Widgets Header -->

 <!-- Block Tabs -->

                        <div class="block">
                            <div class="block-title">
                                <h2>All Payment Logs</h2>
                            </div>
                            <div class="row">
 <div class="table-responsive">
                                <table id="example-datatable" class="table table-striped table-bordered table-vcenter">
                                    <thead>
                                        <tr>
                                           <th>Username</th>
                                           <th>Plan</th>
                                           <th>Payee</td>
                                           <th>Transaction ID</th>
                                           <th>Amount</th>
                                    <th>Method</th>
                                           <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 <?php
 $SQL = $odb -> query("SELECT * FROM `payments` ORDER BY `ID` DESC");
while ($getInfo = $SQL -> fetch(PDO::FETCH_ASSOC))
{
$user = $getInfo['user'];
$SQL2 = $odb -> prepare("SELECT `username` FROM `users` WHERE `ID` = :id");
$SQL2 -> execute(array(':id' => $user));
$username = $SQL2 -> fetchColumn(0);
$amount = $getInfo['paid'];
$SQL3 = $odb -> prepare("SELECT `name` FROM `plans` WHERE `ID` = :id");
$SQL3 -> execute(array(':id' => $getInfo['plan']));
$plan = $SQL3 -> fetchColumn(0);
$sender = $getInfo['email'];
$tid = $getInfo['tid'];
$method = $getInfo['method'];
$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);

      if ($method == 1) {
         $methodcheck = '<button type="button" class="btn btn-rounded btn-warning"><i class="fa fa-bitcoin text-black"/></button></i>';
          } elseif ($method == 2) {
         $methodcheck = '<button type="button" class="btn btn-rounded btn-info"><i class="fa fa-paypal text-black"/></button></i>';
         } elseif ($method == 3) {
         $methodcheck = '<button type="button" class="btn btn-rounded btn-primary"><i class="fa fa-money text-black"/></button></i>';
          } else {
          $methodcheck = '<button type="button" class="btn btn-rounded btn-danger"><i class="fa fa-question text-black"/></button></i>';
          }
        
                                        echo '<tr><td><center>'.$username.'</center></td><td><center>'.$plan.'</center></td><td><center>'.$sender.'</center></td><td><center>'.$tid.'</center></td><td><center>$'.$amount.'</center></td> <td><center>'.$methodcheck.'</center></td> <td><center>'.$date.'</center></td></tr>';
                                }

                                ?>

                                  </tbody>
                                </table>
                            </div>
                        </div>

                        </div>
                                        </div>




