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
			float:left;
		}
	</style>
	<script language="javascript">
		/*
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
		*/

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




            <div class="page page-core page-login" style="padding:0;">

                <div class="text-center"><h3 class="text-light text-white"><span class="text-lightred">F</span>ollowon CRM</h3></div>

                
				
				<div class="container w-720 p-15 bg-white mt-40 text-center" style="padding: 0px !important;">
				<div class="col-md-5" style="padding: 0px !important;">
					<img class="media-object img-responsive" src="{{asset('admin-lte/assets/images/crm-login-side.jpg')}}" alt="">
				</div>
				<div class="col-md-7 mt-20">
                    <h2 class="text-light text-greensea">Log In</h2>
					
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
								<?php
									//print"<pre>";
									//print_r($input);

									if((!empty($input['application'])) && (!empty($input['event']))){
								?>
										<script language="javascript">
											load_event(<?=$input['application']?>,<?=$input['event']?>);
										</script>
								<?php
									}
								?>
								
								<form action="" style="min-height: 335px;" method="POST" id="login-form" class="form-validation mt-20" novalidate="novalidate">
			                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
			                         <div class="form-group">
										
										<label class="control-label" style="float: left;">Application</label>
											<select class="form-control" name="application" id="application" onchange="load_event(this.value)">
												<option value="">Select Application</option>
												<?php
													if(!empty($app_data)){
														foreach($app_data as $app_val){
															$sel_app="";
															if((!empty($input['application'])) && (!empty($app_val->appId))){
																if($input['application'] == $app_val->appId){
																	$sel_app="selected";
																}
															}
												?>
															<option value="<?=(!empty($app_val->appId)?$app_val->appId:"")?>" <?=(!empty($sel_app)?$sel_app:"")?>><?=(!empty($app_val->appName)?$app_val->appName:"")?></option>
												<?php
														}
													}
												?>
											</select>
			                        </div>
									<div class="form-group">										
										<label class="control-label" style="float: left;">Select Event</label>
										<div id="event_div">		
											<select class="form-control" name="event" id="event">
												<option value="">Select Event</option>
											</select>
										</div>	
									</div>
			                        <div class="form-group">
			                                <input type="email" name="email" id="email" class="form-control underline-input" placeholder="E-Mail" value="<?=(!empty($input['email'])?$input['email']:"")?>">
			                        </div>
			                        <div class="form-group">
			                                <input type="password" class="form-control underline-input" name="password" id="password" placeholder="Password">
			                        </div>
			                        <div class="clearfix"></div>
			                        <div class="form-group" style="padding-top:10px;">
										<button type="submit" name="submit" value="Submit" class=" pull-left btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
											<!-- <input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary"> -->
												&nbsp;
											<!--<input type="reset" name="reset" id="reset" value="Reset" class="btn btn-primary">
												&nbsp;-->
										<a class="pull-right" href="{{asset('admin/forgotpassword')}}">Forgot Password</a>
			                        </div>
									
									  
												
											
			                    </form>
								
			                </div>
							<div class="clearfix"></div>
							<div class="col-md-12">
								<div class="bg-slategray lt wrap-reset">
									<div class="container-fluid">
										<div class="row">
											<div class="col-md-12">
												<strong>Copyright © 2016 <a href="#">Followon CRM</a>.</strong> All rights reserved.
											</div>
										</div>
									</div>
								</div>
			                </div>
			                </div>
			            </div>
			        </div>

			