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
							app_name: "required",
							status: {
								required: true,
								notEqualTo: 20
							},
							editor: "required"
						},
						messages: {
							app_name: "Please enter your App name",
							status: "Please select status",
							editor: "Please enter description"
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
<div class="page">
<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
<div class="page page-tables-datatables">

				<?php
					$page_app_id="";
					if(!empty($app_id)){
						$page_app_id = $app_id;
					}
				?>
				@if (session('ServiceUpdateSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							Service Updated successfully
							<script>
						  window.setTimeout(function(){
							 window.setTimeout(function(){window.location.href = "{{asset('/admin/service_all_list/')}}";}, 1000);
						   }, 1000);
						 </script>
						</div>
					</div>
				@endif
				@if (session('ServiceUpdateError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Unable to update service
						</div>
					</div>
				@endif
				<div class="col-md-9">

					<!-- tile -->
					<section class="tile">

						<!-- tile header -->
						<div class="tile-header dvd dvd-btm">
							<h1 class="custom-font"><strong>Edit/Update </strong>Service</h1>
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

						<!-- form start -->
						<form action="#" method="PUT" id="ticket-form" class="form-horizontal" novalidate="novalidate">
							<!--<input type="hidden" name="app_id" id="app_id" class="form-control" value="<?=(!empty($page_app_id)?$page_app_id:"")?>">-->
							<div class="col-md-12">
								<!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
						<!--<div class="form-group">

									<label>App Name <span id="required">*</span></label>
								<select class="form-control" name="app_name" id="app_name">
									<option value="">Select App Name</option>
										@if((isset($eventdata->appId)) && (isset($eventdata->appName)))
											<option value="{{$eventdata->appId}}" selected>{{$eventdata->appName}}</option>
										@endif
								</select>
								</div>-->
								<div class="form-group">
									<label>Service Name <span id="required">*</span></label>
									<input type="text" name="service_name" id="service_name" class="form-control"  value="@if(isset($editservice->serviceName)){{$editservice->serviceName}}@endif">
								</div>
								<!--<div class="form-group">
									<label>Service Description <span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="description" id="description">@if(isset($editservice->description)){{$editservice->description}}@endif</textarea>
								</div>-->
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									<?php
										$active_status="";
										$inactive_status="";
										if(!empty($editservice->status)){
											if($editservice->status==1){
												$active_status="checked";
											}
											elseif($editservice->status==2){
												$inactive_status="checked";
											}
										}
										else{
											$inactive_status="checked";
										}
									?>
									<input type="radio" class="option-input radio" name="status" id="status" value="1" <?=(!empty($active_status)?$active_status:"")?> >&nbsp;Active
									<input type="radio" class="option-input radio" name="status" id="status" value="2" <?=(!empty($inactive_status)?$inactive_status:"")?> >&nbsp;In Active
								</div>

								<div class="form-group">
									<label>Service Description <!--<span id="required">*</span></label>-->
									<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
									<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
									<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12">@if(isset($editservice->description)){{$editservice->description}}@endif</textarea>
									<script>
										initSample();
									</script>
								</div>
							</div>
						<div class="box-footer">
						<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
						{!! HTML::link('admin/service_all_list', 'Cancel', array('class' => 'btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10')) !!}
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</section>
		</div>
	</div>
@endsection


