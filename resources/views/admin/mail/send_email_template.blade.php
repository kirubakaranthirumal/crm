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
								notEqualTo: 100
							},
							template_name: {
								required: true,
								notEqualTo: 100
							}
						},
						messages: {
							template_category: "Please select template category",
							template_name: "Please enter your template name"
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
	<script language="javascript">
		function load_template(id){
			var url_str = "catId="+id;
			$.ajax({
				type: "GET",
				url: "{{asset('admin/load_template')}}",
				data: url_str,
				success: function(data){
					$('#template_div').html(data);
				}
			});
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
<div class="page page-tables-datatables">
				@if (session('mailSendSuccess'))
					<div class="flash-message">
						 <div class="alert alert-success">
							Mail sent successfully
							<script>
								window.setTimeout(function(){window.location.href = "{{asset('/admin/sendmail/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				@if (session('mailSendError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Unable to send mail
						<!--	<script>
              window.setTimeout(function(){
		window.location.href = "{{asset('/admin/create_app/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif";
               }, 2000);
             </script>-->
						</div>
					</div>
				@endif
				<!-- general form elements -->
<div class="col-md-6">

                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Send </strong>Mail</h1>
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
									<label>Category <span id="required">*</span></label>
									<select class="form-control" name="template_category" id="template_category" onchange="load_template(this.value)">
										<option value="">Select Category </option>
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
									<label>Template <span id="required">*</span></label>
									<div id="template_div">
										<select class="form-control" name="template_name" id="template_name">
											<option value="">Select Template</option>
										</select>
									</div>
								</div>
							</div>
						<div class="box-footer">
						<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
							<!-- <input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary"> -->
						</div>
					</form>
					<div style="clear:both">&nbsp;</div>
				</div>
			</div>
			</div>
@endsection


