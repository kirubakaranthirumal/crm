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
							template_name: "required",
							template_desc: "required",
							status: {
								required: true,
								notEqualTo: 20
							}
						},
						messages: {
							app_name: "Please enter your template name",
							app_name: "Please enter your template description",
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
						<form action="" method="PUT" id="ticket-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-8">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>Template Name <span id="required">*</span></label>
									<input type="text" name="template_name" id="template_name" class="form-control" placeholder="Template Name" value="@if(isset($email_template['templateName'])){{$email_template['templateName']}}@endif">
								</div>
								<div class="form-group">
									<label>Template Description<span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="template_desc" id="template_desc">@if(isset($email_template['templateDescription'])){{$email_template['templateDescription']}}@endif</textarea>
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


