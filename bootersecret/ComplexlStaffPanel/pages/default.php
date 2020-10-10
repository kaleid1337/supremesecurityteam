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
    header('location: ../index.php?page=Logout');
    die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
        $CheckUserIP = $CheckUserSQL -> fetch(PDO::FETCH_ASSOC);
        
$link1 = "Viewing Defualt Page";
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));

include("header.php");
?>

<!-- Page content -->
                    <div id="page-content">
                        <!-- First Row -->
                        <div class="row">
                            <!-- Simple Stats Widgets -->
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget">
                                    <div class="widget-content widget-content-mini themed-background-success text-light-op">
                                        <i class="fa fa-clock-o"></i> <strong>TOTAL MEMBERS</strong>
                                    </div>
                                    <div class="widget-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="fa fa-users text-muted"></i>
                                        </div>
                                        <h2 class="widget-heading h3 text-success">
                                            <i class="fa fa-plus"></i> <strong><span data-toggle="counter" data-to="<?php echo $stats -> totalUsers($odb); ?>"></span></strong>
                                        </h2>
                                        <span class="text-muted">MEMBERS</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget">
                                    <div class="widget-content widget-content-mini themed-background-warning text-light-op">
                                        <i class="fa fa-clock-o"></i> <strong>TOTAL ATTACKS</strong>
                                    </div>
                                    <div class="widget-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="fa fa-bars text-muted"></i>
                                        </div>
                                        <h2 class="widget-heading h3 text-warning">
                                            <i class="fa fa-plus"></i> <strong><span data-toggle="counter" data-to="<?php echo $stats -> totalboots($odb); ?>"></span></strong>
                                        </h2>
                                        <span class="text-muted">ATTACKS </span>
                                    </div>
                                </a>
                            </div>
<?php
                $serverSQL = $odb -> prepare("SELECT COUNT(*) FROM `servers` WHERE (`lastUsed` < UNIX_TIMESTAMP() AND `lastUsed` > '0')");
                $serverSQL -> execute();
                $serverSQLCount = $serverSQL -> fetchColumn(0);
                $finalCount = $serverSQLCount * 100 / $serverSQLCount;
                ?>

                                <?php
                            $SQL = $odb -> prepare("SELECT * FROM `servers` WHERE (`lastUsed` > UNIX_TIMESTAMP() AND `lastUsed` != 0)");
                            $SQL -> execute();
                            
                            $count = 0;
                            while($array2 = $SQL -> fetch())
                            {
                                $count++;
                            }
                            
                            if($count < 7) { $status = "Stable"; $color = "success"; }
                            else if($count >= 7 && $count <= 14) { $status = "Busy"; $color = "warning"; }
                            else if($count >= 15) { $status = "Very Busy"; $color = "danger"; }
                            else if($count >= 23) { $status = "Full"; $color = "danger"; }
                ?>
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        <i class="fa fa-clock-o"></i> <strong>SERVERS AVAILABLE</strong>
                                    </div>
                                    <div class="widget-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="gi gi-cardio text-muted"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <strong><span data-toggle="counter" data-to="<?php echo $serverSQLCount-1; ?>"></span></strong>
                                        </h2>
                                        <span class="text-muted">Servers</span>
                                    </div>
                                </a>
                            </div>
                         
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget">
                                    <div class="widget-content widget-content-mini themed-background-danger text-light-op">
                                        <i class="fa fa-clock-o"></i> <strong>Stresser Status</strong>
                                    </div>
                                    <div class="widget-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="fa fa-signal text-muted"></i>
                                        </div>
                                        <h2 class="widget-heading h3 text-danger">
                                            <strong><span></span><?php echo $status; ?></strong>
                                        </h2>
                                        <span class="text-muted">Status </span>
                                    </div>
                                </a>
                            </div>
                            <!-- END Simple Stats Widgets -->
                        </div>
                        <!-- END First Row -->

                      

                      


   <!-- Second Row -->
                        <div class="row">
                            
                          </div>

<?php
$getupdate = "https://sites.google.com/site/omegaproductssources/home/licenses";
$contents = @file_get_contents($getupdate);
if(strstr($contents, "newupdate.v1.0")){

echo '<div class="alert alert-danger">Please Update This Source. Want More Info? /Administrator/index.php?newupdate You currently Have Version v1.0</div>';
}
 ?>


                  <div class="block">
                            <!-- Normal Pricing Tables Title -->
                            <div class="block-title">
                                <h2>Active Tickets</h2>
                            </div>
                            <!-- END Normal Pricing Tables Title -->
                          <!-- Normal Pricing Tables Content -->
                           

                          <div class="panel-body">
                     <center>
                        
                            
                            <table class="table table-striped table-bordered table-vcenter">
                                  <thead>
                                      <tr>
                                         <th>Username</th>
                                            <th>Subject</th>
                                            <th>Priority</th>
                                            <th>Department</th>
                                            <th>Last Update</th>
                                             <th>View</th>
                                      </tr>
                                  </thead>   
                                  <tbody>
<?php 
            $SQLGetTickets = $odb -> prepare("SELECT * FROM `tickets` WHERE `status` = :status ORDER BY `id` DESC");
            $SQLGetTickets -> execute(array(':status' => 'Waiting for admin response'));
            while ($getInfo = $SQLGetTickets -> fetch(PDO::FETCH_ASSOC))
            {
                $id = $getInfo['id'];
                $username = $getInfo['username'];
                $subject = $getInfo['subject'];
                $priority = $getInfo['priority'];
                $department = $getInfo['department'];
                                $status = $getInfo['status'];

                $time = date('Y-m-d h:i:s', $getInfo['time']);

          if ($priority == "Low") {
          $priority1 = '<span class="label label-info">Low</span>';
          } elseif ($priority == "Medium") {
          $priority1 = '<span class="label label-warning">Medium</span>';
          } elseif ($priority == "High") {
          $priority1 = '<span class="label label-danger">High</span>';
          
          }


                echo '<tr><td>'.$username.'</td><td>'.htmlspecialchars($subject).'</td><td>'.$priority1.'</td><td>'.$department.'</td><td>'.$time.'</td> <td width="50px"><a href="index.php?page=Ticket&id='.$id.'"><button type="submit" class="btn btn-warning">View</button></a></td></tr>';
            }
            ?>
                
                
                                   </tbody>
                             </table>
                        </center>
                            </div>
                            <!-- END Normal Pricing Tables Content -->
                        </div>
                        <!-- END Normal Pricing Tables Block -->
                    

