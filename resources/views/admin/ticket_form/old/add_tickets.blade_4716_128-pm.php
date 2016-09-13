@extends('admin.layouts.master')
@section('content')
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	<script language="javascript">
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
					$("#ticket-form").validate({
						rules: {
							application: {
								required: true,
								notEqualTo: 20
							},
							event: {
								required: true,
								notEqualTo: 20
							},
							requester_name: "required",
							requester_email: {
								required: true,
								email: true
							},
							subject: "required",
							source: {
								required: true,
								notEqualTo: 20
							},
							category: {
								required: true,
								notEqualTo: 20
							},
							priority: {
								required: true,
								notEqualTo: 20
							},
							group: {
								required: true,
								notEqualTo: 20
							},
							type: {
								required: true,
								notEqualTo: 20
							},
							status: {
								required: true,
								notEqualTo: 20
							},
							employee: {
								required: false,
								notEqualTo: 20
							},
							description: "required"
						},
						messages: {
							/*
							requester_name: "Please enter your requester email",
							subject: "Please enter your subject",
							source: "Please provide source",
							category: "Please provide category",
							priority: "Please enter priority",
							group: "Please select group",
							type: "Please select type",
							status: "Please select status",
							employee: "Please select employee",
							description: "Please enter description"
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
		#errmsg{
			color:red;
		}

		#ticket-form label.error{
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
    <section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				@if(isset($upload_error))
					@foreach($upload_error as $upload_error_val)
					<div class="flash-message">
						 <div class="alert alert-danger">
							Cannot upload attachment
						</div>
					</div>
					@endforeach
				@endif
				@if (session('ticketSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							Ticket created successfully
							<script>
								window.setTimeout(function(){window.location.href = "{{asset('/admin/view_tickets/')}}";}, 2000);
							</script>
						</div>
					</div>
				@endif
				@if (session('ticketError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Cannot create ticket
						</div>
					</div>
				@endif
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Create Ticket</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						<form action="" method="POST" id="ticket-form" class="form-horizontal" novalidate="novalidate" enctype= multipart/form-data>
							<div class="col-md-6">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Application <span id="required">*</span></label>
									<select class="form-control" name="application" id="application" onchange="load_event(this.value)" tabindex="1">
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
								<div class="form-group">
									<label>Requester E-Mail <span id="required">*</span></label>
									<!--<input type="text" name="requester_name" id="requester_name" class="form-control" placeholder="Requester Name" tabindex="3">-->
									<input type="text" name="requester_email" id="requester_email" class="form-control" placeholder="Requester E-Mail" tabindex="3">
								</div>
								<div class="form-group">
									<label>Subject <span id="required">*</span></label>
									<input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" tabindex="5">
								</div>
							    <div class="form-group">
									<label>Type <span id="required">*</span></label>
										@if(isset($type))
									<select class="form-control" name="type" id="type" tabindex="7" >
										<option value="">Select Type</option>
										@foreach($type as $types)
										@if($types['typeStatus']==1)
										<option value="{{$types['typeId']}}">{{$types['typeName']}}</option>
										@endif
										@endforeach
									</select>
									@endif
								</div>
								<div class="form-group">
									<label>Ticket Source <span id="required">*</span></label>
										@if(isset($source))
									<select class="form-control" name="source" id="source" tabindex="9">
										<option value="">Select Source</option>
											@foreach($source as $sources)
											@if($sources['sourceStatus']==1)
										<option value="{{$sources['sourceId']}}">{{$sources['sourceName']}}</option>
											@endif
											@endforeach
									</select>
									@endif
								</div>
											<div class="form-group">
									<label>Priority <span id="required">*</span></label>
										@if(isset($priority))
									<select class="form-control" name="priority" id="priority" tabindex="11">
										<option value="">Select Priority</option>
										@foreach($priority as $prior)
											@if($prior['priorityStatus']==1)
												<option value="{{$prior['priorityId']}}">{{$prior['priorityName']}}</option>
											@endif
										@endforeach
									</select>
										@endif
								</div>

								<div class="form-group">
									<label>Status <span id="required">*</span></label>
									<select class="form-control" name="status" id="status" tabindex="13">
										<option value="">Select Status</option>
										<option value="1" selected>Open</option>
										<option value="2">Assigned</option>
										<option value="3">InProgress</option>
										<option value="4">Closed</option>
										<option value="5">Waiting On Customer</option>
										<option value="6">Waiting On 3rd Party</option>
									</select>
								</div>
								<div class="form-group">
									<label>Deadline</label>
									<!--<input type="text" name="quantity" id="quantity" />-->
									<!--<input type="text" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->ticketDeadline)){{$ticketdata->ticketDeadline}}@endif" tabindex="5">-->
									<input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->ticketDeadline)){{$ticketdata->ticketDeadline}}@endif" tabindex="5">
									<!--<input type="number" min="0" step="1" max="24"/>-->
									&nbsp;<span id="errmsg"></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Event <span id="required">*</span></label>
									<div id="event_div">
										<select class="form-control" name="event" id="event" tabindex="2">
											<option value="">Select Event</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label>Requester Name <span id="required">*</span></label>
									<!--<input type="text" name="requester_name" id="requester_name" class="form-control" placeholder="Requester Name" tabindex="3">-->
									<input type="text" name="requester_name" id="requester_name" class="form-control" placeholder="Requester Name" tabindex="4">
								</div>
							   <div class="form-group">
									<label>Category <span id="required">*</span></label>
										@if(isset($category))
									<select class="form-control" name="category" id="category" tabindex="6">
										<option value="">Select Category</option>
										@foreach($category as $cate)
										@if($cate['categoryStatus']==1)
										<option value="{{$cate['categoryId']}}">{{$cate['categoryName']}}</option>
										@endif
										@endforeach
									</select>
									@endif
								</div>
								<div class="form-group">
								<label>Group <span id="required">*</span></label>
										@if(isset($department))
									<select class="form-control" name="group" id="group" onchange="load_employee(this.value)" tabindex="8">
										<option value="">Select Group</option>
										@foreach ($department as $data)
											@if($data['deptStatus']==1)
										<option value="{{$data['deptId']}}">{{$data['deptName']}}</option>
											@endif
											@endforeach
									</select>
									@endif
								</div>
								<div class="form-group">
									<label>Assign Employee <span id="required">*</span></label>
									<div id="employee_div">
										<select class="form-control" name="employee" id="employee" tabindex="10">
											<option value="">Select Employee Name</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label>Description <span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="description" id="description" tabindex="12"></textarea>
								</div>
								<div class="form-group">
									<label for="exampleInputFile">Attachment</label>
									<input type="file" name="ticket_attachment" id="ticket_attachment" tabindex="14">
								</div>
							</div>
						</div><!-- /.box-body -->
						<div class="box-footer">
							<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div><!-- /.box -->
		</div>
	</div>
	<script language="javascript">
		$(document).ready(function () {
		  //called when key is pressed in textbox
		  $("#deadline").keypress(function (e){
			 //if the letter is not digit then display error and don't type anything
			 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				//display error message
				$("#errmsg").html("Type only numeric value").show().fadeOut("slow");
				return false;
			}
		   });

		   /*
		   $("#deadline").keypress(function (e){
				var dead_line = "";
				dead_line = $("#deadline").val();

				if(dead_line>24){
					$("#errmsg").html("Enter number less than 24").show().fadeOut("slow");
					return false;
				}
		   });
		   */

		});
	</script>
</section>
@endsection


