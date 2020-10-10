<?php
require_once('includes/configuration.php');
session_start();

if($_POST['runattacks']){

$checkRunningSQL = $odb -> prepare("SELECT * FROM `logs` WHERE `user` = :username  AND `time` + `date` > UNIX_TIMESTAMP()");
                                $checkRunningSQL -> execute(array(':username' => $_SESSION['username']));
                                while ($row = $checkRunningSQL -> fetch(PDO::FETCH_ASSOC)){
$blahblach = $row['date']+$row['time'] - time();



$button=  ' <tr>
                                        <td>'.$row['ip'].'</td>
                                        <td>'.$row['port'].'</td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['method'].'</td>
                                        <td>
                                            <span class="label label-danger">'.$blahblach.' Seconds</span>
                                        </td>    
                                        <td><button class="btn btn-effect-ripple btn-primary" id="kill" onclick="stop('.$row['id'].')">Stop</button><input type="hidden" name="ipID" value="'.$row['ip'].'" /><input type="hidden" name="StopID" value="'.$row['id'].'" /></td>                                   
                                    </tr>  ';

echo $button;


                                }
}

?>
