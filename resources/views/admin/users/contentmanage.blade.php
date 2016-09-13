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
	                   // menu_parent: "required",
	                    menu_name: "required",
						menu_app:"required",
						menu_title:"required",
						editor:"required",
						menu_sort:"required",
						menu_visible:{
							required: true,
							notEqualTo: 3
						},
	                    status: {
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
	                   // menu_parent: "Please Select Parent Menu",
						menu_app: "Please enter menu app",
	                    menu_name: "Please enter menu name",
						menu_title: "Please enter menu title",
						editor: "Please enter menu desc",
						menu_sort: "Please enter menu sort order",
					    menu_visible: "Please select visible ",
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
<script language="javascript">
	function load_event(id){
		var url_str = "appId="+id;
		$.ajax({
			type: "GET",
			url: "{{asset('admin/load_app_event')}}",
			data: url_str,
			success: function(data){
				$('#event_div').html(data);
			}
		});
	}
</script>
@section('content')
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>CMS List</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">CMS</a>
			</li>
			<li>
				<a href="#">CMS List</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
            	@if(session('contentManageSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Content Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/contentmanage/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				@if(session('contentManageDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Content Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/contentmanage/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				@if(session('menuNameError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							{{session('menuNameError')}}
						</div>
					</div>
				@endif

					<a id="modal-department" href="#modal-container-department" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" data-toggle="modal" data-target="#modal-container-department" data-options="splash-2 splash-ef-11">Add Menu <i class="fa fa-plus" aria-hidden="true"></i></a>
					<div style="clear:both;">&nbsp;</div>
					<section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Menu</strong></h1>
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
								<table id="department" class="table table-custom table-stribed dt-responsive">
									<thead>
										<tr>
											<th>Name</th>
											<th>Title</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($menucontent))
											@foreach($menucontent as $menu_data)
												<tr>
													<td>
														@if(isset($menu_data['menuName']))
															{{$menu_data['menuName']}}
														@endif
													</td>
													<td>
														@if(isset($menu_data['menuTitle']))
															{{$menu_data['menuTitle']}}
														@endif
													</td>
													<td>
														@if(isset($menu_data['menuStatus']))
															@if($menu_data['menuStatus']==1)
																Active
															@elseif($menu_data['menuStatus']==2)
																In-Active
															@endif
														@endif
													</td>
													<td>
														@if(isset($menu_data['menuCreatedOn']))
															<?php
																$date=date_create($menu_data['menuCreatedOn']);
																echo date_format($date,"Y-m-d h:i A");
															?>
														@endif
													</td>
													<td>
														@if(isset($menu_data['menuId']))
															<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/edit_menu/')}}/@if(isset($menu_data['menuId'])){{ $menu_data['menuId']}}?set_id=1 @endif" title="edit">
																<i class="fa fa-pencil"></i>
															</a>&nbsp;&nbsp;
															<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/del_menu/')}}/@if(isset($menu_data['menuId'])){{ $menu_data['menuId']}}?set_id=1 @endif" title="delete">
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
													Add Menu
												</h4>
											</div>
											<div class="modal-body">
												<form action="#" method="POST" id="contentmanage-form" novalidate="novalidate">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<!--<input type="hidden" name="settings_type" id="settings_type" value="1">-->
													<div class="box-body">
													<div class="col-md-6">
														<div class="form-group">
															<label>Application <span id="required">*</span></label>
															<select class="form-control" name="menu_app" id="menu_app" onchange="load_event(this.value)" tabindex="1">
																<option value="">Select Application</option>
																@if(isset($app_data))
																	@foreach ($app_data as $data)
																		@if((isset($data->appId)) && (isset($data->appName)))
																			<option value="{{$data->appId}}" >{{$data->appName}}</option>
																		@endif
																	@endforeach
																@endif
															</select>
														</div>
														<!--<div class="form-group">
																<label>Event <span id="required">*</span></label>
																<div id="event_div">
																<select class="form-control" name="event" id="event" tabindex="2">
																	<option value="">Select Event</option>
																</select>
															</div>
														 </div>-->
														<div class="form-group">
															<label>Name</label> <span id="required">*</span>
															<input type="text" placeholder="Name" name="menu_name" id="menu_name" class="form-control">
														</div>
														<div class="form-group">
															<label>Title</label> <span id="required">*</span>
															<input type="text" placeholder="Title" name="menu_title" id="menu_title" class="form-control">
														</div>
														</div>
														<div class="col-md-6">
															<!--<div class="form-group">
																<label>Description</label> <span id="required">*</span>
																<textarea placeholder="Description" rows="2" col="3" name="menu_desc" id="menu_desc" class="form-control"></textarea>
																<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
																<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
																<link rel="stylesheet" href="{{asset('/ckeditor_4.5.9_full/samples/css/samples.css')}}">
																<link rel="stylesheet" href="{{asset('/ckeditor_4.5.9_full/samples/toolbarconfigurator/lib/codemirror/neo.css')}}">
																<div class="adjoined-bottom">
																	<div class="grid-container">
																		<div class="grid-width-100">
																			<div id="editor">
																				<h1>Hello world!</h1>
																				<p>I'm an instance of <a href="http://ckeditor.com">CKEditor</a>.</p>
																			</div>
																		</div>
																	</div>
																</div>
																<script>
																	initSample();
																</script>
															</div>-->
															<div class="form-group">
																<label>Parent</label>
																<select name="menu_parent" id="menu_parent" class="form-control">
																	<option value="0">Select Parent</option>
																	 @if(isset($menucontent))
																		@foreach($menucontent as $menu_data)
																			@if($menu_data['menuParent']==0)
																				<option value="{{$menu_data['menuId']}}">{{$menu_data['menuName']}}</option>
																			@endif
																		@endforeach
																	 @endif
																</select>
															</div>
															<div class="form-group">
																<label>Sort</label> <span id="required">*</span>
																<input type="text" placeholder="Sort Order" name="menu_sort" id="menu_sort" class="form-control">
															</div>
															<div class="form-group">
																<label>Visible Frontend</label>
																<br>
																<input type="radio" class="option-input radio" name="menu_visible" id="menu_visible" value="1"> Visible</input>&nbsp;&nbsp;
																<input type="radio" class="option-input radio" name="menu_visible" id="menu_visible" value="2" checked> In-Visible</input>
															</div>
														</div>
														<div class="col-md-12">
															<div class="form-group">
																<label>Description</label> <!--<span id="required">*</span>-->
																<textarea placeholder="Description" rows="2" col="3" name="editor" id="editor" class="form-control"></textarea>
																<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
																<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
																<!--<div class="adjoined-bottom">
																	<div class="grid-container">
																		<div class="grid-width-100">
																			<div id="editor">
																				<h1>Hello world!</h1>
																				<p>I'm an instance of <a href="http://ckeditor.com">CKEditor</a>.</p>
																			</div>
																		</div>
																	</div>
																</div>-->
																<script>
																	initSample();
																</script>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Status</label>
																<br>
																<input type="radio" class="option-input radio" name="status" id="status" value="1"> Active</input>&nbsp;&nbsp;
																<input type="radio" class="option-input radio" name="status" id="status" value="2" checked> In-Active</input>
															</div>
														</div>



													</div>
													<div class="clearfix"></div>
													<div class="box-footer">
													<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
													<button type="button" class="btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal" aria-hidden="true">Cancel</button>
													</div>
												</form>
											</div>
											<!--<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">
													Close
												</button>
												<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
												<button type="button" class="btn btn-primary">
													Save changes
												</button>
											</div>-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--Add/Edit Department code end-->
					<!--<!DOCTYPE html>
					<html>
						<head>
							<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
							<script>tinymce.init({ selector:'textarea' });</script>
						</head>
						<body>
							<textarea>Easy (and free!) You should check out our premium features.</textarea>
						</body>
					</html>-->

<script language="javascript">
	$(function(){
		$('#department').DataTable({
			"aaSorting": [[ 3, "desc" ]],
			"aoColumnDefs" : [{
				'bSortable' : false,
				'aTargets' : [ 4 ]
			}]
		});
	});
</script>
@endsection


