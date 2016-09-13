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
	                    password: {
	                        required: true,
	                        minlength: 5
	                    },
	                    cpassword: {
							required: true,
							minlength: 5
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
	                    lastname: "Please enter your lastname",
	                    password: {
	                        required: "Please provide password",
	                        minlength: "Your password must be at least 5 characters long"
	                    },
	                    cpassword: {
							required: "Please provide confirm password",
							minlength: "Your password must be at least 5 characters long"
	                    },
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
                <div class="page page-forms-common">

                    <div class="pageheader">

                        <h2>Ticket Admin Management</h2>

                        <div class="page-bar">

                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="#"><i class="fa fa-home"></i> CRM</a>
                                </li>
                                <li>
                                    <a href="#">Ticket Admin Management</a>
                                </li>
                                <li>
                                    <a href="#">Add User</a>
                                </li>
                            </ul>

                        </div>
						<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
                    </div>
					
	<!-- tile -->
    <section class="tile">

				@if (session('userSuccess'))
					<div class="flash-message">
						<div class="alert alert-success">
							User created successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/view_user/')}}";}, 1000);
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
				 <!-- tile header -->
				<div class="tile-header dvd dvd-btm">
				<h1 class="custom-font"><strong>Create User</strong></h1>
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
						<form action="#" method="POST" id="register-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-6">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>First Name <span id="required">*</span></label>
									<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" tabindex="1">
								</div>
								<!--<hr class="line-dashed line-full"/>
								<div class="form-group">
									<label>Password <span id="required">*</span></label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password" tabindex="3">
								</div>-->
								 <hr class="line-dashed line-full"/>
								<div class="form-group">
									<label>E-Mail <span id="required">*</span></label>
									<input type="text" name="email" id="email" class="form-control" placeholder="E-Mail" tabindex="5">
								</div>
								 <hr class="line-dashed line-full"/>
								<div class="form-group">
									<label>Type <span id="required">*</span></label>
									<select class="form-control" name="type" id="type" tabindex="7">
										<?php
											$user_sel_type1="";
											$user_sel_type2="";
											$user_sel_type3="";
											if(!empty($input->userType)){
												if($input->userType==1){
													$user_sel_type1="selected";
												}
												elseif($input->userType==2){
													$user_sel_type2="selected";
												}
												elseif($input->userType==3){
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
										if(!empty($input->status)){
											if($input->status==1){
												$user_status_active="checked";
											}
											elseif($input->status==2){
												$user_status_inactive="checked";
											}
										}
										else{
											$user_status_inactive="checked";
										}
									?>
									<input type="radio" name="status" class="option-input radio" id="status" value="1" <?=(!empty($user_status_active)?$user_status_active:"")?> tabindex="7">&nbsp;Active
										&nbsp;
									<input type="radio" name="status" class="option-input radio" id="status" value="2" <?=(!empty($user_status_inactive)?$user_status_inactive:"")?>>&nbsp;In Active
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Last Name </label> <span id="required">*</span></label>
									<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" tabindex="2">
								</div>
								<!-- <hr class="line-dashed line-full"/>
								<div class="form-group">
									<label>Confirm Password <span id="required">*</span></label>
									<input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" tabindex="4">
								</div>-->
								 <hr class="line-dashed line-full"/>
								<div class="form-group">
									<label>Group <span id="required">*</span></label>
									<select class="form-control" name="group" id="group" tabindex="6">
										<option value="">Select Group</option>

										<?php
											if(!empty($department)){
												foreach($department as $depart){
													$sel_dept="";
													/*
													if((!empty($ticketdata->ticketGroupId)) && (!empty($depart['deptId']))){
														if($ticketdata->ticketGroupId == $depart['deptId']){
															$sel_dept="selected";
														}
													}
													*/
										?>
													<option value="<?=(!empty($depart['deptId'])?$depart['deptId']:"")?>" <?=(!empty($sel_dept)?$sel_dept:"")?>><?=(!empty($depart['deptName'])?$depart['deptName']:"")?></option>

										<?php
												}
											}
										?>
									</select>
								</div>
								 <hr class="line-dashed line-full"/>
								<div class="form-group">
									<label>Gender <span id="required">*</span></label>
									<select class="form-control" name="gender" id="gender" tabindex="8">
										<option value="">Select Gender</option>
										<option value="1">Male</option>
										<option value="2">Female</option>
									</select>
								</div>
							</div>
						<div class="box-footer">
							<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
							{!! HTML::link('admin/view_user', 'Cancel', array('class' => 'btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10')) !!}
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
</section>
</div>
@endsection


