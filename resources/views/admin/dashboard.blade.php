@extends('admin.layouts.master')
@section('content')
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script language="javascript">
	function load_employee(id){
		var url_str = "groupId="+id;

		$.ajax({
			type: "GET",
			url: "{{asset('admin/load_group_user_email')}}",
			data: url_str,
			success: function(data){
				$('#employee_div').html(data);
			}
		});
	}
	
	function load_assign_employee(id){
		var url_str = "groupId="+id;
		$.ajax({
			type: "GET",
			url: "{{asset('admin/load_group_user')}}",
			data: url_str,
			success: function(data){
				$('#assign_employee_div').html(data);
			}
		});
	}	
</script>
<script language="javascript">
	function load_event(id){
		var url_str = "appId="+id;
		$.ajax({
			type: "GET",
			url: "{{asset('admin/load_app_event')}}",
			data: url_str,
			success: function(data){
				$('#event_div').html(data);
			}
		});
	}
</script>
<script language="javascript">
	$("form").submit(function(){
		//alert("Submitted");
	});

	/*
	//Bind the event handler to the "submit" JavaScript event
	$("form").submit(function(event){
		// Get the Login Name value and trim it
		var name = $.trim($("#group").val());
		//Check if empty of not
		if(name  === ""){
			alert('Text-field is empty.');
			return false;
		}
	});
	*/

	/*
	$("form").submit(function(event){
		var group_val = $('#group').val();
		if(group_val==""){
			$("#msg").html('<h4 id="error_msg">Filled Required</h4>');
			return false;
		}
		else{
			$("#msg").html('<h4 id="error_msg">Success</h4>');
		}
	});
	*/


		(function($,W,D){
			var JQUERY4U = {};

			$.validator.addMethod(
				  "notEqualTo",
				  function(elementValue,element,param) {
					return elementValue != param;
				  },
				  "Value cannot be {0}"
			);
			JQUERY4U.UTIL =
			{
				setupFormValidation: function()
				{
					//form validation rules
					$("#compose-form").validate({
						rules: {
							group:{
								required: true
							},
							employee: {
								required: false
							},
							comSubject: {
								required: true
							}
						},
						messages: {
							/*
							requester_name: "Please enter your requester name",
							subject: "Please enter your subject",
							source: "Please provide source",
							category: "Please provide category",
							priority: "Please enter priority",
							group: "Please select group",
							type: "Please select type",
							status: "Please select status",
							employee: "Please select employee",
							editor: "Please enter description"
							*/
						},
						submitHandler: function(form){
							form.submit();
						}
					});
				}
			}
			//when the dom has loaded setup form validation rules
			$(D).ready(function($) {
				JQUERY4U.UTIL.setupFormValidation();
			});

		})(jQuery, window, document);



	</script>
	<style>
		#compose-form label.error{
			color: #FB3A3A;
			display: inline-block;
			//margin: 4px 0 5px 125px;
			padding: 0;
			text-align: left;
			width: 250px;
		}

		.form-control{
			background-color: #fff;
			background-image: none;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
			color: #555;
			display: block;
			font-size: 14px;
			height: 34px;
			line-height: 1.42857;
			padding: 6px 12px;
			transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
			width: 96%;
		}
	</style>
        <div class="page page-dashboard">
			<div class="pageheader">
				<h2>Dashboard <span></span></h2>
				<div class="page-bar">
					<ul class="page-breadcrumb">
						<li>
							<a href="#"><i class="fa fa-home"></i> CRM</a>
						</li>
						<li>
							<a href="#">Dashboard</a>
						</li>
					</ul>
					<!-- <div class="page-toolbar">
						<a role="button" tabindex="0" class="btn btn-lightred no-border pickDate">
							<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
						</a>
					</div> -->
				</div>
			</div>
			@if(session('mailSendSuccess'))
				<div class="flash-message">
					<div class="alert alert-success">
						Mail sent successfully
						<script language="javascript">
							window.setTimeout(function(){window.location.href = "{{asset('/admin/dashboard/')}}";},1000);
						</script>
					</div>
				</div>
			@endif
			@if(session('mailSendError'))
				<div class="flash-message">
					<div class="alert alert-danger">
						Unable to send mail
					</div>
				</div>
			@endif
			<!-- cards row -->
            <div class="row">
			<!-- Main content -->
			<?php
				$dashTicketCount=array();
				foreach($ticketcountdata as $ticketcountdataval){
					$dashTicketCount = $ticketcountdataval;
				}
			?>
			<!-- col -->
                        <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                            <div class="card">
                                <div class="front bg-red">
                                    <!-- row -->
                                    <div class="row">
										<div class="col-xs-4">
                                            <img src="{{ asset("/admin-lte/assets/images/Open-tickets.png") }}" class="w-60" />
                                        </div>
                                        <!-- col -->
                                        <div class="col-xs-8">
                                            <p class="text-elg1 text-strong mb-0">
												@if(isset($dashTicketCount->openStatuscount))
													{{$dashTicketCount->openStatuscount}}
												@else
													0
												@endif
											</p>
                                        </div>
										 <div class="col-xs-12"><span>Open Tickets</span></div>
                                        <!-- /col -->
                                    </div>
                                    <!-- /row -->
                                </div>
                                <div class="back bg-red">
                                    <!-- row -->
                                    <div class="row">
                                        <!-- col -->
                                        <div class="col-xs-6">
                                            <a href="{{asset('admin/add_tickets')}}"><i class="fa fa-ticket fa-2x"></i> Create Ticket</a>
                                        </div>
                                        <!-- /col -->
                                        <!-- col -->
                                        <div class="col-xs-6">
											<?php
												if(!empty($dashTicketCount->openStatuscount)){
											?>
													 <a href="{{asset('admin/view_tickets?tab_id=1')}}" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
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
						<!-- col -->
                        <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                            <div class="card">
                                <div class="front bg-green1">
                                    <!-- row -->
                                    <div class="row">
                                        <div class="col-xs-4">
                                          <img src="{{ asset("/admin-lte/assets/images/Assigned-tickets.png") }}" class="w-60" />
                                        </div>
                                        <!-- col -->
                                        <div class="col-xs-8">
                                            <p class="text-elg1 text-strong mb-0">
												@if(isset($dashTicketCount->assignedStatuscount))
													{{$dashTicketCount->assignedStatuscount}}
												@else
													0
												@endif
											</p>
                                        </div>
                                        <!-- /col -->
										<div class="col-xs-12"> <span>Assigned Tickets</span></div>
                                    </div>
                                    <!-- /row -->
                                </div>
                                <div class="back bg-green1">
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
												if(!empty($dashTicketCount->assignedStatuscount)){
											?>
													 <a href="{{asset('admin/view_tickets?tab_id=2')}}" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
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
                                            <img src="{{ asset("/admin-lte/assets/images/In-Progress-tickets.png") }}" class="w-60" />
                                        </div>
                                        <!-- col -->
                                        <div class="col-xs-8">
                                            <p class="text-elg1 text-strong mb-0">
												@if(isset($dashTicketCount->inprogressStatuscount))
													{{$dashTicketCount->inprogressStatuscount}}
												@else
													0
												@endif
											</p>
                                        </div>
                                        <!-- /col -->
										<div class="col-xs-12"> <span>In-Progress Tickets</span></div>
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
												if(!empty($dashTicketCount->inprogressStatuscount)){
											?>
													 <a href="{{asset('admin/view_tickets?tab_id=3')}}" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
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
                                           <img src="{{ asset("/admin-lte/assets/images/Closed-tickets.png") }}" class="w-60" />
                                        </div>
                                        <!-- col -->
                                        <div class="col-xs-8">
                                            <p class="text-elg1 text-strong mb-0">
												@if(isset($dashTicketCount->closedStatuscount))
													{{$dashTicketCount->closedStatuscount}}
												@else
													0
												@endif
											</p>
                                        </div>
                                        <!-- /col -->
										<div class="col-xs-12"><span>Closed Tickets</span></div>
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
												if(!empty($dashTicketCount->closedStatuscount)){
											?>
													 <a href="{{asset('admin/view_tickets?tab_id=4')}}" class="small-box-footer">More info <i class="fa fa-ellipsis-h fa-2x"></i></a>
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
				    <!-- Main row -->
				    <div class="row">
					<!-- col -->
                        <div class="col-md-12">
                            <!-- tile -->
                            <section class="tile">
                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Tickets </strong>From Portal</h1>
                                    <ul class="controls">
										<li>
											<a href="{{asset('/admin/view_tickets/')}}" class="btn-cyan" style="margin-right:0; color:white;" >More</a>
										</li>
                                        <!-- <li>
                                            <a role="button" tabindex="0" class="pickDate">
                                                <span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                                            </a>
                                        </li>-->
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
                                <!-- /tile header -->
								<div class="tile-body table-custom" style="padding-top:0px;">
                                    <div class="table-responsive">
                                      <table class="table table-striped">
									  <thead>
									  <tr id="thead">
										<th>Ticket ID</th>
										<th>Subject</th>
										<th>Priority</th>
										<th>Status</th>
										<th>Date</th>
										<th>Action</th>
									  </tr>
									  </thead>
									  <tbody>
										<?php
											//print"<pre>";
											//print_r($ticketdata);
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
														<a href="{{asset('/admin/ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
															<?=(!empty($ticketval->ticketId)?$ticketval->ticketId:"")?>
														</a>
													</td>
													<td>
														<a href="{{asset('/admin/ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
															<?=(!empty($ticketval->ticketSubject)?$ticketval->ticketSubject:"")?>
														</a>
													</td>
													<td>
														<?php
															if(!empty($ticketval->priority)){
																if(!empty($priorityDisp[$ticketval->priority])){
																	if(!empty($priorityDisp[$ticketval->priority]['priorityName'])){
																		if($ticketval->priority==1){
																			echo "<small class='text-success'>Low</span>";
																		}
																		elseif($ticketval->priority==2){
																			echo "<small class='text-warning'>".$priorityDisp[$ticketval->priority]['priorityName']."</span>";
																		}
																		elseif($ticketval->priority==3){
																			echo "<small class='text-danger'>".$priorityDisp[$ticketval->priority]['priorityName']."</span>";
																		}
																		elseif($ticketval->priority==4){
																			echo "<small class='text-danger'>".$priorityDisp[$ticketval->priority]['priorityName']."</span>";
																		}
																		elseif($ticketval->priority==5){
																			echo "<small class='text-danger'>".$priorityDisp[$ticketval->priority]['priorityName']."</span>";
																		}
																		else{
																			echo "<small class='text-success'>".$priorityDisp[$ticketval->priority]['priorityName']."</span>";
																		}
																	}
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
													<td>
														<a id="modal-assign-ticket" onClick="quick_assign({{$ticketval->ticketId}})" href="#modal-container-assign-ticket" data-toggle="modal" data-target="#modal-container-assign-ticket" data-options="splash-2 splash-ef-11">Quick Assign</a>
													</td>
												</tr>

										<?php
													}
												}
											}
											else{
										?>
											<tr>
												<td colspan="6">
													No ticket data found
												</td>
											</tr>
										<?php

											}
										?>
									</tbody>
								   </table>
								</div><!-- /.box-body -->
							</div><!-- /.box -->
						</section>
						<section class="tile">
                            <!-- tile header -->
                            <div class="tile-header dvd dvd-btm">
                                <h1 class="custom-font"><strong>Tickets </strong>From E-Mail</h1>
									<ul class="controls">
										<li>
											<a href="{{asset('/admin/emailnotification/')}}" class="btn-cyan" style="margin-right:0; color:white;" >More</a>
										</li>
                                        <!--<li>
                                            <a role="button" tabindex="0" class="pickDate">
                                                <span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                                            </a>
                                        </li> -->
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
								<div class="tile-body table-custom" style="padding-top:0px;">
                                    <div class="table-responsive">
                                      <table class="table table-striped">
										  <thead>
										  <tr id="thead">
											<th>#</th>
											<th>Subject</th>
											<th>Message Body</th>
											 <th>Date</th>
											 <th>Action</th>
										  </tr>
										  </thead>
											<tbody>
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
														<td>
															<a id="modal-create-mail-ticket" onClick="create_mail_ticket({{$ticketval->emailNId}})" href="#modal-container-create-mail-ticket" data-toggle="modal" data-target="#modal-container-create-mail-ticket" data-options="splash-2 splash-ef-11">Create & Assign Ticket</a>
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
														No email data found
													</td>
												</tr>
											<?php

												}
											?>
										</tbody>
									</table>




								</div><!-- /.box-body -->
							</div><!-- /.box -->
							</section>



							<!--<div class="box box-default collapsed-box">
								<div class="box-header with-border">
									<h3 class="box-title">Employee Login Status</h3>
									<div class="box-tools pull-right">
										<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
									</div>
								</div>
								<div class="box-body">

										<div class="box-header">
											 <div style="float:right;">
												<a href="{{asset('/admin/user_log_status/')}}" class="btn-cyan">
													More
												</a>
											</div>
											<div class="box-tools">
											</div>
										</div>


										<table class="table">
										  <tbody><tr id="thead">
											<th>#</th>
											<th>Name</th>
											<th>E-Mail</th>
											 <th>Type</th>
											 <th>Gender</th>
											 <th>Last logged</th>
										  </tr>
											<?php
												//print"<pre>";
												//print_r($maildata);

												$count_val = "0";
												$total_count_val = count($activeuser);
												if(!empty($activeuser)){
													foreach($activeuser as $key => $data){
														$count_val = $key+1;
														if($count_val<=5){
														 if($data->userType!=1){
											?>
													<?php
														//print"<pre>";
														//print_r($count_val);
													?>
													<tr>
														<td>
															<?php
																if(!empty($data->userId)){
																	echo $data->userId;
																}
															?>
														 </td>
														 <td>
														 	<?php
																if(!empty($data->userName)){
																	echo $data->userName;
																}
															?>
														  </td>
														  <td>
														  	<?php
																if(!empty($data->email)){
																	echo $data->email;
																}
															?>
														  </td>
														  <td>
														  	<?php
																if(!empty($data->userType)){
																	if($data->userType==1){
																	  echo "Admin";
																	}
																	elseif($data->userType==2){
																	  echo "Supervisor";
																	}
																	elseif($data->userType==3){
																	  echo "Employee";
																	}
																}
															?>
														  </td>
														  <td>
														  	<?php
																if(!empty($data->gender)){
																	if($data->gender==1){
																	  echo "Male";
																	}
																	elseif($data->gender==2){
																	  echo "Female";
																	}
																}
															?>
														  </td>
														  <td>
														  	<?php
																if(!empty($data->lastLoggedOn)){
																	$date = date_create($data->lastLoggedOn);
																	echo date_format($date,"Y-m-d h:i A");
																}
															?>
                  										</td>
													</tr>

											<?php
												}
											?>
											<?php
															}
														}
													}
													else{
											?>
												<tr>
													<td colspan="4">
														No logged in user data found
													</td>
												</tr>
											<?php

												}
											?>
										</tbody>
										</table>





								</div>
							</div>-->






            </div>
			<div class="col-md-12">
			<div class="col-md-8">
			 <section class="tile widget-message">

                                <!-- tile header -->
                                <div class="tile-header bg-blue dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Quick </strong>Message</h1>
                                    <ul class="controls">
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
                                <!-- /tile header -->

                                <!-- tile widget -->
                                <div class="tile-widget bg-blue">
                                    <form action="#" method="POST" name="compose-form" id="compose-form" novalidate="novalidate" enctype="multipart/form-data">
                                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <select class="form-control" name="group" id="group" onchange="load_employee(this.value)">
												<option value="">Select Group</option>
												<?php
													if(!empty($department)){
														foreach($department as $depart){
															$sel_dept="";
															if((!empty($post['group'])) && (!empty($depart['deptId']))){
																if($post['group'] == $depart['deptId']){
																	$sel_dept="selected";
																}
															}
												?>
															<option value="<?=(!empty($depart['deptId'])?$depart['deptId']:"")?>" <?=(!empty($sel_dept)?$sel_dept:"")?>><?=(!empty($depart['deptName'])?$depart['deptName']:"")?></option>

												<?php
														}
													}
												?>
											</select>
                                        </div>
                                        <div class="form-group">
                                        	<div id="employee_div">
												<select class="form-control" name="employee" id="employee">
													<option value="">Select Employee Name</option>
												</select>
											</div>
                                            <!--<input type="text" class="form-control underline-input" placeholder="Type subject...">-->
                                        </div>
                                        <div class="form-group">
											<!--<input type="text" class="form-control underline-input" placeholder="Type subject...">-->
											<input class="form-control underline-input" name="comSubject" id="comSubject" placeholder="Type subject...">
                                        </div>
                                </div>
                                <!-- /tile widget -->

                                <!-- tile body -->
                                <div class="tile-body p-0">
                                    <!--<div id="summernote">Hello Summernote</div>-->
									<div class="form-group" style="margin-bottom:0px;">
										<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
										<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
										<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12"></textarea>
										<script>
											initSample();
										</script>
									 </div>
                                </div>
                                <!-- /tile body -->

                                <!-- tile footer -->
                                <div class="tile-footer bg-blue text-center">
                                    <!--<button class="btn btn-blue btn-ef btn-ef-7 btn-ef-7h" activate-button="success"><i class="fa fa-envelope"></i> Send message</button>-->
                                    <button type="submit" name="submit" value="Submit" class="btn btn-blue btn-ef btn-ef-7 btn-ef-7h" activate-button="success"><i class="fa fa-envelope"></i>Send Message </button>

                                </div>
                                </form>
                                <!-- /tile footer -->

                            </section>
                            <!-- /tile -->
                        </div>
						 <!-- col -->
                        <div class="col-md-4">
							<section class="tile tile-simple bg-blue" style="min-height:190px;overflow:hidden;">
                                <!-- tile header -->
                                <div class="tile-header">
									<span class="pull-left">
										<i class="fa fa-twitter fa-1x icon-border wh30 text-center" style="line-height: 30px"></i>
									</span>&nbsp;
                                    <h1 class="custom-font"><strong>Twitter</strong> Feed</h1>
                                    <ul class="controls">
                                        <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                                    </ul>
                                </div>
                                <!-- /tile header -->
                                <!-- tile body -->
                                <div class="tile-body">
                                    <div id="feed-carousel" class="owl-carousel">
										<?php $count = 0; ?>
											@if(isset($tweetnotify) && count($tweetnotify) > 0)
												@foreach($tweetnotify as $key => $data)
													@if(isset($data) && count($data) > 0)
														@if($count < 3)
															<div class="media social-feed">
																<span class="pull-left">
																	<img class="img-circle size-50x50" src="{!!$data->user->profile_image_url_https!!}">
																</span>
																<div class="media-body">
																	<p class="media-heading"><strong>{!!$data->user->name!!}</strong> <small class="text-light text-transparent-white"><?php echo date('d M y  H:i', strtotime($data->created_at)); ?></small></p>
																	<p class="text-transparent-white">{!!substr(strstr($data->text," "), 1)!!}</p>
																</div>
															</div>
														@endif
													@endif
										<?php $count++; ?>
										@endforeach
										@endif
                                    </div>
									<div style="float: right;margin-top:6px"><a href="{{asset('admin/tweet')}}">See more...</a></div>
                                </div>
                                <!-- /tile body -->
                            </section>
							<section  class="tile tile-simple bg-lightred" style="min-height: 190px; overflow: hidden;">
								<div class="tile-header">
											<span class="pull-left">
                                                <i class="fa fa-facebook fa-1x icon-border wh30 text-center" style="line-height: 30px"></i>
                                            </span> &nbsp
									<h1 class="custom-font"><strong>Facebook</strong> Feed</h1>
									<ul class="controls">
										<li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
									</ul>
								</div>
                                <!-- tile body -->
                                <div class="tile-body">
                                    <div id="todo-carousel" class="owl-carousel">
										<?php $count = 0; //count?>
										@if(isset($fbpage) && count($fbpage) > 0)
										@foreach($fbpage as $key => $fbpost)
										@if(isset($fbpost) && count($fbpost) > 0)
										@if($count < 3)
												<div class="media social-feed">
													<span class="pull-left">
														<img class="img-circle size-50x50" src="https://graph.facebook.com/{!!$fbpost->from->id!!}/picture?access_token={!!$access_token!!}">
													</span>
													<div class="media-body">
														<p class="media-heading"><strong>{!!$fbpost->from->name!!}</strong> <small class="text-light text-transparent-white">{!!date("d M Y h:i A",strtotime($fbpost->created_time))!!}</small></p>
														<p class="text-transparent-white">{!!$fbpost->message!!}</p>
													</div>
												</div>
										@endif
										@endif
											<?php $count++; ?>
										@endforeach
										@endif
                                    </div>
									<div style="float: right;margin-top:6px"><a href="{{asset('admin/fbpage')}}">See more...</a></div>
                                </div>
                                <!-- /tile body -->
                            </section>
                        </div>

		</div>
		</div>


<!-- row -->
                    <div class="row">



                        <!-- col -->
                        <div class="col-md-8">

                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header bg-greensea dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Statistics </strong>Graph</h1>
                                    <ul class="controls">
                                        <li>
                                            <a role="button" tabindex="0" class="pickDate">
                                                <span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
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
                                <!-- /tile header -->

                                <!-- tile widget -->
                                <div class="tile-widget bg-greensea">
                                    <div id="statistics-chart" style="height: 250px;"></div>
                                </div>
                                <!-- /tile widget -->

                                <!-- tile body -->
                                <div class="tile-body">

                                    <!-- row -->
                                    <div class="row">


                                        <!-- col -->
                                        <div class="col-md-8 col-sm-12">

                                            <h4 class="underline custom-font mb-20"><strong>Actual</strong> Statistics</h4>

                                            <!-- row -->
                                            <div class="row">
                                                <!-- col -->
                                                <div class="col-lg-4 text-center">
                                                    <div class="easypiechart"
                                                         data-percent="100"
                                                         data-size="140"
                                                         data-bar-color="#418bca"
                                                         data-scale-color="false"
                                                         data-line-cap="round"
                                                         data-line-width="4"
                                                         style="width: 140px; height: 140px;">

                                                        <i class="fa fa-usd fa-4x text-blue" style="line-height: 140px;"></i>

                                                    </div>
                                                    <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-blue">6,175</strong> <small class="text-lg text-light text-default lt">Sales</small></p>
                                                    <p class="text-light"><i class="fa fa-caret-up text-success"></i> 18% this month</p>
                                                </div>
                                                <!-- /col
                                                <!-- col -->
                                                <div class="col-lg-4 text-center">
                                                    <div class="easypiechart"
                                                         data-percent="75"
                                                         data-size="140"
                                                         data-bar-color="#e05d6f"
                                                         data-scale-color="false"
                                                         data-line-cap="round"
                                                         data-line-width="4"
                                                         style="width: 140px; height: 140px;">

                                                        <i class="fa fa-eye fa-4x text-lightred" style="line-height: 140px;"></i>
                                                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-lightred">8,213</strong> <small class="text-lg text-light text-default lt">Visits</small></p>
                                                        <p class="text-light"><i class="fa fa-caret-down text-warning"></i> 25% this month</p>
                                                    </div>
                                                </div>
                                                <!-- /col -->
                                                <!-- col -->
                                                <div class="col-lg-4 text-center">
                                                    <div class="easypiechart"
                                                         data-percent="46"
                                                         data-size="140"
                                                         data-bar-color="#16a085"
                                                         data-scale-color="false"
                                                         data-line-cap="round"
                                                         data-line-width="4"
                                                         style="width: 140px; height: 140px;">

                                                        <i class="fa fa-user fa-4x text-greensea" style="line-height: 140px;"></i>
                                                        <p class="text-uppercase text-elg mt-20 mb-0"><strong class="text-greensea">632</strong> <small class="text-lg text-light text-default lt">Users</small></p>
                                                        <p class="text-light"><i class="fa fa-caret-down text-danger"></i> 61% this month</p>
                                                    </div>
                                                </div>
                                                <!-- /col -->
                                            </div>
                                            <!-- /row -->

                                        </div>
                                        <!-- /col -->



                                        <!-- col -->
                                        <div class="col-md-4 col-sm-12">

                                            <h4 class="underline custom-font"><strong>Visitors</strong> Statistics</h4>

                                            <div class="progress-list">
                                                <div class="details">
                                                    <div class="title">America</div>
                                                    <div class="description">visitor from america</div>
                                                </div>
                                                <div class="status pull-right">
                                                    <span>40</span>%
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="progress-xs not-rounded progress">
                                                  <div class="progress-bar progress-bar-dutch" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                    <span class="sr-only">40%</span>
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="progress-list">
                                                <div class="details">
                                                    <div class="title">Europe</div>
                                                    <div class="description">visitor from europe</div>
                                                </div>
                                                <div class="status pull-right">
                                                    <span>38</span>%
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="progress-xs not-rounded progress">
                                                  <div class="progress-bar progress-bar-greensea" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 38%">
                                                    <span class="sr-only">38%</span>
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="progress-list">
                                                <div class="details">
                                                    <div class="title">Asia</div>
                                                    <div class="description">visitor from asia</div>
                                                </div>
                                                <div class="status pull-right">
                                                    <span>12</span>%
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="progress-xs not-rounded progress">
                                                  <div class="progress-bar progress-bar-lightred" role="progressbar" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100" style="width: 12%">
                                                    <span class="sr-only">12%</span>
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="progress-list">
                                                <div class="details">
                                                    <div class="title">Africa</div>
                                                    <div class="description">visitor from africa</div>
                                                </div>
                                                <div class="status pull-right">
                                                    <span>7</span>%
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="progress-xs not-rounded progress">
                                                  <div class="progress-bar progress-bar-blue" role="progressbar" aria-valuenow="7" aria-valuemin="0" aria-valuemax="100" style="width: 7%">
                                                    <span class="sr-only">7%</span>
                                                  </div>
                                                </div>
                                            </div>

                                            <div class="progress-list">
                                                <div class="details">
                                                    <div class="title">Other</div>
                                                    <div class="description">visitor from other</div>
                                                </div>
                                                <div class="status pull-right">
                                                    <span>6</span>%
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="progress-xs not-rounded progress">
                                                  <div class="progress-bar progress-bar-hotpink" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100" style="width: 6%">
                                                    <span class="sr-only">6%</span>
                                                  </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /col -->




                                    </div>
                                    <!-- /row -->

                                </div>
                                <!-- /tile body -->

                            </section>
                            <!-- /tile -->

                        </div>
                        <!-- /col -->
						 <!-- col -->
                        <div class="col-md-4">
                            <!-- tile -->
                            <section class="tile bg-slategray widget-calendar">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Mini </strong>Calendar</h1>
                                    <ul class="controls">
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
                                <!-- /tile header -->

                                <!-- tile body -->
                                <div class="tile-body p-0">
                                    <div id="mini-calendar"></div>
                                </div>
                                <!-- /tile body -->

                            </section>
                            <!-- /tile -->



                        </div>
                        <!-- /col -->


                    </div>
                    <!-- /row -->





                    <!-- row -->
                    <div class="row">


                        <!-- col -->
                        <div class="col-md-8">

                            <!-- tile -->

                            <!-- /tile -->


                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Realtime </strong>Load</h1>
                                    <ul class="controls">
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
                                <!-- /tile header -->

                                <!-- tile widget -->
                                <div class="tile-widget mb-40">

                                    <div class="progress-list mt-20">
                                        <div class="details">
                                            <div class="title text-lg" style="line-height: 30px"><strong>125</strong> Users Online</div>
                                        </div>
                                        <div class="status pull-right bg-greensea">
                                            <span>41</span>%
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="progress not-rounded mb-10">
                                            <div class="progress-bar progress-bar-greensea" role="progressbar" aria-valuenow="41" aria-valuemin="0" aria-valuemax="100" style="width: 41%;"></div>
                                        </div>
                                    </div>

                                    <!-- row -->
                                    <div class="row">
                                        <!-- col -->
                                        <div class="col-md-4">
                                            <h4 class="text-light">HDD 1 <i class="fa fa-caret-up text-success"></i></h4>
                                            <div class="progress progress-xs not-rounded mb-0">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>
                                            </div>
                                            <small>Health: <span class="text-success">Good</span></small>
                                        </div>
                                        <!-- /col -->
                                        <!-- col -->
                                        <div class="col-md-4">
                                            <h4 class="text-light">HDD 2 <i class="fa fa-caret-up text-success"></i></h4>
                                            <div class="progress progress-xs not-rounded mb-0">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                                            </div>
                                            <small>Health: <span class="text-success">Good</span></small>
                                        </div>
                                        <!-- /col -->
                                        <!-- col -->
                                        <div class="col-md-4">
                                            <h4 class="text-light">HDD 3 <i class="fa fa-caret-down text-danger"></i></h4>
                                            <div class="progress progress-xs not-rounded mb-0">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 90%;"></div>
                                            </div>
                                            <small>Health: <span class="text-danger">Bad</span></small>
                                        </div>
                                        <!-- /col -->
                                    </div>
                                    <!-- /row -->

                                </div>
                                <!-- /tile widget -->

                                <!-- tile body -->
                                <div class="tile-body p-0" style="height: 133px">

                                    <div class="rickshaw" id="realtime-rickshaw"></div>

                                </div>
                                <!-- /tile body -->

                            </section>
                            <!-- /tile -->


                        </div>
                        <!-- /col -->




                    </div>
                    <!-- /row -->

                    <!-- row -->
                        <!-- col -->
                            <!-- tile -->
                            <!--@if(session('mailSendSuccess'))
								<div class="flash-message">
									<div class="alert alert-success">
										Mail sent successfully
										<script language="javascript">
											window.setTimeout(function(){window.location.href = "{{asset('/admin/dashboard/')}}";},1000);
										</script>
									</div>
								</div>
							@endif
							@if(session('mailSendError'))
								<div class="flash-message">
									<div class="alert alert-danger">
										Unable to send mail
									</div>
								</div>
							@endif
							-->

                </div>


</div>
<!-- Quick Assign Ticket -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
	
			<div class="modal splash fade" id="modal-container-assign-ticket" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">
								Quick Assign Ticket
							</h4>
						</div>
						<div class="modal-body ">
							<div id="quick_assign_div"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /Quick Assign Ticket -->

<!-- Create Mail Ticket -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
	
			<div class="modal splash fade" id="modal-container-create-mail-ticket" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">
								Quick Assign Ticket
							</h4>
						</div>
						<div class="modal-body">
							<div id="create_mail_ticket_div"></div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- /Create Mail Ticket -->

<script language="javascript">

	$("#searchsubmit").click(function(){
		/*if blank return false else true*/

		var group_val = $('#group').val();
		var employee_val = $('#employee').val();
		var priority_val = $('#priority').val();
		var source_val = $('#source').val();
		var created_on_val = $('#created_on').val();

		if((group_val=='')&&(employee_val=='')&&(priority_val=='')&&(source_val=='')&&(created_on_val=='')){
			$("#login_msg").html('<span style="margin-left:23px;padding-top:5px;color:red;">Please select atleast one field to proceed with filter</span>');
		}
		else{
			$("#login_msg").html('');
			$("#ticket-form").submit();
		}
	});

	function quick_assign(id){
		var url_str = "ticketId="+id;
		$.ajax({
			type: "GET",
			url: "{{asset('admin/quickassign')}}",
			data: url_str,
			success: function(data){
				$('#quick_assign_div').html(data);
			}
		});		
	}
	function create_mail_ticket(id){
		var url_str = "emailNId="+id;
		$.ajax({
			type: "GET",
			url: "{{asset('admin/createMailTicket')}}",
			data: url_str,
			success: function(data){
				$('#create_mail_ticket_div').html(data);
			}
		});
	}
	$(function () {
		$("#example1").DataTable();
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering" : true,
			"info": true,
			"autoWidth": false
		});
	});

	/* $(function(){
		$('#created_on').datepicker({
			format: 'yyyy-mm-dd'
		});
	}); */

</script>
</div><!-- /.row (main row) -->

@endsection
