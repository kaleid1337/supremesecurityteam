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

include("header.php");
?>


	<div class="content content-boxed">

		<div class="block animated zoomInLeft">

			<div class="block-content block-content-full block-content-narrow">

				<h2 style="color:white" class="h3 font-w600 push-30-t push">Still need an answer? <a href="support.php">Click here</a></h2>

				<?php

				

				$i = 1;

				$SQLGetFAQ = $odb -> query("SELECT * FROM `faq` ORDER BY `id` DESC");

				while ($getInfo = $SQLGetFAQ -> fetch(PDO::FETCH_ASSOC)){

					$question = $getInfo['question'];

					$answer = $getInfo['answer'];

	

				?>

					<div id="faq<?php echo $i; ?>" class="panel-group">

						<div class="panel panel-default">

							<div class="panel-heading">

								<h3 class="panel-title">

									<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#faq<?php echo $i; ?>" href="#faq<?php echo $i; ?>_q<?php echo $i; ?>" aria-expanded="false"><?php echo $question; ?></a>

								</h3>

							</div>

							<div id="faq<?php echo $i; ?>_q<?php echo $i; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">

								<div style="color:black" class="panel-body">

									<?php echo $answer; ?>

								</div>

							</div>

						</div>                               

					   

				<?php

				

				$i++;

				}		

				

				?>

			</div>

		</div>

	</div>

</main>	
