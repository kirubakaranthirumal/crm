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
							app_url: "required",
							status: {
								required: true,
								notEqualTo: 20
							},
							editor: "required"
						},
						messages: {
							app_name: "Please enter your application name",
							app_name: "Please enter your application URL",
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

	<script language="javascript">
		function load_employee(id){

			var url_str = "groupId="+id;

			$.ajax({
				type: "GET",
				url: "{{asset('admin/load_group_user')}}",
				data: url_str,
				success: function(data){
					$('#employee_div').html(data);
				}
			});
		}
	</script>
    <section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				@if(session('AppSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							App created successfully
							<script>
             				 window.setTimeout(function(){window.location.href = "{{asset('/admin/list_app/')}}";}, 2000);
           				  </script>
						</div>
					</div>
				@endif
				@if(session('AppError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Unable to create App
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
						<h3 class="box-title">Create App</h3>
					</div><!-- /.box-header -->
					<div class="box-body">
						<!-- form start -->
						<form action="" method="POST" id="ticket-form" class="form-horizontal" novalidate="novalidate">
							<div class="col-md-8">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group">
									<label>App Name <span id="required">*</span></label>
									<input type="text" name="app_name" id="app_name" class="form-control" placeholder="App Name">
								</div>
								<div class="form-group">
									<label>App URL <span id="required">*</span></label>
									<input type="text" name="app_url" id="app_url" class="form-control" placeholder="App URL">
								</div>
								<!--<div class="form-group">
									<label>App Description <span id="required">*</span></label>
									<textarea class="form-control" rows="5" cols="45" name="description" id="description"></textarea>
								</div>-->
								<div class="form-group">
									<label>List Of Events</label>
									<div style="clear:both"></div>
									@foreach ($eventdata as $data)
										@if(isset($data->eventId))
											<input type="checkbox" name="event_<?=(!empty($data->eventId)?$data->eventId:"")?>" id="services" value="<?=(!empty($data->eventId)?$data->eventId:"")?>">
											<label>{{$data->eventName}} &nbsp;</label>
										@endif
									@endforeach
								</div>
								<div class="form-group">
									<label>Status </label>
									<div style="clear:both"></div>
									<input type="radio" name="status" id="status" value="1">&nbsp;Active
										&nbsp;
									<input type="radio" name="status" id="status" value="2" checked>&nbsp;In Active
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group">
									<label>App Description <!--<span id="required">*</span></label>-->
									<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
									<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
									<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12" ></textarea>
									<script>
										initSample();
									</script>
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


