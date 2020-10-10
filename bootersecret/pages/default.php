<?php

  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
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

                    <div id="page-content">
                        <marquee style="font-size: 14pt; font-family: &quot;Book Antiqua&quot;; color: ffffff; background-color: rgb(0, 0, 0);" bgcolor="#000000" scrollamount="10"> WELCOME TO <?php echo $settings['bootername_1']; ?>*** YOUR IP ADDRESS IS : <?php echo $userIP; ?>*** THE #1  SITE IN THE INDUSTRY!!!<php class="h5 text-red push-15-t push-5"></div></marquee>

                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">TOTAL MEMBERS</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i style="color: white;" class="fa fa-users text-dark"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <i style="color:white" class="fa fa-plus"></i> <strong style="color:white"><span data-toggle="counter" data-to="<?php echo $stats -> totalUsers($odb); ?>"></span><?php echo $stats -> totalUsers($odb); ?></strong>
                                        </h2>
                                        <span class="sub-stats-text-red">MEMBERS</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">TOTAL TEST</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i style="color: white;" class="fa fa-wifi"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <i style="color:white" class="fa fa-plus"></i> <strong style="color:white"><span data-toggle="counter" data-to="<?php echo $stats -> totalboots($odb); ?>"></span><?php echo $stats -> totalboots($odb); ?></strong>
                                        </h2>
                                        <span class="sub-stats-text-red">TEST SENT  </span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">SERVERS AVAILABLE</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i style="color: white;" class="fa fa-refresh fa-spin text-dark"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <i style="color:white" class="fa fa-plus"></i> 
                                            <strong style="color:white"><span data-toggle="counter" data-to="<?php
                                            echo $stats->serversonline($odb);
                                            ?>"></span><?php
                                            echo $stats->serversonline($odb);
                                            ?></strong>
                                        </h2>
                                        <span class="sub-stats-text-red">SERVERS</span>
                                    </div>
                                </a>
                            </div>
                            <?php
                            $SQL = $odb -> prepare("SELECT * FROM `servers` WHERE (`lastUsed` > UNIX_TIMESTAMP() AND `lastUsed` != 0)");
                            $SQL -> execute();
                            $count = 0;
                            while($array2 = $SQL -> fetch())
                            {
                                $count++;
                            }
                            if($count < 1) { $status = "ONLINE"; }
                            else if($count >= 1 && $count <= 14) { $status = "Busy"; }
                            else if($count >= 3) { $status = "Very Busy"; }
                            else if($count >= 4) { $status = "Full"; }
                            ?>
                           <div class="col-sm-6 col-lg-3">
                                <a href="javascript:void(0)" class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
                                        </i> <strong class="main-stats-text-dark">RUNNING TEST</strong>
                                    </div>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        <div class="widget-icon pull-left">
                                            <i style="color: white;" class="fa fa-cog fa-spin text-dark"></i>
                                        </div>
                                        <h2 class="widget-heading h3">
                                            <i style="color:white" class="fa fa-fighter-jet"></i> <strong style="color:white"><span data-toggle="counter" data-to="<?php echo $stats -> totalboots($odb); ?>"></span><?php echo $stats -> runningboots($odb); ?></strong>
                                        </h2>
                                        <span class="sub-stats-text-red">RUNNING</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                        <?php global $odb; global $user; if($user->isAdmin($odb)) { ?>
                        <?php
                        $amount = $odb->prepare("SELECT COUNT(*) FROM tickets WHERE lastreply = ?");
                        $amount->execute(array("user"));
                        if($amount->fetchColumn() == 0){
                        echo "";
                        }
                        else
                        {
                        echo '<div class="alert alert-info">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                       <strong> Admin Panel System:</strong> Ticket waiting for your reply
                                                     </div>';
                        }
                        ?>
                        <?php } ?>  
                        <?php global $odb; global $user; if($user->isStaff($odb)) { ?>
                        <?php
                        $amount = $odb->prepare("SELECT COUNT(*) FROM tickets WHERE lastreply = ?");
                        $amount->execute(array("user"));
                        if($amount->fetchColumn() == 0){
                        echo "";
                        }
                        else
                        {
                        echo '<div class="alert alert-danger">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                       <strong> Staff Panel System:</strong> Active ticket waiting for your reply
                                                     </div>';
                        }
                        ?>
                        <?php } ?>  
                        <?php
                        $amount = $odb->prepare("SELECT COUNT(*) FROM tickets WHERE username = ? AND lastreply = ?");
                        $amount->execute(array($_SESSION['username'], "admin"));
                        if($amount->fetchColumn() == 0){
                        echo "";
                        }
                        else
                        {
                        echo '<div class="col-sm-6">
                                                                <a href="index.php?page=Support" class="widget">
                                                                    <div class="widget-content themed-background-dark text-light-op">
                                                                        <i class="fa fa-fw fa-ticket"></i> <strong>Ticket System</strong>
                                                                    </div>
                                                                    <div class="widget-content themed-background-muted text-center">
                                                                        <i class="fa fa-ticket fa-3x text-dark"></i>
                                                                    </div>
                                                                    <div class="widget-content text-center">
                                                                        <h2 class="widget-heading text-dark">
                        Ticket waiting for your reply 
                        </h2>
                                                                    </div>
                                                                </a>
                                                            </div>
                        ';
                        }
                        ?>
                        <div class="col-sm-6 col-lg-6">
                            <div class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
								<div class="widget-content widget-content-mini themed-background text-light-op">
								    <span class="pull-right"><?php echo $settings['bootername_1']; ?></span>
								    <i style="color: black;" class="fa fa-send"></i> <b style="color: black;">News</b>
								</div>
								<div class="widget-content" style="background-color: black;">
									<div style="position: relative; width: auto" class="slimScrollDiv">
										<div id="stats">
											<table class="table table-striped">
												<tbody>
													<tr>
														<th style="color: #ffffff; background-color: black; border-color: black;"><center>Title</center></th>
														<th style="color: #ffffff; background-color: black; border-color: black;"><center>Information</center></th>
														<th style="color: #ffffff; background-color: black; border-color: black;"><center>Date</center></th>													
													</tr>
													<tr>
													</tr>
													<?php
													$newssql = $odb -> query("SELECT * FROM `news` ORDER BY `date` DESC LIMIT 4");
													while($row = $newssql ->fetch())
													{
													$id = $row['ID'];
													$title = $row['title'];
													$detail = $row['detail'];
													
													echo '
													<tr>
															<td style="color: #white; background-color: black; border-color: white;"><center>'.htmlspecialchars($title).'</center></td>
															<td style="color: #white; background-color: black; border-color: white;"><center>'.htmlspecialchars($detail).'</center></td>
															<td style="color: #white; background-color: black; border-color: white;"><center><span style="color: white; background-color:#000000; border-color: #31CFEE;" class="label label-success"> '.date("m/d/y" ,$row['date']).'</span></center></td>
															
															
															
														</div>
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
						<div class="col-sm-6 col-lg-6">
                            <div class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
								<div class="widget-content widget-content-mini themed-background text-light-op">
								    <span class="pull-right"><?php echo $settings['bootername_1']; ?></span>
								    <i style="color: black;" class="fa fa-users"></i> <b style="color: black;">Users Online</b>
								</div>
								<div class="widget-content" style="background-color: black;">
									<?php
        	                                $getUsernames = $odb->prepare("SELECT * FROM `users` WHERE `lastact` > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 MINUTE))");
        	                                $getUsernames->execute();
        	                                if ($getUsernames->rowCount() != 0)
        	                                {
        		                                while ($row = $getUsernames->fetch(PDO::FETCH_ASSOC))
        		                                {
        		                                    if ($row['membership'] == 0)
        		                                    {
        		                                        echo '<center><span style="background-color: #9D6595; color: white;" class="label label-success">User: '. $row['username'] .' | Last Login: '. date("F j, g:i a", $row['lastlogin']) .' | Free User</span></center>
        		                                            <hr style="border-color: #9D6595;">';
        		                                    }
        		                                    else
        		                                    {
        		                                        echo '<center><span style="background-color: #9D6595; color: white;" class="label label-success">User: '. $row['username'] .' | Last Login: '. date("F j, g:i a", $row['lastlogin']) .' | Paid User</span></center>
        		                                            <hr style="border-color: #9D6595;">';
        		                                    }
        		                                }
        	                                }
        	                                else
        	                                {
        	                                    echo '<h2 style="color: #9D6595;">No Users Online</h2>';
        	                                }
                                            ?>
								</div>
							</div>
						</div>
                            <div class="col-sm-4 col-lg-4">
                                <div class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                    <div class="widget-content widget-content-mini themed-background text-light-op">
    								    <span class="pull-right"><?php echo $settings['bootername_1']; ?></span>
    								    <i style="color: black;" class="fa fa-info"></i> <b style="color: black;">Membership Info</b>
    								</div>
                                    <?php
                                    $plansql = $odb -> prepare("SELECT `users`.`expire`, `plans`.`name`, `concurrent`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id");
                                    $plansql -> execute(array(":id" => $_SESSION['ID']));
                                    $row = $plansql -> fetch(); 
                                    ?>
                                    <div class="widget-content main-stats-content text-right clearfix">
                                        
                                                <center>
                                                    <label style="color:#ffffff" class="title-text" for="state-normal">Plan name</label>
                                                </center>
                                                <div class="col-md-12">
                                                    <input style="background-color: black;" type="text" style="width:22  10px; height:30px" id="state-normal" name="state-normal" class="form-control" placeholder="No Memberships" value="<?php
                                                    if ($row['name'] == "")
                                                        echo 'No active membership';
                                                    else
                                                        echo $row['name'];
                                                    ?>" readonly>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <p></p>
                                                </div>
                                            
                                                <center>
                                                    <label style="color:#ffffff" class="title-text" for="state-normal">Boot Time</label>
                                                </center>
                                                <div class="col-md-12">
                                                    <input style="background-color: black;" type="text" id="state-success" name="state-success" class="form-control" placeholder="You have 0 seconds" value="<?php
                                                    if ($row['mbt'] == "")
                                                        echo 'No active membership';
                                                    else
                                                        echo $row['mbt'];
                                                    ?>" readonly>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <p></p>
                                                </div>
                                                
                                                <center>
                                                    <label style="color:#ffffff" class="title-text" for="state-warning">Expire Date</label>
                                                </center>
                                                <div class="col-md-12">
                                                    <input style="background-color: black;" type="text" id="state-warning" name="state-warning" class="form-control" placeholder="" value="<?php
                                                    if ($row['expire'] == "")
                                                        echo 'No active membership';
                                                    else
                                                        echo date("m-d-Y, h:i:s a", $row['expire']);
                                                    ?>" readonly>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <p></p>
                                                </div>
                                                
                                                <center>
                                                    <label style="color:#ffffff" class="title-text" for="state-warning">Concurrents</label>
                                                </center>
                                                <div class="col-md-12">
                                                    <input style="background-color: black;" type="text" id="state-warning" name="state-warning" class="form-control" placeholder="You have 0 Concurrents" value="<?php
                                                    if ($row['concurrent'] == "")
                                                        echo 'No active membership';
                                                    else
                                                        echo $row['concurrent'];
                                                    ?>" readonly>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <p></p>
                                                </div>
                                                
                                            <?php
                                            $SQLGetKey = $odb -> prepare("SELECT `apikey` FROM `users` WHERE `ID` = :id");
                                            $SQLGetKey -> execute(array(':id' => $_SESSION['ID']));
                                            $userKey = $SQLGetKey -> fetchColumn(0);
                                            if ($userKey == "0")
                                            {
                                                $userKey = "No Api Key";
                                            }
                                            ?>
                                            <center>
                                                <label style="color:#ffffff" class="title-text" for="state-danger">Api Key</label>
                                            </center>
                                            <div class="col-md-12" style="display: inline-block;">
                                                <input type="text" id="state-danger" style="display: inline;" name="state-danger" class="form-control" placeholder="No Api Key" value="Hidden" readonly>
												<button class="btn btn-effect-ripple btn-primary" style="display: inline;" id="hit" style="display: inline;" onclick="hideshow()">Hide/Show</button>
												<script>
												function hideshow() {
												var x = document.getElementById("yo");
													if (document.getElementById("state-danger").value === "Hidden") {
														document.getElementById("state-danger").value="<?php echo $userKey; ?>"
													} else {
														document.getElementById("state-danger").value="Hidden"
													}
												}
												</script>
											</div>

                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                    

