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
			
			//var url_str = "groupId="+id;
			
			var assign_user_id = $("#ticket_assigned_userid").val();
			var url_str = "groupId="+id+"&assignUserId="+assign_user_id;

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
<div class="page page-tables-datatables">
	<div class="pageheader">
		<h2>Tickets</h2>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="#"><i class="fa fa-home"></i> CRM</a>
				</li>
				<li>
					<a href="#">Tickets Management</a>
				</li>
				<li>
					<a href="#">Tickets</a>
				</li>
			</ul>
		</div>
		<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
	</div>
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
				 <!-- tile -->
				<section class="tile">

					<!-- tile header -->
					<div class="tile-header dvd dvd-btm">
						<h1 class="custom-font"><strong>Filter </strong>Ticket</h1>
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
					<div class="tile-body">

						@if(isset($error->errorFilter))
							<label class="error">{{$error->errorFilter}}</label>
						@endif

						<div id="login_msg"></div>
						<!-- form start -->
						<form action="#" method="POST" id="ticket-form" novalidate="novalidate">
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
										<input type="text" class="form-control pull-right" name="created_on" id="created_on" value="<?=(!empty($post['created_on'])?$post['created_on']:"")?>">
									</div>
								</div>
								<div class="col-md-6">
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
							<div class="clearfix"></div>
							<div class="box-footer" style="padding: 15px;">
								<!--<button type="submit" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Filter <i class="fa fa-filter"></i></button>-->
								<input type="button" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">
								<!--<button type="submit" class="btn btn-primary">Filter</button>-->
								<input type="reset" id="reset" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">
								<!--<button type="reset" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" name="reset" value="Reset">Reset <i class="fa fa-refresh" aria-hidden="true"></i></button>-->
							</div>
						</form>
              		</div><!-- /.box -->
					</section>
					<script language="javascript">
						document.getElementById('reset').onclick = function(){
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
					<section class="tile">
            		<div class="box-body">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs tabs-dark">
								<?php
									$total_active_tab="";
									if(empty($tab)){
										$total_active_tab="active";
									}
									
									//print"<pre>";
									//print_r($ticketcountdata);
									//exit;
								?>
								@if(isset($ticketcountdata))
									@foreach($ticketcountdata as $countData)										
										<li class="@if(isset($total_active_tab)){{$total_active_tab}}@endif">
											<a href="view_tickets" aria-expanded="false">
												@if(isset($countData->allticketsCount))
													Total ({{$countData->allticketsCount}})
												@endif
											</a>
										</li>
										<?php
											//print"<pre>";
											//print_r($status);
											//exit;
										?>
										@if(isset($status))
											@foreach($status as $stat)											
												<li class="@if($tab == $stat['statusId']) active @endif">
													<a href="view_tickets?tab_id={{$stat['statusId']}}" aria-expanded="false">
														<?php
															//print"<pre>";
															//print_r($stat);
															//exit;
														?>														
														@if(isset($stat['statusName']))
															{{$stat['statusName']}} 
														@endif															
														@if(isset($stat['count']))
															({{$stat['count']}})
														@else
															({{0}})
														@endif
													</a>
												</li>
											@endforeach
										@endif	
										
									@endforeach
								@endif
								<!--<li class="active"><a data-toggle="tab" href="#activity" aria-expanded="true">Activity</a></li>
								<li class=""><a data-toggle="tab" href="#timeline" aria-expanded="false">Timeline</a></li>
								<li class=""><a data-toggle="tab" href="#settings" aria-expanded="false">Settings</a></li>-->
							</ul>
							<div class="tile-body">
							<div class="tab-content table-responsive">
								<table id="example1" class="table table-custom table-striped">
									<thead>
										<tr>
											<th>Id</th>
											<th>Request From</th>
											<th>Subject</th>
											<th>Aging</th>
											<th>Priority</th>
											<th>Deadline</th>
											<th>Created On</th>
											<!--<th>Created By</th>-->
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											//print"<pre>";
											//print_r($ticketdata);

											//print"<pre>";
											//print_r($priorityDisp);
										?>
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
														<?php
															if(!empty($data->priority)){
																if(!empty($priorityDisp[$data->priority])){
																	if(!empty($priorityDisp[$data->priority]['priorityName'])){
																		echo $priorityDisp[$data->priority]['priorityName'];
																	}
																}
															}
														?>
													</td>
													<td>
														<?php
															 date_default_timezone_set("Asia/Kolkata");

															 $deadline="";
															 if((!empty($data->deadLine)) && ($data->deadLine != "0000-00-00 00:00:00")){
																$deadline = substr($data->deadLine,0,19);
															 }
														?>
														@if(isset($deadline))
															{{$deadline}}
														@endif
													</td>
													<td>
														<?php
															$created_on_date="";
															if((!empty($data->createdOn)) && ($data->createdOn != "0000-00-00 00:00:00")){
																$created_on_date = substr($data->createdOn,0,19);
															}
														?>
														@if(isset($created_on_date))
															{{$created_on_date}}
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
														<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/edit_ticket/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="Edit Ticket">
															<i class="fa fa-pencil"></i>
														</a>&nbsp;&nbsp;
														<a class="btn btn-rounded-20 btn-default btn-sm bg-primary" style="width:30px;" href="{{asset('/admin/ticket_details/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="View Ticket">
															<i class="fa fa-eye" style="margin-left: -2px;"></i>
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
				</section>
			</div>

		<script language="javascript">
			$("#searchsubmit").click(function(){
				/*if blank return false else true*/

				var group_val = $('#group').val();
				var employee_val = $('#employee').val();
				var priority_val = $('#priority').val();
				var source_val = $('#source').val();
				var created_on_val = $('#created_on').val();

				/*
				alert("group_val-"+group_val);
				alert("employee_val-"+employee_val);
				alert("priority_val-"+priority_val);
				alert("source_val-"+source_val);
				alert("created_on_val-"+created_on_val);
				*/

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
					"aaSorting": [[ 6, "desc" ]],
					"aoColumnDefs" : [{
						'bSortable' : false,
						'aTargets' : [ 7 ]
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


