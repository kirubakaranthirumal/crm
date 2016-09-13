@extends('admin.layouts.master')
@section('content')
<section class="content">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script language="javascript">
	function load_employee(id){

		var url_str = "groupId="+id;

		$.ajax({
			type: "GET",
			url: "{{asset('admin/load_group_user')}}",
			data: url_str,
			success: function(data){
				$('#employee_div').html(data);
			}
		});
	}

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

	</script>
		<script language="javascript">
		function load_employee(id){

			var url_str = "groupId="+id;

			$.ajax({
				type: "GET",
				url: "{{asset('admin/load_group_user')}}",
				data: url_str,
				success: function(data){
					$('#employee_div').html(data);
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
	<div class="row">
		<!-- left column -->
		<div class="col-md-12">

			<div class="box">
					<div class="box box-primary">
					<div class="box-header with-border">
					<h3 class="box-title">Tickets</h3>
				</div><!-- /.box-header -->
					 @if (session('DeleteTicketSuccess'))
						 <div class="col-md-12">
                <div class="flash-message">
                   <div class="alert alert-success">
                        Ticket Deleted Successfully
						<script>
							window.setTimeout(function(){window.location.href = "{{asset('/admin/view_tickets/')}}";}, 2000);
						</script>
                  </div>
                </div>
				</div>
              @endif
                @if (session('DeleteTicketError'))
				<div class="col-md-12">
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Delete ticket
                    </div>
                  </div>
				  </div>
                @endif
				<div class="box-body"><!-- /.box -->
					<!-- /.box-header -->
					<div class="box box-primary">
						@if(isset($error->errorFilter))
							<label class="error">{{$error->errorFilter}}</label>
						@endif
						<div class="box-header with-border">
							<h3 class="box-title">Filter Ticket</h3>
						</div><!-- /.box-header -->
						<div id="login_msg"></div>
						<!-- form start -->

						<form action="" method="POST" id="ticket-form" novalidate="novalidate">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="box-body">

								<div class="col-md-6">
									<div class="form-group">
										<label>Groups</label>
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
										<label>Employee</label>
										<div id="employee_div">
											<select class="form-control" name="employee" id="employee">
												<option value="">Select Employee Name</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>Date</label>
										<input type="text" class="form-control pull-right" name="created_on" id="created_on">
									</div>
								</div>
								<div class="col-md-6">
									<!--<div class="form-group">
										<label>Status</label>
										<select class="form-control">
											<option>Filter By Status</option>
											<option>Open</option>
											<option>Pending</option>
											<option>Resolved</option>
											<option>InProgress</option>
											<option>Closed</option>
											<option>Waiting On Customer</option>
											<option>Waiting On 3rd Party</option>
										</select>
									</div>-->
									<div class="form-group">

										<label>Priority</label>
										<select class="form-control" name="priority" id="priority">
											<option value="">Select Priority</option>
											<?php
												if(!empty($priority)){
													foreach($priority as $priority_val){
														$sel_priority="";
														if((!empty($post['priority'])) && (!empty($priority_val['priorityId']))){
															if($post['priority'] == $priority_val['priorityId']){
																$sel_priority="selected";
															}
														}
											?>
														<option value="<?=(!empty($priority_val['priorityId'])?$priority_val['priorityId']:"")?>" <?=(!empty($sel_priority)?$sel_priority:"")?>><?=(!empty($priority_val['priorityName'])?$priority_val['priorityName']:"")?></option>

											<?php
													}
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Source</label>
										<select class="form-control" name="source" id="source">
											<option value="">Select Source</option>
											<?php
													if(!empty($source)){
														foreach($source as $source_val){
															$sel_source="";
															if((!empty($post['source'])) && (!empty($source_val['sourceId']))){
																if($post['source'] == $source_val['sourceId']){
																	$sel_source="selected";
																}
															}
												?>
															<option value="<?=(!empty($source_val['sourceId'])?$source_val['sourceId']:"")?>" <?=(!empty($sel_source)?$sel_source:"")?>><?=(!empty($source_val['sourceName'])?$source_val['sourceName']:"")?></option>

												<?php
														}
													}
												?>
										</select>
									</div>
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
								<input type="button" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-primary">
								<!--<button type="submit" class="btn btn-primary">Filter</button>-->
								<button type="reset" id="reset" class="btn btn-primary">Reset</button>
							</div>
						</form>
              		</div><!-- /.box -->
							<script language="javascript">
							document.getElementById('reset').onclick = function() {
							var priority = document.getElementById('priority');
							var group = document.getElementById('group');
							var employee = document.getElementById('employee');
							var source = document.getElementById('source');
							var status = document.getElementById('status');
							var category = document.getElementById('category');
							var start_date = document.getElementById('start_date');
							var end_date = document.getElementById('end_date');
							var application = document.getElementById('application');
							var event = document.getElementById('event');
							priority.selectedIndex = 0;
							group.selectedIndex = 0;
							employee.selectedIndex = 0;
							source.selectedIndex = 0;
							status.selectedIndex = 0;
							category.selectedIndex = 0;
							start_date.selectedIndex = 0;
							end_date.selectedIndex = 0;
							application.selectedIndex = 0;
							event.selectedIndex = 0;
							return false;
						}
					</script>
            		<div class="box-body">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs tabs-dark">
								<?php
									$total_active_tab="";
									$open_active_tab="";
									$assign_active_tab="";
									$progress_active_tab="";
									$closed_active_tab="";
									$waitcust_active_tab="";
									$wait3rdparty_active_tab="";

									if(!empty($tab)){
										if($tab=="1"){
											$total_active_tab="active";
										}
										elseif($tab=="2"){
											$open_active_tab="active";
										}
										elseif($tab=="3"){
											$assign_active_tab="active";
										}
										elseif($tab=="4"){
											$progress_active_tab="active";
										}
										elseif($tab=="5"){
											$closed_active_tab="active";
										}
										elseif($tab=="6"){
											$waitcust_active_tab="active";
										}
										elseif($tab=="7"){
											$wait3rdparty_active_tab="active";
										}
									}
									else{
										$total_active_tab="active";
									}
								?>
								@if(isset($ticketcountdata))
									@foreach($ticketcountdata as $countData)
										<li class="@if(isset($total_active_tab)){{$total_active_tab}}@endif">
											<a href="view_tickets?tab_id=1" aria-expanded="false">
												@if(isset($countData->allticketsCount))
													Total ({{$countData->allticketsCount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($open_active_tab)){{$open_active_tab}}@endif">
											<a href="view_tickets?tab_id=2" aria-expanded="false">
												@if(isset($countData->openStatuscount))
													Open ({{$countData->openStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($assign_active_tab)){{$assign_active_tab}}@endif">
											<a href="view_tickets?tab_id=3" aria-expanded="false">
												@if(isset($countData->assignedStatuscount))
													Assigned ({{$countData->assignedStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($progress_active_tab)){{$progress_active_tab}}@endif">
											<a href="view_tickets?tab_id=4" aria-expanded="false">
												@if(isset($countData->inprogressStatuscount))
													In Progress ({{$countData->inprogressStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($closed_active_tab)){{$closed_active_tab}}@endif">
											<a href="view_tickets?tab_id=5" aria-expanded="false">
												@if(isset($countData->closedStatuscount))
													Closed ({{$countData->closedStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($waitcust_active_tab)){{$waitcust_active_tab}}@endif">
											<a href="view_tickets?tab_id=6" aria-expanded="false">
												@if(isset($countData->wfCusRescount))
													Wait For Customer Reply ({{$countData->wfCusRescount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($wait3rdparty_active_tab)){{$wait3rdparty_active_tab}}@endif">
											<a href="view_tickets?tab_id=7" aria-expanded="false">
												@if(isset($countData->wfTPartyRescount))
													Wait For 3rd Party Reply ({{$countData->wfTPartyRescount}})
												@endif
											</a>
										</li>
									@endforeach
								@endif
								<!--<li class="active"><a data-toggle="tab" href="#activity" aria-expanded="true">Activity</a></li>
								<li class=""><a data-toggle="tab" href="#timeline" aria-expanded="false">Timeline</a></li>
								<li class=""><a data-toggle="tab" href="#settings" aria-expanded="false">Settings</a></li>-->
							</ul>
							<div class="tab-content">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Id</th>
											<th>Request From</th>
											<th>Subject</th>
											<th>Aging</th>
											<th>Priority</th>
											<th>Created On</th>
											<!--<th>Created By</th>-->
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($ticketdata))
											@foreach($ticketdata as $data)
												<tr>
													<td>
														@if(isset($data->ticketId))
															{{$data->ticketId}}
														@endif
													</td>
													<td>
														@if(isset($data->requestorName))
															{{$data->requestorName}}
														@endif
													</td>
													<td>
														@if(isset($data->ticketSubject))
															{{$data->ticketSubject}}
														@endif
													</td>
													<td>
														<?php
															 //$date1 = "2012-11-07 14:05:00";
															 //$date2 = "2012-11-07 14:35:00";

															 date_default_timezone_set("Asia/Kolkata");

															 if((!empty($data->createdOn)) && ($data->createdOn != "0000-00-00 00:00:00")){
															 	$date1 = substr($data->createdOn,0,19);
															 }

															 $date2 = date("Y-m-d H:i:s");

															 //echo $date1."<br>";
															 //echo $date2."<br>";

															 $timezonedate1 = "";
															 if(!empty($date1)){
															 	$timezonedate1 = strtotime($date1);
															 }

                                                             $timezonedate2 = "";
															 if(!empty($date2)){
															 	$timezonedate2 = strtotime($date2);
															 }

															 $diff = "";
															 if((!empty($timezonedate1)) && (!empty($timezonedate2))){
																 $diff = $timezonedate2 - $timezonedate1;
															 }

															 //echo $diff = strtotime($date2) - strtotime($date1);
															 if((!empty($timezonedate1)) && (!empty($timezonedate2))){
															 	$diff_in_hrs = $diff/3600;
															 }

															 //echo floor($diff_in_hrs);
														?>
														@if(isset($diff_in_hrs))
															@if(floor($diff_in_hrs) <= 24)
																@if(floor($diff_in_hrs) == 1)
																	<span style="color:green;">{{floor($diff_in_hrs)}} Hour</span>
																@else
																	<span style="color:green;">{{floor($diff_in_hrs)}} Hours</span>
																@endif
															@else
																<span style="color:red;">Critical</span>
															@endif
														@endif
													</td>
													<td>
														@if(isset($data->priority))
															@if($data->priority==1)
																Low
															@elseif($data->priority==2)
																Medium
															@elseif($data->priority==3)
																High
															@elseif($data->priority==4)
																Urgent
															@endif
														@endif
													</td>
													<td>
														@if(isset($data->createdOn))
															{{$data->createdOn}}
														@endif
													</td>
													<!--<td>
														@if(isset($data->createdBy))
															{{$data->createdBy}}
														@endif
													</td>-->
													<td>
														<!--<a href="{{asset('/admin/view_tickets/')}}/@if(isset($data->ticketId)){{ $data->ticketId}} @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;-->
														<a href="{{asset('/admin/edit_ticket/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="Edit Ticket">
															<i class="fa fa-edit"></i>
														</a>&nbsp;&nbsp;
														<a href="{{asset('/admin/ticket_details/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="View Ticket">
															<i class="fa fa-user-secret"></i>
														</a>
													</td>
												</tr>
											@endforeach
										@endif
									</tbody>
									<!--
									<tfoot>
										<tr>
											<th>Id</th>
											<th>Request From</th>
											<th>Subject</th>
											<th>Aging</th>
											<th>Priority</th>
											<th>Created On</th>
											<th>Created By</th>
											<th>Action</th>
										</tr>
									</tfoot>-->
								</table>


							</div>
						</div>
            		</div><!-- /.box-body -->
				</div>
			</div>
			</div>
		</div>
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

			$(function(){
				$('#example1').DataTable( {
					"aaSorting": [[ 5, "desc" ]],
					"aoColumnDefs" : [{
						'bSortable' : false,
						'aTargets' : [ 6 ]
					}]
				});
			});

			$(function () {
				$("#example1").DataTable();
				$('#example2').DataTable({
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering" : true,
					"info": true,
					"autoWidth": false,
				});
			});

			$(function(){
				$('#created_on').datepicker({
					format: 'yyyy-mm-dd'
				});
			});
		</script>

@endsection


