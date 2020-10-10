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
         
$link1 = 'Members Page';
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));
include("header.php");
?>
  <!-- Page content -->
                    <div id="page-content">
                        <div class="content-header" style="background-color: black; border-color: black;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1 style="color: white;">Members</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li style="color: white;">Index</li>
                                            <li style="color: #ff2828;"><a href="">Members</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block full" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                            <div class="block-title">
                                <h2 class="main-stats-text-dark">Members</h2>
                            </div>
                            <div class="table-responsive" style="border-color: black;">
                                <table id="example-datatable"  style="color: #ff2828; background-color: black; border-color: black;" class="table table-striped table-bordered table-vcenter">
                                    <thead style="border-color: black;">
                                        <tr style="border-color: black;">
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="text-center" style="width: 50px;">ID</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;">User</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;">Email</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;">Last IP</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;">Last Login</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;">Rank</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;" style="width: 50px;">Status</th>
                                            <th style="color: #ff2828; background-color: black; border-color: black;" class="text-center" style="width: 75px;"><i class="fa fa-flash"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: black; background-color: #ff2828; border-color: #ff2828;">
                                    <?php 
                                    $getusers = $odb -> prepare("SELECT * FROM users ORDER BY ID ASC");
                                    $getusers -> execute();
                                    while ($getInfo = $getusers -> fetch(PDO::FETCH_ASSOC))
                                    {
                                        $id = $getInfo['ID'];
                                        $user = $getInfo['username'];
                                        $email = $getInfo['email'];
                                        $rank = $getInfo['rank'];
                                        $rank1 = $getInfo['rank'];
                                        $lastip = $getInfo['lastip'];
                                        $lastlogin = date("m-d-Y, h:i:s a" ,$getInfo['lastlogin']);
                                        $status = (strlen($getInfo['status']) == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Banned</span>';
                                        $action = $getInfo['lastact'];
                                        if ($rank1 > 1) 
                                        {
                                            $rank2 = 'danger';
                                        } 
                                        elseif ($rank1 == 1) 
                                        {
                                            $rank2 = 'warning';
                                        } 
                                        else 
                                        {
                                            $rank2 = 'Member';
                                        }
                                        if ($rank > 1) 
                                        {
                                            $rank = '<span class="label label-danger">Admin</span>';
                                        } 
                                        elseif ($rank == 1) 
                                        {
                                            $rank = '<span class="label label-warning">Staff</span>';
                                        } 
                                        else 
                                        {
                                            $rank = 'Member';
                                        }
                                            echo '<tr style="border-color: black;" class="'.$rank2.'">
                                                    <td style="color: #ff2828; background-color: black; border-color: black;" class="text-center">'.$id.'</td>
                                                    <td style="color: #ff2828; background-color: black; border-color: black;"><strong>'.$user.'</strong></td>
                                                    <td style="color: #ff2828; background-color: black; border-color: black;">'.$email.'</td>
                                                    <td style="color: #ff2828; background-color: black; border-color: black;">'.$lastip.'</td>
                                                    <td style="color: #ff2828; background-color: black; border-color: black;">'.$lastlogin.'</td>
                                                    <td style="color: #ff2828; background-color: black; border-color: black;">'.$rank.'</td>
                                                    <td style="color: #ff2828; background-color: black; border-color: black;">'.$status.'</td>
                                                    <td style="color: #ff2828; background-color: black; border-color: black;" class="text-center"><a href="index.php?page=Manage&id='.$id.'" data-toggle="tooltip" title="Edit User" class="btn btn-effect-ripple btn-xs btn-success"><i class="fa fa-pencil"></i></a></td>
                                                  </tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <script src="../js/vendor/bootstrap.min.js"></script>
        <script src="../js/plugins.js"></script>
        <script src="../js/app.js"></script>
        <script type="text/javascript">
        $(document).ready(function () {
            //Disable full page
            $("body").on("contextmenu",function(e){ 
                 alert('Dont Touch Our Private Shit SupremeSecurity!!!');
                return false;
            });
            
            //Disable part of page
            $("#id").on("contextmenu",function(e){ 
                 alert('Dont Touch Our Private Shit SupremeSecurity!!!');
                return false;
            });
        });
        </script>
        <script>
        $(document).keydown(function (event) {
            if (event.keyCode == 123) { // Prevent F12
                alert('Dont Touch Our Private Shit SupremeSecurity!!!');
                return false;
            } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
                alert('Dont Touch Our Private Shit SupremeSecurity!!!');
                return false;
            }
        });
        document.onkeydown = function(e) {
                if (e.ctrlKey && 
                    (e.keyCode === 67 || 
                     e.keyCode === 86 ||
                     e.keyCode === 65 ||
                     e.keyCode === 97 ||
                     e.keyCode === 85 ||
                     e.keyCode === 123||
                     e.keyCode === 73 ||
                     e.keyCode === 113 ||
                     e.keyCode === 117)) {
                    alert('Dont Touch Our Private Shit SupremeSecurity!!!');
                    return false;
                } else {
                    return true;
                }
        };
        </script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="../js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>
        