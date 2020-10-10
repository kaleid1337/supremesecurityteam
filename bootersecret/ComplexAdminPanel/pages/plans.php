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
        

$link1 = "Viewing Plans Page";
$ip = getRealIpAddr();
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
                                        <h1>Plans</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Plans</a></li>
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
          $unitAdd = $_POST['unit'];
          $lengthAdd = $_POST['lengthAdd'];
          $mbtAdd = intval($_POST['mbt']);
          $priceAdd = floatval($_POST['price']);
          $concurrentAdd = $_POST['concurrent'];
          $privateadd = $_POST['private'];
          $apiaccessadd = $_POST['apiaccess'];
          $vip = $_POST['vip'];
          $xd = $_POST['hiddenx'];

          
          if (empty($priceAdd) || empty($nameAdd) || empty($concurrentAdd) || empty($unitAdd) || empty($lengthAdd) || empty($mbtAdd))
          {
            echo '<p class="alert alert-danger">Please fill in all fields</p>';
          }
          else
          {
            $SQLinsert = $odb -> prepare("INSERT INTO `plans` VALUES(NULL, :name, :mbt, :unit, :length, :price, :concurrent, :apiaccess, :vip, :hidden)");
            $SQLinsert -> execute(array(':name' => $nameAdd, ':mbt' => $mbtAdd, ':unit' => $unitAdd, ':length' => $lengthAdd, ':price' => $priceAdd, ':concurrent' => $concurrentAdd, ':apiaccess' => $apiaccessadd, ':vip' => $vip, ':hidden' => $xd));
            $link2 = 'Added A New Plan ( '.$nameAdd.' )';
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));
            echo '<p class="alert alert-success">Plan has been created!</p>';
          }
        }
        ?>
<?php
    if (isset($_POST['deleteBtn']))
            {
              $deletes = $_POST['id'];
              
                $SQL = $odb -> prepare("DELETE FROM `plans` WHERE `ID` = :id LIMIT 1");
                $SQL -> execute(array(':id' => $deletes));

                $link3 = 'Removed A Plan';
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
                                        <h2>Add A New Plan</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Plan Name:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="nameAdd" class="form-control" placeholder="Plan Name" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Boot Time:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="mbt" class="form-control" placeholder="Boot Time" >
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-warning">Unit:</label>
                                            <div class="col-md-8">
                                                <select name="unit" style="width:450px; text-align:center; height:30px" class="form-control" size="1">
                                                    
                                    <option value="Days">Days</option>
                  <option value="Weeks">Weeks</option>
                  <option value="Months">Months</option>
                  <option value="Years">Years</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Length:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="lengthAdd" class="form-control" placeholder="Length" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Concurrent:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="concurrent" class="form-control" placeholder="Concurrent" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Price:</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="price" class="form-control" placeholder="Price" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">API Access:</label>
                                            <div class="col-md-8">
                                                <select name="apiaccess" style="width:450px; text-align:center; height:30px" class="form-control" size="1">
													<option value="Y">Yes</option>
													<option selected value="N">No</option>
                                                </select>
                                            </div>
                                        </div>
                                       <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">VIP:</label>
                                            <div class="col-md-8">
                                                <select name="vip" style="width:450px; text-align:center; height:30px" class="form-control" size="1">
													<option value="Y">Yes</option>
													<option selected value="N">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Hidden:</label>
                                            <div class="col-md-8">
                                                <select name="hiddenx" style="width:450px; text-align:center; height:30px" class="form-control" size="1">
													<option value="Y">Yes</option>
													<option selected value="N">No</option>
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
                                            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
                                        </div>
                                        <h2>Plans</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                   
                                           <table class="table table-bordered" id="s-table-bordered">
          <thead>
     
 <tr>
             
</th>
<th>Delete</th>
<th>Plan Name</th>
<th>Boot Time</th>
<th>Cc's</th>
<th>Price</th>
<th>API</th>
<th>VIP</th>
<th>Hidden</th>
            </tr>
          </thead>
          <tbody>
          <?php
  $SQLSelect = $odb -> query("SELECT * FROM `plans` ORDER BY `id` ASC");
          while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))

{
$planName = $show['name'];
          $mbtShow = $show['mbt'];
          $concurrentShow = $show['concurrent'];
		  $priceShow = $show['price'];
		  $apiaccessShow = $show['apiaccess'];
		  $vipShow = $show['vip'];
          $rowID = $show['ID'];
          $xx = $show['hidden'];
		  if ($vipShow == "Y") { $vipShow = "Yes"; }
		  if ($vipShow == "N") { $vipShow = "No"; }
		  if ($apiaccessShow == "Y") { $apiaccessShow = "Yes"; }
		  if ($apiaccessShow == "N") { $apiaccessShow = "No"; }
		  if ($xx == "N") { $xx = "No"; }
		  if ($xx == "Y") { $xx = "Yes"; }

echo '<tr><td><form method="post"><button class="btn btn-danger " name="deleteBtn"><i class="fa fa-trash-o"></i></button><input type="hidden" name="id" value="'.$rowID.'" /></form></td><td><center>'.htmlentities($planName).'</center></td><td>'.$mbtShow.'</td><td>'.$concurrentShow.'</td><td>'.$priceShow.'</td><td>'.$apiaccessShow.'</td><td>'.$vipShow.'</td><td>'.$xx.'</td></tr>';
}
?>

                                      
                                   
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
          

    