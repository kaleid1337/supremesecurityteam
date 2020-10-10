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
        
$link1 = "Viewing News Page";
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
                                        <h1>News Manager</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">News</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- Page content -->
            <?php
    if (isset($_POST['addBtn']))
    {
      $name = $_POST['title'];
      $content = $_POST['content'];


        if (empty($content) || empty($name))
          {
            echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Fill In All Fields</p></div>';
          }
          else
          {
$SQLInsert = $odb -> prepare("INSERT INTO news VALUES(NULL, ?, ?, UNIX_TIMESTAMP())");
$SQLInsert -> execute(array($name, $content));

        $link2 = 'Added News ( '.$name.' )';
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
              
                $SQL = $odb -> prepare("DELETE FROM `news` WHERE `ID` = :id LIMIT 1");
                $SQL -> execute(array(':id' => $deletes));

                $link3 = 'Removed News ( '.$deletes.' ) ';
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link3, ));
                  echo '<div class="alert alert-danger"><p><strong>SUCCESS: </strong>Updated</p></div>';
            }
            ?>
                        <!-- First Row -->
                        <div class="row">
                   
         <div class="col-sm-6 col-lg-6">
                                <!-- Input States Block -->
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">

                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">

                                        </div>
                                        <h2 class="main-stats-text-dark">Add News</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Title:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="title" class="form-control" placeholder="Title" >
                                            </div>
                                        </div>
                                            <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Content:</label>
                                            <div class="col-md-8">
                                                <textarea type="area" style="width:400px;  height:50px" name="content" class="form-control" placeholder="" ></textarea>
                                            </div>
                                        </div>
                                         
                                        
                                <center><fieldset>
                                            <div style="background-color: black; border-color: black;" class="form-group form-actions">
                                                <form action="" method="POST">
                                               <button name="addBtn" class="btn btn-primary" type="submit">Submit</button>

                                            </div>

                                        <div style="background-color: black; border-color: black;" class="form-group form-actions">
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
                                        <h2 class="main-stats-text-dark">News</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                   
                                           <table style="border-color: black; background-color: black; color: #9D6595;" class="table table-bordered" id="s-table-bordered">
          <thead>
            <tr></th>
                <th style="background-color: black; border-color: black; color: #9D6595; text-align:center;">#</th>
                <th style="background-color: black; border-color: black; color: #9D6595;">Title</th>
                <th style="background-color: black; border-color: black; color: #9D6595;">Info</th>
                <th style="background-color: black; border-color: black; color: #9D6595;">Date</th>
            </tr>
          </thead>
          <tbody style="background-color: black; border-color: black; color: #9D6595;">
          <?php
          $SQLSelect = $odb -> prepare("SELECT * FROM `news` ORDER BY `ID` ASC");
          $SQLSelect -> execute();
          while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
          {
          $title = $show['title'];
          $content = $show['detail'];
          $date = date("m/d/Y" ,$show['date']);
          $rowID = $show['ID'];
                        echo '<tr style="background-color: black; border-color: black; color: #9D6595;"><td style="background-color: black; border-color: black; color: #9D6595;"><form method="post"><button class="btn btn-danger " name="deleteBtn"><i class="fa fa-trash-o"></i></button><input type="hidden" name="id" value="'.$rowID.'" /></form></td><td style="background-color: black; border-color: black; color: #9D6595;">'.htmlentities($title).'</td><td style="background-color: black; border-color: black; color: #9D6595;">'.htmlentities($content).'</td><td style="background-color: black; border-color: black; color: #9D6595;">'.htmlentities($date).'</td></tr>';
                  }
                  ?>
                                      
                                   
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
          
          
          

    