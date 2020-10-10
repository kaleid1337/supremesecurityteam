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
        

$link1 = "Viewing Support Page";
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
                                        <h1>Ticket Center</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Support</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                  <div class="block">
                            <!-- Normal Pricing Tables Title -->
                            <div class="block-title">
                                <h2>All Tickets</h2>
                            </div>
                            <!-- END Normal Pricing Tables Title -->
                          <!-- Normal Pricing Tables Content -->
                           

                          <div class="panel-body">
                     <center>
                        
                            
                            <table class="table table-bordered table-vcenter">
                                  <thead>
                                      <tr>
                                         <th>Username</th>
                                            <th>Subject</th>
                                            <th>Priority</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th>Last Update</th>
                                             <th>View</th>
                                      </tr>
                                  </thead>   
                                  <tbody>
   <?php 
            $SQLGetTickets = $odb -> prepare("SELECT * FROM `tickets` ORDER BY `status` DESC");
            $SQLGetTickets -> execute(array(':status' => 'Waiting for admin response'));
            while ($getInfo = $SQLGetTickets -> fetch(PDO::FETCH_ASSOC))
            {
                $id = $getInfo['id'];
                $username = $getInfo['username'];
                $subject = $getInfo['subject'];
                $status = $getInfo['status'];
                $priority = $getInfo['priority'];
                $department = $getInfo['department'];
                $time = date('Y-m-d h:i:s', $getInfo['time']);

          if ($priority == "Low") {
          $priority1 = '<span class="label label-info">Low</span>';
          } elseif ($priority == "Medium") {
          $priority1 = '<span class="label label-warning">Medium</span>';
          } elseif ($priority == "High") {
          $priority1 = '<span class="label label-danger">High</span>';
          
          }


                echo '<tr><td>'.$username.'</td><td>'.htmlspecialchars($subject).'</td><td>'.$priority1.'</td><td>'.$department.'</td><td>'.$status.'</td><td>'.$time.'</td> <td width="50px"><a href="index.php?page=Ticket&id='.$id.'"><button type="submit" class="btn btn-warning">View</button></a></td></tr>';
            }
            ?>
                                               </tbody>
                             </table>
                        </center>
                            </div>
                            <!-- END Normal Pricing Tables Content -->
                        </div>
                        <!-- END Normal Pricing Tables Block -->

                        