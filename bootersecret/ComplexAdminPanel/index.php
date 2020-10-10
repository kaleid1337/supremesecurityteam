<?php

session_start();
if(isset($_GET["page"])) {
 $page = $_GET["page"];
}else{$page = "Home";}

if (isset($_GET['newupdate']))
    {
    die();
    }


require_once '../includes/configuration.php';
require_once '../includes/init.php';


switch($page)
                {
                    
                    
                     case "Members":
                     include("pages/members.php");
                     break;
                    case "Manage":
                     include("pages/manage.php");
                     break;
                    case "Servers":
                     include("pages/servermanager.php");
                     break;
                    case "Core":
                     include("pages/core.php");
                     break;
                    case "Payments":
                     include("pages/payments.php");
                     break;
                    case "Skype-BlackList":
                     include("pages/skypeblacklist.php");
                     break;
                    case "IP-BlackList":
                     include("pages/blacklist.php");
                     break;
                    case "Activity":
                     include("pages/activity.php");
                     break;
                     case "Attack-Logs":
                     include("pages/attacklogs.php");
                     break;
                  case "Login-Logs":
                     include("pages/loginlogs.php");
                     break;
                     case "Site-Stats":
                     include("pages/webstats.php");
                     break;
                    case "Plans":
                     include("pages/plans.php");
                     break;
                    case "Support":
                     include("pages/support.php");
                     break;
                    case "Ticket":
                     include("pages/ticket.php");
                     break;
                     case "IP-Banning":
                     include("pages/ipban.php");
                     break;
                        case "News":
                     include("pages/news.php");
                     break;
                    case "Ports":
                     include("pages/ports.php");
                     break;
                   case "FAQ":
                     include("pages/FAQ.php");
                     break;
                   case "Methods":
                     include("pages/method.php");
                     break;
                   case "Database":
                     include("pages/database.php");
                     break;

                   case "Logout":
                     include("../pages/logout.php");
                     break;
                   
                    case "Login":
                     include("../pages/login.php");
                     break;
                    case "TOS":
                     include("pages/tos.php");
                     break;
                    default:
                        include("pages/default.php");
                        break;
                }
                
?>


<!-- JS -->

<script src="../js/jquery.js"></script> <!-- jQuery -->
<script src="../js/funcs.js"></script> <!-- jQuery -->




  <!-- Include Jquery library from Google's CDN but if something goes wrong get Jquery from local file (Remove 'http:' if you have SSL) -->
         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>!window.jQuery && document.write(decodeURI('%3Cscript src="../js/vendor/jquery-2.1.1.min.js"%3E%3C/script%3E'));</script>


        <!-- Bootstrap.js, Jquery plugins and Custom JS code -->
        <script src="../js/vendor/bootstrap.min.js"></script>
        <script src="../js/plugins.js"></script>
        <script src="../js/app.js"></script>

         <script src="../js/pages/readyDashboard.js"></script>
        <script>$(function(){ ReadyDashboard.init(); });</script>


          <script src="../js/pages/uiTables.js"></script>
        <script>$(function(){ UiTables.init(); });</script>
        
        
    </body>
</html>
