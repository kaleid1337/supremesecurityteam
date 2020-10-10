<?php

if(isset($_GET['id']) && Is_Numeric($_GET['id']))
{	
	$id = (int)$_GET['id'];
$userid = $_GET['userid'];

  $userid = (int)$_GET['userid'];

    
$paypalemail = $settings['paypal_email'];
$merchant = $settings['merchant'];

if($settings['redirect'] == 1){
	$siteurl = $settings['redirect_site'];
}else{
		$siteurl = $settings['site_forgot'];
}


	$plansql = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = :id");
	$plansql -> execute(array(":id" => $id));
	$row = $plansql -> fetch();

	if($row === NULL) { die("Bad ID"); }

	if($_GET['proc'] == 1)
	{
		if($settings['paypal'] == "0"){
			die("PayPal mehtod is unavailable, Try again later.");
		}
		$paypalurl = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&amount=".urlencode($row['price'])."&business=".urlencode($paypalemail)."&item_name=".
		urlencode($row['name'])."&item_number=".urlencode($row['ID']."_".$userid)."&return=".urlencode($siteurl)."index.php?page=Purchase"."&rm=2&notify_url=".urlencode($siteurl)."includes/paypalipn.php"."&cancel_return=".urlencode($siteurl)."index.php?page=Purchase"."&no_note=1&currency_code=USD";
		header("Location: ".$paypalurl);
	}
	else if($_GET['proc'] == 2)
	{

		if($settings['coinpayments'] == "0"){
			die("CoinPayments mehtod is unavailable, Try again later.");
		}
		$coinURL = "https://www.coinpayments.net/index.php?cmd=_pay&reset=1&merchant=".$merchant."&item_name=".$row['name']."&item_number=".$row['ID']."&first_name=".($_SESSION['username'])."&last_name=".$settings['bootername_2']."&currency=USD&amountf=".$row['price']."&quantity=1&allow_quantity=0&want_shipping=0&ipn_url=".urlencode($siteurl)."includes/coinsipn.php&allow_extra=0&";
		header("Location: ".$coinURL);
	}
}
?>