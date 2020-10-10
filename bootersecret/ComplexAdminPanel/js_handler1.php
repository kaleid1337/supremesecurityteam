<?php

require_once('../includes/configuration.php');

if($_POST['runpage']) {
	$SQLNews = $odb -> query("SELECT * FROM `adminlogs` ORDER BY `date` DESC LIMIT 500");
	$data1 = '';
	while ($getInfo = $SQLNews -> fetch(PDO::FETCH_ASSOC))
            {

$admin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `rank` = ? AND `username` = ?");
$admin->execute(array("2", $getInfo['username']));
$checkadmin = $admin->fetchcolumn(0);

            	$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);

if($checkadmin){
$check = "success";
}else{
	$check = "warning";
}
            
		$data1 .= '<tr class="'.$check.'">
					<td>'.$getInfo['username'] .'</td>
					<td>'.$getInfo['page'].' </td>
					<td>' .$getInfo['ip']. '</td>
					<td>'.$date.'</td>
				  </tr>';
	}
	die($data1);
}
?>
