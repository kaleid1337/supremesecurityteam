<?php
ob_start();
if (!($user -> LoggedIn()))
{
    header('location: index.php?page=Login');
    die();
}
if (!($user -> notBanned($odb)))
{
    header('location: index.php?page=logout');
    die();
}


include("header.php");
$id = $_GET['id'];
if(!is_numeric($id)) {
echo "ID Does Not Exist";
die;
}
if(!isset($_GET['id'])){
  header("Location: support.php");
  exit;
}
$ifread = $odb->prepare("SELECT COUNT(*) FROM tickets WHERE `read` = 0 AND `id` = ? LIMIT 1");
$ifread->execute(array($id));
if($ifread->fetchColumn() > 0){
  $read = $odb->prepare("UPDATE tickets SET `read` = 1 WHERE `id` = ?");
  $read->execute(array($id));
}

if(isset($_POST['close'])){
  $close = $odb->prepare("UPDATE tickets SET status = ? WHERE id = ?");
  $close->execute(array("Closed", $id));
}

?>

                    <div id="page-content" class="inner-sidebar-left">
                        <div style="border-color: black; background-color: black; -webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;" id="page-content-sidebar">
                            <a href="javascript:void(0)" class="btn btn-block btn-effect-ripple btn-default visible-xs" data-toggle="collapse" data-target="#email-nav">Navigation</a>
                            <div id="email-nav" class="collapse navbar-collapse remove-padding">
                                <div class="block-section">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li>
                                            <a style="color: #9D6595;" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-inbox icon-push"></i> <strong style="color:white">Inbox</strong><span class="label label-primary pull-right"><?php echo $stats -> totalusertickets($odb, $_SESSION['username']); ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a style="color: #9D6595;" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-star icon-push"></i> <strong style="color:white">Read Ticket</strong><span class="label label-primary pull-right"><?php echo $stats -> totalreadtickets($_SESSION['username']); ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a style="color: #9D6595;" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-exclamation-circle icon-push"></i> <strong style="color:white">Unread Ticket</strong><span class="label label-primary pull-right"><?php echo $stats -> totalunreadtickets($_SESSION['username']); ?></span>
                                            </a>
                                        </li>
                                        <li>
                                            <a style="color: #9D6595;" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-send icon-push"></i> <strong style="color:white">Closed Ticket</strong><span class="label label-primary pull-right"><?php echo $stats -> totalclosedtickets($_SESSION['username']); ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="block-section">
                                    <h4 class="inner-sidebar-header">
                                        <a href="javascript:void(0)" class="btn btn-effect-ripple btn-xs btn-default pull-right"></a>
                                        Labels
                                    </h4>
                                    <ul class="nav nav-pills nav-stacked nav-icons">
                                        <li>
                                            <a style="color: #9D6595;" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-circle icon-push text-danger"></i> <strong style="color:white">Admin</strong>
                                            </a>
                                        </li>
                                        <li>
                                            <a style="color: #9D6595;" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-circle icon-push text-default"></i> <strong style="color:white">Client</strong>
                                            </a>
                                        </li>
                                      
                                    </ul>
                                </div>
                                <div class="block-section">
                                    <h4 class="inner-sidebar-header">
                                        Support Online
                                    </h4>
                                    <ul class="nav">
<?php
$get = $odb->prepare("SELECT * FROM users WHERE rank = ?");
$get->execute(array("2"));
while($online = $get->fetch(PDO::FETCH_ASSOC)){
    $lastlogin = $online['lastact'];
    $dif = time() - $lastlogin;

     if ($online['rank'] > 1) {
          $rank = "Admin";
          } elseif ($online['rank'] == 2) {
          $rank = "Staff";
          } else {
          $rank = 'Member';
          }
    if($dif < 300)
    {
        echo ' <li>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$rank.'">
                                <i class="fa fa-fw fa-circle icon-push text-success"></i>
                               <span >'.$online['username'].'</span>
                            </a>
                        </li>';
    }
    else
    {
        echo ' <li>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="'.$rank.' - Offline">
                                <i class="fa fa-fw fa-circle icon-push text-danger"></i>
                               <span >'.$online['username'].'</span>
                            </a>
                        </li>';
    }
}
?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="message-view" class="block-content-full ">
                                <div class="block-title clearfix">
                                    <div class="block-options pull-right">
                                        <a style="color: black;" href="javascript:void(0)" class="btn btn-effect-ripple btn-warning" data-toggle="tooltip" title="Star"><i class="fa fa-star"></i></a>
                                        <a style="color: black;" href="javascript:void(0)" class="btn btn-effect-ripple btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-times"></i></a>
                                    </div>
                                    <div class="block-options pull-left">
                                        <a style="color: black;" href="index.php?page=Support" class="btn btn-effect-ripple btn-default" id="message-view-back"><i class="fa fa-chevron-left"></i> Back to Inbox</a>
                                    </div>
                                </div>
                                <?php
                                $SQLGetTickets = $odb->prepare("SELECT * FROM tickets WHERE id = ?");
     $SQLGetTickets->execute(array($id));
     while ($getInfo = $SQLGetTickets -> fetch(PDO::FETCH_ASSOC))
     {
    $username = $getInfo['username'];
    $subject = $getInfo['subject'];
    $status = $getInfo['status'];
    $department = $getInfo['department'];
     $priority = $getInfo['priority'];
     $original = $getInfo['content'];
    }
    $statust = $status;
    if($username != $_SESSION['username']){
   $cinema4dize = "CINEMA IS THE BEST";
    echo "<div class='alert alert-danger'>Invalid Ticket</div>";
    header('location: index.php?page=Support');
    die();
    }

if($status == "Closed"){
    echo "<div class='alert alert-danger'>Ticket Is Closed</div>";
}

                                    
                                if (isset($_POST['closeBtn']))
                                {
                                    $SQLupdate = $odb -> prepare("UPDATE `tickets` SET `status` = ? WHERE `id` = ?");
                                    $SQLupdate -> execute(array("Closed", $id));
                                
                                    $SQLupdate = $odb -> prepare("UPDATE `tickets` SET `lastreply` = ? WHERE `id` = ?");
                                    $SQLupdate -> execute(array("Closed", $id));
                                    echo '<div class="alert alert-success"><p><strong><font color="black">SUCCESS: </font></strong><font color="black">Ticket has been closed.  Redirecting....</font></p></div><meta http-equiv="refresh" content="3;url=index.php?page=Support">';
                                }
                                if (isset($_POST['updateBtn']))
                                {
                                    $updatecontent = $_POST['content'];
                                    if(empty($original) || empty($content) || empty($subject))
                                    {
                                        
                                        echo '<div class="alert alert-danger"><p>Please Fill In All Fields</p></div>';
                                    }
                                    if($status == "Waiting for admin response")
                                    {
                                        $cinema = "CINEMA IS THE BEST";
                                        echo '<div class="alert alert-danger"><p>Please wait for an admin to reply.</p></div>';    
                                    }
                                    if(empty($cinema))
                                    {
                                        $msgfloat = "panel panel-default";
                                        $min = $odb->prepare("INSERT INTO `messages` VALUES(NULL, ?, ?, ?, ?, UNIX_TIMESTAMP())");
                                        $min->execute(array($id, $updatecontent, $_SESSION['username'], $msgfloat));
                                        {
                                        $SQLUpdate = $odb -> prepare("UPDATE `tickets` SET `status` = :status, `time` = UNIX_TIMESTAMP() WHERE `id` = :id");
                                        $SQLUpdate -> execute(array(':status' => 'Waiting for admin response', ':id' => $id));
                                    
                                        $SQLUpdate = $odb -> prepare("UPDATE `tickets` SET `lastreply` = :lastreply WHERE `id` = :id");
                                        $SQLUpdate -> execute(array(':lastreply' => 'user', ':id' => $id));
                                        echo '<div class="alert alert-info"><p>Message has been sent.</p></div>';
                                        }
                                    }
                                }
                                ?>
                                <h3 style="color: #9D6595;"><strong style="color: #9D6595;"><?php echo htmlentities($subject); ?> </strong> <small style="color: #9D6595;"><em style="color: #9D6595;"><?php echo htmlspecialchars($status); ?></em></small></h3>
                                <p style="color: #9D6595;"><strong style="color: #9D6595;">Priority:</strong> <?php echo htmlentities($priority); ?>    <strong style="color: #9D6595;"> Department:</strong> <?php echo htmlentities($department); ?></p>
                                <hr class="text-danger ">
                                <div style="border-color: #9D6595; background-color: #9D6595;" class="panel panel-default">
                                    <div style="border-color: #9D6595; background-color: #9D6595;" class="panel-heading">
                                        <div style="border-color: #9D6595; background-color: #9D6595;" class="panel-title">
                                            <i style="color: black;" class="fa fa-comment"></i> <strong style="color: black;">Message </strong> </a>
                                        </div>
                                    </div>
                                    <div id="faq2_q'.$ID.'" class="panel-collapse active">
                                        <div style="color: black;" class="panel-body"><?php echo htmlentities($original); ?></div>
                                    </div>
                                </div>
                                <?php 
                                $SQLGetMessages = $odb -> prepare("SELECT * FROM `messages` WHERE `ticketid` = ? ORDER BY `messageid` ASC");
                                $SQLGetMessages -> execute(array($id));
                                while ($getInfo = $SQLGetMessages -> fetch(PDO::FETCH_ASSOC))
                                {
                                    $ID = $getInfo['messageid'];
                                    $sender = $getInfo['sender'];
                                    $content = $getInfo['content'];
                                    $msgTime = date('Y-m-d h:i:s', $getInfo['time']);
                                    $messagefloat = $getInfo['messagefloat'];
                                    if ($sender != "Admin") 
                                    { 
                                        $li = "in"; 
                                    } 
                                    else 
                                    { 
                                        $li = "out"; 
                                    }
                                        echo '<div style="border-color: #9D6595;" class="'.$messagefloat.'">
                                            <div style="border-color: #9D6595; background-color: #9D6595;" class="panel-heading">
                                                <div style="border-color: #9D6595; background-color: #9D6595;" class="panel-title">
                                                    <i style="color: black;" class="fa fa-share"></i> <a style="color: black;" class="accordion-toggle" data-toggle="collapse" data-parent="#faq'.$ID.'" href="#faq2_q'.$ID.'"><strong style="color: black;">'.$sender.'</strong></a>
                                                </div>
                                            </div>
                                            <div id="faq2_q'.$ID.'" class="panel-collapse active">
                                                <div style="border-color: #9D6595; color: #9D6595; background-color: black;" class="panel-body">'.htmlspecialchars($content).'</div>
                                            </div>
                                        </div>';
                                }
                                ?>
                                <form action="" method="post" onsubmit="">
                                <?php
                                $checkticketstatus = $odb -> prepare("SELECT * FROM tickets WHERE id = ?");
                                $checkticketstatus -> execute(array($id));
                                while ($ticket = $checkticketstatus -> fetch(PDO::FETCH_ASSOC))
                                {
                                    $username = $ticket['username'];
                                    if($username != $_SESSION['username'])
                                    {
                                        $cinemalove = "HEY BABEY I LOVE YOU";
                                    }
                                    if(empty($cinemalove))
                                    {
                                        if($ticket['status'] == "Closed")
                                        {
                                            echo "";
                                        }
                                        else
                                        {
                                            echo '<textarea id="content" name="content" rows="5" class="form-control push-bit" placeholder="Your message.." ></textarea> <button type="submit" name="updateBtn" class="btn btn-effect-ripple btn-primary" ><i class="fa fa-share"></i> Reply</button>
                                                    <button type="submit" name="closeBtn" class="btn btn-effect-ripple btn-danger" ><i class="fa fa-trash-o" ></i> Close</button>';
                                        }   
                                    }
                                }
                                ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        