<?php 
require '../includes/configuration.php';
require '../includes/init.php';
$type = $_GET['type'];
if ($type == "submit")
{
    session_start();
    $subject = $_POST['subject'];
    $content = $_POST['message'];
    $department = $_POST['department'];
    $priority = $_POST['ppp'];
    $errors = array();
    if($department == "1" || $priority == "2")
    {
        echo '<div class="alert alert-danger">Please choose a department and a priority</div>';
    }
    else
    {
        if (empty($subject) || empty($content) || empty($department) || empty($priority))
        {
            $errors[] = '<div class="alert alert-danger">Pleaes Fill In All Fields</div>';
        }
        if (strlen($subject) > 50) 
        {
            $errors[] = '<div class="alert alert-danger">Your Subject is too long.</div>';
        }
        if (strlen($content) > 5000) 
        {
            $errors[] = '<div class="alert alert-danger">Your Message is too long.</div>';
        }
        $SQLCount = $odb -> prepare("SELECT COUNT(*) FROM `tickets` WHERE `username` = :username AND `status` = 'Waiting for admin response'");
        $SQLCount -> execute(array(':username' => $_SESSION['username']));
        if ($SQLCount -> fetchColumn(0) > 2)
        {
            $errors[] = '<div class="alert alert-danger">You have too many tickets open</div>';
        }
        $validMethods = array("Billing", "General", "Tech", "Other");
        $MethodIsValid = 0;
        foreach($validMethods as $i)
        {
            if($i == $department)
            {
                $MethodIsValid = 1;
                break;
            }
        }
        $pvalidmethods = array("Low", "Medium", "High");
        $Pisvalid = 0;
        foreach($pvalidmethods as $i)
        {
            if($i == $priority)
            {
                $Pisvalid = 1;
                break;
            }
        }
        if($MethodIsValid == 1 && $Pisvalid == 1)
        {
            if (empty($errors))
            {        
                $subjectnon = preg_replace('@[^0-9a-z\.\-\:\_\,]+@i', '', $subject);
                $subjectnon = strtolower ( $subjectnon );
                $SQLinsert = $odb -> prepare("INSERT INTO `tickets` VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP())");
                $SQLinsert -> execute(array($subjectnon, $content, $priority, $department, 'Waiting for admin response', $_SESSION['username'], 'user', 0));
                echo '<div class="alert alert-success">Ticket has been created.</div>';
            }
            else
            {
                echo "";
                foreach($errors as $error)
                {
                    echo ''.$error.'';
                }
                echo '';
            }
        }
        else
        {
            echo '<div class="alert alert-danger">Invalid department or priority</div>';
        }
    }
}
if ($_GET['type'] == 'update')
{
    session_start();
    $SQLGetTickets = $odb -> prepare("SELECT * FROM `tickets` WHERE `username` = :username ORDER BY `id` DESC");
    $SQLGetTickets -> execute(array(':username' => $_SESSION['username']));
    while ($getInfo = $SQLGetTickets -> fetch(PDO::FETCH_ASSOC))
    {
        $id = $getInfo['id'];
        $user = $_SESSION['username'];
        $subject = $getInfo['subject'];
        $status = $getInfo['status'];
        $date = $getInfo['time'];
        if ($status == "Closed") 
        {
            $status1 = "danger";
        } 
        elseif ($status == "Waiting for admin response") 
        {
            $status1 = "info";
        } 
        elseif ($status == "Waiting for user response") 
        {
            $status1 = "warning";
        }
        echo '<tr style="color: #ff2828; background-color: black;">
                <td style="color: #ff2828;" class="td-label td-label-info text-center" style="width: 5%;">
                    <label class="csscheckbox csscheckbox-primary"><input type="checkbox"><span></span></label>
                </td>
                <td>
                    <h4 style="color: white;">
                        <a style="color: white;" href="index.php?page=Ticket&id='.$id.'" class="text-light"><strong style="color:white">'.htmlspecialchars($subject).'</strong></a>
                    </h4>
                    <span style="color: #ffffff;" class="text-muted">'.$status.'</span>
                </td>
                <td class="hidden-xs text-center" style="width: 30px;">
                    <i style="color: #ffffff;" class="fa fa-ticket fa-2x text-muted"></i>
                </td>
                <td class="hidden-xs text-right text-muted" style="width: 120px;"><em style="color: #fffff;">'.date('jS F Y h:i:s A (T)', $date).'</em></td>
              </tr>';
    }
}
?>