<script language="javascript">



	(function($,W,D){
		var JQUERY4U = {};

		JQUERY4U.UTIL =
		{
			setupFormValidation: function()
			{
				//form validation rules
				$("#quick_assign_ticket_form").validate({
					rules: {
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

	#quick_assign_ticket_form label.error{
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
	<form method="POST" id="quick_assign_ticket_form" name="quick_assign_ticket_form" novalidate="novalidate">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="ticket_id" id="ticket_id" value="{{$ticketId}}">
		<input type="hidden" name="requester_email" id="requester_email" value="{{$ticketdata->portalUserEmailId}}">
		<input type="hidden" name="requester_name" id="requester_name" value="{{$ticketdata->requestorName}}">
		<div class="box-body">
			<div class="form-group">
				<label>Group <span id="required">*</span></label>
				<select class="form-control" name="group" id="group" onchange="load_assign_employee(this.value)" tabindex="8">
					<option value="">Select Group</option>
					@if(!empty($department))
						@foreach($department as $depart)					
							<option value="<?=(!empty($depart['deptId'])?$depart['deptId']:"")?>" ><?=(!empty($depart['deptName'])?$depart['deptName']:"")?></option>
						@endforeach
					@endif
				</select>
			</div>
			<div class="form-group">
				<label>Assign Employee <span id="required">*</span></label>
				<div id="assign_employee_div">
					<select class="form-control" name="employee" id="employee" tabindex="10">
						<option value="">Select Employee Name</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label>Deadline</label>
				<input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="@if(isset($ticketdata->deadlineHours)){{$ticketdata->deadlineHours}}@endif" tabindex="14">
				&nbsp;<span id="errmsg"></span>
			</div>			
		</div>
		<div class="modal-footer">
			<button type="submit" name="submit" value="Assign Ticket" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
			<button type="button" class="btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal" aria-hidden="true">Cancel</button>
		</div>
	</form>