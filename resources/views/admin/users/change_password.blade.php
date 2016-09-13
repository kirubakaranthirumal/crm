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
							old_password:"required",
							new_password: "required"
						},
						messages: {
							old_password:"Please enter your old password",
							new_password: "Please enter your new password"
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
<div class="page page-tables-datatables">
				@if (session('ChangePasswordSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							{{session('ChangePasswordSuccess')}}
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/change_password/')}}/<?=$usrId?>";}, 1000);
							</script>
						</div>
					</div>
				@elseif (session('ChangePasswordError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							{{session('ChangePasswordError')}}
							<script language="javascript">
								//window.setTimeout(function(){window.location.href = "{{asset('/admin/change_password/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				<!-- general form elements -->

				<div class="col-md-6">

                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Change Password </strong>Form</h1>
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
								<form action="#" method="PUT" name="ticket-form" id="ticket-form" class="form-horizontal" novalidate="novalidate">
									<div class="col-md-12">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<!--<div class="form-group">
											<label>Email Address <span id="required">*</span></label>
											<input type="text" name="email" id="email" class="form-control" placeholder="Enter Your Email">
										</div>-->
										<div class="form-group">
											<label>Old Password <span id="required">*</span></label>
											<input type="password" name="old_password" id="old_password" class="form-control" >
										</div>
										<div class="form-group">
											<label>New Password <span id="required">*</span></label>
											<input type="password" name="new_password" id="new_password" class="form-control" >
										</div>

									</div>
								</div><!-- /.box-body -->
								<div class="box-footer" style="text-align: center;">
									<button type="submit" name="submit"  value="Change Password" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Change Password <i class="fa fa-key" aria-hidden="true"></i></button>
								</div>
							</form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div>

		</div>

@endsection


