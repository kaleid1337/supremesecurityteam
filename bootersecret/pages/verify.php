<?php
if (!($user -> LoggedIn()))
{
    header('location: index.php?page=Login');
    die();
}

if (($user->isVerified($odb)))
{
  header('location: index.php?page=');
  die();
}
include("header.php");
?>

                    <!-- Page content -->
                    <div id="page-content">
                        <!-- Wizard Header -->
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1>Verification</h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Home</li>
                                            <li>Verification</li>
              
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
if (isset($_POST['updateBtn']))
     {
    $update = false;
    $errors = array();

$apikey = $_POST['key'];
$code = intval($_POST['secrectcode']);
$securityquestion = $_POST['question'];
$answerquestion = $_POST['answer'];

$apiuser = preg_replace('@[^0-9a-z\.\-\:\_\,]+@i', '', $apikey);
$apiuser = strtolower ( $apiuser );

$answernono = preg_replace('@[^0-9a-z\.\-\:\_\,]+@i', '', $answerquestion);
$answernono = strtolower ( $answernono );

    if(empty($code))
    {
        $iloveme = "ILOVECINEMA";
                echo '<div class="alert alert-danger">Secrect Code can only be numbers</div>';


    }

    if (empty($iloveme))
         if (empty($answerquestion) || empty($securityquestion) || empty($code) || empty($apikey))

      {
$iloveme = "ILOVECINEMA";
        echo '<div class="alert alert-danger">Please Fill In All Fields</div>';

      }
       if ($apikey)
    {
        $CheckKey = $odb -> prepare("SELECT * FROM `users` WHERE `apikey` = ?");
                $CheckKey -> execute(array($_POST['key']));
                $CheckUserKey = $CheckKey -> fetch(PDO::FETCH_ASSOC);
                if ($CheckUserKey){
                                                $iloveme = "ILOVECINEMA";
                        echo '<div class="alert alert-danger"><p><strong>Error: </strong>Invalid Api Key</p></div>';
                        
                    } 
                    else
                    {
                          $SQL = $odb -> prepare("UPDATE `users` SET `apikey` = :key WHERE `ID` = :id");
      $SQL -> execute(array(':key' => $apiuser, ':id' => $_SESSION['ID']));
      $update = true;
      $apikey = $_POST['key'];
   }
    }

     
if (empty($iloveme))
    if ($update == true)
    {
      echo '<div class="alert alert-success"><p><strong>SUCCESS: </strong>Updated</p></div> <meta http-equiv="refresh" content="0;URL="index.php?page=" " /> ';
      if ($code)    
     {
                                
        $CheckCode = $odb -> prepare("SELECT * FROM `users` WHERE `code_api` = :code");
                $CheckCode -> execute(array(':code' => $_POST['secrectcode']));
                $CheckUserCode = $CheckCode -> fetch(PDO::FETCH_ASSOC);
               
                if ($CheckUserCode){
                            $iloveme = "ILOVECINEMA";
                        echo '<div class="alert alert-danger"><p><strong>Error: </strong>Invalid Secret Code</p></div>';
                    
                    }
      $SQL = $odb -> prepare("UPDATE `users` SET `code_account` = :code WHERE `ID` = :id");
      $SQL -> execute(array(':code' => $_POST['secrectcode'], ':id' => $_SESSION['ID']));
      $update = true;
      $code = $_POST['secrectcode'];
    }

     if ($securityquestion)
         {
      $SQL = $odb -> prepare("UPDATE `users` SET `security_question` = :question WHERE `ID` = :id");
      $SQL -> execute(array(':question' => $_POST['question'], ':id' => $_SESSION['ID']));
      $update = true;
      $securityquestion = $_POST['question'];
    }
      if ($answerquestion)
          {
      $SQL = $odb -> prepare("UPDATE `users` SET `answer_question` = :answer WHERE `ID` = :id");
      $SQL -> execute(array(':answer' => MD5($answernono), ':id' => $_SESSION['ID']));
      $update = true;
      $answerquestion = $_POST['answer'];
    }  

    }
    else
    {
      echo '<div class="alert alert-warning"><p><strong>UPDATE: </strong>Nothing updated</p></div>';
    }
    if (!empty($errors))
    {
      echo '<div class="alert alert-success"><p><strong>ERROR:</strong><br />';
      foreach($errors as $error)
      {
        echo '-'.$error.'<br />';
      }
      echo '</div>';
    }
     }  
       
     ?>
                         <!-- Wizards Content -->
                        <!-- Form Wizards are initialized in js/pages/formsWizard.js -->
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- Clickable Wizard Block -->
                                <div class="block">
                                    <!-- Clickable Wizard Title -->
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                         
                                        </div>
                                        <h2>Verification </h2>
                                    </div>
                                    <!-- END Clickable Wizard Title -->
                                      <form id="clickable-wizard" action="" method="POST" class="form-horizontal form-bordered"> 
                                    
                                        <div id="clickable-first" class="step">
                                
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <ul class="nav nav-pills nav-justified clickable-steps">
                                                        <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-first"><i class="fa fa-user"></i> <strong>Account</strong></a></li>
                                                        <li><a href="javascript:void(0)" data-gotostep="clickable-second"><i class="fa fa-shield"></i> <strong>2-Step Verification</strong></a></li>
                                                        <li><a href="javascript:void(0)" data-gotostep="clickable-third"><i class="fa fa-check"></i> <strong>Confirmation</strong></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- END Step Info -->
                                           <div class="form-group">
                                                    <label class="col-md-3 control-label" for="fc_inputmask_1">Api Key</label>
                                                    <div class="col-md-9    ">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-key"></i>
                                                            </span>
                                                            <input type="text" name="key" placeholder="Example:Example93" class="form-control" maxlength="20">
                                                        </div>
                                                                                                <span class="help-block">Please enter an api key. This will be used for the Api Manger. This Can Be Anything You Want</span>

                                                    </div>
                                                    </div>

                                          <div class="form-group">
                                                    <label class="col-md-3 control-label" for="fc_inputmask_1">Secret Code</label>
                                                    <div class="col-md-9">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-lock"></i>
                                                            </span>
                                                            <input type="text" name="secrectcode" placeholder="5 Digit Code" class="form-control" maxlength="5">
                                                        </div>
                                                        <span class="help-block">Please Choose A 5 Digit Code for Security Reasons.</span>
                                                    </div>
                                                    </div> 
                                        </div>
                                        <!-- END First Step -->

                                        <!-- Second Step -->
                                        <div id="clickable-second" class="step">
                                            <!-- Step Info -->
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <ul class="nav nav-pills nav-justified clickable-steps">
                                                        <li><a href="javascript:void(0)" class="text-muted" data-gotostep="clickable-first"><i class="fa fa-user"></i> <del><strong>Account</strong></del></a></li>
                                                        <li class="active"><a href="javascript:void(0)" data-gotostep="clickable-second"><i class="fa fa-shield"></i> <strong>2-Step Verification</strong></a></li>
                                                        <li><a href="javascript:void(0)" data-gotostep="clickable-third"><i class="fa fa-check"></i> <strong>Confirmation</strong></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- END Step Info -->
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-chosen">Question</label>
                                            <div class="col-md-9">
                                                <select name="question" class="select-chosen" data-placeholder="Choose a security question" style="width: 250px;">
                                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                                    <option value="What is your favorite sport?">What is your favorite sport?</option>
                                                                <option value="In what city were you born?">In what city were you born?</option>
                                                                <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                                                                <option value="What is your favorite color?">What is your favorite color?</option>
                                                                <option value="In what county where you born?">In what county where you born?</option>
                                                </select>
                                            </div>
                                        </div>

                                             <div class="form-group">
                                                    <label class="col-md-3 control-label" for="fc_inputmask_1">Answer</label>
                                                    <div class="col-md-9    ">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-question"></i>
                                                            </span>
                                                            <input type="text" name="answer" placeholder="Your Answer here." class="form-control">
                                                        </div>
                                                    </div>
                                                    </div> 
                                        </div>
                                        <!-- END Second Step -->

                                        <!-- Third Step -->
                                        <div id="clickable-third" class="step">
                                            <!-- Step Info -->
                                            <div class="form-group">
                                                <div class="col-xs-12">
                                                    <ul class="nav nav-pills nav-justified clickable-steps">
                                                        <li><a href="javascript:void(0)" class="text-muted" data-gotostep="clickable-first"><i class="fa fa-user"></i> <strong style="color:white">Account</strong></a></li>
                                                        <li><a href="javascript:void(0)" class="text-muted" data-gotostep="clickable-second"><i class="fa fa-shield"></i> <del><strong>2-Step Verification</strong></del></a></li>
                                                        <li class="active"><a href="javascript:void(0)" id="finish" data-gotostep="clickable-third"><i class="fa fa-check"></i> <strong>Confirmation</strong></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- END Step Info -->
                                          
                                            <div class="form-group">
                <h3 class="modal-title text-center"><strong>Terms and Conditions</strong></h3>
<?php echo $settings['tos']; ?>

<h3>By Clicking ( <b>Next</b> ) You <b> Agree To The Terms Of Service </b> </h3>
                                            </div>
                                        </div>
                                        <!-- END Third Step -->

                                        <!-- Form Buttons -->
                                        <div class="form-group form-actions">
                                            <div class="col-md-8 col-md-offset-4">
                                                <button type="reset" style="color:white" class="btn btn-effect-ripple" id="back">Back</button>
                                                <button type="submit" name="updateBtn" class="btn btn-effect-ripple btn-primary" id="next">Next</button>


                                            </div>
                                        </div>
                                        <!-- END Form Buttons -->
                                    </form>
                                    <!-- END Clickable Wizard Content -->
                                </div>
                                <!-- END Clickable Wizard Block -->
                                 
