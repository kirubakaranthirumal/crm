@extends('admin.layouts.master')
@section('content')
<section class="content">
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
						<div class="box-header with-border">
							<h3 class="box-title">Filter Ticket</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form">
							<div class="box-body">
								<div class="col-md-6">
									<div class="form-group">
										<label>Employee</label>
										<input type="text" class="form-control"  placeholder="Filter By Employee">
									</div>
									<div class="form-group">
										<label>Groups</label>
										<input type="text" class="form-control" placeholder="Filter By Groups">
									</div>
									<div class="form-group">
										<label>Date</label>
										<input type="date" class="form-control"></input>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
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
									</div>
									<div class="form-group">
										<label>Priority</label>
										<select class="form-control">
											<option>Filter By Priority</option>
											<option>Low</option>
											<option>Medium</option>
											<option>High</option>
											<option>Urgent</option>
										</select>
									</div>
									<div class="form-group">
										<label>Source</label>
										<select class="form-control">
											<option>Filter By Source</option>
											<option>Portal</option>
											<option>Email</option>
											<option>Social Media</option>
											<option>Live Chat</option>
										</select>
									</div>
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Filter</button>
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
											<a data-toggle="tab" href="{{asset('/admin/view_tickets?tab_id=1')}}" aria-expanded="false">
												@if(isset($countData->allticketsCount))
													Total ({{$countData->allticketsCount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($open_active_tab)){{$open_active_tab}}@endif">
											<a data-toggle="tab" href="{{asset('/admin/view_tickets?tab_id=2')}}" aria-expanded="false">
												@if(isset($countData->openStatuscount))
													Open ({{$countData->openStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($assign_active_tab)){{$assign_active_tab}}@endif">
											<a data-toggle="tab" href="{{asset('/admin/view_tickets?tab_id=3')}}" aria-expanded="false">
												@if(isset($countData->assignedStatuscount))
													Assigned ({{$countData->assignedStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($progress_active_tab)){{$progress_active_tab}}@endif">
											<a data-toggle="tab" href="{{asset('/admin/view_tickets?tab_id=4')}}" aria-expanded="false">
												@if(isset($countData->inprogressStatuscount))
													In Progress ({{$countData->inprogressStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($closed_active_tab)){{$closed_active_tab}}@endif">
											<a data-toggle="tab" href="{{asset('/admin/view_tickets?tab_id=5')}}" aria-expanded="false">
												@if(isset($countData->closedStatuscount))
													Closed ({{$countData->closedStatuscount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($waitcust_active_tab)){{$waitcust_active_tab}}@endif">
											<a data-toggle="tab" href="{{asset('/admin/view_tickets?tab_id=6')}}" aria-expanded="false">
												@if(isset($countData->wfCusRescount))
													Wait For Customer Reply ({{$countData->wfCusRescount}})
												@endif
											</a>
										</li>
										<li class="@if(isset($wait3rdparty_active_tab)){{$wait3rdparty_active_tab}}@endif">
											<a data-toggle="tab" href="{{asset('/admin/view_tickets?tab_id=7')}}" aria-expanded="false">
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
														@if(isset($data->aging))
															@if($data->aging<=24)
																{{$data->aging}}
															@else
																Overdue
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
													<td>
														@if(isset($data->createdBy))
															{{$data->createdBy}}
														@endif
													</td>
													<td>
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
												</tr>
											@endforeach
										@endif
									</tbody>
									<tfoot>
										<tr>
											<th>Id</th>
											<th>Request From</th>
											<th>Subject</th>
											<th>Aging</th>
											<th>Priority</th>
											<th>Created On</th>
											<th>Created By</th>
										</tr>
									</tfoot>
								</table>


							</div>
						</div>
            		</div><!-- /.box-body -->
				</div>
			</div>
		</div>
	<script>
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
	</script>
@endsection


