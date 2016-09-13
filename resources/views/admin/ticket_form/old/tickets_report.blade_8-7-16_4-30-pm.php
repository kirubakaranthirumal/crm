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
				@if(session('menuNameError'))
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
											<?php
												if(!empty($department)){
													foreach($department as $depart){
														$sel_dept="";
														if((!empty($post['group'])) && (!empty($depart['deptId']))){
															if($post['group'] == $depart['deptId']){
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
												<?php
													if(!empty($priority)){
														foreach($priority as $priority_val){
															$sel_priority="";
															if((!empty($post['priority'])) && (!empty($priority_val['priorityId']))){
																if($post['priority'] == $priority_val['priorityId']){
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
									</div>
								<div class="col-md-3">
									<div class="form-group">
										<label>Source</label>
										<select class="form-control" name="source" id="source">
											<option value="">Select Source</option>
												<?php
													if(!empty($source)){
														foreach($source as $source_val){
															$sel_source="";
															if((!empty($post['source'])) && (!empty($source_val['sourceId']))){
																if($post['source'] == $source_val['sourceId']){
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
								</div>

								</div>
								<div class="col-md-12">
								<div class="col-md-3">
									<div class="form-group">
										<label>Status <span id="required">*</span></label>
										<select class="form-control" name="status" id="status" >
											<option value="">Select Status</option>
											<?php
												if(!empty($status)){
													foreach($status as $status_val){
														$sel_stat="";
														if((!empty($post['status'])) && (!empty($status_val['statusId']))){
															if($post['status'] == $status_val['statusId']){
																$sel_stat="selected";
															}
														}

														//if((!empty($status_val['statusId'])) && ($status_val['statusId']!=7)){
											?>
															<option value="<?=(!empty($status_val['statusId'])?$status_val['statusId']:"")?>" <?=(!empty($sel_stat)?$sel_stat:"")?>><?=(!empty($status_val['statusName'])?$status_val['statusName']:"")?></option>
											<?php
														//}
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-3">
								  <div class="form-group">
									<label>App <span id="required">*</span></label>
									<select class="form-control" name="application" id="application" onchange="load_event(this.value)">
										<option value="">Select Application</option>
											<?php
												if(!empty($app_data)){
													foreach($app_data as $data){
														$sel_app="";
														if((!empty($post['application'])) && (!empty($data->appId))){
															if($post['application'] == $data->appId){
																$sel_app="selected";
															}
														}
											?>
														<option value="<?=(!empty($data->appId)?$data->appId:"")?>" <?=(!empty($sel_app)?$sel_app:"")?>><?=(!empty($data->appName)?$data->appName:"")?></option>

											<?php
													}
												}
											?>
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
											<?php
												if(!empty($category)){
													foreach($category as $cate){
														$sel_cat="";
														if((!empty($post['category'])) && (!empty($cate['categoryId']))){
															if($post['category'] == $cate['categoryId']){
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
								</div>
								</div>
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">
											<label>Start Date</label>

											<?php
												//print"<pre>";
												//print_r($inputArray);
												//exit;
											?>
											<input type="text" class="form-control" name="start_date" id="start_date" value="<?=(!empty($inputArray['start_date'])?$inputArray['start_date']:"")?>">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>End Date</label>
											<input type="text" class="form-control" name="end_date" id="end_date" value="<?=(!empty($inputArray['end_date'])?$inputArray['end_date']:"")?>">
										</div>
									</div>
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
								<input type="button" name="searchsubmit" id="searchsubmit" value="Filter" class="btn btn-primary">
								<!--<button type="submit" class="btn btn-primary">Filter</button>-->
								<button type="reset" id="reset" class="btn btn-primary">Reset</button>
							</div>
						</form>
              		</div>
              		<?php
						if(!empty($inputArray['group'])){
					?>
							<script>
								load_employee('<?=$inputArray['group']?>');
							</script>
					<?php
						}
					?>
					<?php
						//print"<pre>";
						//print_r($inputArray);
						if(!empty($ticketReportArray)){
					?>
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
														@if(isset($ticketdata['ticketId']))
															{{$ticketdata['ticketId']}}
														@endif
													</td>
													<td>
														@if(isset($ticketdata['requestorName']))
															{{$ticketdata['requestorName']}}
														@endif
													</td>
													<td>
														@if(isset($ticketdata['ticketSubject']))
															{{$ticketdata['ticketSubject']}}
														@endif
													</td>
													<td>
														@if(isset($ticketdata['status']))
															@if($ticketdata['status']==1)
																Open
															@endif
															@if($ticketdata['status']==2)
																Assigned
															@endif
															@if($ticketdata['status']==3)
																InProgress
															@endif
															@if($ticketdata['status']==4)
																Closed
															@endif
															@if($ticketdata['status']==5)
																Waiting On Customer
															@endif
															@if($ticketdata['status']==6)
																Waiting On 3rd Party
															@endif
														@endif
													</td>
													<td>
														@if(isset($ticketdata['priority']))
															@if($ticketdata['priority']==1)
																Low
															@elseif($ticketdata['priority']==2)
																Medium
															@elseif($ticketdata['priority']==3)
																High
															@elseif($ticketdata['priority']==4)
																Urgent
															@endif
														@endif
													</td>
													<td>
														@if(isset($ticketdata['createdOn']))
														  <?php
															  $date = date_create($ticketdata['createdOn']);
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
						<?php
							}
						?>
					</div><!-- /.box -->
					<script language="javascript">
						$(function(){
							$('#ticket_list').DataTable( {
								"aaSorting": [[ 5, "desc" ]],
								"aoColumnDefs" : [{
									'bSortable' : false,
									'aTargets' : [ 4 ]
								}]
							});
						});
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

							//if((group_val=='')&&(employee_val=='')&&(priority_val=='')&&(source_val=='')&&(status_val=='')&&(app=='')&&(event=='')&&(category=='')){
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
					<script language="javascript">
						document.getElementById('reset').onclick = function() {
							var priority = document.getElementById('priority');
							var group = document.getElementById('group');
							var employee = document.getElementById('employee');
							var source = document.getElementById('source');
							var status = document.getElementById('status');
							var category = document.getElementById('category');
							var start_date = document.getElementById('start_date');
							var end_date = document.getElementById('end_date');
							var application = document.getElementById('application');
							var event = document.getElementById('event');
							var start_date = document.getElementById('start_date');
							var end_date = document.getElementById('end_date');
							priority.selectedIndex = 0;
							group.selectedIndex = 0;
							employee.selectedIndex = 0;
							source.selectedIndex = 0;
							status.selectedIndex = 0;
							category.selectedIndex = 0;
							start_date.selectedIndex = 0;
							end_date.selectedIndex = 0;
							application.selectedIndex = 0;
							event.selectedIndex = 0;
							start_date.selectedIndex = 0;
							end_date.selectedIndex = 0;
							return false;
						}
					</script>

@endsection


