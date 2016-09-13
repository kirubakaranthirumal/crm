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
		                    },
		                    password: {
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
		<div style="margin-top:5%;"></div>
		<div class="container-fluid">
			<div style="margin-top: 10%;"></div>
			<div class="container-fluid">
			    <div class="row">
			    	<div class="col-md-8 col-md-offset-2">
			            <div class="panel panel-default">
			                <div class="panel-heading"><b>Follow On CRM Login</b></div>
			                <div class="panel-body">
			                	@if (session('userTypeError'))
									<div class="flash-message">
										 <div class="alert alert-danger">
											{{session('userTypeError')}}
										</div>
									</div>
								@endif
			                	@if (session('loginError'))
									<div class="flash-message">
										 <div class="alert alert-danger">
											User Does not Exist
										</div>
									</div>
								@endif
								<form action="" method="POST" id="login-form" class="form-horizontal" novalidate="novalidate">
			                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
			                         <div class="form-group">
										<label class="col-md-4 control-label">Application</label>
										<div class="col-md-6">
											<select class="form-control" name="application" id="application" onchange="load_event(this.value)">
												<option value="">Select Application</option>
													@if(isset($app_data))
														@foreach ($app_data as $data)
															@if((isset($data->appId)) && (isset($data->appName)))
																<option value="{{$data->appId}}">{{$data->appName}}</option>
															@endif
														@endforeach
													@endif
											</select>
										</div>
			                        </div>
									<div class="form-group">
										<label class="col-md-4 control-label">Select Event</label>
										<div class="col-md-6" id="event_div">
											<select class="form-control" name="event" id="event">
												<option value="">Select Event</option>
											</select>
										</div>
									</div>
			                        <div class="form-group">
			                            <label class="col-md-4 control-label">E-Mail <span id="required">*</span></label>
			                            <div class="col-md-6">
			                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="col-md-4 control-label">Password <span id="required">*</span></label>
			                            <div class="col-md-6">
			                                <input type="password" class="form-control" name="password" id="password">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <div class="col-md-6 col-md-offset-4">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
			                            </div>
			                        </div>
			                    </form>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<strong>Copyright © 2016 <a href="#">Follow On CRM</a>.</strong> All rights reserved.
					</div>
				</div>
			</div>