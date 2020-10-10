<?php
  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `fe` = ?");
$admin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `rank` = ? AND `id` = ?");
$admin->execute(array("2", $_SESSION['ID']));
$checkadmin = $admin->fetchcolumn(0);

$SQLCheckPage -> execute(array("1"));
$CheckPage = $SQLCheckPage -> fetchColumn(0);
if ($CheckPage > 0 && $checkadmin < 1)
{
    header('location: index.php?page=Construction');
    die();
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
  <img src="img/black.jpg" class="full-bg animation-pulseSlow"></img>
                    <div id="page-content">
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1><strong class="text-light">FRIENDS & ENEMIES</strong></h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li class="text-light">index
                                            <li><a href="">Friends And Enemies</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
                                        </div>
                                        <h2 class="main-stats-text-dark">Friends And Enemies</h2>
                                    </div>
                                    <?php 
                                    if (isset($_POST['addBtn']))
                                    {
                                        $ipAdd = $_POST['ipAdd'];
                                        $noteAdd = $_POST['noteAdd'];
                                        $type = $_POST['type'];
                                        if (empty($ipAdd) || empty($type))
                                        {
                                            echo '<div class="alert alert-danger">Please fill in all fields</div>';
                                        }
                                        else
                                        {
                                            if (!filter_var($ipAdd, FILTER_VALIDATE_IP))
                                            {
                                                echo '<div class="alert alert-danger">IP is invalid</div>';
                                            }
                                            else
                                            {
                                                $SQLinsert = $odb -> prepare("INSERT INTO `fe` VALUES(NULL, :userID, :type, :ip, :note)");
                                                $SQLinsert -> execute(array(':userID' => $_SESSION['ID'], ':type' => $type, ':ip' => $ipAdd, ':note' => $noteAdd));
                                                echo '<div class="alert alert-success">IP has been added</div>';
                                            }
                                        }
                                    }
                                    ?>
                                    <form action="" method="POST" class="form-horizontal form-bordered" onsubmit="">
                                        <center><fieldset>
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            <label class="sr-only title-text" for="example-if-email"></label>
                                            <div class="col-md-12">
                                                <input style="width:450px; text-align:center; height:30px" type="text" name="ipAdd" class="form-control" placeholder="IP Address">
                                            </div>
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            
                                            <label class="sr-only title-text" for="example-if-email"></label>
                                            <div class="col-md-12">
                                                <input style="width:450px; text-align:center; height:30px" type="text" name="noteAdd" class="form-control" placeholder="Persons name"></input>
                                            </div>
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            
                                            <label class="sr-only title-text" for="example-if-email"></label>
                                            <form class="form-horizontal group-border-dashed" action="#" style="border-radius: 0px;">
                                            <div class="col-sm-12">
                                                <select style="width:450px; text-align:center; height:30px" name="type" class="form-control">
                                                    <option value="f" >Friend</option>
                                                    <option value="e" >Enemy</option>
                                                </select>                 
                                            </div>
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            <form action="" method="POST">
                                                <button type="submit" name="addBtn" class="btn btn-effect-ripple btn-primary">Add</button>
                                                <button type="reset" class="btn btn-effect-ripple btn-danger">Reset</button>
                                            </form>
                                            <div class="col-md-12">
                                                <p></p>
                                            </div>
                                            </form>
                                        </center></fieldset>
                                    </form>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                                    <div class="block-title">
                                        <h2 class="main-stats-text-dark">Friends And Enemies-Logs</h2>
                                    </div>
                                    <?php
                                    if (isset($_POST['deleteBtn']))
                                    {
                                        $deletes = $_POST['id'];
                                        if (!empty($deletes))
                                        {
                                            $SQL = $odb -> prepare("DELETE FROM `fe` WHERE `ID` = :id AND `userID` = :uid LIMIT 1");
                                            $SQL -> execute(array(':id' => $deletes, ':uid' => $_SESSION['ID']));
                                            echo '<div class="alert alert-success">IP(s) Have been removed</div>';
                                        }
                                    }
                                    ?>
                                    <div class="table-responsive" style="border-color: black;">
                                        <table class="table table-borderless table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th style="color: #ff2828; background-color: black; border-color: black;">#</th>
                                                    <th style="color: #ff2828; background-color: black; border-color: black;">IP Address</th>
                                                    <th style="color: #ff2828; background-color: black; border-color: black;">Type</th>
                                                    <th style="color: #ff2828; background-color: black; border-color: black;">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $SQLSelect = $odb -> prepare("SELECT * FROM `fe` WHERE `userID` = :user ORDER BY `ID` DESC");
                                            $SQLSelect -> execute(array(':user' => $_SESSION['ID']));
                                            while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
                                            {
                                                $ipShow = $show['ip'];
                                                $noteShow = $show['note'];
                                                $rowID = $show['ID'];
                                                $type = ($show['type'] == 'f') ? 'Friend' : 'Enemy';
                                                echo '<tr>
                                                        <td>
                                                        <form method="post">
                                                            <button style="background-color: #ff2828; border-color: #ff2828;" class="btn btn-danger btn-mini" name="deleteBtn">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button>
                                                            <input type="hidden" name="id" value="'.$rowID.'" />
                                                        </form>
                                                        </td>
                                                        <td style="color: #ff2828; background-color: black; border-color: black;">'.$ipShow.'</td>
                                                        <td style="color: #ff2828; background-color: black; border-color: black;">'.$type.'</td>
                                                        <td style="color: #ff2828; background-color: black; border-color: black;">'.htmlentities($noteShow).'</td>
                                                      </tr>';
                                            }
                                            ?>  
                                            </tbody>
                                        </table>
                                        <center>
                                    </div>
                                </div>
                            </div>
                        </div>

