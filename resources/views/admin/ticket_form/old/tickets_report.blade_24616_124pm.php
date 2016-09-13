@extends('admin.layouts.master')
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
<style>
	#contentmanage-form label.error{
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

<script type="text/javascript" language="javascript">
    $(document).ready(function(){
    	//$("#modal-container-department").dialog({modal: true});
    });
</script>
@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            	@if(session('contentManageSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Menu Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/contentmanage/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif

				@if(session('contentManageDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Menu Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/contentmanage/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif

				@if (session('menuNameError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							{{session('menuNameError')}}
						</div>
					</div>
				@endif

				<div class="col-md-12">
					<div style="clear:both;">&nbsp;</div>
					<!-- general form elements -->
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
								<div class="col-md-12">
								<div class="col-md-3">
									<div class="form-group">
										<label>Groups</label>
										<select class="form-control" name="group" id="group" onchange="load_employee(this.value)">
											<option value="">Select Group</option>
											<option value="1">Techical Support</option>
											<option value="2">Network Support</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Employee</label>
										<div id="employee_div">
											<select class="form-control" name="employee" id="employee">
												<option value="">Select Employee Name</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-3">
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
									</div>
								<div class="col-md-3">
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
						
								</div>
								<div class="col-md-12">
								<div class="col-md-3">
									<div class="form-group">
										<label>Status <span id="required">*</span></label>
										<select class="form-control" name="status" id="status" >
											<option value="">Select Status</option>
											<option value="1">Open</option>
											<option value="2">Assigned</option>
											<option value="3">InProgress</option>
											<option value="4">Closed</option>
											<option value="5">Waiting On Customer</option>
											<option value="6">Waiting On 3rd Party</option>
										</select>
									</div>
								</div>
								<div class="col-md-3">
								  <div class="form-group">
									<label>App <span id="required">*</span></label>
									<select class="form-control" name="application" id="application" onchange="load_event(this.value)">
										<option value="">Select Application</option>
											@if(isset($app_data))
												@foreach ($app_data as $data)
													@if((isset($data->appId)) && (isset($data->appName)))
														<option value="{{$data->appId}}" >{{$data->appName}}</option>
													@endif
												@endforeach
											@endif
									</select>
								  </div>
								</div>
								<div class="col-md-3">
										<div class="form-group">
									<label>Event <span id="required">*</span></label>
									<div id="event_div">
										<select class="form-control" name="event" id="event">
											<option value="">Select Event</option>
										</select>
									</div>
								</div>
								</div>
									<div class="col-md-3">
									<div class="form-group">
										<label>Category</label>
										<select class="form-control" name="category" id="category">
											<option value="">Select Category</option>
											<option value="1">Network Issue</option>
											<option value="3">Payment</option>
											<option value="4">Browser</option>
											<option value="5">Streaming</option>
										</select>
									</div>
								</div>
								</div>
								<div class="col-md-12">
								<div class="col-md-3">
								
									<div class="form-group">
										<label>Start Date</label>
										<input type="text" class="form-control" name="start_date" id="start_date">
									</div>
								</div>
									<div class="col-md-3">
								
									<div class="form-group">
										<label>End Date</label>
										<input type="text" class="form-control" name="end_date" id="end_date">
									</div>
								</div>
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
								<input type="button" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-primary">
								<!--<button type="submit" class="btn btn-primary">Filter</button>-->
								<button type="reset" class="btn btn-primary">Reset</button>
							</div>
						</form>
              		</div>
					<div class="box box-primary"  id="report_data">
						<div class="box-header with-border">
							<h3 class="box-title">Report Generate</h3>
						<div class="pull-right" style="margin-right:45px;">
						<a href="#" title="Excel" onClick ="$('#ticket_list').tableExport({type:'excel',escape:'false'});" style="font-size:25px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
						<a href="#" title="PDF" onClick ="$('#ticket_list').tableExport({type:'pdf',escape:'false'});" style="font-size:25px;"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
						</div>
						</div><!-- /.box-header -->
					
							<div class="box-body">
								<!--<a id="modal-department" href="#modal-container-department" role="button" class="btn btn-primary" data-toggle="modal">Add DepartMent</a>-->
								<table id="ticket_list" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>ID</th>
											<th>Request From</th>
											<th>Subject</th>
											<!--<th>Aging</th>-->
											<th>Status</th>
											<th>Priority</th>
											<th>Created On</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($ticketReportArray))
											@foreach($ticketReportArray as $ticketdata)
												<tr>
													<td>
														@if(isset($ticketdata->ticket_id))
															{{$ticketdata->ticket_id}}
														@endif
													</td>
													<td>
														@if(isset($ticketdata->requestor_name))
															{{$ticketdata->requestor_name}}
														@endif
													</td>
													<td>
														@if(isset($ticketdata->ticket_subject))
															{{$ticketdata->ticket_subject}}
														@endif
													</td>
													<td>
														@if(isset($ticketdata->status))
															{{$ticketdata->status}}
														@endif
													</td>
													<td>
														@if(isset($ticketdata->priority))
															@if($ticketdata->priority==1)
																Low
															@elseif($ticketdata->priority==2)
																Medium
															@elseif($ticketdata->priority==3)
																High
															@elseif($ticketdata->priority==4)
																Urgent
															@endif
														@endif
													</td>
													<td>
														@if(isset($ticketdata->create_on))
															  <?php
																  $date=date_create($ticketdata->create_on);
																  echo date_format($date,"Y-m-d h:i A");
																  ?>
														@endif
													</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div><!-- /.box -->
					
					<script language="javascript">

						$(function() {

						$('#ticket_list').DataTable( {
							"aaSorting": [[ 0, "asc" ]],
							 "aoColumnDefs" : [
								 {
								   'bSortable' : false,
								   'aTargets' : [ 4 ]
								 }]
							} );
						
						} );
					</script>
							<script language="javascript">
			$("#searchsubmit").click(function(){
				/*if blank return false else true*/

				var group_val = $('#group').val();
				var employee_val = $('#employee').val();
				var priority_val = $('#priority').val();
				var source_val = $('#source').val();
				var status_val = $('#status').val();
				var start_date = $('#start_date').val();
				var end_date = $('#end_date').val();
				var app = $('#application').val();
				var event = $('#event').val();
				var category = $('#category').val();
		

	if((group_val=='')&&(employee_val=='')&&(priority_val=='')&&(source_val=='')&&(status_val=='')&&(start_date=='')&&(end_date=='')&&(app=='')&&(event=='')&&(category=='')){
					$("#login_msg").html('<span style="margin-left:23px;padding-top:5px;color:red;">Please select atleast one field to proceed with filter</span>');
				}
				else{
		
					$("#login_msg").html('');
					$("#ticket-form").submit();
					
				}
			});

			$(function () {
				$("#example1").DataTable();
				$('#example1').DataTable( {
						dom: 'Bfrtip',
						buttons: [
							'copy', 'csv', 'excel', 'pdf', 'print'
						]
					} );

			});

			$(function(){
				$('#start_date').datepicker({
					format:'yyyy-mm-dd'
				});
				$('#end_date').datepicker({
					format:'yyyy-mm-dd'
				});
				
			});
		</script>


@endsection


