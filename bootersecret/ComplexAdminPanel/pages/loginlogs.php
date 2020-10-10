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
         if($CheckUserIP['ip_address'] == "OFF"){
        }elseif($CheckUserIP['ip_address'] != $ip){
  header('location: ../index.php?page=Check');
  die();
        }
$link1 = "Viewing Login Logs Page";
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
                                        <h1>Login Logs</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Login Logs</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                          <div class="block">
                            <!-- Normal Pricing Tables Title -->
                            <div class="block-title">
                                <h2>Login Logs</h2>
                            </div>
                            <!-- END Normal Pricing Tables Title -->
                          <!-- Normal Pricing Tables Content -->
                           

                          <div class="panel-body">
                     <center>
                             <div class="table-responsive">
                           <table id="example-datatable" class="table table-bordered table-vcenter">
                                  <thead>
                                      <tr>
                                  <th>Username</th>
                                  <th>IP Address</th>
                                  <th>Country</th>
                                  <th>City</th>
                                  <th>Hostname</th>
                                  <th>Result</th>
                                  <th>Date</th>
                                           
                                      </tr>
                                    </thead>
                                    <tbody>

                                  <?PHP
                                                        $SQLGetLogs = $odb -> prepare("SELECT * FROM `loginlogss` ORDER BY `date` DESC");
                                                        $SQLGetLogs -> execute(array());
                                                        while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
                                                        {
                                                            $user = $getInfo['username'];
                                                            $IP = $getInfo['ip'];
                                                            $result = $getInfo['results'];
                                                             $city = $getInfo['city'];
                                                              $c = $getInfo['country'];
                                                               $h = $getInfo['hostname'];
                                                            $date = date("m-d-Y, h:i:s a" ,$getInfo['date']);

                                                            if ($result > "Successful") {
                                                            $result1 = 'success';
                                                            } elseif ($result == "Failed") {
                                                           $result1 = 'danger';
                                                           } else {
                                                           $result1 = 'success';
                                                        
                                                         }
                                        echo '<tr class="'.$result1.'">
                                            <td>'.$user.'</td>
                                            <td>'.$IP.'</td>
                                            <td>'.$c.'</td>
                                            <td>'.$city.'</td>
                                            <td>'.$h.'</td>
                                            <td>'.$result.'</td>
                                            <td>'.$date.'</td>

                                        </tr>';
                                            
                                            }
                                                    ?>
                                  </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END Datatables Block -->
                    </div>
                    <!-- END Page Content -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->
                    
        

