<script language="javascript">

	(function($,W,D){
		var JQUERY4U = {};

		JQUERY4U.UTIL =
		{
			setupFormValidation: function()
			{
				//form validation rules
				$("#create_mail_ticket_form").validate({
					rules: {
						application: {
							required: true
						},
						event: {
							required: true
						},
						type: {
							required: true
						},
						category: {
							required: true
						},						
						group: {
							required: true
						},
						employee: {
							required: true
						},
						deadline:{
							required: true
						}
					},
					messages: {
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

	#create_mail_ticket_form label.error{
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

	<form method="POST" id="create_mail_ticket_form" name="create_mail_ticket_form" class="form-horizontal" novalidate="novalidate" enctype= multipart/form-data>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="requester_email" value="{{ $mailnotify->fromAddress }}">
		<input type="hidden" name="subject" value="{{ $mailnotify->subjectLine }}">
		<input type="hidden" name="source" value="{{ $mailnotify->source }}">
		<input type="hidden" name="priority" value="{{ $mailnotify->priority }}">
		<input type="hidden" name="status" value="{{ $mailnotify->status }}">
		<input type="hidden" name="requester_name" value="{{ $mailnotify->fromAddress }}">
		<input type="hidden" name="editor" value="{{ $mailnotify->detailContent }}">
		<input type="hidden" name="email_notify_id" value="{{ $mailnotify->emailNId }}">

		<div class="col-md-6">
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
				<label>Type <span id="required">*</span></label>
				<select class="form-control" name="type" id="type" tabindex="3" >
					<option value="">Select Type</option>
					@foreach($type as $types)
					@if($types['typeStatus']==1)
					<option value="{{$types['typeId']}}">{{$types['typeName']}}</option>
					@endif
					@endforeach
				</select>
			</div>
		
			<div class="form-group">
				<label>Group <span id="required">*</span></label>
					@if(isset($department))
				<select class="form-control" name="group" id="group" onchange="load_assign_employee(this.value)" tabindex="5">
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
				<label>Deadline</label>
				<input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->ticketDeadline)){{$ticketdata->ticketDeadline}}@endif" tabindex="7">
				<span id="errmsg"></span>
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
				<label>Category <span id="required">*</span></label>
					@if(isset($category))
				<select class="form-control" name="category" id="category" tabindex="4">
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
				<label>Assign Employee <span id="required">*</span></label>
				<div id="assign_employee_div">
					<select class="form-control" name="employee" id="employee" tabindex="6">
						<option value="">Select Employee Name</option>
					</select>
				</div>
				<span id="errmsg"></span>
			</div>
			<div class="form-group">
			</div>

		</div>
		<div class="modal-footer">
			<button type="submit" name="submit" value="Create Ticket" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
			<button type="button" class="btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal" aria-hidden="true">Cancel</button>
		</div>		
	</form>