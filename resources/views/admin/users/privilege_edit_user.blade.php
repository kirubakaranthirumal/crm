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
<div class="page page-tables-datatables">
				@if (session('userUpdateSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							User Updated Successfully
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
				<div class="col-md-12">

                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Edit/Update User </strong></h1>
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


						<form action="#" method="PUT" id="register-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-6">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>First Name <span id="required">*</span></label>
									<input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name" value="@if(isset($userdata->firstName)){{$userdata->firstName}}@endif">
								</div>
								<!--<div class="form-group">
									<label>Password <span id="required">*</span></label>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password" value="@if(isset($userdata->password)){{$userdata->password}}@endif">
								</div>-->
								<div class="form-group">
									<label>E-Mail <span id="required">*</span></label>
									<input type="text" name="email" id="email" class="form-control" placeholder="E-Mail" value="@if(isset($userdata->email)){{$userdata->email}}@endif">
								</div>
								<div class="form-group">
									<label>Type <span id="required">*</span></label>
									<select class="form-control" name="type" id="type">
										<option value="">Select Type</option>
										@if(isset($userdata->userType))
											@if($userdata->userType==1)
												<option value="1" selected>Admin</option>
												<option value="2">Supervisor</option>
												<option value="3">Employee</option>
											@elseif($userdata->userType==2)
												<option value="1">Admin</option>
												<option value="2" selected>Supervisor</option>
												<option value="3">Employee</option>
											@elseif($userdata->userType==3)
												<option value="1">Admin</option>
												<option value="2">Supervisor</option>
												<option value="3" selected>Employee</option>
											@endif
										@endif
									</select>
								</div>
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									@if(isset($userdata->status))
										@if($userdata->status==1)
											<input type="radio" class="option-input radio" name="status" id="status" value="1" checked>&nbsp;Active
												&nbsp;
											<input type="radio" class="option-input radio" name="status" id="status" value="2">&nbsp;In Active
										@elseif($userdata->status==2)
											<input type="radio" class="option-input radio" name="status" id="status" value="1">&nbsp;Active
												&nbsp;
											<input type="radio" class="option-input radio" name="status" id="status" value="2" checked>&nbsp;In Active
										@else
											<input type="radio" class="option-input radio" name="status" id="status" value="1">&nbsp;Active
												&nbsp;
											<input type="radio" class="option-input radio" name="status" id="status" value="2" checked>&nbsp;In Active
										@endif
									@endif

								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Last Name </label>
									<input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name" value="@if(isset($userdata->lastName)){{$userdata->lastName}}@endif">
								</div>
								<!--<div class="form-group">
									<label>Confirm Password <span id="required">*</span></label>
									<input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password">
								</div>-->
								<div class="form-group">
									<label>Group <span id="required">*</span></label>
									<select class="form-control" name="group" id="group">
										<option value="">Select Group</option>
										@if(isset($userdata->groupId))
											@if($userdata->groupId==1)
												<option value="1" selected>Tech Support</option>
												<option value="2">Network Support</option>
											@elseif($userdata->groupId==2)
												<option value="1">Tech Support</option>
												<option value="2" selected>Network Support</option>
											@endif
										@endif
									</select>
								</div>
								<div class="form-group">
									<label>Gender <span id="required">*</span></label>
									<select class="form-control" name="gender" id="gender">
										@if(isset($userdata->gender))
											@if($userdata->gender==1)
												<option value="1" selected>Male</option>
												<option value="2">Female</option>
											@elseif($userdata->gender==2)
												<option value="1">Male</option>
												<option value="2" selected>Female</option>
											@endif
										@endif
									</select>
								</div>
							</div>
						</div><!-- /.box-body -->
						<div style="clear:both">&nbsp;</div>
						<div class="box-footer col-md-12">
							<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
					</section>
				</div>
			</div><!-- /.box -->

@endsection


