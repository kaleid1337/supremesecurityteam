<?php
  if ($settings['cloudflare_set'] == '1') {
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
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
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1>Purchase</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Index</li>
                                            <li><a href="">Purchase</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
        
           
                         
                        </div>
                      
                    </div>
                   
                </div>
                
			
				
                 <!-- END Pricing Tables Header -->
<!-- Normal Pricing Tables Block -->
                        <div class="block">
                            <!-- Normal Pricing Tables Title -->
                            <div class="block-title">
                                <h2>Purchase</h2>
                            </div>
                            <!-- END Normal Pricing Tables Title -->
                          <!-- Normal Pricing Tables Content -->
                            <div class="row">
            <body>
            

                 
                    <div id="sidebar-scroll">
                 
                        <div class="sidebar-content">
                    
                            <ul class="sidebar-nav">
                                <li>
                                    <a class="active"><i class="fa fa-exclamation-triangle sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Purchasing Package</span></a>
                                </li>
                                <li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
						<li>
                                    <a href="?purchase.php" ><i class="fa fa-shopping-cart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Purchase</span></a>
                                </li>
                                 <li>
                                    <a href="./index.php"><i class="gi gi-undo sidebar-nav-icon "></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                                </li>
								<li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
								<li>
                                    <a href="https://discordapp.com/invite/P7dn7pN" ><i class="fa fa-group"></i><span class="sidebar-nav-mini-hide">Support Center</span></a>
                                </li>
                            </ul>

                        </div>
                 
                    </div>
                 

               
                    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                        <div class="text-center">
                            <small>Criticalstresser</small><br>
                            <small><span id="year-copy"></span> &copy; <a href="https://supremesecurity.cz" target="_blank">Criticalstresser</a></small>
                        </div>
                    </div>
         
                </div>
				<div id="main-container">
				<header class="navbar navbar-inverse navbar-fixed-top">
                       
                        <ul class="nav navbar-nav-custom">
                          
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');">
                                    <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                    <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                </a>
                            </li>
                           

                      
                            <li class="hidden-xs animation-fadeInQuick">
                                <a href=""><strong>Bitcoin</strong></a>
                            </li>
                         
                        </ul>
               
                        <ul class="nav navbar-nav-custom pull-right">

                            <li class="dropdown">
                                
                               
                            </li>
                          
                        </ul>
						
						
						
                       
                    </header>
				
				<div id="page-content">
<div class="content-header">
<div class="row">
<div class="col-sm-6">
<div class="header-section">
<h1>Bitcoin Pay</h1>
</div>
</div>
<div class="col-sm-6 hidden-xs">
<div class="header-section">
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
<div class="block">
<div class="block-title">
<div class="block-options pull-right">
<a href="javascript:void(0)" class="btn btn-effect-ripple btn-default" onclick="App.pagePrint();"><i class="fa fa-print"></i> Print</a>
</div>
<h2>Purchase With Bitcon</h2>
</div>
<div class="table-responsive">
<table class="table table-striped table-hover table-bordered table-vcenter">
<thead>
<tr>
<th class="text-center"></th>
<th style="width: 50%;">Package</th>
<th class="text-center">Boot</th>
<th class="text-center">Length</th>
<th class="text-right">Amount</th>
</tr>
</thead>
<tbody>
<tr>
<td class="text-center"></td>
<td>
<h4><strong>Plan Of Your Choice</strong></h4>
</td>
<td class="text-center"><?php echo $row['mbt']; ?> seconds <br>and <br><?php echo $row['concurrents']; ?>concurrents</td>
<td class="text-center">Days</td>
<td class="text-right">Price</td>
</tr>
<tr>
<td colspan="4" class="text-right"><span class="h4"><strong>Total Due</strong></span></td>
<td class="text-right"><span class="h4"><strong>$<?php echo $row['price']; ?></strong></span></td>
</tr>
</tbody>
</table>
</div>
<div class="alert alert-success text-center">
<h3><strong>Send the money to  </strong> <i class=></i></h3>
<p>If you bought it contact us and put BTC Transaction HASH, Amount, Package Name and picture.</p>
</div>
</div>
</div>
</div>
</div>
</body>	
			
                

				
