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
			@if (session('createTicktSuccess'))
				<div class="flash-message">
					 <div class="alert alert-success">
						Ticket created successfully
						<script>
							window.setTimeout(function(){
							window.location.href = "{{asset('/admin/notification/')}}";
							}, 2000);
						</script>
					</div>
				</div>
			@endif
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">E-Mail Notification</h3>
					 <div style="float:right;margin-right:1%;">
						<a href="{{asset('/admin/add_tickets/')}}" class="btn btn-primary" target="_blank">
							Create Ticket
						</a>
					</div>
				</div><!-- /.box-header -->

				<div class="box-body"><!-- /.box -->
					<!-- /.box-header -->

            		<div class="box-body">
						<div class="nav-tabs-custom">
							<div class="tab-content">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>From</th>
											<th>Subject</th>
											<th>Message Body</th>
											<th>Received On</th>
											<!--<th>Action</th>-->
										</tr>
									</thead>
									<tbody>
										<?php
											/*
											print"<pre>";
											print_r($notificationdata);
											exit;
											*/
										?>
										@if(isset($notificationdata))
											@foreach($notificationdata as $data)
												<tr>
													<td>
														@if(isset($data->fromAddress))
															{{$data->fromAddress}}
														@endif
													</td>
													<td>
														@if(isset($data->subjectLine))
															{{$data->subjectLine}}
														@endif
													</td>
													<td>
														@if(isset($data->detailContent))
															{{$data->detailContent}}
														@endif
													</td>
													<td>
														@if(isset($data->sendDate))
															{{$data->sendDate}}
														@endif
													</td>
													<!--<td>
														<a href="{{ url(config('quickadmin.route').'/createticketfromnotification') }}/@if(isset($data->notificationId)){{ $data->notificationId}}@endif" title="Create Ticket" class="btn btn-primary">
															Create Ticket
														</a>
													</td>-->
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


