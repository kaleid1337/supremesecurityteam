<?php
$SQLCheckPage = $odb -> prepare("SELECT COUNT(*) FROM `siteconfig` WHERE `support` = ?");
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

include("header.php");
?>
<script type='text/javascript' src='js/ajax/support.js'></script>

                    <div id="page-content" class="inner-sidebar-left">
                        <div class="content-header" style="background-color: black; border-color: black;">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1 style="color: white;">Support Center</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li style="color: white;">Index</li>
                                            <li style="color: #9D6595;"><a href="">Support Center</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="border-color: black; background-color: black; -webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;" id="page-content-sidebar">
                            <div style="background-color: black;" class="block-section">
                                <a href="#modal-compose" class="btn btn-effect-ripple btn-block btn-success" data-toggle="modal"><i class="fa fa-pencil"></i> Compose Message</a>
                            </div>
                            <div id="modal-compose" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div style="background-color: black;" class="modal-content">
                                        <div style="background-color: #9D6595;" class="modal-header">
                                            <button style="color: black;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h3 style="color: black;" class="modal-title"><strong>Compose Message <i class="fa fa-spinner fa-2x fa-spin text-danger" id="newticketloader" style="display:none"></i></strong></h3>
                                        </div>
                                        <div class="modal-body">
                                            <div id="newticketalert" style="display:none"></div>
                                                <div class="form-horizontal form-bordered">
                                                    <div style="border-color: black;" class="form-group">
                                                        <div class="col-xs-12">
                                                            <label class="sr-only" for="example-if-email"></label>
                                                            <input style="width:650px; height:30px" type="text" id="subject" class="form-control" placeholder="Subject">
                                                            <br>
                                                            <select id="department" style="width:650px; text-align:center; height:30px"  class="form-control" size="1">
                                                                <option value="1">Choose a Department</option>
                                                                <option value="Billing">Billing</option>
                                                                <option value="General">General</option>
                                                                <option value="Tech">Tech</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                            <br>
                                                            <select id="priority" style="width:650px; text-align:center; height:30px" class="form-control" size="1">
                                                                <option value="2" >Choose a Priority</option>
                                                                <option value="Low">Low</option>
                                                                <option value="Medium">Medium</option>
                                                                <option value="High">High</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div style="border-color: black;" class="form-group">
                                                        <div class="col-xs-12">
                                                            <textarea id="message" rows="7" class="form-control" placeholder="Write your message.."></textarea>
                                                        </div>
                                                    </div>
                                                    <div style="background-color: black; border-color: black;" class="form-group form-actions">
                                                        <div class="col-xs-12 text-right">
                                                            <button class="btn btn-effect-ripple btn-primary" onclick="submitTicket()">Send</button>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <a style="color: #9D6595;" href="javascript:void(0)" class="btn btn-effect-ripple btn-xs btn-default pull-right"></a>
                                    Labels
                                </h4>
                                <ul class="nav nav-pills nav-stacked nav-icons">
                                    <li>
                                        <a style="color: #9D6595;" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-circle icon-push text-info"></i> <strong style="color:white">User Replied</strong>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: #9D6595;" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-circle icon-push text-warning"></i> <strong style="color:white">Admin Replied</strong>
                                        </a>
                                    </li>
                                    <li>
                                        <a style="color: #9D6595;" href="javascript:void(0)">
                                            <i class="fa fa-fw fa-circle icon-push text-danger"></i> <strong style="color:white">Closed Ticket</strong>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;" class="block overflow-hidden">
                        <div id="message-list">
                            <div class="block-title clearfix">
                                <div class="block-options pull-right">
                                    <a style="color: black;" href="javascript:void(0)" class="btn btn-effect-ripple btn-default">Last updated <i class="fa fa-reply"></i></a>
                                </div>
                                <div class="block-options pull-left">
                                    <button style="color: black;" class="btn btn-effect-ripple btn-info" data-toggle="tooltip" title="Refresh The List" onclick="updateTickets()"><i class="fa fa-refresh"></i></button>
                                </div>
                            </div>
                            <div style="background-color: black;" class="block-content-full">
                                <table style="background-color: black;" class="table table-borderless table-vcenter remove-margin">
                                    <tbody id="ticketsdiv"> </tbody>
                                </table>
                            </div>
                        </div>
                           
       