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
        
         
$link1 = "Viewing Faq Page";
$SQLinsert = $odb -> prepare("INSERT INTO `adminlogs` VALUES(NULL, :username, :ip , :page , UNIX_TIMESTAMP())");
$SQLinsert -> execute(array(':username' => $_SESSION['username'], ':ip' => $ip, ':page' => $link1, ));
include("header.php");
?>

  <!-- Page content -->
                    <div id="page-content">
                        <!-- FAQ Header -->
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1>FAQ Manager</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Admin</li>
                                            <li><a href="">Faq</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-- Page content -->
            <?php
    if (isset($_POST['addfaq'])){

		

		if (empty($_POST['question']) || empty($_POST['answer'])){

			$notify = error('Please verify all fields');

		}


        else{

			$SQLinsert = $odb -> prepare("INSERT INTO `faq` VALUES(NULL, :question, :answer)");

			$SQLinsert -> execute(array(':question' => $_POST['question'], ':answer' => $_POST['answer']));

			$notify = success('FAQ has been added');

		}

	}


        
        ?>
        
        <?php
    if (isset($_POST['deletefaq']) && is_numeric($_POST['deletefaq'])){

		$delete = $_POST['deletefaq'];

		$SQL = $odb -> query("DELETE FROM `faq` WHERE `id` = '$delete'");

		$notify = success('FAQ has been removed');

	}
            ?>
                        <!-- First Row -->
                        <div class="row">
                   
         <div class="col-sm-6 col-lg-6">
                                <!-- Input States Block -->
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">

                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">

                                        </div>
                                        <h2 class="main-stats-text-dark">Faq Manager</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                        <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Question ?</label>
                                            <div class="col-md-8">
                                                <input type="text" style="width:22  10px; height:30px" name="title" class="form-control" placeholder="Question ?" >
                                            </div>
                                        </div>
                                            <div style="border-color: black;" class="form-group">
                                            <label class="col-md-3 control-label" for="state-normal">Answer</label>
                                            <div class="col-md-8">
                                                <textarea type="area" style="width:400px;  height:50px" name="content" class="form-control" placeholder="Answer" ></textarea>
                                            </div>
                                        </div>
                                         
                                        
                                <center><fieldset>
                                            <div style="background-color: black; border-color: black;" class="form-group form-actions">
                                                <form action="" method="POST">
                                               <button name="addBtn" class="btn btn-primary" type="submit">Submit</button>

                                            </div>

                                        <div style="background-color: black; border-color: black;" class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                    
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
                                 </div>
                                <!-- END Input States Block -->
         <div class="col-md-6">
                                <!-- Input States Block -->
                                <div class="block" style="-webkit-box-shadow:0px 0px 30px 2px #9D6595 ;  -moz-box-shadow:0px 0px 30px 2px #9D6595 ;  box-shadow:0px 0px 30px 2px #9D6595 ;">

                                    <!-- Input States Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">

                                        </div>
                                        <h2 class="main-stats-text-dark">News</h2>
                                    </div>
                                    <!-- END Input States Title -->

                                    <!-- Input States Content -->
                                    <form action="" method="post" class="form-horizontal form-bordered" onsubmit="">
                                   
                                           <table style="border-color: black; background-color: black; color: #9D6595;" class="table table-bordered" id="s-table-bordered">
          <thead>
            <tr></th>
                <th style="background-color: black; border-color: black; color: #9D6595;">Question</th>
                <th style="background-color: black; border-color: black; color: #9D6595;">Answer</th>
                <th style="background-color: black; border-color: black; color: #9D6595;">Delete</th>
                </tr>
          </thead>
          <tbody style="background-color: black; border-color: black; color: #9D6595;">
          <form method="post">
          <?php 

							$SQLGetfaq = $odb -> query("SELECT * FROM `faq` ORDER BY `id` DESC");

							while ($getInfo = $SQLGetfaq -> fetch(PDO::FETCH_ASSOC)){

								$id = $getInfo['id'];

								$question = $getInfo['question'];

								$answer = $getInfo['answer'];

								echo '<tr>

										<td>'.htmlspecialchars($question).'</td>

										<td>'.htmlspecialchars($answer).'</td>

										<td class="text-center"><button name="deletefaq" value="'.$id.'"class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></td>

									  </tr>';

							}

							?>
                                      
                                   
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END Input States Content -->
                                </div>
          
          
          

    