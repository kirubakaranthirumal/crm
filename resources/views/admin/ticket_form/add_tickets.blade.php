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
							editor: "required"
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
							editor: "Please enter description"
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
			border-radius: 2px;
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
<div class="page page-forms-common">
	<div class="pageheader">
		<h2>Create Ticket</h2>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="#"><i class="fa fa-home"></i> CRM</a>
				</li>
				<li>
					<a href="#">Tickets Management</a>
				</li>
				<li>
					<a href="#">Create Ticket</a>
				</li>
			</ul>
		</div>
		<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
	</div>
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
				 <!-- tile -->
				<section class="tile">

					<!-- tile header -->
					<div class="tile-header dvd dvd-btm">
						<h1 class="custom-font"><strong>Create</strong> Ticket</h1>
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
						<form action="#" method="POST" id="ticket-form" class="form-horizontal" novalidate="novalidate" enctype= multipart/form-data>
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
										<?php
											if(!empty($status)){
												foreach($status as $status_val){
													$sel_stat="";
													if((!empty($ticketdata->status)) && (!empty($status_val['statusId']))){
														if($ticketdata->status == $status_val['statusId']){
															$sel_stat="selected";
														}
													}

													if((!empty($status_val['statusId'])) && ($status_val['statusId']!=7)){
														//if((!empty($status_val['statusId'])) && ($status_val['statusId']!=1)){
										?>
															<option value="<?=(!empty($status_val['statusId'])?$status_val['statusId']:"")?>" <?=(!empty($sel_stat)?$sel_stat:"")?>><?=(!empty($status_val['statusName'])?$status_val['statusName']:"")?></option>
										<?php
														//}
													}
												}
											}
										?>
									</select>
								</div>
								<!--<div class="form-group">
									<label>Deadline</label>
									<input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->ticketDeadline)){{$ticketdata->ticketDeadline}}@endif" tabindex="5">
									&nbsp;<span id="errmsg"></span>
								</div>-->
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
									<label>Deadline</label>
									<input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->ticketDeadline)){{$ticketdata->ticketDeadline}}@endif" tabindex="5">
									<span id="errmsg"></span>
								</div>
								<!--<div class="form-group">
									<label>Description <span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="description" id="description" tabindex="12"></textarea>
								</div>-->
								<div class="form-group">
									<label for="exampleInputFile">Attachment</label>
									<!-- <input type="file" name="ticket_attachment" id="ticket_attachment" tabindex="14"> -->
									<div class="input-group" style="width: 96%;">
										<label class="input-group-btn">
											<span class="btn btn-primary">
												Choose file&hellip; <input type="file" style="display: none;" multiple>
											</span>
										</label>
										<input type="text" name="ticket_attachment" id="ticket_attachment" tabindex="14" class="form-control" readonly>
									</div>

								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label>Description</label> <span id="required">*</span>
									<textarea placeholder="Description" rows="2" col="3" name="editor" id="editor" class="form-control"></textarea>
									<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
									<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
									<!--<div class="adjoined-bottom">
										<div class="grid-container">
											<div class="grid-width-100">
												<div id="editor">
													<h1>Hello world!</h1>
													<p>I'm an instance of <a href="http://ckeditor.com">CKEditor</a>.</p>
												</div>
											</div>
										</div>
									</div>-->
									<script>
										initSample();
									</script>
								</div>
							</div>
						<div class="box-footer">
							<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
							{!! HTML::link('admin/view_tickets', 'Cancel', array('class' => 'btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10')) !!}
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
				</section>
	</div><!-- /.box -->

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

		$(function() {

		  // We can attach the `fileselect` event to all file inputs on the page
		  $(document).on('change', ':file', function() {
			var input = $(this),
				numFiles = input.get(0).files ? input.get(0).files.length : 1,
				label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			input.trigger('fileselect', [numFiles, label]);
		  });

		  // We can watch for our custom `fileselect` event like this
		  $(document).ready( function() {
			  $(':file').on('fileselect', function(event, numFiles, label) {

				  var input = $(this).parents('.input-group').find(':text'),
					  log = numFiles > 1 ? numFiles + ' files selected' : label;

				  if( input.length ) {
					  input.val(log);
				  } else {
					  if( log ) alert(log);
				  }

			  });
		  });

		});
	</script>
</section>
@endsection


