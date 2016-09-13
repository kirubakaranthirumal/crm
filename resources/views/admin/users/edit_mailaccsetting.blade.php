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
	                    mail_app_id: "required",
						mail_user_id:"required",
						mail_user_password:"required",
						mail_desc:"required",
						mail_status:{
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
						mail_app_id: "Please select menu app",
	                    mail_user_id: "Please enter user name",
						mail_user_password: "Please enter password",
						mail_desc: "Please enter mail desc",
						mail_status: "Please select status"
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
<div class="pageheader">
	<h2>Mail Account Settings</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Settings</a>
			</li>
			<li>
				<a href="#">Mail Account Settings</a>
			</li>
			<li>
				<a href="#">Edit</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>

				@if(session('contentManageUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Mail Account Setting Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/mailaccsettings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif

				<div class="col-md-8">

                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Mail Account </strong>Settings</h1>
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

									<form action="#" class="form-horizontal" method="PUT" id="contentmanage-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<!--<input type="hidden" name="settings_type" id="settings_type" value="1">-->
										<div class="box-body col-md-12">
													<div class="form-group">
															<label>Application</label>&nbsp;<span id="required">*</span>
															<select class="form-control" name="mail_app_id" id="mail_app_id" onchange="load_event(this.value)" tabindex="1">
																<option value="">Select Application</option>
																	@if(isset($app_data))
																		@foreach ($app_data as $data)
																			@if((isset($data->appId)) && (isset($data->appName)))
																				<?php
																					$mailaccset_sel="";
																				?>
																				@if((!empty($data->appId)) && (!empty($mailAccSetVal['mailAppId'])))
																					@if($data->appId == $mailAccSetVal['mailAppId'])
																						<?php $mailaccset_sel="selected"; ?>
																					@endif
																				@endif
																				<option value="{{$data->appId}}" <?=$mailaccset_sel?>>{{$data->appName}}</option>
																			@endif
																		@endforeach
																	@endif
															</select>
														</div>
												<div class="form-group">
													<label>User Name</label>&nbsp;<span id="required">*</span>
													<input type="text" placeholder="User Name" name="mail_user_id" id="mail_user_id" class="form-control" value="<?=(!empty($mailAccSetVal['mailUserId'])?$mailAccSetVal['mailUserId']:"")?>">
											    </div>
												<div class="form-group">
													<label>Password</label>&nbsp;<span id="required">*</span>
													<input type="text" placeholder="Password" name="mail_user_password" id="mail_user_password" class="form-control" value="<?=(!empty($mailAccSetVal['mailUserPassword'])?$mailAccSetVal['mailUserPassword']:"")?>">
												</div>
												<!--<div class="form-group">
													<label>Description</label>&nbsp;<span id="required">*</span>
													<textarea placeholder="Description" name="mail_desc" id="mail_desc" class="form-control"><?=(!empty($mailAccSetVal['mailDesc'])?$mailAccSetVal['mailDesc']:"")?></textarea>
												</div>-->
												<div class="form-group">
													<label>Description <!--<span id="required">*</span>--></label>
													<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
													<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
													<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12" ><?=(!empty($mailAccSetVal['mailDesc'])?$mailAccSetVal['mailDesc']:"")?></textarea>
													<script>
														initSample();
													</script>
												</div>
												<div class="form-group">
													<label>Status</label>
													<br>
													<?php
														$active_checked="";
														$inactive_checked="";
														if(!empty($mailAccSetVal['mailStatus'])){
															if($mailAccSetVal['mailStatus']==1){
																$active_checked="checked";
																$inactive_checked="";
															}
															elseif($mailAccSetVal['mailStatus']==2){
																$active_checked="";
																$inactive_checked="checked";
															}
														}
														else{
															$active_checked="";
															$inactive_checked="checked";
														}
													?>
													<input type="radio" class="option-input radio" name="mail_status" id="mail_status" value="1" <?=(!empty($active_checked)?$active_checked:"")?>> Active
													<input type="radio" class="option-input radio" name="mail_status" id="mail_status" value="2" <?=(!empty($inactive_checked)?$inactive_checked:"")?>> In-Active
												</div>
											</div>
										<div class="box-footer">
										<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
										{!! HTML::link('admin/mailaccsettings', 'Cancel', array('class' => 'btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10')) !!}
										</div>
									</form>
									</div>
									</section>
								</div>

						<div class="clearfix"></div>
								<section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Mail Account</strong> Settings details</h1>
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
								<table id="department" class="table table-custom table-striped dt-responsive">
									<thead>
										<tr>
											<th>Application Name</th>
											<th>User Name</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>

									<tbody>
										@if(isset($mailAccSetArray))
											@foreach($mailAccSetArray as $mail_acc_set_data)
												<tr>
													<td>
														@if(isset($mail_acc_set_data['mailAppName']))
															{{$mail_acc_set_data['mailAppName']}}
														@endif
													</td>
													<td>
														@if(isset($mail_acc_set_data['mailUserId']))
															{{$mail_acc_set_data['mailUserId']}}
														@endif
													</td>
													<td>
														@if(isset($mail_acc_set_data['mailStatus']))
															@if($mail_acc_set_data['mailStatus']==1)
																Active
															@elseif($mail_acc_set_data['mailStatus']==2)
																In-Active
															@endif
														@endif
													</td>
													<td>
														@if(isset($mail_acc_set_data['createdOn']))
														<?php
															$date=date_create($mail_acc_set_data['createdOn']);
															echo date_format($date,"Y-m-d h:i A");
														?>
														@endif
													</td>
													<td>
														@if(isset($mail_acc_set_data['mailId']))
															{!!HTML::linkRoute('admin.mailaccsettings.edit','',array($mail_acc_set_data['mailId']), array('title'=>'edit', 'class'=>'btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea fa-edit-icon'))!!}

															<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/del_mail/')}}/@if(isset($mail_acc_set_data['mailId'])){{ $mail_acc_set_data['mailId']}} @endif" title="delete">
																<i class="fa fa-times"></i>
															</a>
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


