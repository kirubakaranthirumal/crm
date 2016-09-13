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
	            $("#register-form").validate({
	                rules: {
	                    firstname: "required",
	                    lastname: "required",
	                    email: {
	                        required: true,
	                        email: true
	                    },
	                    gender: {
							required: true,
              				notEqualTo: 30
						},
						group: {
							required: true,
							notEqualTo: 30
						},
						type: {
							required: true,
							notEqualTo: 30
						},
						status: {
							required: true,
							notEqualTo: 30
						}
	                },
	                messages: {
	                    firstname: "Please enter your firstname",
	                    email: "Please enter a valid email address",
	                    gender: "Please select gender",
	                    group: "Please select group",
	                    type: "Please select type",
	                    status: "Please select status"
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
	#register-form label.error{
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
	<section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				@if (session('userUpdateSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							User Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/view_user/')}}";}, 2000);
							</script>
						</div>
					</div>
				@endif
				@if (session('userError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Email address already exist
						</div>
					</div>
				@endif
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Edit/Update User</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						<form action="" method="PUT" id="register-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-6">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>First Name <span id="required">*</span></label>
									<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" value="@if(isset($userdata->firstName)){{$userdata->firstName}}@endif" tabindex="1">
								</div>
								<div class="form-group">
									<label>E-Mail <span id="required">*</span></label>
									<input type="text" name="email" id="email" class="form-control" placeholder="E-Mail" value="@if(isset($userdata->email)){{$userdata->email}}@endif" tabindex="3">
								</div>
								
								<div class="form-group">
									<label>Type <span id="required">*</span></label>
									@if($id != $userdata->userId)
									<select  class="form-control" name="type" id="type" tabindex="5">
									@else
									<select disabled class="form-control" name="type" id="type" tabindex="5">
									@endif
										<option value="">Select Type</option>
										<?php
											$user_sel_type1="";
											$user_sel_type2="";
											$user_sel_type3="";
											if(!empty($userdata->userType)){
												if($userdata->userType==1){
													$user_sel_type1="selected";
												}
												elseif($userdata->userType==2){
													$user_sel_type2="selected";
												}
												elseif($userdata->userType==3){
													$user_sel_type3="selected";
												}
											}
											else{
												$user_sel_type1="selected";
											}
										?>
										<option value="1" <?=(!empty($user_sel_type1)?$user_sel_type1:"")?> >Admin</option>
										<option value="2" <?=(!empty($user_sel_type2)?$user_sel_type2:"")?> >Supervisor</option>
										<option value="3" <?=(!empty($user_sel_type3)?$user_sel_type3:"")?> >Employee</option>
									</select>
									
										
									
								</div>
								
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									<?php
										$user_status_active="";
										$user_status_inactive="";
										if(!empty($userdata->status)){
											if($userdata->status==1){
												$user_status_active="checked";
											}
											elseif($userdata->status==2){
												$user_status_inactive="checked";
											}
										}
										else{
											$user_status_inactive="checked";
										}
									?>
									<input type="radio" name="status" id="status" value="1" <?=(!empty($user_status_active)?$user_status_active:"")?> tabindex="7">&nbsp;Active
										&nbsp;
									<input type="radio" name="status" id="status" value="2" <?=(!empty($user_status_inactive)?$user_status_inactive:"")?>>&nbsp;In Active
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Last Name </label>
									<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="@if(isset($userdata->lastName)){{$userdata->lastName}}@endif" tabindex="2">
								</div>
								<div class="form-group">
									<label>Group <span id="required">*</span></label>
									@if($id != $userdata->userId)
									<select class="form-control" name="group" id="group" tabindex="4">
									@else
									<select disabled class="form-control" name="group" id="group" tabindex="4">	
									@endif
										<option value="">Select Group</option>
										<?php
											if(!empty($department)){
												foreach($department as $depart){
													$sel_dept="";
													if((!empty($userdata->groupId)) && (!empty($depart['deptId']))){
														if($userdata->groupId == $depart['deptId']){
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
								<div class="form-group">
									<label>Gender <span id="required">*</span></label>
									<select class="form-control" name="gender" id="gender" tabindex="6">
										@if(isset($userdata->gender))
											@if($userdata->gender==1)
												<option value="1" selected>Male</option>
												<option value="2">Female</option>
											@elseif($userdata->gender==2)
												<option value="1">Male</option>
												<option value="2" selected>Female</option>
											@else
												<option value="1">Male</option>
												<option value="2" selected>Female</option>
											@endif
										@else
											<option value="1">Male</option>
											<option value="2">Female</option>
										@endif
									</select>
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
</section>
@endsection


