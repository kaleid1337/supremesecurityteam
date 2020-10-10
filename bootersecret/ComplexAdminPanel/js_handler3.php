
<?php

require_once('../includes/configuration.php');



if($_POST['runmembers']) 
 {
 $get = $odb->prepare("SELECT * FROM users ORDER BY `lastact` DESC");
	$get->execute(array(""));
	$data1 = '';
while($online = $get->fetch(PDO::FETCH_ASSOC)){
            
            	 $lastlogin = $online['lastact'];
    $dif = time() - $lastlogin;
    if($dif < 300){
     echo ' <li>
                            <a href="javascript:;">
                                <i class="fa fa-fw fa-circle icon-push text-success"></i>
                                <span>'.$online['username'].'</span>
                            </a>
                        </li>';
    }
    else
    {
        echo '<li>
                            <a href="javascript:;">
                                <i class="fa fa-fw fa-circle icon-push text-danger"></i>
                                <span>'.$online['username'].'</span>
                            </a>
                        </li>';
    }
}
	die($data1);
}
?>