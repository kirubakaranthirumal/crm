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

	#category-form label.error{
		color: #FB3A3A;
		display: inline-block;
		//margin: 4px 0 5px 125px;
		padding: 0;
		text-align: left;
		width: 250px;
	}

	#priority-form label.error{
		color: #FB3A3A;
		display: inline-block;
		//margin: 4px 0 5px 125px;
		padding: 0;
		text-align: left;
		width: 250px;
	}

	#source-form label.error{
		color: #FB3A3A;
		display: inline-block;
		//margin: 4px 0 5px 125px;
		padding: 0;
		text-align: left;
		width: 250px;
	}

	#type-form label.error{
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
<script type="text/javascript" language="javascript">
    $(document).ready(function(){
    	//$("#modal-container-department").dialog({modal: true});
    });
</script>
@section('content')
<div class="page page-tables-datatables">

				@if(session('socialUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Social Media Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/smsettings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				<div class="col-md-12">
				<!-- tile -->
						<section class="tile">

							<!-- tile header -->
							<div class="tile-header dvd dvd-btm">
								<h1 class="custom-font"><strong>Social Media </strong>Form</h1>
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

								<!--<a id="modal-department" href="#modal-container-department" role="button" class="btn btn-primary" data-toggle="modal">Add DepartMent</a>-->
									<form action="#" method="PUT" id="contentmanage-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<!--<input type="hidden" name="settings_type" id="settings_type" value="1">-->
										<div class="box-body">
													<?php
														//print"<pre>";
														//print_r($social);
													?>
													<div class="col-md-6">
														<div class="form-group">
															<label>Type <span id="required">*</span></label>
															<select class="form-control" name="sms_type" id="sms_type" tabindex="1">
																<option value="">Select Type</option>
																<?php
																	$selsms_type_tweet="";
																	$selsms_type_face="";
																	if(!empty($social['smsType'])){
																		if($social['smsType']==1){
																			$selsms_type_tweet="selected='selected'";
																		}
																		elseif($social['smsType']==2){
																			$selsms_type_face="selected='selected'";
																		}
																	}
																?>
																<option value="1" <?=(!empty($selsms_type_tweet)?$selsms_type_tweet:"")?>>Twitter</option>
																<option value="2" <?=(!empty($selsms_type_face)?$selsms_type_face:"")?>>Facebook</option>
															</select>
														</div>
														<div class="form-group">
															<label>User ID</label> <span id="required">*</span>
															<input type="text" placeholder="User ID" name="sms_user_id" id="sms_user_id" class="form-control" value="<?=(!empty($social['smsUserId'])?$social['smsUserId']:"")?>">
														</div>
														<div class="form-group">
															<label>Password</label> <span id="required">*</span>
															<input type="text" placeholder="Password" name="sms_user_password" id="sms_user_password" class="form-control" value="<?=(!empty($social['smsUserPassword'])?$social['smsUserPassword']:"")?>">
														</div>
														<div class="form-group">
															<label>Consumer Key</label> <span id="required">*</span>
															<input type="text" placeholder="Consumer Key" name="sms_consumer_key" id="sms_consumer_key" class="form-control" value="<?=(!empty($social['smsConsumerKey'])?$social['smsConsumerKey']:"")?>">
														</div>
														<div class="form-group">
															<label>Consumer Secret</label> <span id="required">*</span>
															<input type="text" placeholder="Consumer Secret" name="sms_consumer_secret" id="sms_consumer_secret" class="form-control" value="<?=(!empty($social['smsConsumerSecret'])?$social['smsConsumerSecret']:"")?>">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Access Token</label> <span id="required">*</span>
															<input type="text" placeholder="Access Token" name="sms_access_token" id="sms_access_token" class="form-control" value="<?=(!empty($social['smsAccessToken'])?$social['smsAccessToken']:"")?>">
														</div>
														<div class="form-group">
															<label>Access Token Secret</label> <span id="required">*</span>
															<input type="text" placeholder="Access Token Secret" name="sms_access_token_secret" id="sms_access_token_secret" class="form-control" value="<?=(!empty($social['smsAccessTokenSecret'])?$social['smsAccessTokenSecret']:"")?>">
														</div>
														<div class="form-group">
															<label>Oauth Call Back</label> <span id="required">*</span>
															<input type="text" placeholder="Oauth Callback" name="sms_oauth_callback" id="sms_oauth_callback" class="form-control" value="<?=(!empty($social['smsOauthCallback'])?$social['smsOauthCallback']:"")?>">
														</div>
														<div class="form-group">
															<label>Description</label> <span id="required">*</span>
															<input type="text" placeholder="Description" name="sms_desc" id="sms_desc" class="form-control" value="<?=(!empty($social['smsDesc'])?$social['smsDesc']:"")?>">
														</div>
														<div class="form-group">
															<label>Status</label> <span id="required">*</span>
															<br>
															<?php
																$sms_status_active="";
																$sms_status_inactive="";
																if(!empty($social['smsStatus'])){
																	if($social['smsStatus']==1){
																		$sms_status_active="checked";
																	}
																	elseif($social['smsStatus']==2){
																		$sms_status_inactive="checked";
																	}
																}
																else{
																	$sms_status_inactive="checked";
																}
															?>
															<input type="radio" class="option-input radio" name="sms_status" id="sms_status" value="1" <?=(!empty($sms_status_active)?$sms_status_active:"")?> >Active
															<input type="radio" class="option-input radio" name="sms_status" id="sms_status" value="2" <?=(!empty($sms_status_inactive)?$sms_status_inactive:"")?>>In-Active
														</div>
													</div>
												</div>
												<div style="clear:both;"></div>
										<div class="box-footer">
											<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
											{!! HTML::link('admin/smsettings', 'Cancel', array('class' => 'btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10')) !!}
										</div>
									</form>
									</div>
								</section>
				</div>
								<div style="clear:both;"></div>
								 <section class="tile">
								 <div class="tile-body">
										<table id="department" class="table table-custom table-striped dt-responsive">
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
												@if(isset($sociallist))
													@foreach($sociallist as $social_data)
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

	<script language="javascript">

		$(function() {

		$('#department').DataTable( {
			"aaSorting": [[ 3, "desc" ]],
			 "aoColumnDefs" : [
				 {
				   'bSortable' : false,
				   'aTargets' : [ 4 ]
				 }]
			} );
		} );
	</script>


@endsection


