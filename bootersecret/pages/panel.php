<?php

$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `stresser` = ?");
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
  <!-- Page content -->
   <script type='text/javascript' src='js/ajax/hub.js'></script>
                    <div id="page-content">
                        <!-- Pricing Tables Header -->
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1>PANEL</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Index</li>
                                            <li><a href="">Panel</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

   <div class="row">
                           <div class="col-md-12">
                                <!-- Input States Block -->
                                <div class="block">
                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
                                        </div>
                                        <h2>Panel <i class="fa fa-spinner fa-2x fa-spin text-danger" id="attackloader" style="display:none"></i> </h2>
                                    </div>
<?php
            $plansql = $odb -> prepare("SELECT `users`.`expire`, `plans`.`name`, `concurrent`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id");
            $plansql -> execute(array(":id" => $_SESSION['ID']));
            $row = $plansql -> fetch(); 

             if ($row['mbt'] == "")
            {
            $row['mbt'] = "1";
            }
            ?>


   <div id="attackalert" style="display:none"></div>

                                    <!-- END Input States Title -->
                                    <!-- Input States Content -->
                            
                                    <div class="form-horizontal form-bordered" >
                                           
                                        <div class="form-group">

                    
<center><fieldset>

											<center style="color:white">Best Methods: OVHBYPASS, NFOBYPASS, VOX-X (VIP) DIE & UDPRAND</center>
											
                                            <div class="form-group">
                                            <label class="sr-only" for="example-if-email"></label>
                                            <input style="width:450px; text-align:center; height:30px" type="text" id="host" class="form-control" placeholder="IP Address" onkeydown="if (event.keyCode == 13) document.getElementById('hit').click()">
                                            </div>
                                            <div class="form-group">
                                            <label class="sr-only" for="example-if-email"></label>
                                            <input style="width:450px; text-align:center; height:30px" type="text" id="port" class="form-control" placeholder="Port" onkeydown="if (event.keyCode == 13) document.getElementById('hit').click()">
                                            </div>

                                        <?php
                                        if($settings['slider'] == '1'){

echo '<div class="form-group">
                                            <label class="col-md-3 control-label"></label>
                                            <div  style="width:450px; text-align:center; height:30px">
                                                <input type="text" id="time" class="form-control input-slider" data-slider-min="0" data-slider-max="'.$row['mbt'].'" data-slider-step="1" data-slider-value="25" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show">
</div>
</div>';

                                        }else{

echo '<div class="form-group">
                                            <label class="sr-only" for="example-if-email"></label>
                                            <input style="width:450px; text-align:center; height:30px" type="text" id="time" class="form-control" placeholder="Time" >
                                            </div>';
                                        
                                        }
                                        ?>
                                        

                                            <div  class="form-group">
                                            <label class="col-md-3 control-label" for="example-select"></label>
                                            <div class="col-md-6">
                                                <select id="method" style="width:450px; text-align:center; height:30px" class="form-control" size="1">
<optgroup style="color:white" label="UDP">
<?php
$getMethods = $odb -> prepare("SELECT * FROM methods WHERE type = ? AND adminonly = 'N' AND viponly = 'N'");
$getMethods -> execute(array("UDP"));
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<option value="'.$methodsFetched["tag"].'" selected>'.$methodsFetched["name"].'</option>';
}
?>
<optgroup label="TCP">
<?php
$getMethods = $odb -> prepare("SELECT * FROM methods WHERE type = ? AND adminonly = 'N' AND viponly = 'N'");
$getMethods -> execute(array("TCP"));
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<option value="'.$methodsFetched["tag"].'" selected>'.$methodsFetched["name"].'</option>';
}
?>
<optgroup style="color:white" label="ACK">
<?php
$getMethods = $odb -> prepare("SELECT * FROM methods WHERE type = ? AND adminonly = 'N' AND viponly = 'N'");
$getMethods -> execute(array("ACK"));
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<option value="'.$methodsFetched["tag"].'" selected>'.$methodsFetched["name"].'</option>';
}
?>
<?php
$SQL = $odb -> prepare("SELECT `rank` FROM `users` WHERE `ID` = :ID");
$SQL -> execute(array(':ID' => $_SESSION['ID']));
$expire = $SQL -> fetchColumn(0);
if ($expire == 2) {
?>
<optgroup label="Admin Methods">
<?php
$getMethods = $odb -> prepare("SELECT * FROM methods WHERE adminonly = 'Y'");
$getMethods -> execute(array("ADMIN"));
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<option value="'.$methodsFetched["tag"].'" selected>'.$methodsFetched["name"].'</option>';
}
?>

<?php } ?>

<?php
$SQLA = $odb -> prepare("SELECT `membership` FROM `users` WHERE `ID` = :ID");
$SQLA -> execute(array(':ID' => $_SESSION['ID']));
$membership = $SQLA -> fetchColumn(0);
$SQLB = $odb -> prepare("SELECT `vip` FROM `plans` WHERE `ID` = :ID");
$SQLB -> execute(array(':ID' => $membership));
$vip = $SQLB -> fetchColumn(0);

if ($vip == "Y") {
?>
<optgroup style="color:white" label="NFO/VPN (VIP)">
<?php
$getMethods = $odb -> prepare("SELECT * FROM methods WHERE viponly = 'Y'");
$getMethods -> execute(array("NFO/VPN"));
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<option value="'.$methodsFetched["tag"].'" selected>'.$methodsFetched["name"].'</option>';
}
?>

<?php } ?>

<optgroup label="HTTP(S)">
<?php
$getMethods = $odb -> prepare("SELECT * FROM methods WHERE type = ?");
$getMethods -> execute(array("HTTP(S)"));
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<option value="'.$methodsFetched["tag"].'">'.$methodsFetched["name"].'</option>';
}
?>
</optgroup>

                                     
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-actions">
                                                    
                                                <button class="btn btn-effect-ripple btn-primary" id="hit" onclick="attack()">Send</button> <br /> <span id="sendbutton"></span>
						
                                            </div>
										<center style="color:white"> ONLY USE NFO METHODS ON NFOS! </center>
										<center style="color:white"> ONLY USE OVH METHODS ON OVHS! </center>
										<center style="color:white"> DON'T INCLUDE HTTPS:// / WHEN USING HTTP! </center>
										<center style="color:white"> DON'T SPAM PANEL! </center>
										<center style="color:white"> DON'T SHARE YOUR LOGIN! </center>
										<center style="color:white"> ^ VIOLATING THESE WILL RESULT IN A BAN (NO REFUNDS) ^ </center>
                                                                                <center style="color:white">BY CLICKING THE SEND BUTTON YOU HAVE AGREED TO OUR TERMS OF SERVICE</center>

                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                    
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Input States Content -->
                                </div>
                                <!-- END Input States Block -->

</div>
 <div class="block">
                           
                          <!-- Test Manager Content -->
                           

                          

                        <div class="">
    <div class="block-title">
        <h2>Running Attacks</h2>
    </div>

    <div class="row">
        <div class="panel-body">
           <div class="table-responsive">
            <center>
                <table class="table table-bordered table-vcenter">
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Port</th>
                            <th>Time</th>
                            <th>Method</th>
                            <th>Timeleft</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody id="live_attacks"></tbody>
                </table>
            </center>
        </div>
    </div>
</div>
                       </div>
                            <!-- Test Manager Content -->
                        </div>
                       </div>

  <script src="js/jquery.js"></script> <!-- jQuery -->
                       <script src="js/funcs.js"></script> <!-- jQuery -->
                     <script>run_attacks(0);</script>
