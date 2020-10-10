<?php
session_start();
if(isset($_GET["page"])) {
 $page = $_GET["page"];
}else{$page = "Home";}

if (isset($_GET['about']))
    {
    die();
    }

require_once 'includes/configuration.php';
require_once 'includes/init.php';


        


switch($page)
                {
                    case "Login":
                     include("pages/login.php");
                     break;
                     case "Register":
                     include("pages/register.php");
                     break;
		            case "SecuredPremiumPanel":
                     include("pages/panel.php");
                     break;
                     case "Skype":
                     include("pages/skype.php");
                     break;
                     case "Http":
                     include("pages/http.php");
                     break;
                     case "PSN-Resolver":
                     include("pages/psn.php");
                     break;
                     case "Phone-Lookup":
                     include("pages/phone.php");
                     break;
                     case "Cloudflare":
                     include("pages/cloudflare.php");
                     break;
                     case "IPLogger":
                     include("pages/iplogger.php");
                     break;
                     case "Phone-GeoLocation":
                     include("pages/phone.php");
                     break;
                     case "Friends-And-Enemies":
                     include("pages/fe.php");
                     break;
                     case "FAQ":
                     include("pages/faq.php");
                     break;
                     case "GeoLocation":
                     include("pages/geo.php");
                     break;
                     case "Support":
                     include("pages/support.php");
                     break;
                     
                     case "Ticket":
                     include("pages/ticket.php");
                     break;
                     case "Purchase":
                     include("pages/buy.php");
                     break;
                     case "Api":
                     include("pages/api.php");
                     break;
                     case "Api-Manager":
                     include("pages/api-manager.php");
                     break;
                     case "Attack-logs":
                     include("pages/attacklogs.php");
                     break;
                     case "Nomembership":
                     include("pages/nomembership.php");
                     break;

                     case "logout":
                     include("pages/logout.php");
                     break;
                     case "images":
                     include("pages/images.php");
                     break;
                    
                     case "free":
                     include("pages/free.php");
                     break;
                    
                     case "referral":
                     include("pages/referral.php");
                     break;
                      
                      case "TOS":
                     include("pages/tos.php");
                     break;
                     
                      case "plan":
                     include("pages/order.php");
                     break;
                    
                     case "btc":
                     include("pages/btc.php");
                     break;
                     
                     case "Bitcoin":
                     include("pages/bitcoinp.php");
                     break;
                    
                    case "Loginlogs":
                     include("pages/loginlogs.php");
                     break;
                    
                    case "Servers":
                     include("pages/servers.php");
                     break;
                    
                    case "Autoban":
                     include("pages/autoban.php");
                     break;
                    
                    case "UnderConstruction":
                     include("pages/under.php");
                     break;
                    case "Construction":
                     include("pages/under-construction.php");
                     break;
                    
                     case "Reset":
                     include("pages/reset.php");
                     break;
                    
                     case "Online":
                     include("pages/online.php");
                     break;
                    
                      case "Verify":
                     include("pages/verify.php");
                     break;
                    
                            case "Profile":
                     include("pages/profile.php");
                     break;
                    
                      
                    case "Forgot":
                     include("pages/forgot.php");
                     break;
                    default:
                        include("pages/default.php");
                        break;
                }
                
?>



   <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>

        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>



        <script src="js/pages/formsWizard.js"></script>
        <script>$(function(){ FormsWizard.init(); });</script>
     
    </body>
</html>