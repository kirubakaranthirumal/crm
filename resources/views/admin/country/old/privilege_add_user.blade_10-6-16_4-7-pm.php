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
				@if (session('userSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							User created successfully
							<script>
								window.setTimeout(function(){
								window.location.href = "{{asset('/privilege_user_list/')}}";
								}, 2000);
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
						<h3 class="box-title">Create User </h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						<form action="" method="POST" id="register-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-6">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>First Name <span id="required">*</span></label>
									<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
								</div>
								<div class="form-group">
									<label>Password <span id="required">*</span></label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password">
								</div>
								<div class="form-group">
									<label>E-Mail <span id="required">*</span></label>
									<input type="text" name="email" id="email" class="form-control" placeholder="E-Mail">
								</div>
								<div class="form-group">
									<label>Type <span id="required">*</span></label>
									<select class="form-control" name="type" id="type">
										<option value="">Select Type</option>
										<option value="1">Admin</option>
										<option value="2">Supervisor</option>
										<option value="3" selected>Employee</option>
									</select>
								</div>
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									<input type="radio" name="status" id="status" value="1">&nbsp;Active
										&nbsp;
									<input type="radio" name="status" id="status" value="2" checked>&nbsp;In Active
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Last Name </label> <span id="required">*</span></label>
									<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
								</div>
								<div class="form-group">
									<label>Confirm Password <span id="required">*</span></label>
									<input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password">
								</div>
								<div class="form-group">
									<label>Group <span id="required">*</span></label>
									<select class="form-control" name="group" id="group">
										<option value="">Select Group</option>
										<option value="1">Tech Support</option>
										<option value="2">Network Support</option>
									</select>
								</div>
								<div class="form-group">
									<label>Gender <span id="required">*</span></label>
									<select class="form-control" name="gender" id="gender">
										<option value="">Select Gender</option>
										<option value="1">Male</option>
										<option value="2">Female</option>
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


