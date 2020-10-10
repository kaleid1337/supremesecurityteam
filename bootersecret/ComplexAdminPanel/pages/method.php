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
         
$link1 = "Viewing Method Manager Page";
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
                                        <h1>Methods Manager</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Methods</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- Page content -->
            <?php
    if (isset($_POST['addBtn']))
    {
      $name = $_POST['name'];
      $tag = $_POST['tag'];
      $type = $_POST['type'];
      $adminonly = $_POST['adminonly'];
	  $viponly = $_POST['viponly'];


        if (empty($name) || empty($tag))
          {
            echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Fill In All Fields</p></div>';
          }
          else
          {
$SQLInsert = $odb -> prepare("INSERT INTO methods VALUES(NULL, ?, ?, ?, ?, ?)");
$SQLInsert -> execute(array($name, $tag, $type, $adminonly, $viponly));



        $link2 = 'Added A New Method ( '.$name.' ) ';
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
              
                $SQL = $odb -> prepare("DELETE FROM `methods` WHERE `ID` = :id LIMIT 1");
                $SQL -> execute(array(':id' => $deletes));

                $link3 = 'Removed a method ( '.$deletes.' )';
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

                                        </div>
                                        <h2>Add Methods</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Name:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="name" class="form-control" placeholder="Name" >
                                            </div>
                                        </div>
                                                    <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Tag:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="tag" class="form-control" placeholder="Tag" >
                                            </div>
                                        </div>
                    <div class="form-group">
                    <label class="col-sm-3 control-label">Type: </label>
                    <div class="col-sm-8">
                    <select name="type" class="form-control">
                    <option value="UDP" >UDP</option>
                    <option value="ACK" >ACK</option>
                    <option value="TCP" >TCP</option>
                    <option value="NFO/VPN" >NFO/VPN</option>
                    <option value="SYN" >SYN</option>
                    <option value="HTTP(S)" >HTTP(S)</option>
                    <option value="ADMIN" >ADMIN</option>
                    </select>                 
                    </div>
                    </div>
                    
                    <div class="form-group">
                    <label class="col-sm-3 control-label">Admin only: </label>
                    <div class="col-sm-8">
                    <select name="adminonly" class="form-control">
                    <option value="Y" >Yes</option>
                    <option value="N" selected>No</option>
                    </select>                 
                    </div>
                    </div>
                     
                     <div class="form-group">
                    <label class="col-sm-3 control-label">VIP only: </label>
                    <div class="col-sm-8">
                    <select name="viponly" class="form-control">
                    <option value="Y" >Yes</option>
                    <option value="N" selected>No</option>
                    </select>                 
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

                                        </div>
                                        <h2>Methods</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                   
                                           <table class="table table-bordered" id="s-table-bordered">
          <thead>
     
  <tr>
             
</th>
<th style="text-align:center;">#</th>
              <th>Name</th>
               <th>Tag</th>
               <th>Type</th>
	       <th>Admin</th>
	       <th>Vip</th>
            </tr>
          </thead>
          <tbody>
          <?php
                    $SQLSelect = $odb -> prepare("SELECT * FROM `methods` ORDER BY `ID` ASC");
          $SQLSelect -> execute();
          while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
          {
          $name = $show['name'];
          $tag = $show['tag'];
          $type = $show['type'];
          $adminonlyx = $show['adminonly'];
		  if ($adminonlyx == "Y") { $adminonlyx = "Yes"; }
		  if ($adminonlyx == "N") { $adminonlyx = "No"; }
		  $viponlyx = $show['viponly'];
		  if ($viponlyx == "Y") { $viponlyx = "Yes"; }
		  if ($viponlyx == "N") { $viponlyx = "No"; }
          $rowID = $show['ID'];
                        echo '<tr><td><form method="post"><button class="btn btn-danger " name="deleteBtn"><i class="fa fa-trash-o"></i></button><input type="hidden" name="id" value="'.$rowID.'" /></form></td><td>'.htmlentities($name).'</td><td>'.htmlentities($tag).'</td><td>'.htmlentities($type).'</td><td>'.htmlentities($adminonlyx).'</td><td>'.htmlentities($viponlyx).'</td></tr>';
                  }

                  ?>
                                      
                                   
                                            </div>
                                        </div>
                                    </form>
                                    
                                    <!-- END Input States Content -->
                                </div>
          

    