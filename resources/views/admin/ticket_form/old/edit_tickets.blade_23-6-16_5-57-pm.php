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
								required: true,
								notEqualTo: 20
							},
							description: "required"
						},
						messages: {
							/*
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
	<!--<body OnLoad="LoadValue(document.getElementById('ticket-form'));">-->
		<section class="content">
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
					@if (session('ticketUpdateSuccess'))
						<div class="flash-message">
							 <div class="alert alert-success">
								Ticket Updated successfully
								<script>
									window.setTimeout(function(){window.location.href = "{{asset('/admin/view_tickets/')}}";}, 2000);
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
							<form action="" method="PUT" name="ticket-form" id="ticket-form" class="form-horizontal" novalidate="novalidate" enctype="multipart/form-data">
								<div class="col-md-6">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group">
										<label>Application <span id="required">*</span></label>
										<?php
											$view_app_id = "";
											if(!empty($ticketdata->appId)){
												$view_app_id = $ticketdata->appId;
											}

											$view_event_id = "";
											if(!empty($ticketdata->eventId)){
												$view_event_id = $ticketdata->eventId;
											}

											//print"<pre>";
											//print_r($ticketdata);
											//print_r($view_event_id);
										?>
										<select class="form-control" name="application" id="application" onchange="load_event(this.value)" tabindex="1">
											<option value="">Select Application</option>
												@if(isset($app_data))
													@foreach ($app_data as $data)
														@if((isset($data->appId)) && (isset($data->appName)))
															@if(isset($ticketdata->appId))
																@if($ticketdata->appId == $data->appId)
																	<option value="{{$data->appId}}" selected>{{$data->appName}}</option>
																@else
																	<option value="{{$data->appId}}">{{$data->appName}}</option>
																@endif
															@endif
														@endif
													@endforeach
												@endif
										</select>
									</div>

									<div class="form-group">
										<label>Requester E-Mail <span id="required">*</span></label>
										<!--<input type="text" name="requester_name" id="requester_name" class="form-control" placeholder="Requester Name" tabindex="3">-->
										<input type="text" name="requester_email" id="requester_email" class="form-control" placeholder="Requester E-Mail" value="@if(isset($ticketdata->portalUserEmailId)){{$ticketdata->portalUserEmailId}}@endif" tabindex="3">
									</div>
									<div class="form-group">
										<label>Subject <span id="required">*</span></label>
										<input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" value="@if(isset($ticketdata->ticketSubject)){{$ticketdata->ticketSubject}}@endif" tabindex="5">
									</div>
									<div class="form-group">
										<label>Type <span id="required">*</span></label>
										@if(isset($type))
										<select class="form-control" name="type" id="type" tabindex="7">
											<option value="">Select Type</option>
											@foreach($type as $types)
												@if($types['typeStatus']==1)
													@if(isset($ticketdata->type))
														@if($ticketdata->type==$types['typeId'])
															<option value="{{$types['typeId']}}" selected>{{$types['typeName']}}</option>
														@endif
													@else
														<option value="{{$types['typeId']}}">{{$types['typeName']}}</option>
													@endif
												@endif
											@endforeach
										</select>
										@endif
									</div>
									<div class="form-group">
										<label>Ticket Source <span id="required">*</span></label>
										<?php
										 //print"<pre>";
										 //print_r($ticketdata);
										 //exit;
										 ?>
										<select class="form-control" name="source" id="source" tabindex="9">
											<option value="">Select Source</option>
												@if(isset($source))
													@foreach($source as $sources)
														 @if($sources['sourceStatus']==1)
															  @if(isset($ticketdata->ticketSource))
																	@if($ticketdata->ticketSource==$sources['sourceId'])
																		<option value="{{$sources['sourceId']}}" selected>{{$sources['sourceName']}}</option>
																	@else
																		<option value="{{$sources['sourceId']}}">{{$sources['sourceName']}}</option>
																	@endif
															  @else
																<option value="{{$sources['sourceId']}}">{{$sources['sourceName']}}</option>
															  @endif
														@endif
													@endforeach
												@endif
										</select>
									</div>
									<div class="form-group">

										<label>Priority <span id="required">*</span></label>
										<select class="form-control" name="priority" id="priority" tabindex="11">
											<option value="">Select Priority</option>
											@if(isset($priority))
												@foreach($priority as $prior)
													@if($prior['priorityStatus']==1)
														@if(isset($ticketdata->priority))
															@if($ticketdata->priority==$prior['priorityId'])
																<option value="{{$prior['priorityId']}}" selected>{{$prior['priorityName']}}</option>
															@endif
															@else
																<option value="{{$prior['priorityId']}}">{{$prior['priorityName']}}</option>
															@endif
														@endif
													@endforeach
												@endif
										</select>
									</div>
									<div class="form-group">
										<label>Status <span id="required">*</span></label>
										<select class="form-control" name="status" id="status" tabindex="13">
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
										<?php
											if(!empty($ticketdata->appId)){
										?>
											<script>
												load_event('<?=$ticketdata->appId?>');
											</script>
										<?php
											}
										?>
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
										<input type="text" name="requester_name" id="requester_name" class="form-control" placeholder="Requester Name" value="@if(isset($ticketdata->requestorName)){{$ticketdata->requestorName}}@endif" tabindex="4">
									</div>
									<div class="form-group">
										<label>Category <span id="required">*</span></label>
										@if(isset($category))
										<select class="form-control" name="category" id="category" tabindex="6">
											<option value="">Select Category</option>
												@foreach($category as $cate)
											@if($cate['categoryStatus']==1)
												  @if(isset($ticketdata->ticketCatId))
															@if($ticketdata->ticketCatId==$cate['categoryId'])
																<option value="{{$cate['categoryId']}}" selected>{{$cate['categoryName']}}</option>
															@endif
															@else
																<option value="{{$cate['categoryId']}}">{{$cate['categoryName']}}</option>

													@endif
												@endif
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group">
									<label>Group <span id="required">*</span></label>
									@if(isset($department))
										<select class="form-control" name="group" id="group" onchange="load_employee(this.value)" tabindex="8">
											<option value="">Select Group</option>
											@foreach ($department as $data)
													@if($data['deptStatus']==1)
														@if(isset($ticketdata->ticketGroupId))
															@if($ticketdata->ticketGroupId==$data['deptId'])
															<option value="{{$data['deptId']}}" selected>{{$data['deptName']}}</option>
															@endif
															@else
																<option value="{{$data['deptId']}}">{{$data['deptName']}}</option>

													@endif
												@endif
											@endforeach
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
											<select class="form-control" name="employee" id="employee" tabindex="10">
												<option value="">Select Employee Name</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>Description <span id="required">*</span></label>
										<textarea class="form-control" rows="5" cols="45" name="description" id="description" tabindex="12" >@if(isset($ticketdata->ticketText)){{$ticketdata->ticketText}}
										@endif
										</textarea>
									</div>
									@if(isset($ticketdata->attachmentUrl))
										<div class="form-group">
											<a href="../../upload/tickets/@if(isset($ticketdata->attachmentUrl)){{$ticketdata->attachmentUrl}}@endif" target="_blank">
												<i class="fa fa-paperclip"></i>
												@if(isset($ticketdata->attachmentUrl)){{$ticketdata->attachmentUrl}}@endif
											</a>
										</div>
									@endif
									<div class="form-group">
										<label for="exampleInputFile">Attachment</label>
											<!--<script language="JavaScript">
												LoadValue(document.getElementById('ticket_attachment'));
											</script>-->
										<input type="file" name="ticket_attachment" id="ticket_attachment">
									</div>
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
<!--</body>-->
<script>
<script language="JavaScript">
	/*function LoadValue(frmAttachObj){
		frmAttachObj.value='C:\location\of\file.gif';
	}*/
 $(function () {
        //Add text editor
        $("#description").wysihtml5();
      });
</script>
@endsection

