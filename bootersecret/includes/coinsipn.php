<?php     

	function debugPP($string)
	{
		$file = "debug.txt";
		$open = fopen($file, "a");
		fwrite($open, $string);
	}
  

	// Created by 0x68 (Nathan Mallett)
	ob_start();
	require_once('configuration.php');
$Merchant = $odb -> query("SELECT `Merchant` FROM `siteconfig` LIMIT 1") -> fetchColumn(0);
$IPNNN = $odb -> query("SELECT `ipnsecret` FROM `siteconfig` LIMIT 1") -> fetchColumn(0);
    // Fill these in with the information from your CoinPayments.net account.
    // Add merchant ID here 
    $cp_merchant_id = ''.$Merchant.''; 
    // Create a random key here and add it in your coinpayments acc
    $cp_ipn_secret = ''.$IPNNN.''; 
    $cp_debug_email = 'ipn@skid.pw'; 
     
    //These would normally be loaded from your database, the most common way is to pass the Order ID through the 'custom' POST field. 
	// Fetch the stuff from the SQL Server
	$itemName = $_POST['item_name'];
	
	$plansql = $odb->prepare("SELECT * FROM `plans` WHERE `name` = :name");
	$plansql->execute(array(":name" => $itemName));
	$planRow = $plansql->fetch();
	
    $order_currency = 'USD'; 
    $order_total = $planRow['price'];
     
    function errorAndDie($error_msg) { 
        global $cp_debug_email; 
        if (!empty($cp_debug_email)) { 
            $report = 'Error: '.$error_msg."\n\n"; 
            $report .= "POST Data\n\n"; 
            foreach ($_POST as $k => $v) { 
                $report .= "|$k| = |$v|\n"; 
            } 
            mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
        } 
        die('IPN Error: '.$error_msg); 
    } 
     
    if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
		debugPP("not hmac");
        errorAndDie('IPN Mode is not HMAC'); 
    } 
     
    if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
        errorAndDie('No HMAC signature sent.'); 
    } 
     
    $request = file_get_contents('php://input'); 
    if ($request === FALSE || empty($request)) { 
        errorAndDie('Error reading POST data'); 
    } 

    if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
        errorAndDie('No or incorrect Merchant ID passed'); 
    } 

    $hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
    if ($hmac != $_SERVER['HTTP_HMAC']) { 
        errorAndDie('HMAC signature does not match'); 
    } 
     
    // HMAC Signature verified at this point, load some variables. 
	
    $txn_id = $_POST['txn_id']; 
    $item_name = $_POST['item_name']; 
    list($item_number, $user_id) = explode("_", $_POST['item_number']);
    $amount1 = floatval($_POST['amount1']); 
    $amount2 = floatval($_POST['amount2']); 
    $currency1 = $_POST['currency1']; 
    $currency2 = $_POST['currency2']; 
    $status = intval($_POST['status']); 
    $status_text = $_POST['status_text']; 

    // Verify the Transaction ID
	$sql = $odb->prepare("SELECT COUNT(id) FROM `payments` WHERE tid = :tid LIMIT 1");
	$sql -> execute(array(":tid" => $txn_id));	
    if ($sql -> fetchColumn(0) > 0)
	{
		errorAndDie('This Transaction ID has already been processed.');
	}
	
    // Check the original currency to make sure the buyer didn't change it. 
    if ($currency1 != $order_currency) { 
        errorAndDie('Original currency mismatch!'); 
    }     
     
    // Check amount against order total 
    if ($amount1 < $order_total) { 
        errorAndDie('Amount is less than order total!'); 
    } 
   
    if ($status >= 100 || $status == 2)
	{ 
         $data = array(
       ':tid' => $txn_id, 
       ':plan' => (int)$planRow['ID'],
       ':email' => $_POST['email'],
        ':user' => (int)$user_id,
        ':usernameid' => $userkeyy,
      ':paid' => (float)$amount1, 
        ':method' => "3",

        );
			  
			  $odb -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
			    $odb -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $insertsql = $odb -> prepare("INSERT INTO `payments` VALUES(NULL, :paid, :plan, :user, :usernameid, :email, :tid, :method, UNIX_TIMESTAMP())");
              $insertsql -> execute($data);

			  $getPlanInfo = $odb -> prepare("SELECT `unit`,`length` FROM `plans` WHERE `ID` = :plan");
              $getPlanInfo -> execute(array(':plan' => $planRow['ID']));
              $plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
              $unit = $planRow['unit'];
			  $length = $planRow['length'];
			  
              $newExpire = strtotime("+{$length} {$unit}");
              $updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `id` = :id");
              $updateSQL -> execute(array(':expire' => $newExpire, ':plan' => $planRow['ID'], ':id' => $user_id));
			  
    } else if ($status < 0) { 
    } else { 
    } 
    die('IPN OK');
?>