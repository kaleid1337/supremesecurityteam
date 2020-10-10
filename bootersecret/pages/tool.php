<?
  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `geolocation` = ?");
$admin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `rank` = ? AND `id` = ?");
$admin->execute(array("2", $_SESSION['ID']));
$checkadmin = $admin->fetchcolumn(0);

              $SQLCheckPage -> execute(array("1"));
              $CheckPage = $SQLCheckPage -> fetchColumn(0);
              if ($CheckPage > 0 && $checkadmin < 1)
              {
                
               header('location: index.php?page=Construction');

  die();
              }
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
if (!($user->isVerified($odb)))
{
  header('location: index.php?page=Verify');
  die();
}
$CheckUserSQL = $odb -> prepare("SELECT * FROM `users` WHERE `id` = :id");
        $CheckUserSQL -> execute(array(':id' => $_SESSION['ID']));
        $CheckUserIP = $CheckUserSQL -> fetch(PDO::FETCH_ASSOC);
         if($CheckUserIP['ip_address'] == "OFF"){
        }elseif($CheckUserIP['ip_address'] != $ip){
  header('location: index.php?page=Check');
  die();
        }
include("header.php");
?>
  <!-- Page content -->
                    <div id="page-content">
                        <!-- Pricing Tables Header -->
                        <div class="content-header" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1>GeoLocation</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Index</li>
                                            <li><a href="">GeoLocation</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
   <div class="row">
                           <div class="col-md-12">
                                <!-- Input States Block -->
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #ff2828 ;  -moz-box-shadow:0px 0px 30px 2px #ff2828 ;  box-shadow:0px 0px 30px 2px #ff2828 ;">
                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default toggle-bordered enable-tooltip" data-toggle="button" title="Toggles .form-bordered class"></a>
                                        </div>
                                        <h2>GeoLocation</h2>
                                    </div>




                                    <!-- END Input States Title -->
                                    <!-- Input States Content -->
                            
                                    <form action="" method="POST" class="form-horizontal form-bordered" onsubmit="">
                                            <?php
                      $theState = '';
                      $geoIP = '';
                      if(isset($_POST['resolveGeo'])){
                        $geoIP = $_POST['geoIP'];
                        if(empty($geoIP)){
                          echo $design->alert('danger', 'Error', 'Please enter a IP Address!');
                        } else {
                          $theState = '-active';
                          $ip = $geoIP;
                          $json = file_get_contents('http://ip-api.com/json/'.$ip);
                          $array = json_decode($json);
                          $status = strtoupper($array->status);
                          $country = $array->country;
                          $regionName = $array->regionName;
                          $region = $array->region;
                          $city = $array->city;
                          $lat = $array->lat;
                          $lon = $array->lon;
                          $tz = $array->timezone;
                        }
                      }
                    ?>
                                        <div class="form-group">
<center><fieldset>
<div class="form-group">
                  <label class="col-sm-3 control-label">IP Address: </label>
                  <div class="col-sm-6">
                    <input type="<?php echo $geoIP; ?>" name="geoIP" class="form-control" placeholder="IP Address">
                  </div>
                </div>  
              




              <div class="form-group form-actions">
                                                    <form action="" method="POST">
                                                <button type="submit" name="resolveGeo" class="btn btn-effect-ripple btn-primary">Resolve</button>
                                                <button type="reset" class="btn btn-effect-ripple btn-danger">Reset</button>

                                            </div>
     <br>
                    <hr>
                    <?php if($theState == '-active'){ ?>
                    <div class="panel-group" id="cfResolver">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#cfResolver" href="#cfResolve">
                              Geolocation Results
                            </a>
                          </h4>
                        </div>
                        <div id="cfResolve" class="panel-collapse collapse<?php echo $theState; ?>">
                          <div class="panel-body">
                            <div class="table-responsive">
                              <table class="table table-striped table-bordered table-hover table-green" id="example">
                                <tbody>
                                  <tr>
                                    <td>IP Address:</td>
                                    <td><?php echo $ip; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Status:</td>
                                    <td><?php echo $status; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Country:</td>
                                    <td><?php echo $country; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Region:</td>
                                    <td><?php echo $regionName; ?></td>
                                  </tr>
                                  <tr>
                                    <td>City:</td>
                                    <td><?php echo $city; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Latitude:</td>
                                    <td><?php echo $lat; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Longitude:</td>
                                    <td><?php echo $lon; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Timezone:</td>
                                    <td><?php echo $tz; ?></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                    
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
                                <!-- END Input States Block -->
   </div>
   </div>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5a47f539d7591465c7067417/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

