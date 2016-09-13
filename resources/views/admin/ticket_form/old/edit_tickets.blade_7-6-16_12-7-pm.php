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
							requester_name: "required",
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
								required: true,
								notEqualTo: 20
							},
							description: "required"
						},
						messages: {
							requester_name: "Please enter your requester name",
							subject: "Please enter your subject",
							source: "Please provide source",
							category: "Please provide category",
							priority: "Please enter priority",
							group: "Please select group",
							type: "Please select type",
							status: "Please select status",
							employee: "Please select employee",
							description: "Please enter description"
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

    <section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				@if (session('ticketUpdateSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							Ticket Updated successfully
							<script>
								window.setTimeout(function(){
								window.location.href = "{{asset('/admin/view_tickets/')}}";
								}, 2000);
							</script>
						</div>
					</div>
				@endif
				@if (session('ticketError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Cannot Update ticket
						</div>
					</div>
				@endif
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Edit Ticket</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						<form action="" method="PUT" id="ticket-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-6">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Requester Name <span id="required">*</span></label>
									<input type="text" name="requester_name" id="requester_name" class="form-control" placeholder="Requester Name" value="@if(isset($ticketdata->requestorName)){{$ticketdata->requestorName}}@endif">
								</div>
								<div class="form-group">
									<label>Subject <span id="required">*</span></label>
									<input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" value="@if(isset($ticketdata->ticketSubject)){{$ticketdata->ticketSubject}}@endif">
								</div>
								<div class="form-group">
									<label>Type <span id="required">*</span></label>
									<select class="form-control" name="type" id="type">
										<option value="">Select Type</option>
										 @if(isset($ticketdata->type))
										@if($ticketdata->type==1)
										<option value="1" selected>Question</option>
										<option value="2">Indicent</option>
										<option value="3">Problem</option>
										<option value="4">Feature Request</option>
										@endif
										@if($ticketdata->type==2)
										<option value="1">Question</option>
										<option value="2" selected>Indicent</option>
										<option value="3">Problem</option>
										<option value="4">Feature Request</option>
										@endif
										@if($ticketdata->type==3)
										<option value="1">Question</option>
										<option value="2">Indicent</option>
										<option value="3" selected>Problem</option>
										<option value="4">Feature Request</option>
										@endif
											@if($ticketdata->type==4)
										<option value="1">Question</option>
										<option value="2">Indicent</option>
										<option value="3">Problem</option>
										<option value="4" selected>Feature Request</option>
										@endif
										@else
											<option value="1">Question</option>
											<option value="2">Indicent</option>
											<option value="3">Problem</option>
											<option value="4">Feature Request</option>
										@endif
									</select>
								</div>
								<div class="form-group">
									<label>Ticket Source <span id="required">*</span></label>
									<select class="form-control" name="source" id="source">
										<option value="">Select Source</option>
										@if(isset($ticketdata->ticketSource))
										@if($ticketdata->ticketSource==1)
										<option value="1" selected>Portal</option>
										<option value="2">Email</option>
										<option value="3">Social Media</option>
										<option value="4">Live Chat</option>
										@endif
										@if($ticketdata->ticketSource==2)
										<option value="1">Portal</option>
										<option value="2" selected>Email</option>
										<option value="3">Social Media</option>
										<option value="4">Live Chat</option>
										@endif
										@if($ticketdata->ticketSource==3)
										<option value="1">Portal</option>
										<option value="2">Email</option>
										<option value="3" selected>Social Media</option>
										<option value="4">Live Chat</option>
										@endif
										@if($ticketdata->ticketSource==4)
										<option value="1">Portal</option>
										<option value="2">Email</option>
										<option value="3">Social Media</option>
										<option value="4" selected>Live Chat</option>
										@endif
										@else
											<option value="1">Portal</option>
											<option value="2">Email</option>
											<option value="3">Social Media</option>
											<option value="4">Live Chat</option>
										@endif
									</select>
								</div>
								<div class="form-group">
									<label>Category <span id="required">*</span></label>
									<select class="form-control" name="category" id="category">
										<option value="">Select Category</option>
									 @if(isset($ticketdata->ticketCatId))
										@if($ticketdata->ticketCatId==1)
										<option value="1" selected>Network Issue</option>
										<option value="2">Payment</option>
										<option value="3">Browser</option>
										<option value="4">Streaming</option>
										@endif
											@if($ticketdata->ticketCatId==2)
										<option value="1">Network Issue</option>
										<option value="2" selected>Payment</option>
										<option value="3">Browser</option>
										<option value="4">Streaming</option>
										@endif
											@if($ticketdata->ticketCatId==3)
										<option value="1">Network Issue</option>
										<option value="2">Payment</option>
										<option value="3" selected>Browser</option>
										<option value="4">Streaming</option>
										@endif
											@if($ticketdata->ticketCatId==4)
										<option value="1">Network Issue</option>
										<option value="2">Payment</option>
										<option value="3">Browser</option>
										<option value="4" selected>Streaming</option>
										@endif
										@else
											<option value="1">Network Issue</option>
											<option value="2">Payment</option>
											<option value="3">Browser</option>
											<option value="4">Streaming</option>
										@endif
									</select>
								</div>
								<div class="form-group">
									<label>Status <span id="required">*</span></label>
									<select class="form-control" name="status" id="status">
										<option value="">Select Status</option>
										@if(isset($ticketdata->status))
											@if($ticketdata->status==1)
											<option value="1" selected>Open</option>
											<option value="2">Assigned</option>
											<option value="3">InProgress</option>
											<option value="4">Closed</option>
											<option value="5">Waiting On Customer</option>
											<option value="6">Waiting On 3rd Party</option>
											@endif
											@if($ticketdata->status==2)
											<option value="1">Open</option>
											<option value="2" selected>Assigned</option>
											<option value="3">InProgress</option>
											<option value="4">Closed</option>
											<option value="5">Waiting On Customer</option>
											<option value="6">Waiting On 3rd Party</option>
											@endif
											@if($ticketdata->status==3)
											<option value="1">Open</option>
											<option value="2">Assigned</option>
											<option value="3" selected>InProgress</option>
											<option value="4">Closed</option>
											<option value="5">Waiting On Customer</option>
											<option value="6">Waiting On 3rd Party</option>
											@endif
											@if($ticketdata->status==4)
											<option value="1">Open</option>
											<option value="2">Assigned</option>
											<option value="3">InProgress</option>
											<option value="4" selected>Closed</option>
											<option value="5">Waiting On Customer</option>
											<option value="6">Waiting On 3rd Party</option>
											@endif
											@if($ticketdata->status==5)
											<option value="1">Open</option>
											<option value="2">Assigned</option>
											<option value="3">InProgress</option>
											<option value="4">Closed</option>
											<option value="5" selected>Waiting On Customer</option>
											<option value="6">Waiting On 3rd Party</option>
											@endif
											@if($ticketdata->status==6)
											<option value="1">Open</option>
											<option value="2">Assigned</option>
											<option value="3">InProgress</option>
											<option value="4">Closed</option>
											<option value="5">Waiting On Customer</option>
											<option value="6" selected>Waiting On 3rd Party</option>
										    @endif
										@else
											<option value="1">Open</option>
											<option value="2">Assigned</option>
											<option value="3">InProgress</option>
											<option value="4">Closed</option>
											<option value="5">Waiting On Customer</option>
											<option value="6">Waiting On 3rd Party</option>
										@endif
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Priority <span id="required">*</span></label>
									<select class="form-control" name="priority" id="priority">
										<option value="">Select Priority</option>
										@if(isset($ticketdata->priority))
											@if($ticketdata->priority==1)
											<option value="1" selected>Low</option>
											<option value="2">Medium</option>
											<option value="3">High</option>
											<option value="4">Urgent</option>
											@endif
								         	@if($ticketdata->priority==2)
											<option value="1">Low</option>
											<option value="2" selected>Medium</option>
											<option value="3">High</option>
											<option value="4">Urgent</option>
											@endif
											@if($ticketdata->priority==3)
											<option value="1">Low</option>
											<option value="2">Medium</option>
											<option value="3" selected>High</option>
											<option value="4">Urgent</option>
											@endif
											@if($ticketdata->priority==4)
											<option value="1">Low</option>
											<option value="2">Medium</option>
											<option value="3">High</option>
											<option value="4" selected>Urgent</option>
											@endif
										@else
											<option value="1">Low</option>
											<option value="2">Medium</option>
											<option value="3">High</option>
											<option value="4">Urgent</option>
										@endif
									</select>
								</div>
								<div class="form-group">
								<label>Group <span id="required">*</span></label>
									<select class="form-control" name="group" id="group" onchange="load_employee(this.value)">
										<option value="">Select Group</option>
										@if(isset($ticketdata->ticketGroupId))
											@if($ticketdata->ticketGroupId==1)
												<option value="1" selected>Techical Support</option>
												<option value="2">Network Support</option>
											@endif
											@if($ticketdata->ticketGroupId==2)
												<option value="1">Techical Support</option>
												<option value="2" selected>Network Support</option>
											@endif
											@else
											<option value="1">Techical Support</option>
											<option value="2">Network Support</option>
										@endif
									</select>
								</div>
									<?php
										if(!empty($req_groupid)){
									?>
										<script>
											load_employee('<?=$req_groupid?>');
										</script>

									<?php

										}
									?>
								<div class="form-group">
									<label>Assign Employee <span id="required">*</span></label>
									<div id="employee_div">
										<select class="form-control" name="employee" id="employee">
											<option value="">Select Employee Name</option>
										</select>
									</div>
									<!--<select class="form-control" name="employee" id="employee">
										<option value="">Select Employee Name</option>
										<option value="1">Employee_Name 1</option>
										<option value="2">Employee_Name 2</option>
									</select>-->
								</div>
								<div class="form-group">
									<label>Description <span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="description" id="description" >@if(isset($ticketdata->ticketText)){{$ticketdata->ticketText}}
									@endif
									</textarea>
								</div>
								<!--<div class="form-group">
									<label for="exampleInputFile">Attachment</label>
									<input type="file" id="exampleInputFile">
								</div>-->
							</div>
						</div><!-- /.box-body -->
						<div class="box-footer">
							<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
							<!--<button type="submit" class="btn btn-primary">Submit New</button>
							&nbsp;<button type="button" class="btn btn-primary">Submit Close</button>
							&nbsp;<button type="reset" class="btn btn-primary">Reset</button>-->
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div><!-- /.box -->
		</div>
	</div>
</section>
<script>
 $(function () {
        //Add text editor
        $("#description").wysihtml5();
      });
</script>
@endsection


