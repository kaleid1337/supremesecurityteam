<?php

ob_start();
  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
if (!($user -> LoggedIn()))
{
    header('location: ../index.php?page=Login');
    die();
}
if (!($user->isAdmin($odb)))
{
  header('location: ../notadmin.php');
  die();
}
if (!($user -> notBanned($odb)))
{
    header('location: ../index.php?page=logout');
    die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
        


include("header.php");
$id = $_GET['id'];
if(!is_numeric($id)) {
echo "ID Does Not Exist";
exit;
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
$link1 = 'Viewing Ticket #'.$id.' ';
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));
?>

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

if ($status == "Closed") {
echo "<span class='label label-danger'>Ticket Is Closed</span>";
}
     if (isset($_POST['closeBtn']))
     {
      $SQLupdate = $odb -> prepare("UPDATE `tickets` SET `status` = :status WHERE `id` = :id");
      $SQLupdate -> execute(array(':status' => 'Closed', ':id' => $id));
      $SQLupdate = $odb -> prepare("UPDATE `tickets` SET `lastreply` = :lastreply WHERE `id` = :id");
      $SQLupdate -> execute(array(':lastreply' => 'Closed', ':id' => $id));

      $link4 = 'Closed Ticket #'.$id.' ';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link4, ));
echo '<div class="alert alert-success"><p><strong><font color="black">SUCCESS: </font></strong><font color="black">Ticket has been closed.  Redirecting....</font></p></div><meta http-equiv="refresh" content="3;url=index.php?page=Support">';
     }
     if (isset($_POST['updateBtn']))
                {
                  $updatecontent = $_POST['content'];

                  $errors = array();
                  if (empty($updatecontent))
                  {
                    $errors[] = 'Fill in all fields';
                  }
                  if (empty($errors))
                  {
                    $msgfloat = "panel panel-danger";
$min = $odb->prepare("INSERT INTO `messages` VALUES(NULL, ?, ?, ?, ?, UNIX_TIMESTAMP())");
$min->execute(array($id, $updatecontent,"Admin", $msgfloat));
      {
        $SQLUpdate = $odb -> prepare("UPDATE `tickets` SET `status` = :status, `time` = UNIX_TIMESTAMP() WHERE `id` = :id");
        $SQLUpdate -> execute(array(':status' => 'Waiting for user response', ':id' => $id));

        $SQLUpdate = $odb -> prepare("UPDATE `tickets` SET `lastreply` = :lastreply WHERE `id` = :id");
        $SQLUpdate -> execute(array(':lastreply' => 'admin', ':id' => $id));


$link2 = 'Replied To Ticket #'.$id.' ( '.$username.' ) ';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));
        echo '<div class="alert alert-success"><p><strong><font color="black">SUCCESS: </font></strong><font color="black"> Your reply to this ticket has been posted.</font></p></div>';
      }
      }
      else
      {
        echo '<div class="alert alert-error"><p><strong>ERROR:</strong><br />';
        foreach($errors as $error)
        {
          echo '-'.$error.'<br />';
        }
        echo '</div>';
      }
    }
?>


<?php
$getuserinfo = $odb -> prepare("SELECT * FROM `users` WHERE `username` = ?");
$getuserinfo -> execute(array($username));
$userInfo = $getuserinfo -> fetch(PDO::FETCH_ASSOC);


$getplan = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = ?");
$getplan -> execute(array($userInfo['membership']));
$getplaninfo = $getplan -> fetch(PDO::FETCH_ASSOC);

$userexpire = date("m-d-y, h:i:s a", $userInfo['expire']);

?>
                    <!-- Page content -->
                    <!--
                        Available classes when #page-content-sidebar is used:

                        'inner-sidebar-left'      for a left inner sidebar
                        'inner-sidebar-right'     for a right inner sidebar
                    -->
                    <div id="page-content" class="inner-sidebar-left">
                        <!-- Inner Sidebar -->
                        <div id="page-content-sidebar">
                   

                            <!-- Collapsible Navigation -->
                            <a href="javascript:void(0)" class="btn btn-block btn-effect-ripple btn-default visible-xs" data-toggle="collapse" data-target="#email-nav">Navigation</a>
                            <div id="email-nav" class="collapse navbar-collapse remove-padding">
                                <!-- Menu -->
                                <div class="block-section">
                                    <ul class="nav nav-pills nav-stacked">
                                      <h3>Client Account Info</h3>
                                        <div class="form-group">
                                            <div class="col-md-9">
                                                <input type="text" id="state-warning" name="state-warning" class="form-control" placeholder="Username" value="<?php echo $username;?>" readonly>
                                            </div>
                                            <a href='index.php?page=Manage&id=<?php echo $userInfo['ID']; ?>' target="_Blank_"> <button class="btn btn-primary bg-red" type="submit"> <i class="fa fa-user text-" ></i></button></a>
                                        </div>
                                            
                                            <li> 
                                            <a href="javascript:void(0)">
                                                Plan
                                                <input class="form-control" value="<?php
if($userInfo['membership'] == "0"){
  echo 'No Membership';
}else{
  echo $getplaninfo['name'];
}
?>" readonly>


                                            </a>
                                        </li>
                                          <li>
                                            <a href="javascript:void(0)">
                                                Expiry Date
                                                <input class="form-control" value="<?php echo $userexpire; ?>" readonly>
                                            </a>
                                        </li>
                                          <li>
                                            <a href="javascript:void(0)">
                                                IP Address
                                                <input class="form-control" value="<?php echo $userInfo['ip_address'] ?>" readonly>
                                            </a>
                                        </li>
                                          <li>
                                            <a href="javascript:void(0)">
                                                Code
                                                <input class="form-control" value="<?php echo $userInfo['code_account'] ?>" readonly>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>



                            <div id="message-view" class="block-content-full ">
                                <!-- Title -->
                                <div class="block-title clearfix">
                                    <div class="block-options pull-right">
                                        <a href="javascript:void(0)" class="btn btn-effect-ripple btn-warning" data-toggle="tooltip" title="Star"><i class="fa fa-star"></i></a>
                                        <a href="javascript:void(0)" class="btn btn-effect-ripple btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-times"></i></a>
                                    </div>
                                    <div class="block-options pull-left">
                                        <a href="index.php?page=Support" class="btn btn-effect-ripple btn-default" id="message-view-back"><i class="fa fa-chevron-left"></i> Back to Inbox</a>
                                    </div>
                                </div>
                                <!-- END Title -->



                                <!-- Header -->
                                <h3><strong><?php echo htmlentities($subject); ?> </strong> <small><em><?php echo htmlspecialchars($status); ?></em></small></h3>
                                <p><strong>Priority:</strong> <?php echo htmlentities($priority); ?>    <strong> Department:</strong> <?php echo htmlentities($department); ?></p>
                                <!-- END Header -->

                                <!-- Message Body -->
                                <hr>
                             
                                <p><?php echo htmlentities($original); ?></p>

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
               
        if ($sender != "Admin") { $li = "in"; } else { $li = "out"; }
                                
 


                 echo '<div class="'.$messagefloat.'">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <i class="fa fa-share"></i> <a class="accordion-toggle" data-toggle="collapse" data-parent="#faq'.$ID.'" href="#faq2_q'.$ID.'"><strong>'.$sender.'</strong></a>
                                        </div>
                                    </div>
                                    <div id="faq2_q'.$ID.'" class="panel-collapse active">
                                        <div class="panel-body">'.htmlspecialchars($content).'</div>
                                    </div>
                                </div>';

                                }
      ?>

                                <hr>
                                <!-- END Message Body -->

                    

                                <!-- Quick Reply Form -->
                                <form action="" method="post" onsubmit="">
                                    <textarea id="content" name="content" rows="5" class="form-control push-bit" placeholder="Your message.." ></textarea>
                                    <button type="submit" name="updateBtn" class="btn btn-effect-ripple btn-primary" ><i class="fa fa-share"></i> Reply</button>
                                    <button type="submit" name="closeBtn" class="btn btn-effect-ripple btn-danger" ><i class="fa fa-trash-o" ></i> Close</button>
                                </form>
                                <!-- END Quick Reply Form -->
                            </div>
                            <!-- END Message View -->
                        </div>
                        <!-- END Email Center Content -->
                    </div>
                    <!-- END Page Content -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->

          <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="../js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="../js/vendor/bootstrap.min.js"></script>
        <script src="../js/plugins.js"></script>
        <script src="../js/app.js"></script>
