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

$link1 = "Viewing Skype Blacklist Page";
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
                                        <h1>Skype Blacklist</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Skype Blacklist</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- Page content -->
            <?php
    if (isset($_POST['addBtn']))
    {
      $nameAdd = $_POST['nameAdd'];
      

        if (empty($nameAdd))
          {
            echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Fill In All Fields</p></div>';
          }
          else
          {
            $SQLinsert = $odb -> prepare("INSERT INTO `skypeblacklist` VALUES(NULL, :skype)");
        $SQLinsert -> execute(array(':skype' => $nameAdd));

        $link2 = 'Blacklisted '.$nameAdd.'';
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));
        echo '<div class="alert alert-success"><p><strong>SUCCESS: </strong>Updated</p></div>';
          }
        }
        ?>
        
        <?php
    if (isset($_POST['deleteBtn']))
            {
              $deletes = $_POST['id'];
              
                $SQL = $odb -> prepare("DELETE FROM `skypeblacklist` WHERE `ID` = :id LIMIT 1");
                $SQL -> execute(array(':id' => $deletes));
                $link3 = 'Removed '.$deletes.' From Blacklist';
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link3, ));
                  echo '<div class="alert alert-danger"><p><strong>SUCCESS: </strong>Updated</p></div>';
            }
            ?>
                        <!-- First Row -->
                        <div class="row">
                   
         <div class="col-sm-6 col-lg-6">
                                <!-- Input States Block -->
                                <div class="block">

                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
                                        </div>
                                        <h2>Skype Blacklist</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Username:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" id="username" name="nameAdd" class="form-control" placeholder="Username" >
                                            </div>
                                        </div>
                                        
                                         
                                        
                                <center><fieldset>
     <div class="form-group form-actions">
                                                    <form action="" method="POST">
                                               <button name="addBtn" class="btn btn-primary" type="submit">Submit</button>

                                            </div>

                                        <div class="form-group form-actions">
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
                                <div class="block">

                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
                                        </div>
                                        <h2>Blacklisted Usernames</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                   
                                           <table class="table table-bordered" id="s-table-bordered">
          <thead>
     
 <tr>
             
</th>
<th>Delete</th>
              <th>Username</th>
 
            </tr>
          </thead>
          <tbody>
          <?php
          $SQLSelect = $odb -> query("SELECT * FROM `skypeblacklist` ORDER BY `ID` DESC");
          while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
          {
          $NameShow = $show['skype'];
          $rowID = $show['ID'];
                        echo '<tr><td><form method="post"><button class="btn btn-danger " name="deleteBtn"><i class="fa fa-trash-o"></i></button><input type="hidden" name="id" value="'.$rowID.'" /></form></td><td>'.htmlentities($NameShow).'</td></tr>';
                  }
                  ?>
                                      
                                   
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
          

    