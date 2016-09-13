@extends('admin.layouts.master')
@section('content')
<script language="javascript">
	function load_ticket_count(url){

		var url_str = "url="+url;

		$.ajax({
			type: "GET",
			url: "{{asset('load_dashboard_ticket_count')}}",
			data: url_str,
			success: function(data){
				$('#ticket_dash_count_div').html(data);
			}
		});
	}
</script>
<div class="page page-dashboard">
	<div class="pageheader">
	<h1>
		Dashboard
		<small>Control panel</small>
	</h1>
	<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="#"><i class="fa fa-home"></i> CRM</a>
				</li>
				<li>
					<a href="#">Dashboard</a>
				</li>
			</ul>
			<div class="page-toolbar">
				<a role="button" tabindex="0" class="btn btn-lightred no-border pickDate">
					<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
				</a>
			</div>
	</div>

	</div>
	<!-- Main content -->
	<?php
		$dashTicketCount = array();
	?>
	<!--
	<div class="col-lg-3 col-xs-6">
	  <div class="small-box bg-aqua">
		<div class="inner">
		  <h3>
			@if(isset($dashTicketCount->openStatuscount))
				{{$dashTicketCount->openStatuscount}}
			@endif
		  </h3>
		  <p>Open Tickets</p>
		</div>
		<div class="icon">
		  <i class="ion ion-bag"></i>
		</div>
		<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	  </div>
	</div>-->
	<div class="col-xs-12">
		<script language="javascript">
			load_ticket_count('{{asset('my_tickets')}}');
			setInterval(function(){
				//code goes here that will be run every 5 seconds.
				load_ticket_count('{{asset('my_tickets')}}');
			}, 1000);
		</script>
            <div id="ticket_dash_count_div" style="width:100%;border:0px solid red;float:left;"></div>
             <!--
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>
                  	@if(isset($ticketcountdata->assignedStatus))
						{{$ticketcountdata->assignedStatus}}
					@else
						0
					@endif
                  <p>Assigned Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <?php
					if(!empty($ticketcountdata->assignedStatus)){
				?>
						 <a href="{{asset('my_tickets?tab_id=3')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>
						@if(isset($ticketcountdata->inprogressStatus))
							{{$ticketcountdata->inprogressStatus}}
						@else
							0
						@endif
					</h3>
					<p>In-Progress Tickets</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<?php
					if(!empty($ticketcountdata->inprogressStatus)){
				?>
						 <a href="{{asset('my_tickets?tab_id=4')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
			</div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>
                  	@if(isset($ticketcountdata->closedStatus))
						{{$ticketcountdata->closedStatus}}
					@else
						0
					@endif
                  </h3>
                  <p>Closed Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <?php
                	if(!empty($ticketcountdata->closedStatus)){
                ?>
						 <a href="{{asset('my_tickets?tab_id=5')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
              </div>-->
            </div>




	<!--
		<div class="box box-warning">
			<div class="box-header with-border">
				<h3 class="box-title">My Assigned Tickets</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">

				<div class="box-header">
					 <div style="float:right;">
						<a href="{{asset('my_tickets?tab_id=3')}}" class="btn btn-primary">
							More
						</a>
					</div>
					<div class="box-tools"></div>
				</div>

				<table class="table">
				  <tbody>
					<tr id="thead">
						<th>Ticket ID</th>
						<th>Subject</th>
						<th>Priority</th>
						<th>Status</th>
						<th>Date</th>
					</tr>
					<?php
						//print"<pre>";
						//print_r($ticketdata);
						//exit;
					?>
					<?php

						$count_val = "0";
						$total_count_val = count($ticketdata);
						if(!empty($ticketdata)){
							//rsort($ticketdata);
							foreach($ticketdata as $key => $ticketval){
								$count_val = $key+1;
								if($count_val<=5){
					?>
							<?php
								//print"<pre>";
								//print_r($count_val);
							?>
							<tr>
								<td>
									<a href="{{asset('/emp_ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
										<?=(!empty($ticketval->ticketId)?$ticketval->ticketId:"")?>
									</a>
								</td>
								<td>
									<a href="{{asset('/emp_ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
										<?=(!empty($ticketval->ticketSubject)?$ticketval->ticketSubject:"")?>
									</a>
								</td>
								<td>
									<?php
										if(!empty($ticketval->priority)){
											if($ticketval->priority==1){
												echo "Low";
											}
											elseif($ticketval->priority==2){
												echo "Medium";
											}
											elseif($ticketval->priority==3){
												echo "High";
											}
											elseif($ticketval->priority==4){
												echo "Urgent";
											}
										}
									?>
								</td>
								<td>
									<?php
										if(!empty($ticketval->status)){
											if($ticketval->status==1){
												echo "Open";
											}
											elseif($ticketval->status==2){
												echo "Assigned";
											}
											elseif($ticketval->status==3){
												echo "Inprogress";
											}
											elseif($ticketval->status==4){
												echo "Closed";
											}
											elseif($ticketval->status==5){
												echo "Waiting for customer reply";
											}
											elseif($ticketval->status==6){
												echo "Waiting for 3rd party reply";
											}
										}
									?>
								</td>
								<td>
									<?php
										if((!empty($ticketval->createdOn)) && ($ticketval->createdOn != "0000-00-00 00:00:00.000" )){
											echo date("Y-m-d h:i:s a",strtotime($ticketval->createdOn));
										}
									?>
								</td>
							</tr>

					<?php
								}
							}
						}
						else{
					?>
						<tr>
							<td colspan="4">
								No ticket data found
							</td>
						</tr>
					<?php
						}
					?>
				</tbody>
			</table>



			</div>
		</div>-->

<div class="row">
	<div class="col-md-12">
		<section class="tile">
			<div class="tile-header dvd dvd-btm">
				<h1 class="custom-font"><strong>My Assigned Tickets </strong></h1>
				<ul class="controls">
					<li><a href="{{asset('my_tickets?tab_id=3')}}" class="btn btn-primary" style="margin-right:0; color:white;">More</a></li>
					<li class="dropdown"><a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown"><i class="fa fa-cog"></i><i class="fa fa-spinner fa-spin"></i></a>
						<ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
							<li><a role="button" tabindex="0" class="tile-toggle"><span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span><span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span></a></li>
							<li><a role="button" tabindex="0" class="tile-refresh"><i class="fa fa-refresh"></i> Refresh</a></li>
							<li><a role="button" tabindex="0" class="tile-fullscreen"><i class="fa fa-expand"></i> Fullscreen</a></li>
						</ul>
					</li>
					<li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
				</ul>
			</div>

			<div class="tile-body table-custom">
				<div class="table-responsive">
					<table class="table table-custom table-striped dt-responsive">
						<thead>
							<tr id="thead">
								<th>Ticket ID</th>
								<th>Subject</th>
								<th>Priority</th>
								<th>Status</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody ng-controller="EmpTicketController">
							<tr ng-repeat="et in emptickets">
								<td><a href="{{asset('/emp_ticket_details/<%et.ticketId%>')}}" title="View Ticket"><%et.ticketId%></a></td>
								<td><a href="{{asset('/emp_ticket_details/<%et.ticketId%>')}}" title="View Ticket"><%et.ticketSubject%></a></td>
								<td>
									<div ng-if="et.priority == '1' ">Low</div>
									<div ng-if="et.priority == '2' ">Medium</div>
									<div ng-if="et.priority == '3' ">High</div>
									<div ng-if="et.priority == '4' ">Urgent</div>
								</td>
								<td>
									<div ng-if="et.status == '1' ">Open</div>
									<div ng-if="et.status == '2' ">Assigned</div>
									<div ng-if="et.status == '3' ">Inprogress</div>
									<div ng-if="et.status == '4' ">Closed</div>
									<div ng-if="et.status == '5' ">Waiting for customer reply</div>
									<div ng-if="et.status == '6' ">Waiting for 3rd party reply</div>
								</td>
								<td ng-bind="et.createdOn"></td>
							</tr>
						</tbody>
					</table>
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</section><!-- /.box -->
	</div><!-- /.box -->
</div><!-- /.box -->
			

<!-- <div class="row">


                        <div class="col-md-12">

                            <section class="tile">


                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>My Assigned Tickets </strong></h1>

                                    <ul class="controls">
										<li>
											<a href="{{asset('my_tickets?tab_id=3')}}" class="btn btn-primary" style="margin-right:0; color:white;">
												More
											</a>
										</li>


                                        <li class="dropdown">

                                            <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                                <i class="fa fa-cog"></i>
                                                <i class="fa fa-spinner fa-spin"></i>
                                            </a>

                                            <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                                <li>
                                                    <a role="button" tabindex="0" class="tile-toggle">
                                                        <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                                                        <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a role="button" tabindex="0" class="tile-refresh">
                                                        <i class="fa fa-refresh"></i> Refresh
                                                    </a>
                                                </li>
                                                <li>
                                                    <a role="button" tabindex="0" class="tile-fullscreen">
                                                        <i class="fa fa-expand"></i> Fullscreen
                                                    </a>
                                                </li>
                                            </ul>

                                        </li>
                                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                                    </ul>

                                </div>

		  								<div class="tile-body table-custom">
                                    <div class="table-responsive">
		  									<table class="table table-custom table-striped dt-responsive">
		  									  <thead>
		  									  	<tr id="thead">
		  											<th>Ticket ID</th>
		  											<th>Subject</th>
		  											<th>Priority</th>
		  											<th>Status</th>
		  											<th>Date</th>
		  									  	</tr>
												</thead>
												<tbody>
		  										<?php
		  											//print"<pre>";
		  											//print_r($ticketdata);
		  											//exit;
		  										?>
		  										<?php

		  											$count_val = "0";
		  											$total_count_val = count($ticketdata);
		  											if(!empty($ticketdata)){
		  												//rsort($ticketdata);
		  												foreach($ticketdata as $key => $ticketval){
		  													$count_val = $key+1;
		  													if($count_val<=5){
		  										?>
		  												<?php
		  													//print"<pre>";
		  													//print_r($count_val);
		  												?>
		  												<tr>
		  													<td>
		  														<a href="{{asset('/emp_ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
		  															<?=(!empty($ticketval->ticketId)?$ticketval->ticketId:"")?>
		  														</a>
		  													</td>
		  													<td>
		  														<a href="{{asset('/emp_ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
		  															<?=(!empty($ticketval->ticketSubject)?$ticketval->ticketSubject:"")?>
		  														</a>
		  													</td>
		  													<td>
		  														<?php
		  															if(!empty($ticketval->priority)){
		  																if($ticketval->priority==1){
		  																	echo "Low";
		  																}
		  																elseif($ticketval->priority==2){
		  																	echo "Medium";
		  																}
		  																elseif($ticketval->priority==3){
		  																	echo "High";
		  																}
		  																elseif($ticketval->priority==4){
		  																	echo "Urgent";
		  																}
		  															}
		  														?>
		  													</td>
		  													<td>
		  														<?php
		  															if(!empty($ticketval->status)){
		  																if($ticketval->status==1){
		  																	echo "Open";
		  																}
		  																elseif($ticketval->status==2){
		  																	echo "Assigned";
		  																}
		  																elseif($ticketval->status==3){
		  																	echo "Inprogress";
		  																}
		  																elseif($ticketval->status==4){
		  																	echo "Closed";
		  																}
		  																elseif($ticketval->status==5){
		  																	echo "Waiting for customer reply";
		  																}
		  																elseif($ticketval->status==6){
		  																	echo "Waiting for 3rd party reply";
		  																}
		  															}
		  														?>
		  													</td>
		  													<td>
		  														<?php
		  															if((!empty($ticketval->createdOn)) && ($ticketval->createdOn != "0000-00-00 00:00:00.000" )){
		  																echo date("Y-m-d h:i:s a",strtotime($ticketval->createdOn));
		  															}
		  														?>
		  													</td>
		  												</tr>

		  										<?php
		  													}
		  												}
		  											}
		  											else{
		  										?>
		  											<tr>
		  												<td colspan="5">
		  													No ticket data found
		  												</td>
		  											</tr>
		  										<?php
		  											}
		  										?>
		  									</tbody>
		  								   </table>
		  								</div>
		  							</div>
			</section>
			</div>
			</div>
			</div> -->
									<!--
		  							<div class="box box-default collapsed-box">
		  								<div class="box-header with-border">
		  									<h3 class="box-title">E-Mail</h3>
		  									<div class="box-tools pull-right">
		  										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		  									</div>
		  								</div>
		  								<div class="box-body">
		  										<div class="box-header">
		  											 <div style="float:right;">
		  												<a href="{{asset('/admin/emailnotification/')}}" class="btn btn-primary">
		  													More
		  												</a>
		  											</div>
		  											<div class="box-tools">
		  											</div>
		  										</div>


		  										 <table class="table">
		  										  <tbody><tr id="thead">
		  											<th>#</th>
		  											<th>Subject</th>
		  											<th>Message Body</th>
		  											 <th>Date</th>
		  										  </tr>
		  											<?php
		  												//print"<pre>";
		  												//print_r($maildata);

		  												$count_val = "0";
		  												$total_count_val = count($maildata);
		  												if(!empty($maildata)){
		  													foreach($maildata as $key => $ticketval){
		  														$count_val = $key+1;
		  														if($count_val<=5){
		  											?>
		  													<?php
		  														//print"<pre>";
		  														//print_r($count_val);
		  													?>
		  													<tr>
		  														<td>
		  															<?=(!empty($ticketval->emailNId)?$ticketval->emailNId:"")?>
		  														</td>
		  														<td>
		  															<?=(!empty($ticketval->subjectLine)?$ticketval->subjectLine:"")?>
		  														</td>
		  														<td>
		  															<?=(!empty($ticketval->fromAddress)?$ticketval->fromAddress:"")?>
		  														</td>
		  														<td>
		  															<?php
		  																if((!empty($ticketval->sendDate)) && ($ticketval->sendDate != "0000-00-00 00:00:00.000" )){
		  																	echo date("Y-m-d h:i:s a",strtotime($ticketval->sendDate));
		  																}
		  															?>
		  														</td>
		  													</tr>

		  											<?php
		  															}
		  														}
		  													}
		  													else{
		  											?>
		  												<tr>
		  													<td colspan="4">
		  														No email data found
		  													</td>
		  												</tr>
		  											<?php

		  												}
		  											?>
		  										</tbody>
		  									</table>




		  								</div>
		  							</div>-->




          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
			<section class="col-lg-7 connectedSortable">
				<!-- Custom tabs (Charts with tabs)-->
				<!--<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li class="pull-left header"><i class="fa fa-inbox"></i> Tickets</li>
					</ul>
					<div class="tab-content no-padding">
						<div class="chart tab-pane active" id="revenue-chart" style="position:relative;height:300px;"></div>
						<div class="chart tab-pane" id="sales-chart" style="position: relative;height:300px;"></div>
					</div>
				</div>-->
				<!-- /.nav-tabs-custom -->

              <!-- Chat box -->
              <!-- /.box (chat box) -->

              <!-- TO DO List -->
             <!-- /.box -->

              <!-- quick email widget -->
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

              <!-- Map box -->

              <!-- /.box -->

              <!-- solid sales graph -->
              <!-- /.box -->

              <!-- Calendar -->
             <!-- /.box -->

            </section><!-- right col -->
          </div><!-- /.row (main row) -->


<script language="javascript">

	$(function () {
		$("#example2").DataTable();
	});
    
 </script>
@endsection
