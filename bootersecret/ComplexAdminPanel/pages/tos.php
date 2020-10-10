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
        $CheckUserIP = $CheckUserSQL -> fetch(PDO::FETCH_ASSOC);
         if($CheckUserIP['ip_address'] == "OFF"){
        }elseif($CheckUserIP['ip_address'] != $ip){
  header('location: ../index.php?page=Check');
  die();
        }

$link1 = "Viewing T.O.S Page";
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));
include("header.php");
?>


    <!-- Page content -->
                      <div id="page-content">
                          <!-- Pricing Tables Header -->
                          <div class="content-header">
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="header-section">
                                          <h1>Terms Of Service</h1>
                                      </div>
                                  </div>
                                  <div class="col-sm-6 hidden-xs">
                                      <div class="header-section">
                                          <ul class="breadcrumb breadcrumb-top">
                                              <li>Admin</li>
                                              <li><a href="">TOS</a></li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>

<?php
if(isset($_POST['tosbtn'])){
$tos = $_POST['textarea-tos'];


$update = $odb -> prepare("UPDATE `siteconfig` SET `tos` = ?");
$update -> execute(array($tos));

}

$sqlgetnews = $odb -> prepare("SELECT `tos` FROM `siteconfig`");
$sqlgetnews -> execute();
$getnews = $sqlgetnews -> fetchcolumn(0);
?>


                        <div class="row">

                          <!-- CKEditor Block -->
                        <div class="block">

                            <!-- CKEditor Title -->
                            <div class="block-title">
                                <div class="block-options pull-right">

                                </div>
                                <h2>T.O.S Manager</h2>
                            </div>
                            <!-- END CKEditor Title -->

                            <!-- CKEditor Content -->
                            <form action="" method="post" class="form-horizontal form-bordered" >
                                <!-- CKEditor, you just need to include the plugin (see at the bottom of this page) and add the class 'ckeditor' to your textarea -->
                                <!-- More info can be found at http://ckeditor.com -->
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <textarea id="textarea-ckeditor" name="textarea-tos" class="ckeditor"><?php echo $getnews; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group form-actions">
                                    <div class="col-xs-12">
                                        <button type="submit" name="tosbtn" class="btn btn-effect-ripple btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <!-- END CKEditor Content -->
                        </div>
                            <div class="col-xs-12">
                                <div class="block">
                                    <div class="block-title"><h4>Preview</h4></div>
<?php echo $getnews; ?>
                                </div>
                            </div>

                        <!-- END CKEditor Block -->
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

        <!-- ckeditor.js, load it only in the page you would like to use CKEditor (it's a heavy plugin to include it with the others!) -->
        <script src="../js/plugins/ckeditor/ckeditor.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="../js/pages/formsComponents.js"></script>
        <script>$(function(){ FormsComponents.init(); });</script>
    </body>
</html>
