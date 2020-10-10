<?php
if ($settings['cloudflare_set'] == '1') 
{
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} 
else 
{
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                    <div id="page-content">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">TOTAL MEMBERS</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="fa fa-users"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <i class="fa fa-plus"></i> <strong><span data-toggle="counter" data-to="<?php echo $stats -> totalUsers($odb); ?>"></span></strong>
                                        </h2>
                                        <span class="sub-stats-text-white">MEMBERS</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">TOTAL TEST</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="fa fa-wifi"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <i class="fa fa-plus"></i> <strong><span data-toggle="counter" data-to="<?php echo $stats -> totalboots($odb); ?>"></span></strong>
                                        </h2>
                                        <span class="sub-stats-text-white">TEST SENT  </span>
                                    </div>
                                </a>
                            </div>
                            <?php
                            $serverSQL = $odb -> prepare("SELECT COUNT(*) FROM `servers` WHERE (`lastUsed` < UNIX_TIMESTAMP() AND `lastUsed` > '0')");
                            $serverSQL -> execute();
                            $serverSQLCount = $serverSQL -> fetchColumn(0);
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
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">PAID MEMBERS</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="fa fa-user-secret"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <i class="fa fa-plus"></i> <strong><span data-toggle="counter" data-to="<?php echo $stats -> userswithplans($odb); ?>"></span></strong>
                                        </h2>
                                        <span class="sub-stats-text-white">TOTAL PAID  </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">SERVERS AVAILABLE</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <strong><span></span><?php echo $serverSQLCount; ?></strong>
                                        </h2>
                                        <span class="sub-stats-text-white">SERVERS</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                            <div class="row">
                            </div>
                            
                            <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                <div class="block-title">
                                    <h2 class="main-stats-text-dark">Active Tickets</h2>
                                </div>
                                <div class="panel-body">
                                <center>
                                <table class="table table-bordered table-vcenter">
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
                        </div>
                        <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                            <div class="block-title">
                                <h2 class="main-stats-text-dark">Current Attacks</h2>
                            </div>
                            <div class="row">
                                <div class="panel-body">
                                <center>
                                <?php
                                $checkRunningSQL = $odb -> prepare("SELECT * FROM `logs` WHERE `time` + `date` > UNIX_TIMESTAMP()");
                                $checkRunningSQL -> execute(array(':username' => $_SESSION['username']));
                                ?>
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>IP Address</th>
                                            <th>Port</th>
                                            <th>Time</th>
                                            <th>Method</th>
                                            <th>Timeleft</th>
                                        </tr>
                                    </thead>   
                                    <tbody>
                                    <?php 
                                    while ($row = $checkRunningSQL -> fetch(PDO::FETCH_ASSOC))
                                    {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['user']; ?></td>
                                            <td><?php echo $row['ip']; ?></td>
                                            <td><?php echo $row['port']; ?></td>
                                            <td><?php echo $row['time']; ?></td>
                                            <td><?php echo $row['method']; ?></td>
                                            <td><span class="label label-danger"><?php echo $row['date']+$row['time'] - time(); ?> Seconds</span></td>                                       
                                        </tr>  
                                    <?php 
                                    } 
                                    ?>
                                    </tbody>
                                </table>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                        <div class="block-title">
                            <h2 class="main-stats-text-dark">Admin Panel Activity</h2>
                        </div>
                        <div class="panel-body">
                        <center>
                            <table class="table table-bordered table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Page</th>
                                        <th>IP Address</th>
                                        <th>Date</th>
                                     </tr>
                                </thead>   
                                <tbody id="live_admin_panel">
                                </tbody>
                            </table>
                        </center>
                        </div>
                    </div>
           
