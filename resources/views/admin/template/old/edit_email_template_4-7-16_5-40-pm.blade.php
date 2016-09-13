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
							template_category: {
								required: true,
								notEqualTo: 20
							},
							template_name: "required",
							template_desc: "required",
							template_from: "required",
							template_subject: "required",
							template_user_field: "required",
							template_body: "required",
							template_status: {
								required: true,
								notEqualTo: 20
							}
						},
						messages: {
							template_category: "Please select template category",
							template_name: "Please enter your template name",
							template_desc: "Please enter your template description",
							template_from: "Please enter your template from",
							template_subject: "Please enter your template subject",
							template_user_field: "Please enter your template field",
							template_body: "Please enter your template body",
							template_status: "Please select status"
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
	<script type="text/javascript">
		function fn_set_selected_field(objFrm,fldval){
			//alert(objFrm);
			//alert(fldval);
			objFrm.template_merged_fld_val.value=fldval;
			//objFrm.submit();
		}
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
				@if (session('templateUpdSuc'))
					<div class="flash-message">
						 <div class="alert alert-success">
							Template updated successfully
							<script>
             				 window.setTimeout(function(){window.location.href = "{{asset('/admin/list_template/')}}";}, 2000);
           				  </script>
						</div>
					</div>
				@endif
				@if (session('AppError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Unable to update template
						<!--	<script>
              window.setTimeout(function(){
		window.location.href = "{{asset('/admin/create_app/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif";
               }, 2000);
             </script>-->
						</div>
					</div>
				@endif
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Edit/Update Template</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						<?php
							//print"<pre>";
							//print_r($email_template);
							//print"<hr>";
							//print_r($template_category);
							//exit;
						?>
						<form action="" method="PUT" id="ticket-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-8">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Category Type <span id="required">*</span></label>
									<select class="form-control" name="template_category" id="template_category">
										<option value="">Select Category Type</option>
										@if(isset($template_category))
											@foreach($template_category as $data)
												@if(isset($email_template['templateCatId']))
													@if($email_template['templateCatId'] == $data['varCatId'])
														<option value="{{$data['varCatId']}}" selected>{{$data['varCatName']}}</option>
													@else
														<option value="{{$data['varCatId']}}">{{$data['varCatName']}}</option>
													@endif
												@else
													<option value="{{$data['varCatId']}}">{{$data['varCatName']}}</option>
												@endif
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group">
									<label>Template Name <span id="required">*</span></label>
									<input type="text" name="template_name" id="template_name" class="form-control" placeholder="Template Name" value="@if(isset($email_template['templateName'])){{$email_template['templateName']}}@endif">
								</div>
								<div class="form-group">
									<label>Template Description<span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="template_desc" id="template_desc">@if(isset($email_template['templateDescription'])){{$email_template['templateDescription']}}@endif</textarea>
								</div>
								<div class="form-group">
									<label>From <span id="required">*</span></label>
									<input type="text" name="template_from" id="template_from" class="form-control" placeholder="From" value="@if(isset($email_template['templateFrom'])){{$email_template['templateFrom']}}@endif">
								</div>
								<div class="form-group">
									<label>Subject <span id="required">*</span></label>
									<input type="text" name="template_subject" id="template_subject" class="form-control" placeholder="Subject" value="@if(isset($email_template['templateSubject'])){{$email_template['templateSubject']}}@endif">
								</div>
								<div class="box box-primary">
									<div class="box-body box-profile">
										<div style="border:0px solid red;float:left;width:100%;">
											<div style="border:0px solid red;float:left;width:100%;">
												<label>Field <span id="required">*</span></label>
												<select class="form-control" name="template_user_field" id="template_user_field" onchange="fn_set_selected_field(this.form,this.value)">
													<option value="">Select Field</option>
													@if(isset($email_template['templateUserField']))
														@if($email_template['templateUserField'] == 1)
															<option value="1" selected>First name</option>
															<option value="2">Last Name</option>
															<option value="3">E-Mail</option>
														@elseif($email_template['templateUserField'] == 2)
															<option value="1">First name</option>
															<option value="2" selected>Last Name</option>
															<option value="3">E-Mail</option>
														@elseif($email_template['templateUserField'] == 3)
															<option value="1">First name</option>
															<option value="2">Last Name</option>
															<option value="3" selected>E-Mail</option>
														@endif
													@else
														<option value="1">First name</option>
														<option value="2">Last Name</option>
														<option value="3">E-Mail</option>
													@endif
												</select>
											</div>
										</div>
										<!--<div style="border:0px solid red;float:left;width:100%;clear:both;">&nbsp;</div>-->
										<div style="border:0px solid red;float:left;width:100%;" id="">
											<input type="hidden" name="template_merged_fld_val" id="template_merged_fld_val" class="form-control" value="@if(isset($email_template['templateMergedFldVal'])){{$email_template['templateMergedFldVal']}}@endif">
										</div>
										<div style="border:0px solid red;float:left;width:100%;clear:both;">&nbsp;</div>
										<div style="border:0px solid red;float:left;width:100%;">
											<label>Body <span id="required">*</span></label>
											<textarea class="form-control" rows="5" cols="45" name="template_body" id="template_body">@if(isset($email_template['templateBody'])){{$email_template['templateBody']}}@endif</textarea>
										</div>
										<div style="border:0px solid red;float:left;width:100%;clear:both;">&nbsp;</div>
									</div><!-- /.box-body -->
								</div>
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									<!--templateStatus-->
									@if(isset($email_template['templateStatus']))
										@if($email_template['templateStatus']==1)
											<input type="radio" name="status" id="status" value="1" checked>&nbsp;Active
												&nbsp;
											<input type="radio" name="status" id="status" value="2">&nbsp;In Active
										@elseif($email_template['templateStatus']==2)
											<input type="radio" name="status" id="status" value="1">&nbsp;Active
												&nbsp;
											<input type="radio" name="status" id="status" value="2" checked>&nbsp;In Active
										@else
											<input type="radio" name="status" id="status" value="1">&nbsp;Active
												&nbsp;
											<input type="radio" name="status" id="status" value="2" checked>&nbsp;In Active
										@endif
									@endif
								</div>

							</div>
						</div><!-- /.box-body -->
						<div class="box-footer">
							<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection


