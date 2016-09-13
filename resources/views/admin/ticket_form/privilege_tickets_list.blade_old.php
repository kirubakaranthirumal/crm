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
							window.setTimeout(function(){window.location.href = "{{asset('/admin/pticket/')}}";}, 2000);
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
											<a href="pticket?tab_id=1" aria-expanded="false">
												@if(isset($countData->allticketsCount))
													Total ({{$countData->allticketsCount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($open_active_tab)){{$open_active_tab}}@endif">
											<a href="pticket?tab_id=2" aria-expanded="false">
												@if(isset($countData->openStatuscount))
													Open ({{$countData->openStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($assign_active_tab)){{$assign_active_tab}}@endif">
											<a href="pticket?tab_id=3" aria-expanded="false">
												@if(isset($countData->assignedStatuscount))
													Assigned ({{$countData->assignedStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($progress_active_tab)){{$progress_active_tab}}@endif">
											<a href="pticket?tab_id=4" aria-expanded="false">
												@if(isset($countData->inprogressStatuscount))
													In Progress ({{$countData->inprogressStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($closed_active_tab)){{$closed_active_tab}}@endif">
											<a href="pticket?tab_id=5" aria-expanded="false">
												@if(isset($countData->closedStatuscount))
													Closed ({{$countData->closedStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($waitcust_active_tab)){{$waitcust_active_tab}}@endif">
											<a href="pticket?tab_id=6" aria-expanded="false">
												@if(isset($countData->wfCusRescount))
													Wait For Customer Reply ({{$countData->wfCusRescount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($wait3rdparty_active_tab)){{$wait3rdparty_active_tab}}@endif">
											<a href="pticket?tab_id=7" aria-expanded="false">
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
															$date_diffin_hours = "";
															$date1 = $data->createdOn;
															$date2 = date("Y-m-d h:i:s");
															//echo "date1-".$date1."<br>";
															//echo "date2-".$date2."<br>";
															$date2 = date("Y-m-d");
															$timestamp1 = strtotime($date1);
															$timestamp2 = strtotime($date2);

															$date_diffin_hours = $hour = abs($timestamp2 - $timestamp1)/(60*60);
															$date_diffin_hours = floor($date_diffin_hours);
															//echo "Difference between two dates is " . $hour = abs($timestamp2 - $timestamp1)/(60*60) . " hour(s)";
														?>
														@if(isset($date_diffin_hours))
															@if($date_diffin_hours <= 24)
																<span style="color:green;">{{$date_diffin_hours}} Hours</span>
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
														<?php
															$ticket_edit_show = $ticket_delete_show = "";

															$ticket_edit_show = session()->get('ticketEdit');
															$ticket_delete_show = session()->get('ticketDelete');
														?>
														<?php
															if(!empty($ticket_edit_show)){
														?>
															<a href="{{asset('/admin/edit_ticket/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="Edit Ticket">
																<i class="fa fa-edit"></i>
															</a>&nbsp;&nbsp;

														<?php
															}
														?>

														<!--<a href="{{asset('/admin/view_tickets/')}}/@if(isset($data->ticketId)){{ $data->ticketId}} @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;-->

														<?php
															if(!empty($ticket_delete_show)){
														?>
															<a href="{{asset('/admin/ticket_details/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="View Ticket">
																<i class="fa fa-user-secret"></i>
															</a>
														<?php
															}
														?>
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

			$(function(){
				$('#created_on').datepicker({
					format: 'yyyy-mm-dd'
				});
			});
		</script>
@endsection


