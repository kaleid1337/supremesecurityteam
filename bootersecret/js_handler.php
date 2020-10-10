<?php
require_once('includes/configuration.php');
session_start();

if($_POST['runservers'])
{
    $SQLGetInfo = $odb->query("SELECT * FROM `servers` ORDER BY `id` DESC");
    while ($getInfo = $SQLGetInfo->fetch(PDO::FETCH_ASSOC)) 
    {
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
    }
}
?>