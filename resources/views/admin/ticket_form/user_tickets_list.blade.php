@extends('admin.layouts.master')

@section('content')
<section class="content">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>My Tickets</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">My Tickets</a>
			</li>
		</ul>
	</div>
</div>

<div class="col-md-6">

                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Filter Ticket </strong>Form</h1>
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

						<form action="#" method="POST" id="ticket-form" novalidate="novalidate">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="box-body">
								<div class="col-md-12">
									<!--<div class="form-group">
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
										<label>Date</label>
										<!-- Date Picker -->
										<link href="{{ asset('/admin-lte/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
										<!-- Daterange picker -->
    									<link href="{{ asset('/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
										<input type="text"  class="form-control pull-right" name="created_on" id="created_on">
										<!-- bootstrap datepicker -->
										<!-- datepicker -->
    									<script src="{{ asset('/admin-lte/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
									</div>

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
							<div class="clearfix"></div>
							<div class="box-footer">
							<button type="submit" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Filter <i class="fa fa-filter"></i></button>
								<!--<input type="button" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-primary">-->
								<!--<button type="submit" class="btn btn-primary">Filter</button>-->
								<button type="reset" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Reset <i class="fa fa-refresh" aria-hidden="true"></i></button>
							</div>
						</form>
              		</div><!-- /.box -->
              		</section><!-- /.box -->
              		</div><!-- /.box -->
					<div class="clearfix"></div>

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
										<!--<li class="@if(isset($total_active_tab)){{$total_active_tab}}@endif">
											<a href="view_tickets_user?tab_id=1" aria-expanded="false">
												@if(isset($countData->allticketsCount))
													Total ({{$countData->allticketsCount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($open_active_tab)){{$open_active_tab}}@endif">
											<a href="view_tickets_user?tab_id=2" aria-expanded="false">
												@if(isset($countData->openStatuscount))
													Open ({{$countData->openStatuscount}})
												@endif
											</a>
										</li>
										-->
										<li class="@if(isset($assign_active_tab)){{$assign_active_tab}}@endif">
											<a href="my_tickets?tab_id=3" aria-expanded="false">
												@if(isset($countData->assignedStatus))
													Assigned ({{$countData->assignedStatus}})
												@endif
											</a>
										</li>
										<li class="@if(isset($progress_active_tab)){{$progress_active_tab}}@endif">
											<a href="my_tickets?tab_id=4" aria-expanded="false">
												@if(isset($countData->inprogressStatus))
													In Progress ({{$countData->inprogressStatus}})
												@endif
											</a>
										</li>
										<li class="@if(isset($closed_active_tab)){{$closed_active_tab}}@endif">
											<a href="my_tickets?tab_id=5" aria-expanded="false">
												@if(isset($countData->closedStatus))
													Closed ({{$countData->closedStatus}})
												@endif
											</a>
										</li>
										<li class="@if(isset($waitcust_active_tab)){{$waitcust_active_tab}}@endif">
											<a href="my_tickets?tab_id=6" aria-expanded="false">
												@if(isset($countData->wfcrStatus))
													Wait For Customer Reply ({{$countData->wfcrStatus}})
												@endif
											</a>
										</li>
										<li class="@if(isset($wait3rdparty_active_tab)){{$wait3rdparty_active_tab}}@endif">
											<a href="my_tickets?tab_id=7" aria-expanded="false">
												@if(isset($countData->wf3pStatus))
													Wait For 3rd Party Reply ({{$countData->wf3pStatus}})
												@endif
											</a>
										</li>
									@endforeach
								@endif
								<!--<li class="active"><a data-toggle="tab" href="#activity" aria-expanded="true">Activity</a></li>
								<li class=""><a data-toggle="tab" href="#timeline" aria-expanded="false">Timeline</a></li>
								<li class=""><a data-toggle="tab" href="#settings" aria-expanded="false">Settings</a></li>-->
							</ul>

							<section class="tile">

                                <!-- tile body -->
                                <div class="tile-body">

								<table id="example1" class="table table-custom table-striped dt-responsive">
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
														<?php

															// print"<pre>";
															//print_r(Session::all());
															// exit;

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
														<!--<a href="#" title="delete">
															<i class="fa fa-remove"></i>
														</a>&nbsp;&nbsp;-->
														@if(isset($userType) && $userType != 3)
															<a href="{{asset('/edit_ticket/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif?tab_id=<?=!empty($tab)?$tab:""?>" title="Edit Ticket">
																<i class="fa fa-edit"></i>
															</a>&nbsp;&nbsp;
														@else
															&nbsp;&nbsp;&nbsp;&nbsp;
														@endif
														<a href="{{asset('/emp_ticket_details/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="View Ticket">
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
						</section>
            		</div><!-- /.box-body -->
				</div>
			</div>
	<script language="javascript">
		$("#searchsubmit").click(function(){
			/*if blank return false else true*/

			var priority_val = $('#priority').val();
			var source_val = $('#source').val();
			var created_on_val = $('#created_on').val();

			//alert(source_val);
			//alert(priority_val);
			//alert(created_on_val);

			if((priority_val=='')&&(source_val=='')&&(created_on_val=='')){
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
    $('#created_on').datepicker({
    	  format: 'yyyy-mm-dd'
    });
  });
	</script>
@endsection


