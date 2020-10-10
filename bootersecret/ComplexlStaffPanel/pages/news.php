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
                                <div class="block">

                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">

                                        </div>
                                        <h2>Add News</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Title:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="title" class="form-control" placeholder="Title" >
                                            </div>
                                        </div>
                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Content:</label>
                                            <div class="col-md-8">
                                                <textarea type="area" style="width:400px;  height:50px" name="content" class="form-control" placeholder="" ></textarea>
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
                                        <h2>News</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                   
                                           <table class="table table-bordered" id="s-table-bordered">
          <thead>
     
 <tr>
             
</th>
<th style="text-align:center;">#</th>
              <th>Title</th>
               <th>Content</th>
               <th>Date</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $SQLSelect = $odb -> prepare("SELECT * FROM `news` ORDER BY `ID` ASC");
          $SQLSelect -> execute();
          while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
          {
          $title = $show['title'];
          $content = $show['detail'];
          $date = date("m/d/Y" ,$show['date']);
          $rowID = $show['ID'];
                        echo '<tr><td><form method="post"><button class="btn btn-danger " name="deleteBtn"><i class="fa fa-trash-o"></i></button><input type="hidden" name="id" value="'.$rowID.'" /></form></td><td>'.htmlentities($title).'</td><td>'.htmlentities($content).'</td><td>'.htmlentities($date).'</td></tr>';
                  }
                  ?>
                                      
                                   
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
          

    