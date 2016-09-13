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
	<script language="javascript">
		function load_event(id,event_id){

			var url_str = "appId="+id+"&eventId="+event_id;

			//alert(url_str);

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
<div class="page page-tables-datatables">
					<?php
						//echo $tab_id;
					?>
					@if (session('ticketUpdateSuccess'))
						<div class="flash-message">
							 <div class="alert alert-success">
								Ticket Updated successfully
								<script>
									window.setTimeout(function(){window.location.href = "{{asset('/my_tickets/')}}?tab_id=3";}, 2000);
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
					<section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Edit Ticket </strong></h1>
									<input type="hidden" name="ticket_assigned_userid" id="ticket_assigned_userid" value="@if(isset($ticketdata->ticketAssigneduserId)) {{$ticketdata->ticketAssigneduserId}} @endif" />
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
								
		
							<form action="#" method="PUT" name="ticket-form" id="ticket-form" class="form-horizontal" novalidate="novalidate" enctype= multipart/form-data>
								<input type="hidden" name="tab_id" id="tab_id" value="3">
								<div class="col-md-6">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="tab_id" id="tab_id" value="<?=($tab_id)?$tab_id:""?>">
									<div class="form-group">
										<label>Application <span id="required">*</span></label>
										<?php
											//print"<pre>";
											//print_r($ticketdata);

											$view_app_id = "";
											if(!empty($ticketdata->appId)){
												$view_app_id = $ticketdata->appId;
											}

											$view_event_id = "";
											if(!empty($ticketdata->eventId)){
												$view_event_id = $ticketdata->eventId;
											}

											//print"<pre>";
											//print_r($view_app_id);
											//print_r($view_event_id);
										?>
										<select class="form-control" name="application" id="application" onchange="load_event(this.value)">
											<option value="">Select Application</option>
												<?php
													if(!empty($app_data)){
														foreach($app_data as $app_val){
															$sel_app="";
															if((!empty($ticketdata->appId)) && (!empty($app_val->appId))){
																if($ticketdata->appId == $app_val->appId){
																	$sel_app="selected";
																}
															}
												?>
															<option value="<?=(!empty($app_val->appId)?$app_val->appId:"")?>" <?=(!empty($sel_app)?$sel_app:"")?>><?=(!empty($app_val->appName)?$app_val->appName:"")?></option>
												<?php
														}
													}
												?>
										</select>
									</div>
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
											<?php
												if(!empty($type)){
													foreach($type as $type_val){
														$sel_type="";
														if((!empty($ticketdata->type)) && (!empty($type_val['typeId']))){
															if($ticketdata->type == $type_val['typeId']){
																$sel_type="selected";
															}
														}
											?>
														<option value="<?=(!empty($type_val['typeId'])?$type_val['typeId']:"")?>" <?=(!empty($sel_type)?$sel_type:"")?>><?=(!empty($type_val['typeName'])?$type_val['typeName']:"")?></option>

											<?php
													}
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Ticket Source <span id="required">*</span></label>
										<select class="form-control" name="source" id="source">
											<option value="">Select Source</option>
											<?php
												if(!empty($source)){
													foreach($source as $source_val){
														$sel_source="";
														if((!empty($ticketdata->ticketSource)) && (!empty($source_val['sourceId']))){
															if($ticketdata->ticketSource == $source_val['sourceId']){
																$sel_source="selected";
															}
														}
											?>
														<option value="<?=(!empty($source_val['sourceId'])?$source_val['sourceId']:"")?>" <?=(!empty($sel_source)?$sel_source:"")?>><?=(!empty($source_val['sourceName'])?$source_val['sourceName']:"")?></option>

											<?php
													}
												}
											?>
										</select>
									</div>

									<div class="form-group">
										<label>Status <span id="required">*</span></label>
										<select class="form-control" name="status" id="status">
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

														
														
											?>
															<option value="<?=(!empty($status_val['statusId'])?$status_val['statusId']:"")?>" <?=(!empty($sel_stat)?$sel_stat:"")?>><?=(!empty($status_val['statusName'])?$status_val['statusName']:"")?></option>
											<?php
														
														
													}
												}
											?>
										</select>
									</div>
									
									<div class="form-group">
										<label>Deadline</label>
										<!--<input type="text" name="quantity" id="quantity" />-->
										<!--<input type="text" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->ticketDeadline)){{$ticketdata->ticketDeadline}}@endif" tabindex="5">-->
										<!--<input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->ticketDeadline)){{$ticketdata->ticketDeadline}}@endif" tabindex="5">-->
										<input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->deadlineHours)){{$ticketdata->deadlineHours}}@endif" tabindex="14">
										<!--<input type="number" min="0" step="1" max="24"/>-->
										&nbsp;<span id="errmsg"></span>
									</div>									
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<?php
											if(!empty($ticketdata->appId)){
										?>
											<script>
												load_event('<?=$ticketdata->appId?>','<?=$ticketdata->eventId?>');
											</script>
										<?php
											}
										?>
										<label>Event <span id="required">*</span></label>
										<div id="event_div">
											<select class="form-control" name="event" id="event">
												<option value="">Select Event</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label>Priority <span id="required">*</span></label>
										<select class="form-control" name="priority" id="priority">
											<option value="">Select Priority</option>
											<?php
												if(!empty($priority)){
													foreach($priority as $priority_val){
														$sel_priority="";
														if((!empty($ticketdata->priority)) && (!empty($priority_val['priorityId']))){
															if($ticketdata->priority == $priority_val['priorityId']){
																$sel_priority="selected";
															}
														}
											?>
														<option value="<?=(!empty($priority_val['priorityId'])?$priority_val['priorityId']:"")?>" <?=(!empty($sel_priority)?$sel_priority:"")?>><?=(!empty($priority_val['priorityName'])?$priority_val['priorityName']:"")?></option>

											<?php
													}
												}
											?>
										</select>
									</div>
									<div class="form-group">
									<label>Group <span id="required">*</span></label>
										<select class="form-control" name="group" id="group" onchange="load_employee(this.value)">
											<option value="">Select Group</option>
											<?php
												if(!empty($department)){
													foreach($department as $depart){
														$sel_dept="";
														if((!empty($ticketdata->ticketGroupId)) && (!empty($depart['deptId']))){
															if($ticketdata->ticketGroupId == $depart['deptId']){
																$sel_dept="selected";
															}
														}
											?>
														<option value="<?=(!empty($depart['deptId'])?$depart['deptId']:"")?>" <?=(!empty($sel_dept)?$sel_dept:"")?>><?=(!empty($depart['deptName'])?$depart['deptName']:"")?></option>

											<?php
													}
												}
											?>
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
									<!--<div class="form-group">
										<label>Description <span id="required">*</span></label>
										<textarea class="form-control" rows="5" cols="45" name="description" id="description" >@if(isset($ticketdata->ticketText)){{$ticketdata->ticketText}}
										@endif
										</textarea>
									</div>-->
									<div class="form-group">
										<label>Category <span id="required">*</span></label>
										<select class="form-control" name="category" id="category">
											<option value="">Select Category</option>
											<?php
												if(!empty($category)){
													foreach($category as $cate){
														$sel_cat="";
														if((!empty($ticketdata->ticketCatId)) && (!empty($cate['categoryId']))){
															if($ticketdata->ticketCatId == $cate['categoryId']){
																$sel_cat="selected";
															}
														}
											?>
														<option value="<?=(!empty($cate['categoryId'])?$cate['categoryId']:"")?>" <?=(!empty($sel_cat)?$sel_cat:"")?>><?=(!empty($cate['categoryName'])?$cate['categoryName']:"")?></option>

											<?php
													}
												}
											?>
										</select>
									</div>
									<div class="form-group" style="width: 99%;">
										
										<label>Attachment</label>
										<div class="input-group">
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
										<label>Description <span id="required">*</span></label>
										<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
										<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
										<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12" >@if(isset($ticketdata->ticketText)){{$ticketdata->ticketText}}@endif</textarea>
										<script>
											initSample();
										</script>
									</div>
								</div>
								<div style="clear:both">&nbsp;</div>
							<div class="box-footer">
							<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
								<!--<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
								<button type="submit" class="btn btn-primary">Submit New</button>
								&nbsp;<button type="button" class="btn btn-primary">Submit Close</button>
								&nbsp;<button type="reset" class="btn btn-primary">Reset</button>-->
							</div>
						</form>
						<div style="clear:both">&nbsp;</div>
					</div>
				</section><!-- /.box -->
			</div>

@endsection


