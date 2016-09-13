@include('admin.partials.header')
	<script src="{{asset('/admin-lte/dist/js/jquery.min.js')}}"></script>
	<script src="{{asset('/admin-lte/dist/js/jquery.validate.min.js')}}"></script>
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
		            $("#login-form").validate({
		                rules: {
		                    email: {
		                        required: true,
		                        email: true
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
		#login-form label.error{
		    color: #FB3A3A;
		    display: inline-block;
		    //margin: 4px 0 5px 125px;
		    padding: 0;
		    text-align: left;
		    width: 250px;
		}
	</style>
	<script language="javascript">
		function load_event(id,event_id){

			var url_str = "appId="+id+"&eventId="+event_id;

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
<div id="wrap" class="animsition">

            <div class="page page-core page-login">

                <div class="text-center"><h3 class="text-light text-white"><span class="text-lightred">F</span>ollow On CRM</h3></div>

                <div class="container w-420 p-15 bg-white mt-40 text-center">

                    <h2 class="text-light text-greensea">Forgot Password?</h2>

			                	@if(session('ForgotPasswordSuccess'))
									<div class="flash-message">
										<div class="alert alert-success">
											Password Sent successfully
											<script language="javascript">
												window.setTimeout(function(){window.location.href = "{{asset('/admin/forgotpassword/')}}";}, 1000);
											</script>
										</div>
									</div>
								@endif
								@if(session('ForgotPasswordError'))
									<div class="flash-message">
										 <div class="alert alert-danger">
											Unable to Change Password
										</div>
									</div>
								@endif
						
								<form action="" method="POST" id="login-form" class="form-validation mt-20" novalidate="novalidate">
			                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
			                        <div class="form-group">
			                                <input type="email" placeholder="Email" name="email" id="email" class="form-control underline-input" value="<?=(!empty($input['email'])?$input['email']:"")?>">
			                        </div>

									 <div class="bg-slategray lt wrap-reset mt-40 text-left">
										<p class="m-0">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
											<a class="btn btn-lightred b-0 text-uppercase pull-right" href="{{asset('admin/login_user')}}">Back To Login</a>
										</p>
									</div>
			                    </form>
								<div style="clear:both;">&nbsp;</div>
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-8 col-md-offset-2">
											<strong>Copyright © 2016 <a href="#">Follow On CRM</a>.</strong> All rights reserved.
										</div>
									</div>
								</div>
			                </div>
			            </div>
			        </div>
			  
			