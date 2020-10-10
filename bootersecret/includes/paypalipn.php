<?php
define("_VALID_PHP", true);

function debugPP($string)
{
  $file = "debug.txt";
  $open = fopen($file, "a");
  fwrite($open, $string);
}
  
  if (isset($_POST['payment_status'])) {

     require_once('configuration.php');


      set_time_limit(0);      
      function verifyTxnId($txn_id, $odb)
      {          
          $sql = $odb->prepare("SELECT COUNT(id) FROM `payments` WHERE tid = :tid LIMIT 1");
    $sql -> execute(array(":tid" => $txn_id));  
          if ($sql -> fetchColumn(0) > 0)
              return false;
          else
              return true;

      }
      
      $req = 'cmd=_notify-validate';
      
      foreach ($_POST as $key => $value) {
          $value = urlencode(stripslashes($value));
          $req .= '&' . $key . '=' . $value;

      }
      $demo = false;
      $url = 'www.paypal.com';
      
      $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
      $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
      $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
      $fp = fsockopen($url, 80, $errno, $errstr, 30);
      
      $payment_status = $_POST['payment_status'];
      $receiver_email = $_POST['business'];
      list($membership_id, $user_id) = explode("_", $_POST['item_number']);
      $mc_gross = $_POST['mc_gross'];
      $txn_id = $_POST['txn_id'];
    
    debugPP("Selecting Price\n");
      
      $getxn_id = verifyTxnId($txn_id, $odb);
      $pricesql = $odb -> prepare("SELECT `price` FROM `plans` WHERE id = :id");
      $pricesql -> execute(array(":id" => (int)$membership_id));
      $price = $pricesql -> fetchColumn(0);
      
    debugPP("Selecting Client's PayPal Email\n");
    
      $pp_emailsql = $odb -> query("SELECT `paypal_email` FROM `siteconfig` LIMIT 1");
      $pp_email = $pp_emailsql->fetchColumn(0);

      if (!$fp) {
          echo $errstr . ' (' . $errno . ')';
      } else {
          fputs($fp, $header . $req);
          
      debugPP("Phase 1\n");
      
          while (!feof($fp)) {
        $res = fgets($fp, 1024);
      debugPP("Phase 2\n");
              if (strcmp($res, "VERIFIED") == 0) {
          debugPP("Phase 3\n");
                  if (preg_match('/Completed/', $payment_status)) {
            debugPP("Phase 4\n");
                      if ($receiver_email == $pp_email && $mc_gross == $price && $getxn_id == true) {

$SQLGetUser = $odb -> prepare("SELECT `username` FROM `users` WHERE `ID` = :id");
$SQLGetUser -> execute(array(':id' => $user_id));
$userkeyy = $SQLGetUser -> fetchColumn(0);
        
 $data = array(
        ':tid' => $txn_id, 
        ':plan' => (int)$membership_id,
        ':email' => $_POST['payer_email'],
        ':user' => (int)$user_id,
        ':usernameid' => $userkeyy,
        ':paid' => (float)$mc_gross, 
        ':method' => "2",

        );
        

        debugPP("Phase 5\n");
        $odb -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        $insertsql = $odb -> prepare("INSERT INTO `payments` VALUES(NULL, :paid, :plan, :user, :usernameid, :email, :tid, :method, UNIX_TIMESTAMP())");
              $insertsql -> execute($data);
                          
                           $getPlanInfo = $odb -> prepare("SELECT `unit`,`length` FROM `plans` WHERE `ID` = :plan");
                           $getPlanInfo -> execute(array(':plan' => (int)$membership_id));
                          $plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
                          $unit = $plan['unit'];
                          $length = $plan['length'];
                          $newExpire = strtotime("+{$length} {$unit}");
                          $updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `id` = :id");
                          $updateSQL -> execute(array(':expire' => $newExpire, ':plan' => (int)$membership_id, ':id' => (int)$user_id));

            }          
                  }
          
              }
          }
          fclose($fp);

      }
  }
?>
