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
							editor: "required",
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
							editor: "Please enter your template body",
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
<div class="pageheader">
	<h2>Create Template</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Settings</a>
			</li>
			<li>
				<a href="#">E-Mail Template</a>
			</li>
			<li>
				<a href="#">Create Template</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
				@if (session('templateSuc'))
					<div class="flash-message">
						 <div class="alert alert-success">
							Templated created successfully
							<script>
								window.setTimeout(function(){window.location.href = "{{asset('/admin/list_template/')}}";}, 2000);
							</script>
						</div>
					</div>
				@endif
				@if (session('AppError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Unable to create template
							<!--<script>window.setTimeout(function(){window.location.href = "{{asset('/admin/create_app/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif";
							}, 1000);
							</script>-->
						</div>
					</div>
				@endif
				<div class="col-md-9">
				<section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Create </strong>Template</h1>
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

						<form action="#" method="POST" id="ticket-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-12">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Category Type <span id="required">*</span></label>
									<select class="form-control" name="template_category" id="template_category">
										<option value="">Select Category Type</option>
										@if(isset($template_category))
											@foreach($template_category as $data)
												@if((isset($data['varCatId'])) && (isset($data['varCatName'])))
													<option value="{{$data['varCatId']}}">{{$data['varCatName']}}</option>
												@endif
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group">
									<label>Template Name <span id="required">*</span></label>
									<input type="text" name="template_name" id="template_name" class="form-control" placeholder="Template Name">
								</div>
								<div class="form-group">
									<label>Template Description<span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="template_desc" id="template_desc"></textarea>
								</div>
								<!--<div class="form-group">
									<label>Template Description <span id="required">*</span></label>
									<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
									<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
									<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12"></textarea>
									<script>
										initSample();
									</script>
								</div>-->
								<div class="form-group">
									<label>From <span id="required">*</span></label>
									<input type="text" name="template_from" id="template_from" class="form-control" placeholder="From">
								</div>
								<div class="form-group">
									<label>Subject <span id="required">*</span></label>
									<input type="text" name="template_subject" id="template_subject" class="form-control" placeholder="Subject">
								</div>
								<div class="form-group box box-primary">
									<div class="box-body box-profile">
										<div style="border:0px solid red;float:left;width:100%;">
											<div style="border:0px solid red;float:left;width:100%;">
												<label>Field <span id="required">*</span></label>
												<select class="form-control" name="template_user_field" id="template_user_field" onchange="fn_set_selected_field(this.form,this.value)">
													<option value="">Select Field</option>
													<option value="1">First name</option>
													<option value="2">Last Name</option>
													<option value="3">E-Mail</option>
												</select>
											</div>
										</div>
										<!--<div style="border:0px solid red;float:left;width:100%;clear:both;">&nbsp;</div>-->
										<div style="border:0px solid red;float:left;width:100%;" id="">
											<input type="hidden" name="template_merged_fld_val" id="template_merged_fld_val" class="form-control" value="">
										</div>
										<div style="border:0px solid red;float:left;width:100%;clear:both;">&nbsp;</div>
										<!--<div style="border:0px solid red;float:left;width:100%;">
											<label>Body <span id="required">*</span></label>
											<textarea class="form-control" rows="5" cols="45" name="template_body" id="template_body"></textarea>
										</div>-->
										<div style="border:0px solid red;float:left;width:100%;" id="">
											<label>Body<!-- <span id="required">*</span>--></label>
											<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
											<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
											<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12"></textarea>
											<script>
												initSample();
											</script>
										</div>
										<div style="border:0px solid red;float:left;width:100%;clear:both;">&nbsp;</div>
									</div><!-- /.box-body -->
								</div>
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									<input type="radio" class="option-input radio" name="template_status" id="template_status" value="1">&nbsp;Active
										&nbsp;
									<input type="radio" class="option-input radio" name="template_status" id="template_status" value="2" checked>&nbsp;In Active
								</div>
							</div>
						<div class="box-footer">
							<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
							{!! HTML::link('admin/list_template', 'Cancel', array('class' => 'btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10')) !!}
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</section>
		</div>
		</div>

@endsection


