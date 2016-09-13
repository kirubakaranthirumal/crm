<div class="row">
<div class="card-container col-lg-3 col-sm-6 col-sm-12">
<div class="card">
	<div class="front bg-green1">
	
	<?php
	$server_name=$image_path="";
	if(!empty($_SERVER['SERVER_NAME'])){
		//$image_path=public_path();
		$server_name=$_SERVER['SERVER_NAME'];
		
		if(!empty($server_name)){								
			if($server_name == "localhost"){
				$image_path="/1.5/public/admin-lte/assets/images/";
			}
			else{
				$image_path="/CricketGateway_Crm_Php_Std/branches/public/admin-lte/assets/images/";
			}								
		}
	}

	//echo $public_path;
	//Closed-tickets.png

	//print"<pre>";
	//print_r($_SERVER);
	//exit;

	//echo $image_path;
//exit;
?>

		<!-- row -->
		<div class="row">
			<!-- col -->
			<div class="col-xs-4">
				<img src="<?=(!empty($image_path)?$image_path:"")?>Assigned-tickets.png" class="w-60" />
			</div>
			<div class="col-xs-8">
				
				<p class="text-elg1 text-strong mb-0">

							<?php
								if(!empty($ticketcountdata->assignedStatus)){
									echo $ticketcountdata->assignedStatus;
								}
								else{
									echo"0";
								}
							?>
							</p>
							
						</div>
						<!-- /col -->
						<div class="col-xs-12"><span>Assigned Tickets</span></div>
					</div>
					<!-- /row -->

				</div>
				<div class="back  bg-green1">

					<!-- row -->
					<div class="row">
						<!-- col -->
						<!--<div class="col-xs-4">
							<a href=#><i class="fa fa-cog fa-2x"></i> Settings</a>
						</div>-->
						<!-- /col -->
						<!-- col -->
						<div class="col-xs-6">
							<a href=#><i class="fa fa-chain-broken fa-2x"></i> Content</a>
						</div>
						<!-- /col -->
						<!-- col -->
						<div class="col-xs-6">
							<?php
							if(!empty($ticketcountdata->assignedStatus)){
								?>
									<a href="<?=(!empty($url)?$url:"")?>?tab_id=3" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
								<?php
									}
									else{
								?>
								<a href="#" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
							<?php
								}
							?>
						</div>
						<!-- /col -->
					</div>
					<!-- /row -->

				</div>
			</div>
		</div>
		<!-- /col -->


<div class="card-container col-lg-3 col-sm-6 col-sm-12">
<div class="card">
	<div class="front bg-orange">
		<!-- row -->
		<div class="row">

			<div class="col-xs-4">
				<img src="<?=(!empty($image_path)?$image_path:"")?>In-Progress-tickets.png" class="w-60" />
			</div>
			<div class="col-xs-8">
				<p class="text-elg1 text-strong mb-0">
							<?php
								if(!empty($ticketcountdata->inprogressStatus)){
									echo $ticketcountdata->inprogressStatus;
								}
								else{
									echo"0";
								}
							?>

							</p>
						</div>
						<div class="col-xs-12">
						<span>In-Progress Tickets</span>
						</div>
						<!-- /col -->
					</div>
					<!-- /row -->

				</div>
				<div class="back bg-orange">

					<!-- row -->
					<div class="row">
						<!-- col -->
						<!--<div class="col-xs-4">
							<a href=#><i class="fa fa-cog fa-2x"></i> Settings</a>
						</div>-->
						<!-- /col -->
						<!-- col -->
						<div class="col-xs-6">
							<a href=#><i class="fa fa-chain-broken fa-2x"></i> Content</a>
						</div>
						<!-- /col -->
						<!-- col -->
						<div class="col-xs-6">
							<?php
								if(!empty($ticketcountdata->inprogressStatus)){
							?>
									 <a href="<?=(!empty($url)?$url:"")?>?tab_id=4" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
							<?php
								}
								else{
							?>
									<a href="#" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
							<?php
								}
							?>
						</div>
						<!-- /col -->
					</div>
					<!-- /row -->

				</div>
			</div>
		</div>


			<div class="card-container col-lg-3 col-sm-6 col-sm-12">
			<div class="card">
				<div class="front bg-gray">

					<!-- row -->
					<div class="row">
						
						<div class="col-xs-4">
				<img src="<?=(!empty($image_path)?$image_path:"")?>Closed-tickets.png" class="w-60" />
			</div>
			<div class="col-xs-8">
							<p class="text-elg1 text-strong mb-0">
                 	 <?php
						if(!empty($ticketcountdata->closedStatus)){
							echo $ticketcountdata->closedStatus;
						}
						else{
							echo"0";
						}
					?>
					</p>
					</div>
					<div class="col-xs-12">
						<span>Closed Tickets</span>
					</div>
					<!-- /col -->
				</div>
				<!-- /row -->

			</div>
			<div class="back bg-gray">

				<!-- row -->
				<div class="row">
					<!-- col -->
					<!--<div class="col-xs-4">
						<a href=#><i class="fa fa-cog fa-2x"></i> Settings</a>
					</div>-->
					<!-- /col -->
					<!-- col -->
					<div class="col-xs-6">
						<a href=#><i class="fa fa-chain-broken fa-2x"></i> Content</a>
					</div>
					<!-- /col -->
					<!-- col -->
					<div class="col-xs-6">
						 <?php
								if(!empty($ticketcountdata->closedStatus)){
							?>
									 <a href="<?=(!empty($url)?$url:"")?>?tab_id=5" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></i></a>
							<?php
								}
								else{
							?>
									<a href="#" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
							<?php
								}
							?>
					</div>
					<!-- /col -->
				</div>
				<!-- /row -->

			</div>
		</div>
	</div>

</div><!-- /.row -->

