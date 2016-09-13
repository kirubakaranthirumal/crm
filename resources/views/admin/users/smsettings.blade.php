@extends('admin.layouts.master')
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
	            $("#contentmanage-form").validate({
	                rules: {
	                	sms_type:{
							required: true,
							notEqualTo: 3
						},
	                    sms_user_id: "required",
	                    sms_user_id: "required",
						sms_user_password: "required",
						sms_consumer_key: "required",
						sms_consumer_secret: "required",
						sms_access_token: "required",
						sms_access_token_secret: "required",
						sms_oauth_callback: "required",
						sms_desc: "required",
	                    status: {
							required: true,
							notEqualTo: 3
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
	#contentmanage-form label.error{
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
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
    	//$("#modal-container-department").dialog({modal: true});
    });
</script>
@section('content')
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>Social Media Settings</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Settings</a>
			</li>
			<li>
				<a href="#">Social Media Settings</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
            	@if(session('socia1Suc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Social Media Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/smsettings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				@if(session('socialDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Social Media Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/smsettings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif

					<a id="modal-department" href="#modal-container-department" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" data-toggle="modal" data-target="#modal-container-department" data-options="splash-2 splash-ef-11">Add Social Media Account <i class="fa fa-plus" aria-hidden="true"></i></a>
					<div style="clear:both;">&nbsp;</div>
					<section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Social Media</strong> Settings</h1>
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

								<table id="department" class="table table-custom table-stribed dt-responsive">
									<thead>
										<tr>
											<th>Type</th>
											<th>User ID</th>
											<th>Password</th>
											<!--<th>Consumer Key</th>
											<th>Call Back</th>
											<th>Desc</th>-->
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($social))
											@foreach($social as $social_data)
												<tr>
													<td>
														@if(isset($social_data['smsType']))
															@if($social_data['smsType']==1)
																Twitter
															@elseif($social_data['smsType']==2)
																Facebook
															@endif
														@endif
													</td>
													<td>
														@if(isset($social_data['smsUserId']))
															{{$social_data['smsUserId']}}
														@endif
													</td>
													<td>
														@if(isset($social_data['smsUserPassword']))
															{{$social_data['smsUserPassword']}}
														@endif
													</td>
													<!--<td>
														@if(isset($social_data['smsConsumerKey']))
															{{$social_data['smsConsumerKey']}}
														@endif
													</td>
													<td>
														@if(isset($social_data['smsOauthCallback']))
															{{$social_data['smsOauthCallback']}}
														@endif
													</td>
													<td>
														@if(isset($social_data['smsDesc']))
															{{$social_data['smsDesc']}}
														@endif
													</td>-->
													<td>
														@if(isset($social_data['smsStatus']))
															@if($social_data['smsStatus']==1)
																Active
															@elseif($social_data['smsStatus']==2)
																In-Active
															@endif
														@endif
													</td>
													<td>
														@if(isset($social_data['smsCreatedOn']))
														<?php
															$date=date_create($social_data['smsCreatedOn']);
														   echo date_format($date,"Y-m-d h:i A");
														 ?>
														@endif
													</td>
													<td>
														@if(isset($social_data['smsId']))
															<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/edit_sms/')}}/@if(isset($social_data['smsId'])){{ $social_data['smsId']}} @endif" title="edit">
																<i class="fa fa-pencil"></i>
															</a>&nbsp;&nbsp;
															<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/del_sms/')}}/@if(isset($social_data['smsId'])){{ $social_data['smsId']}} @endif" title="delete">
																<i class="fa fa-times"></i>
															</a>
															<!--<a id="modal-department" href="#modal-container-department" data-toggle="modal">
																<i class="fa fa-edit"></i>
															</a>-->
														@endif
													</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
							</div><!-- /.box-body -->
						</section><!-- /.box -->
					</div><!-- /.box -->
					</div><!-- /.box -->
					<!--
					<link href="{{asset('/modal/css/bootstrap.min.css')}}" rel="stylesheet">
					<link href="{{asset('/modal/css/style.css')}}" rel="stylesheet">-->
					<!--Add/Edit Department code starts-->
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="modal splash fade" id="modal-container-department" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												<h4 class="modal-title" id="myModalLabel">
													Add Social Media
												</h4>
											</div>
											<div class="modal-body">
												<form action="#" method="POST" id="contentmanage-form" novalidate="novalidate">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<!--<input type="hidden" name="settings_type" id="settings_type" value="1">-->
													<div class="box-body">
													<div class="col-md-6">
														<div class="form-group">
															<label>Type <span id="required">*</span></label>
															<select class="form-control" name="sms_type" id="sms_type" tabindex="1">
																<option value="">Select Type</option>
																<option value="1">Twitter</option>
																<option value="2">Facebook</option>
															</select>
														</div>
														<div class="form-group">
															<label>User ID</label> <span id="required">*</span>
															<input type="text" placeholder="User ID" name="sms_user_id" id="sms_user_id" class="form-control">
														</div>
														<div class="form-group">
															<label>Password</label> <span id="required">*</span>
															<input type="text" placeholder="Password" name="sms_user_password" id="sms_user_password" class="form-control">
														</div>
														<div class="form-group">
															<label>Consumer Key</label> <span id="required">*</span>
															<input type="text" placeholder="Consumer Key" name="sms_consumer_key" id="sms_consumer_key" class="form-control">
														</div>
														<div class="form-group">
															<label>Consumer Secret</label> <span id="required">*</span>
															<input type="text" placeholder="Consumer Secret" name="sms_consumer_secret" id="sms_consumer_secret" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Access Token</label> <span id="required">*</span>
															<input type="text" placeholder="Access Token" name="sms_access_token" id="sms_access_token" class="form-control">
														</div>
														<div class="form-group">
															<label>Access Token Secret</label> <span id="required">*</span>
															<input type="text" placeholder="Access Token Secret" name="sms_access_token_secret" id="sms_access_token_secret" class="form-control">
														</div>
														<div class="form-group">
															<label>Oauth Call Back</label> <span id="required">*</span>
															<input type="text" placeholder="Oauth Callback" name="sms_oauth_callback" id="sms_oauth_callback" class="form-control">
														</div>
														<div class="form-group">
															<label>Description</label> <span id="required">*</span>
															<input type="text" placeholder="Description" name="sms_desc" id="sms_desc" class="form-control">
														</div>
														<div class="form-group">
															<label>Status</label> <span id="required">*</span>
															<br>
															<input type="radio" class="option-input radio" name="sms_status" id="sms_status" value="1">Active
															<input type="radio" class="option-input radio" name="sms_status" id="sms_status" value="2" checked>In-Active
														</div>
													</div>
												</div>
												<div class="box-footer">
													<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
													<button type="button" class="btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal" aria-hidden="true">Cancel</button>
												</div>
											</form>
										</div>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--Add/Edit Department code end-->




					<script language="javascript">

						$(function() {

						$('#department').DataTable( {
							"aaSorting": [[ 4, "desc" ]],
							 "aoColumnDefs" : [
								 {
								   'bSortable' : false,
								   'aTargets' : [ 5 ]
								 }]
							} );
						} );
					</script>


@endsection


