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
  <!-- Page content -->
  <img src="img/black.jpg" class="full-bg animation-pulseSlow"></img>
  
                    <div id="page-content">
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1><strong class="text-light">Purchase</strong></h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li class="text-light">index
                                            <li><a href="">Purchase</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <div class="widget" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
    								<div class="widget-content widget-content-mini themed-background text-light-op">
    								    <span class="pull-right"></span>
    								    <i style="color: black;" class="fa fa-shopping-cart"></i> <b style="color: black;">Top Up Your Account | Balance: $<?php echo $user -> accountBalance($odb); ?></b>
    								</div>
    								<div class="widget-content" style="background-color: black;">
    								    <?php
                    					if (isset($_POST['balancePurchase']))
                    					{
                    					    $id4Bal = $_POST['balancePurchase'];
                
                            		        $planfo = $odb -> prepare("SELECT `price`, `name` FROM `plans` WHERE `ID` = :id");
                                            $planfo -> execute(array(":id" => htmlentities($id4Bal)));
                                            $planInfo = $planfo -> fetch(PDO::FETCH_ASSOC);
                            		        $price4Bal = $planInfo['price'];
                            		        
                            		        if ($user -> accountBalance($odb) > $price4Bal || $user -> accountBalance($odb) == $price4Bal)
                            		        {
                            		            $user -> takeAccountBalance($odb, htmlentities($price4Bal));
                            		            $user -> addPlanWithBalance($odb, htmlentities($id4Bal));
                                                
                            		            echo '<div class="alert alert-success">Purchase successful! Your Plan Will Be Added In One Moment!!</div><meta http-equiv="refresh" content="2;url=index.php?page=Purchase">';
                            		        }
                            		        else
                            		        {
                            		            echo '<div class="alert alert-success">Insufficient balance!</div>';
                            		        }
                    					}
                    					?>
                                        <div class="col-md-12">
                                            <p></p>
                                        </div>
                                        <div class="form-group form-actions">
                                            <center>
                                                <a href="<?php echo 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&amount=&business=dereknigen@yahoo.com&item_name=Balance&item_number=1-'.urlencode($_SESSION['username']).'&return=https://supremesecurityteam.com/Home/index.php?page=Purchase'.'&rm=2&notify_url='.'&cancel_return=https://supremesecurityteam.com/Home/index.php?page=Purchase'.'&no_note=1&currency_code=USD'; ?>" id="TopUp" name="Add Balance" class="btn btn-effect-ripple btn-primary"><img src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" height="12" width="50" alt="PayPal" /></a>
                                            </center>
                                        </div>
    								</div>
    							</div>
    						</div>
    					</div>
                        <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">
                        <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                            <div class="block-title">
                                <h2>Purchase</h2>
                            </div>
                            <div class="row">
                            <?php
                             $getpp = $odb -> query("SELECT `paypal_email` FROM `siteconfig` LIMIT 1");
     $pp = $getpp->fetchColumn(0);
     $GetPlan = $odb -> prepare("SELECT * FROM `plans` ORDER BY `price` ASC");
     $GetPlan -> execute();
                                while($row = $GetPlan ->fetch()){

                            $pp1 = $row['price'];
  if ($settings['redirect'] == '1') {
    $redirect_paypal = "https://paypal.me/$pp/".$pp1."";
} else {
    $redirect_paypal = "https://paypal.me/$pp/".$pp1."";
}
    $redirect_bitcoin = "".$settings['site_forgot']."/index.php?page=BTC&id=".$row['ID']."";
if (strpos($row['price'], '.') !== false) {
    $tt = "";
} else {
$tt = ".00";
}
  	$redirect_coin = "".$settings['site_forgot']."index.php?page=plan&proc=2&id=".$row['ID']."";
     $redirect_cash = "https://cash.me/SupremeStresser/".$row['price']."";

 if ($settings['paypal'] == '1') {
    $paypalpros = '<a href="'.$redirect_paypal.'" style="width:132px; height:35px" target="_blank" class="btn btn-effect-ripple  btn-primary"><i class="fa fa-paypal"></i> PayPal</a>';
} else {
    $paypalpros = "";
}
 if ($settings['coinpayments'] == '1') {
    $coinpaymentspros = ' <a href="'.$redirect_coin.'" style="width:132px; height:35px" target="_blank" class="btn btn-effect-ripple  btn-info"><i class="fa fa-btc"></i> CoinPayments</a>';
} else {
    $coinpaymentspros = "";
}

 if ($settings['cash'] == '1') {
    $cashpros = ' <a href="'.$redirect_cash.'" style="width:132px; height:35px" target="_blank" class="btn btn-effect-ripple  btn-success"><i class="fa fa-shopping-cart"></i> Cash App</a>';
} else {
    $cashpros = "";
}

 if ($settings['bitcoin_set'] == '1') {
    $bitcoin = ' <a href="'.$redirect_bitcoin.'" style="width:132px; height:35px" target="_blank" class="btn btn-effect-ripple  btn-warning"><i class="fa fa-bitcoin"></i> Bitcoin</a>';
} else {
    $bitcoin = "";
}
if ($row['apiaccess'] == "Y") {
	$apiac = "<tr><td><strong>Api Access:</strong> Yes</td></tr>";
} else { $apiac = "<tr><td><strong>Api Access:</strong> No</td></tr>"; }
if ($row['vip'] == "Y") {
	$vipxa = "<tr><td><strong>Vip Methods:</strong>Yes</td></tr>";
} else { $vipxa = "<tr><td><strong>Vip Methods:</strong> No</td></tr>"; }
if ($row['hidden'] == "N") {
 echo '<div class="col-sm-3">
                                    <table class="table table-borderless table-pricing">
                                        <thead>
                                            <tr>
                                                <th style="color: white;">'.$row['name'].'</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="active">
                                                <td>
                                                    <h1 style="color: black;">$<strong style="color: black;">'.$row['price'].'</strong><br><small></small></h1>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>'.$row['mbt'].'</strong> Seconds</td>
                                            </tr>
                                            <tr>
                                                <td><strong>'.$row['length'].'</strong> '.$row['unit'].'</td>
                                            </tr>
                                            <tr>
                                                <td><strong>'.$row['concurrent'].'</strong> Concurrent</td>
                                            </tr>
                                            '.$apiac.'
											'.$vipxa.'
                                            <tr class="active">
                                                <td>

'.$paypalpros.'
'.$cashpros.'
'.$bitcoin.'
'.$coinpaymentspros.'
<button type="submit" value="'. $row['ID'] .'" style="width:132px; height:35px" name="balancePurchase" id="balancePurchase" class="btn btn-effect-ripple btn-warning">Account Balance</button>

                                                
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted">
                                                    <strong><font size="2" color="red">*Contact Livechat or Open a support ticket after purchase!</font></strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>'; 

                                    }
								}
                            ?>
                            </div>
                            <!-- END Normal Pricing Tables Content -->
                        </form>
                        </div>
                        <!-- END Normal Pricing Tables Block -->
                    </div>
                    <!-- END Page Content -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->