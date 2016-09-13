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
							 app_url:"required",
							status: {
								required: true,
								notEqualTo: 20
							},
							description: "required"
						},
						messages: {
							app_name: "Please enter your app name",
							app_url:"Please enter your app url",
							status: "Please select status",
							description: "Please enter description"
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
				@if (session('AppUpdateSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							App Updated successfully
							           <script>
              window.setTimeout(function(){
window.location.href = "{{asset('/admin/list_app/')}}";
               }, 1000);
             </script>
						</div>
					</div>
				@endif
				@if (session('AppUpdateError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Unable to update App
						</div>
					</div>
				@endif
				<!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Edit/Update App</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						<form action="" method="PUT" id="ticket-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-8">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>App Name <span id="required">*</span></label>
									<input type="text" name="app_name" id="app_name" class="form-control" placeholder="App Name" value="@if(isset($editapp->appName)){{$editapp->appName}}@endif">
								</div>
								<div class="form-group">
									<label>App URL <span id="required">*</span></label>
									<input type="text" name="app_url" id="app_url" class="form-control" value="@if(isset($editapp->appUrl)){{$editapp->appUrl}}@endif">
								</div>
								<div class="form-group">
									<label>App Description <span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="description" id="description">@if(isset($editapp->appDesc)){{$editapp->appDesc}}@endif</textarea>
								</div>
							<div class="form-group">
								<label>List Of Events</label>
									<div style="clear:both"></div>
							
									@foreach ($eventdata as $data)
										@if(isset($data->eventId))
									<input type="checkbox" name="event_<?=(!empty($data->eventId)?$data->eventId:"")?>" id="services" value="<?=(!empty($data->eventId)?$data->eventId:"")?>" <?php foreach($checkedevent as $check){
									if(isset($check->eventId)){if(!empty($check->eventId==$data->eventId)){?> checked <?php }}
									}
									?>>
									<label>{{$data->eventName}} &nbsp;</label>
									
									@endif
									@endforeach
								</div>
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									
									@if(isset($editapp->appStatus))
										@if($editapp->appStatus==1)
											<input type="radio" name="status" id="status" value="1" checked>&nbsp;Active
											<input type="radio" name="status" id="status" value="2">&nbsp;In Active
										@elseif($editapp->appStatus==2)
											<input type="radio" name="status" id="status" value="1">&nbsp;Active
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


