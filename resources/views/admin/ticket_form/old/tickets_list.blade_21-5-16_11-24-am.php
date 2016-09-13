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
	<div class="row">
		<!-- left column -->
		<div class="col-md-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Tickets</h3>
				</div><!-- /.box-header -->
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
											<option value="1">Techical Support</option>
											<option value="2">Network Support</option>
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
											<option value="1">Low</option>
											<option value="2">Medium</option>
											<option value="3">High</option>
											<option value="4">Urgent</option>
										</select>
									</div>
									<div class="form-group">
										<label>Source</label>
										<select class="form-control" name="source" id="source">
											<option value="">Select Source</option>
											<option value="1">Portal</option>
											<option value="2">Email</option>
											<option value="3">Social Media</option>
											<option value="4">Live Chat</option>
										</select>
									</div>
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
								<input type="button" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-primary">
								<!--<button type="submit" class="btn btn-primary">Filter</button>-->
								<button type="reset" class="btn btn-primary">Reset</button>
							</div>
						</form>
              		</div><!-- /.box -->
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
											<th>Created By</th>
											<!--<th>Action</th>-->
										</tr>
									</thead>
									<tbody>
										@if(isset($ticketdata))
											@foreach($ticketdata as $data)
												<?php

													//$ticketListArray['agingHours'][] = strtotime($responseVal->createdOn);

												?>
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
													<td>
														@if(isset($data->createdBy))
															{{$data->createdBy}}
														@endif
													</td>
													<!--<td>
														<a href="#" title="delete">
															<i class="fa fa-remove"></i>
														</a>&nbsp;&nbsp;
														<a href="{{asset('/admin/edit_user/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="edit">
															<i class="fa fa-edit"></i>
														</a>&nbsp;&nbsp;
														<a href="{{asset('/admin/ticket_details/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="user details">
															<i class="fa fa-user-secret"></i>
														</a>
													</td>
													-->
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
	<script>

	$("#searchsubmit").click(function(){

		/*  if blank return false else true */

		var group_val = $('#group').val();
		var employee_val = $('#employee').val();
		var priority_val = $('#priority').val();
		var source_val = $('#source').val();
		var created_on_val = $('#created_on').val();

		//alert(group_val);
		//alert(employee_val);
		//alert(priority_val);
		//alert(source_val);
		//alert(group_val);

		if((group_val=='')&&(employee_val=='')&&(priority_val=='')&&(source_val=='')&&(created_on_val=='')){
			$("#login_msg").html('<span style="margin-left:23px;padding-top:5px;color:red;">Please select atleast one field to proceed with filter</span>');
		}
		else{
			$("#login_msg").html('');
			$("#ticket-form").submit();
		}


   });


	$('#submit').click(function(){
		//var group = $('#group').val();
		//var employee = $('#employee').val();

		//alert(group);

		//if(l_email=='' && l_password==''){
		//	$("#login_msg").html('<h4 id="error_msg">Please fill out the blank fields</h4>');
		//	return false;
		//}
	});


	  $(function () {
		$("#example1").DataTable();
		$('#example2').DataTable({
		  "paging": true,
		  "lengthChange": false,
		  "searching": false,
		  "ordering": true,
		  "info": true,
		  "autoWidth": false
		});
	  });


	    $(function () {
	      $('#created_on').datepicker({
	         format: 'yyyy-mm-dd'
	      });
  });
	</script>
@endsection


