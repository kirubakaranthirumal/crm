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
					<h3 class="box-title">Tickets Notification</h3>
				</div><!-- /.box-header -->
				<div class="box-body"><!-- /.box -->
					<!-- /.box-header -->

            		<div class="box-body">
						<div class="nav-tabs-custom">
							<div class="tab-content">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>E-Mail</th>
											<th>Subject</th>
											<th>Description</th>
											<th>Read Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($notificationdata))
											@foreach($notificationdata as $data)
												<tr>
													<td>
														@if(isset($data->userEmail))
															{{$data->userEmail}}
														@endif
													</td>
													<td>
														@if(isset($data->title))
															{{$data->title}}
														@endif
													</td>
													<td>
														@if(isset($data->description))
															{{$data->description}}
														@endif
													</td>
													<td>
														@if(isset($data->readStatus))
															@if($data->readStatus==1)
																Un-Read
															@elseif($data->readStatus==2)
																Read
															@endif
														@endif
													</td>
													<td>
														@if(isset($data->createdOn))
															{{$data->createdOn}}
														@endif
													</td>
													<td>
														<a href="{{asset('/admin/createticketfromnotification/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="View Ticket">
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


