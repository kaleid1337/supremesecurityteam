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
        
$link1 = "Viewing IP BlackList Page";
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
                                        <h1>IP Address Blacklist</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">IP Address Blacklist</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- Page content -->
            <?php
    if (isset($_POST['addBtn']))
    {
      $ipAdd = $_POST['ipAdd'];
      

        if (empty($ipAdd))
          {
            echo '<div class="alert alert-danger"><p><strong>FAILURE: </strong>Fill In All Fields</p></div>';
          }
          else
          {
            $SQLinsert = $odb -> prepare("INSERT INTO `blacklist` VALUES(NULL, :ip)");
        $SQLinsert -> execute(array(':ip' => $ipAdd));

        $link2 = 'Blacklisted '.$ipAdd.'';
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
              
                $SQL = $odb -> prepare("DELETE FROM `blacklist` WHERE `ID` = :id LIMIT 1");
                $SQL -> execute(array(':id' => $deletes));

                $link3 = 'Removed IP Address From BlackList';
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
                                        <h2>IP Address Blacklist</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">IP Address:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" id="ip" name="ipAdd" class="form-control" placeholder="IP Address" >
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
                                        <h2>Blacklisted IP Address's</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                   
                                           <table class="table table-bordered" id="s-table-bordered">
          <thead>
     
 <tr>
             
</th>
<th>Delete</th>
              <th>Host</th>
 
            </tr>
          </thead>
          <tbody>
          <?php
          $SQLSelect = $odb -> query("SELECT * FROM `blacklist` ORDER BY `ID` DESC");
          while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
          {
          $ipShow = $show['IP'];
          $rowID = $show['ID'];
                        echo '<tr><td><form method="post"><button class="btn btn-danger " name="deleteBtn"><i class="fa fa-trash-o"></i></button><input type="hidden" name="id" value="'.$rowID.'" /></form></td><td>'.htmlentities($ipShow).'</td></tr>';
                  }
                  ?>
                                      
                                   
                                            </div>
                                        </div>
                                    </form>
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
                                    <!-- END Input States Content -->
                                </div>
          

    