<?php
  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
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

include("header.php");
?>
                    <div id="page-content">
                        <div class="content-header" style="background-color: black; border-color: black;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1 style="color: white;">Attack Logs</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li style="color: white;">Index</li>
                                            <li style="color: #ff2828;"><a href="">Attack Logs</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                            <div class="block-title">
                                <h2 class="main-stats-text-dark">Attack Logs</h2>
                            </div>
                            <div class="row">
                                <table style="color: #ff2828; background-color: black; border-color: black;" id="example-datatable" class="table table-striped table-bordered table-vcenter">
                                    <thead>
                                        <tr style="border-color: black;">
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="hidden-phone">User</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="hidden-phone">IP</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="hidden-phone">Port</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="hidden-phone">Time</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="hidden-phone">Method</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="hidden-phone">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?PHP
                                        $SQLGetLogs = $odb -> prepare("SELECT * FROM `logs` WHERE `user` = :username ORDER BY `date` DESC");
                                        $SQLGetLogs -> execute(array(':username' => $_SESSION['username']));
                                        while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
                                        {
                                            $user = $getInfo['user'];
                                            $IP = $getInfo['ip'];
                                            $port = $getInfo['port'];
                                            $time = $getInfo['otime'];
                                            $method = $getInfo['method'];
                                            $date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
                                            echo '<tr class="odd gradeX">
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$user.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$IP.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$port.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$time.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$method.'</td>
                                                    <td style="color: black; background-color: #ff2828; border-color: #ff2828;">'.$date.'</td>
                                                  </tr>';
                                        }
                                        ?>
                                    </tbody>
                                        </tr>
                                </table>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

