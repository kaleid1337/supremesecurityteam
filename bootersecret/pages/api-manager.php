<?php
if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `apimanager` = ?");
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
                    <div id="page-content">
                        <div class="content-header" style="background-color: black; border-color: black;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1 style="color: white;">Api Manager</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li style="color: white;">Index</li>
                                            <li style="color: #9D6595;"><a href="">Api Manager</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main">
                            <div class="col-lg-12 discussions"></div>
                            <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                                <div class="block-title">
                                    <h2 class="main-stats-text-dark">API Management</h2>
                                </div>
                                <div class="row">
                                    <div class="panel-body">
                                        <center>
                                            <?php
                                            if(!isset($_POST['keyBtn']))
                                            {
                                                $SQLGetKey = $odb -> prepare("SELECT `apikey` FROM `users` WHERE `ID` = :id");
                                                $SQLGetKey -> execute(array(':id' => $_SESSION['ID']));
                                                $userKey = $SQLGetKey -> fetchColumn(0);
                                            }
                                            else
                                            {
                                                function generateRandomKey($length = 15) 
                                                {
                                                    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                                                    $randomString = '';
                                                    for ($i = 0; $i < $length; $i++) 
                                                    {
                                                        $randomString .= $characters[rand(0, strlen($characters) - 1)];
                                                    }
                                                    return $randomString;
                                                }
                                                $userKey = generateRandomKey();
                                                $SQLNewKey = $odb -> prepare("UPDATE `users` SET `apikey` = :newkey WHERE `ID` = :id");
                                                $SQLNewKey -> execute(array(':newkey' => $userKey, ':id' => $_SESSION['ID']));
                                                echo '<div class="alert alert-success" id="not-theme">Your API key has been changed.</div>';
                                            }
                                            if (isset($_POST["updatewl"])) {
									echo '<div class="alert alert-success" id="not-theme">Your API settings have been changed.</div>';
								}

                                            ?>
                                            <strong style="color: #ffffff;">API Link: <strong style="color: #00DE29;"><?php echo $settings['site_forgot']; ?>index.php?page=Api&key=<?php echo $userKey; ?>&host=[host]&port=[port]&time=[time]&method=[method]</strong><br><br>
                                            <strong style="color: #ffffff;">Methods Link: <strong style="color: #0489B1;"><?php echo $settings['site_forgot']; ?>index.php?page=Api&key=<?php echo $userKey; ?>&host=1.1.1.1&port=1&time=1&method=methods</strong><br><br>
                                            <form action="" method="POST">
                                                <button class="btn btn-success" name="keyBtn" type="submit" style="width: 150px; height: 30px;">Generate New Key</button>
                                            </form>
                                            <br>
							<?php 
						if (isset($_POST["updatewl"])) {
							$SQLNewKey = $odb -> prepare("UPDATE `users` SET `api_ips` = :apiips WHERE `ID` = :id");
                            $SQLNewKey -> execute(array(':apiips' => $_POST["whitelistedips"], ':id' => $_SESSION['ID']));
							$SQL = $odb -> prepare("SELECT `api_ips` FROM `users` WHERE `ID` = :id"); $SQL -> execute(array(':id' => $_SESSION['ID'])); $whitelistedips = $SQL -> fetchColumn(0);
							$SQLNewKey = $odb -> prepare("UPDATE `users` SET `whiteliston` = :whiteliststatus WHERE `ID` = :id");
                            $SQLNewKey -> execute(array(':whiteliststatus' => $_POST["whiteliston"], ':id' => $_SESSION['ID']));
							
						}
							$SQLX = $odb -> prepare("SELECT `whiteliston` FROM `users` WHERE `ID` = :id");
                            $SQLX -> execute(array(':id' => $_SESSION['ID']));
                            $iswhitelistenabled = $SQLX -> fetchColumn(0);
							if ($iswhitelistenabled == "Y") { $selected = "selected='selected'"; }
							if ($iswhitelistenabled == "N") { $selected = ""; }
						?>
							<strong style="color: #ffffff;">API Whitelist Manager</strong><br>
							<form action="" method="POST">
							<div class="form-group">
													<select name="whiteliston" style="width: 150px;" class="form-control">
                                                    <option value="Y" <?php if ($iswhitelistenabled == "Y") { echo 'selected="selected"'; }?>>Enabled</option>
													<option value="N" <?php if ($iswhitelistenabled == "N") { echo 'selected="selected"'; }?>>Disabled</option>
													</select>
											<button class="btn btn-success" name="updatewl" type="submit" style="width: 130px; vertical-align: top; height:30px; display: inline;">Apply Changes</button>
											<input style="width:200px; text-align:center; vertical-align: top; width: 240px; height:30px; display: inline;" type="text" name="whitelistedips" class="form-control" value="<?php $SQL = $odb -> prepare("SELECT `api_ips` FROM `users` WHERE `ID` = :id"); $SQL -> execute(array(':id' => $_SESSION['ID'])); $whitelistedips = $SQL -> fetchColumn(0); echo $whitelistedips; ?>" placeholder="1.1.1.1" >
							</div>
                                      </form>

                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                            <div class="block-title">
                                <h2 class="main-stats-text-dark">Current Attacks</h2>
                            </div>
                            <div class="row">
                                <div class="panel-body">
                                    <center>
                                    <?php
                                        $checkRunningSQL = $odb -> prepare("SELECT * FROM `logs` WHERE `user` = :username  AND `time` + `date` > UNIX_TIMESTAMP()");
                                        $checkRunningSQL -> execute(array(':username' => $_SESSION['username']));
                                    ?>
                                    <table style="color: #9D6595; background-color: black; border-color: black;" class="table table-condensed">
                                        <thead>
                                            <tr style="border-color: black;">
                                                <th style="color: #ffffff; background-color: black; border-color: black;">IP Address</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Port</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Time</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Method</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Timeleft</th>
                                            </tr>
                                        </thead>   
                                        <tbody style="color: black; background-color: #ffffff; border-color: #ffffff;">
                                        <?php while ($row = $checkRunningSQL -> fetch(PDO::FETCH_ASSOC))
                                        {
                                        ?>
                                            <tr style="border-color: black;">
                                                <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['ip']; ?></td>
                                                <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['port']; ?></td>
                                                <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['time']; ?></td>
                                                <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['method']; ?></td>
                                                <td style="color: #9D6595; background-color: black; border-color: black;"><span class="label label-danger"><?php echo $row['date']+$row['time'] - time(); ?> Seconds</span></td>                                       
                                            </tr>  
                                        <?php 
                                        } 
                                        ?>
                                        </tbody>
                                    </table>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                            <div class="block-title">
                                <h2 class="main-stats-text-dark">Your Last 5 Test</h2>
                            </div>
                            <div class="row">
                                <div class="panel-body">
                                    <center>
                                    <?php
                                        $checkRunningSQL = $odb -> prepare("SELECT * FROM `logs` WHERE `user` = :username ORDER BY `date` DESC LIMIT 5");
                                        $checkRunningSQL -> execute(array(':username' => $_SESSION['username']));
                                    ?>
                                    <table style="color: #9D6595; background-color: black; border-color: black;" class="table table-condensed">
                                        <thead>
                                            <tr style="border-color: black;">
                                                <th style="color: #ffffff; background-color: black; border-color: black;">IP Address</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Port</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Time</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Method</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Date</th>
                                                <th style="color: #ffffff; background-color: black; border-color: black;">Status</th>
                                            </tr>
                                        </thead>   
                                        <tbody style="color: black; background-color: #9D6595; border-color: #9D6595;">
                                        <?php while ($row = $checkRunningSQL -> fetch(PDO::FETCH_ASSOC))
                                        {
                                        ?>
                                        <tr style="border-color: black;">
                                            <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['ip']; ?></td>
                                            <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['port']; ?></td>
                                            <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['time']; ?></td>
                                            <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo $row['method']; ?></td>
                                            <td style="color: #9D6595; background-color: black; border-color: black;"><?php echo date('jS F Y h:i:s A (T)', $row['date']); ?></td>
                                            <td style="color: #9D6595; background-color: black; border-color: black;"><?php if($row['date']+$row['time'] > time())
                                                {
                                                    echo '<span class="label label-danger">In Progress</span>';
                                                }
                                                else
                                                {
                                                    echo '<span class="label label-success">Completed</span>';
                                                }
                                                ?></td>
                                        </tr>  
                                        <?php 
                                        } 
                                        ?>
                                        </tbody>
                                    </table>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           