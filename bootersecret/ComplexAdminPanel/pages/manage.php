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
    header('location: ../index.php?page=logout');
    die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
$CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));

$id = $_GET['id'];
$SQLGetInfo = $odb -> prepare("SELECT * FROM `users` WHERE `ID` = :id LIMIT 1");
$SQLGetInfo -> execute(array(':id' => $_GET['id']));
$userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
$username = $userInfo['username'];
$password = $userInfo['password'];
$email = $userInfo['email'];
$rank = $userInfo['rank'];
$membership = $userInfo['membership'];
$status = $userInfo['status'];
$balance = $userInfo['account_balance'];
$lastip = $userInfo['lastip'];
$key = $userInfo['apikey'];
$lastlogin = date("m-d-Y, h:i:s a" ,$userInfo['lastlogin']);
$expire = date("m-d-Y, h:i:s a" ,$userInfo['expire']);

$link1 = 'Viewing '.$username.' profile';
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));

include("header.php");
?>
                    <div id="page-content">
                        <div class="content-header" style="background-color: black; border-color: black;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1 style="color: white;">Manage: #<?php echo htmlentities($id);?> <?php echo htmlentities($username);?></h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li style="color: white;">Index</li>
                                            <li style="color: #9D6595;"><a href=""><?php echo htmlentities($username);?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <?php 
                        if (isset($_POST['rBtn']))
                        {
                            $sql = $odb -> prepare("DELETE FROM `users` WHERE `ID` = :id");
                            $sql -> execute(array(':id' => $id));
                            $link3 = 'Removed '.$username.'';
                            $ip = getRealIpAddr();
                            $SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
                            $SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link3, ));
                            echo '<div class="alert alert-success"><p><strong>SUCCESS: </strong>User has been removed...</p></div>';
                        }
                        if (isset($_POST['updateBtn']))
                        {
                            $update = false;
                            $errors = array();
                            if ($username!= $_POST['username'])
                            {
                                if (ctype_alnum($_POST['username']) && strlen($_POST['username']) >= 4 && strlen($_POST['username']) <= 15)
                                {
                                    $SQL = $odb -> prepare("UPDATE `users` SET `username` = :username WHERE `ID` = :id");
                                    $SQL -> execute(array(':username' => $_POST['username'], ':id' => $id));
                                    $update = true;
                                    $username = $_POST['username'];
                                }
                                else
                                {
                                    $errors[] = 'Username has to be 4-15 characters in length and alphanumeric';
                                }
                            }
                            if (!empty($_POST['password']))
                            {
                                $shapassword = hash('sha512',$_POST['password']);
                                $SQL = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `ID` = :id");
                                $SQL -> execute(array(':password' => $shapassword, ':id' => $id));
                                $update = true;
                                $password = hash('sha512',$_POST['password']);
                            }
                            if ($email != $_POST['email'])
                            {
                                if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                                {
                                    $SQL = $odb -> prepare("UPDATE `users` SET `email` = :email WHERE `ID` = :id");
                                    $SQL -> execute(array(':email' => $_POST['email'], ':id' => $id));
                                    $update = true;
                                    $email = $_POST['email'];
                                }
                                else
                                {
                                    $errors[] = 'Email is invalid';
                                }
                            }
                            if ($rank != $_POST['rank'])
                            {
                                $SQL = $odb -> prepare("UPDATE `users` SET `rank` = :rank WHERE `ID` = :id");
                                $SQL -> execute(array(':rank' => $_POST['rank'], ':id' => $id));
                                $update = true;
                                $rank = $_POST['rank'];
                            }
                            if ($balance != $_POST['balance'])
                            {
                                $SQL = $odb -> prepare("UPDATE `users` SET `account_balance` = :balance WHERE `ID` = :id");
                                $SQL -> execute(array(':balance' => $_POST['balance'], ':id' => $id));
                                $update = true;
                                $balance = $_POST['balance'];
                            }
                            if ($membership != $_POST['plan'])
                            {
                                if ($_POST['plan'] == 0)
                                {
                                    $SQL = $odb -> prepare("UPDATE `users` SET `expire` = '0', `membership` = '0' WHERE `ID` = :id");
                                    $SQL -> execute(array(':id' => $id));
                                    $update = true;
                                    $membership = $_POST['plan'];
                                }
                                else
                                {
                                    $getPlanInfo = $odb -> prepare("SELECT `unit`,`length` FROM `plans` WHERE `ID` = :plan");
                                    $getPlanInfo -> execute(array(':plan' => $_POST['plan']));
                                    $plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
                                    $unit = $plan['unit'];
                                    $length = $plan['length'];
                                    $newExpire = strtotime("+{$length} {$unit}");
                                    $updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `id` = :id");
                                    $updateSQL -> execute(array(':expire' => $newExpire, ':plan' => $_POST['plan'], ':id' => $id));
                                    $update = true;
                                    $membership = $_POST['plan'];
                                }
                            }
                            if ($status != $_POST['status'] || $status != $_POST['banReason'])
                            {
                                $SQL = $odb -> prepare("UPDATE `users` SET `status` = :status WHERE `ID` = :id");
                                if($_POST['status'] != "0")
                                {
                                    $SQL -> execute(array(':status' => $_POST['banReason'], ':id' => $id));
                                } 
                                else 
                                {
                                    $SQL -> execute(array(':status' => $_POST['status'], ':id' => $id));
                                }
                                $update = true;
                                $status = ($_POST['status'] != "0" ? $_POST['banReason'] : $status);
                            }
                            if ($update == true)
                            {
                                $link2 = 'Edited '.$username.'';
                                $ip = getRealIpAddr();
                                $SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
                                $SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));
                                echo '<div class="alert alert-success"><p><strong>SUCCESS: </strong>User has been updated</p></div>';
                            }
                            else
                            {
                                echo '<div class="nNote nWarning hideit"><p><strong>UPDATE: </strong>Nothing updated</p></div>';
                            }
                            if (!empty($errors))
                            {
                                echo '<div class="alert alert-success"><p><strong>ERROR:</strong><br />';
                                foreach($errors as $error)
                                {
                                    echo '-'.$error.'<br />';
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                            <div class="col-sm-6 col-lg-6">
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="block-title">
                                        <div class="block-options pull-right">

                                        </div>
                                        <h2 class="main-stats-text-dark"><?php echo htmlentities($username);?> Info</h2>
                                    </div>
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Username:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" id="username" name="username" class="form-control" placeholder="Username" value="<?php echo htmlentities($username);?>">
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Password:</label>
                                            <div class="col-md-8">
                                                <input type="text" id="password" name="password" class="form-control" placeholder="Password" >
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Email:</label>
                                            <div class="col-md-8">
                                                <input type="text" id="email" name="email" class="form-control" placeholder="" value="<?php echo htmlentities($email);?>" >
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Balance: $</label>
                                            <div class="col-md-8">
                                                <input type="text" id="balance" name="balance" class="form-control" placeholder="" value="<?php echo htmlentities($balance);?>" >
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Rank:</label>
                                            <div class="col-md-8">
                                                <select name="rank" style="width:450px; text-align:center; height:30px" id="rank"  class="form-control" size="1">
                                                    <?php
                                                    function selectedR($check, $rank)
                                                    {
                                                        if ($check == $rank)
                                                        {
                                                            return 'selected="selected"';
                                                        }
                                                    }
                                                    ?>
                                                    <option value="0" <?php echo selectedR(0, $rank); ?> >User</option>
                                                    <option value="1" <?php echo selectedR(1, $rank); ?> >Staff</option>
                                                    <option value="2" <?php echo selectedR(2, $rank); ?> >Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Membership:</label>
                                            <div class="col-md-8">
                                                <select name="plan" style="width:450px; text-align:center; height:30px" id="method-select"  class="form-control" size="1">
                                         <option value="0">No Membership</option>  
                                              <?php 
                                                $SQLGetMembership = $odb -> query("SELECT * FROM `plans`");
                                                while($memberships = $SQLGetMembership -> fetch(PDO::FETCH_ASSOC))
                                                {
                                                  $mi = $memberships['ID'];
                                                  $mn = $memberships['name'];
                                                  $selectedM = ($mi == $membership) ? 'selected="selected"' : '';
                                                  echo '<option value="'.$mi.'" '.$selectedM.'>'.$mn.'</option>';
                                                }
                                              ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Status:</label>
                                            <div class="col-md-8">
                                                <select name="status" style="width:450px; text-align:center; height:30px" id="status"  class="form-control" size="1">
                                                <?php
                                                function selectedS($check, $rank)
                                                {
                                                    if ($check == $rank)
                                                    {
                                                        return 'selected="selected"';
                                                    }
                                                }
                                                ?>
                                <option value="0" <?php echo selectedS(0, $status); ?>>Active</option>
                                <option value="1" <?php echo ($status != "0" ? "selected=\"selected\"" : ""); ?>>Banned</option>
                                                </select>
                                                <input type="text" id="banReason" name="banReason" class="form-control" placeholder="Ban Reason" value="<?php echo ($status != "0" ? $status : ""); ?>" >
                                            </div>
                                        </div>
                                <center><fieldset>
     <div style="border-color: black; background-color: black;" class="form-group form-actions">
                                                    <form action="" method="POST">
                                               <button name="updateBtn" class="btn btn-primary" type="submit">Submit</button>
                 <button name="rBtn" disabled class="btn btn-danger" type="submit">Remove User</button>

                                            </div>

                                        <div style="border-color: black; background-color: black;" class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                    
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
                                 </div>
                                <!-- END Input States Block -->
         <div class="col-md-6">
                                <!-- Input States Block -->
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">

                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">

                                        </div>
                                        <h2 class="main-stats-text-dark"><?php echo htmlentities($username);?>  Info</h2>
                                    </div>
                                    <!-- END Input States Title -->


                                    <!-- Input States Content -->
                                    <form action="" method="POST" class="form-horizontal form-bordered" >
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">IP Address:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" id="state-normal" name="state-normal" class="form-control" placeholder="No Memberships" value="<?php echo htmlentities($lastip);?>" readonly>
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Last Login:</label>
                                            <div class="col-md-8">
                                                <input type="text" id="state-success" name="state-success" class="form-control" placeholder="You have 0 seconds" value="<?php echo date("m-d-Y, h:i:s a", $userInfo['lastlogin']); ?>" readonly>
                                            </div>
                                        </div>
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Api Key:</label>
                                            <div class="col-md-8">
                                                <input type="text" id="state-warning" name="state-warning" class="form-control" placeholder="" value="<?php echo htmlentities($key);?>" readonly>
                                            </div>
                                        </div>

                                          <div style="border-color: black; background-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Code:</label>
                                            <div class="col-md-6">
                                                <input type="text" id="state-warning" name="state-warning" class="form-control" placeholder="Account Code" value="<?php echo $userInfo['code_account'];?>" maxlength="5">
                                            </div>
                                            <button name="updateBtn" class="btn btn-primary bg-red" type="submit"> <i class="fa fa-check-square text-" ></i> </button>
                                        </div>

                                        <div style="border-color: black; background-color: black;" class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                    
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
          

       <script type="text/javascript" src="../nt/js/jquery.js"></script>
  <script type="text/javascript" src="../nt/js/jquery.gritter/js/jquery.gritter.js"></script>

  <script type="text/javascript" src="../nt/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="../nt/js/behaviour/general.js"></script>
  <script src="../nt/js/jquery.ui/jquery-ui.js" type="text/javascript"></script>
    <script type="text/javascript" src="../nt/js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="../nt/js/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
    <script type="text/javascript" src="../nt/js/jquery.nestable/jquery.nestable.js"></script>
    <script type="text/javascript" src="../nt/js/bootstrap.switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="../nt/js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
  <script src="../nt/js/jquery.select2/select2.min.js" type="text/javascript"></script>
  <script src="../nt/js/skycons/skycons.js" type="text/javascript"></script>
  <script src="../nt/js/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
  <script src="../nt/js/intro.js/intro.js" type="text/javascript"></script>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>

<script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dashBoard();        
        
          introJs().setOption('showBullets', false).start();

      });

      $('#not-theme').show(function(){
      $.gritter.add({
        title: 'System',
        text: 'Ticket Waiting For Your Response',
        image: 'images/NUKE.png',
        class_name: 'clean',
        time: ''
      });
      return false;
    });

      $('#not-theme2').show(function(){
      $.gritter.add({
        title: 'System',
        text: 'Ticket Waiting For Your Response',
        image: 'images/NUKE.png',
        class_name: 'clean',
        time: ''
      });
      return false;
    });
 <?php global $odb; global $user; if($user->isAdmin($odb)) { ?>
      $('#newticket').show(function(){
      $.gritter.add({
        title: 'System - Admin Panel',
        text: 'Ticket Waiting For Your Response',
        image: 'images/NUKE.png',
        class_name: 'clean',
        time: ''
      });
      return false;
    });
    <?php } ?>  
    </script>



    
    <script src="../nt/js/behaviour/voice-commands.js"></script>
  <script src="../nt/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../nt/js/jquery.flot/jquery.flot.js"></script>
    <script type="text/javascript" src="../nt/js/jquery.flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="../nt/js/jquery.flot/jquery.flot.resize.js"></script>
    <script type="text/javascript" src="../nt/js/jquery.flot/jquery.flot.labels.js"></script>
  </body>
</html>



