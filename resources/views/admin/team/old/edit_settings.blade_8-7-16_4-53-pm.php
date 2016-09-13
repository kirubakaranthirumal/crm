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
	            $("#department-form").validate({
	                rules: {
	                    dept_name: "required",
	                    dept_desc: "required",
	                    status: {
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
	                    dept_name: "Please enter name",
	                    dept_desc: "Please enter description",
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
	            $("#category-form").validate({
	                rules: {
	                    cat_name: "required",
	                    cat_desc: "required",
	                    status: {
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
	                    cat_name: "Please enter name",
	                    cat_desc: "Please enter description",
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
	            $("#priority-form").validate({
	                rules: {
	                    priority_name: "required",
	                    priority_desc: "required",
	                    status: {
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
	                    priority_name: "Please enter name",
	                    priority_desc: "Please enter description",
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
	            $("#source-form").validate({
	                rules: {
	                    source_name: "required",
	                    source_desc: "required",
	                    status: {
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
	                    source_name: "Please enter name",
	                    source_desc: "Please enter description",
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
	            $("#type-form").validate({
	                rules: {
	                    type_name: "required",
	                    type_desc: "required",
	                    status: {
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
	                    type_name: "Please enter name",
	                    type_desc: "Please enter description",
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
	            $("#status-form").validate({
	                rules: {
	                    status_name: "required",
	                    status_desc: "required",
	                    status: {
							required: true,
							notEqualTo: 3
						}
	                },
	                messages: {
	                    status_name: "Please enter name",
	                    status_desc: "Please enter description",
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
	#department-form label.error{
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

	#status-form label.error{
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
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
            	<?php
					//echo session()->get('departmentUpdSuc');
					//exit;
					//echo session('userSuccess');
            	?>
				@if(session('departmentUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Group Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('categoryUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Category Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('priorityUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Priority Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('sourceUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Source Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('typeUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Type Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('statusUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Status Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Group</h3>
						</div><!-- /.box-header -->

							<div class="box-body">
								<!--<a id="modal-department" href="#modal-container-department" role="button" class="btn btn-primary" data-toggle="modal">Add DepartMent</a>-->

								@if(isset($set_id))
									@if($set_id==1)
									<form action="" method="PUT" id="department-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="settings_type" id="settings_type" value="1">
										<div class="box-body">
											<div class="form-group">
												<label>Name</label>
												<input type="text" placeholder="Name" name="dept_name" id="dept_name" value="@if(isset($deptval->dept_name)){{$deptval->dept_name}}@endif" class="form-control">
											</div>
											<div class="form-group">
												<label>Description</label>
												<textarea placeholder="Description" name="dept_desc" id="dept_desc" class="form-control">@if(isset($deptval->dept_desc)){{$deptval->dept_desc}}@endif</textarea>
											</div>
											<div class="form-group">
												<label>Status</label>
												<br>
												@if(isset($deptval->status))
													@if($deptval->status==1)
														<input type="radio" name="status" id="status" value="1" checked>Active
														<input type="radio" name="status" id="status" value="2">In-Active
													@elseif($deptval->status==2)
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@else
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@endif
												@else
													<input type="radio" name="status" id="status" value="1">Active
													<input type="radio" name="status" id="status" value="2" checked>In-Active
												@endif
											</div>
										</div>
										<div class="box-footer">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
										</div>
									</form>
									@endif
								@endif
								<div style="clear:both;"></div>
								<table id="department" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
								<tbody>
									@if(isset($department))
										@foreach($department as $department_data)
											<tr>
												<td>
													@if(isset($department_data['deptName']))
														{{$department_data['deptName']}}
													@endif
												</td>
												<td>
													@if(isset($department_data['deptDescription']))
														{{$department_data['deptDescription']}}
													@endif
												</td>
												<td>
													@if(isset($department_data['deptStatus']))
														@if($department_data['deptStatus']==1)
															Active
														@elseif($department_data['deptStatus']==2)
															In-Active
														@endif
													@endif
												</td>
												<td>
													@if(isset($department_data['deptCreatedOn']))
														{{$department_data['deptCreatedOn']}}
													@endif
												</td>
												<td>
													@if(isset($department_data['deptId']))
														<a href="{{asset('/admin/del_dept/')}}/@if(isset($department_data['deptId'])){{ $department_data['deptId']}}?set_id=1 @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;
														<a href="{{asset('/admin/edit_dept/')}}/@if(isset($department_data['deptId'])){{ $department_data['deptId']}}?set_id=1 @endif" title="edit">
															<i class="fa fa-edit"></i>
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
					</div><!-- /.box -->
				</div><!-- /.box -->

				<!--category list code starts-->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Category</h3>
						</div><!-- /.box-header -->
							<div class="box-body">
								@if(isset($set_id))
									@if($set_id==2)
									<form action="" method="PUT" id="category-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="settings_type" id="settings_type" value="2">
										<div class="box-body">
											<div class="form-group">
												<label>Name</label>
												<input type="text" placeholder="Name" name="cat_name" id="cat_name" value="@if(isset($catval->cat_name)){{$catval->cat_name}}@endif" class="form-control">
											</div>
											<div class="form-group">
												<label>Description</label>
												<textarea placeholder="Description" name="cat_desc" id="cat_desc" class="form-control">@if(isset($catval->cat_desc)){{$catval->cat_desc}}@endif</textarea>
											</div>
											<div class="form-group">
												<label>Status</label>
												<br>
												@if(isset($catval->status))
													@if($catval->status==1)
														<input type="radio" name="status" id="status" value="1" checked>Active
														<input type="radio" name="status" id="status" value="2">In-Active
													@elseif($catval->status==2)
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@else
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@endif
												@else
													<input type="radio" name="status" id="status" value="1">Active
													<input type="radio" name="status" id="status" value="2" checked>In-Active
												@endif
											</div>
										</div>
										<div class="box-footer">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
										</div>
									</form>
									@endif
								@endif
								<!--<a id="modal-category" href="#modal-container-category" role="button" class="btn btn-primary" data-toggle="modal">Add Category</a>
								<div style="clear:both;">&nbsp;</div>-->
								<table id="category" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
								<tbody>
									@if(isset($category))
										@foreach($category as $category_data)
											<tr>
												<td>
													@if(isset($category_data['categoryName']))
														{{ $category_data['categoryName']}}
													@endif
												</td>
												<td>
													@if(isset($category_data['categoryDescription']))
														{{ $category_data['categoryDescription']}}
													@endif
												</td>
												<td>
													@if(isset($category_data['categoryStatus']))
														@if($category_data['categoryStatus']==1)
															Active
														@elseif($category_data['categoryStatus']==2)
															In-Active
														@endif
													@endif
												</td>
												<td>
													@if(isset($category_data['categoryCreatedOn']))
														{{ $category_data['categoryCreatedOn'] }}
													@endif
												</td>
												<td>
													@if(isset($category_data['categoryId']))
														<a href="{{asset('/admin/del_cat/')}}/@if(isset($category_data['categoryId'])){{ $category_data['categoryId']}}?set_id=2 @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;
														<a href="{{asset('/admin/edit_cat/')}}/@if(isset($category_data['categoryId'])){{ $category_data['categoryId']}}?set_id=2 @endif" title="edit">
															<i class="fa fa-edit"></i>
														</a>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
				<!--category list code end-->

				<!--priority list code starts-->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Priority</h3>
						</div><!-- /.box-header -->
							<div class="box-body">
								@if(isset($set_id))
									@if($set_id==3)
									<form action="" method="PUT" id="priority-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="settings_type" id="settings_type" value="3">
										<div class="box-body">
											<div class="form-group">
												<label>Name</label>
												<input type="text" placeholder="Name" name="priority_name" id="priority_name" value="@if(isset($priorityval->priority_name)){{$priorityval->priority_name}}@endif" class="form-control">
											</div>
											<div class="form-group">
												<label>Description</label>
												<textarea placeholder="Description" name="priority_desc" id="priority_desc" class="form-control">@if(isset($priorityval->priority_desc)){{$priorityval->priority_desc}}@endif</textarea>
											</div>
											<div class="form-group">
												<label>Status</label>
												<br>
												@if(isset($priorityval->status))
													@if($priorityval->status==1)
														<input type="radio" name="status" id="status" value="1" checked>Active
														<input type="radio" name="status" id="status" value="2">In-Active
													@elseif($priorityval->status==2)
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@else
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@endif
												@else
													<input type="radio" name="status" id="status" value="1">Active
													<input type="radio" name="status" id="status" value="2" checked>In-Active
												@endif
											</div>
										</div>
										<div class="box-footer">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
										</div>
									</form>
									@endif
								@endif
								<!--<a id="modal-priority" href="#modal-container-priority" role="button" class="btn btn-primary" data-toggle="modal">Add Priority</a>
								<div style="clear:both;">&nbsp;</div>-->
								<table id="priority" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
								<tbody>
									@if(isset($priority))
										@foreach($priority as $priority_data)
											<tr>
												<td>
													@if(isset($priority_data['priorityName']))
														{{ $priority_data['priorityName']}}
													@endif
												</td>
												<td>
													@if(isset($priority_data['priorityDescription']))
														{{ $priority_data['priorityDescription']}}
													@endif
												</td>
												<td>
													@if(isset($priority_data['priorityStatus']))
														@if($priority_data['priorityStatus']==1)
															Active
														@elseif($priority_data['priorityStatus']==2)
															In-Active
														@endif
													@endif
												</td>
												<td>
													@if(isset($priority_data['priorityCreatedOn']))
														{{ $priority_data['priorityCreatedOn'] }}
													@endif
												</td>
												<td>
													@if(isset($priority_data['priorityId']))
														<a href="{{asset('/admin/del_prior/')}}/@if(isset($priority_data['priorityId'])){{ $priority_data['priorityId']}}?set_id=3 @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;
														<a href="{{asset('/admin/edit_prior/')}}/@if(isset($priority_data['priorityId'])){{ $priority_data['priorityId']}}?set_id=3 @endif" title="edit">
															<i class="fa fa-edit"></i>
														</a>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
				<!--priority list code end-->

				<!--source list code starts-->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Source</h3>
						</div><!-- /.box-header -->
							<div class="box-body">
								@if(isset($set_id))
									@if($set_id==4)
									<form action="" method="PUT" id="source-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="settings_type" id="settings_type" value="4">
										<div class="box-body">
											<div class="form-group">
												<label>Name</label>
												<input type="text" placeholder="Name" name="source_name" id="source_name" value="@if(isset($sourceval->source_name)){{$sourceval->source_name}}@endif" class="form-control">
											</div>
											<div class="form-group">
												<label>Description</label>
												<textarea placeholder="Description" name="source_desc" id="source_desc" class="form-control">@if(isset($sourceval->source_desc)){{$sourceval->source_desc}}@endif</textarea>
											</div>
											<div class="form-group">
												<label>Status</label>
												<br>
												@if(isset($sourceval->status))
													@if($sourceval->status==1)
														<input type="radio" name="status" id="status" value="1" checked>Active
														<input type="radio" name="status" id="status" value="2">In-Active
													@elseif($sourceval->status==2)
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@else
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@endif
												@else
													<input type="radio" name="status" id="status" value="1">Active
													<input type="radio" name="status" id="status" value="2" checked>In-Active
												@endif
											</div>
										</div>
										<div class="box-footer">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
										</div>
									</form>
									@endif
								@endif
								<!--<a id="modal-source" href="#modal-container-source" role="button" class="btn btn-primary" data-toggle="modal">Add Source</a>
								<div style="clear:both;">&nbsp;</div>-->
								<table id="source" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
								<tbody>
									@if(isset($source))
										@foreach($source as $source_data)
											<tr>
												<td>
													@if(isset($source_data['sourceName']))
														{{ $source_data['sourceName']}}
													@endif
												</td>
												<td>
													@if(isset($source_data['sourceDescription']))
														{{ $source_data['sourceDescription']}}
													@endif
												</td>
												<td>
													@if(isset($source_data['sourceStatus']))
														@if($source_data['sourceStatus']==1)
															Active
														@elseif($source_data['sourceStatus']==2)
															In-Active
														@endif
													@endif
												</td>
												<td>
													@if(isset($source_data['sourceCreatedOn']))
														{{ $source_data['sourceCreatedOn'] }}
													@endif
												</td>
												<td>
													@if(isset($source_data['sourceId']))
														<a href="{{asset('/admin/del_source/')}}/@if(isset($source_data['sourceId'])){{ $source_data['sourceId']}}?set_id=4 @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;
														<a href="{{asset('/admin/edit_source/')}}/@if(isset($source_data['sourceId'])){{ $source_data['sourceId']}}?set_id=4 @endif" title="edit">
															<i class="fa fa-edit"></i>
														</a>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
				<!--source list code end-->

				<!--type list code starts-->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Type</h3>
						</div><!-- /.box-header -->

							<div class="box-body">
								@if(isset($set_id))
									@if($set_id==5)
									<form action="" method="PUT" id="type-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="settings_type" id="settings_type" value="5">
										<div class="box-body">
											<div class="form-group">
												<label>Name</label>
												<input type="text" placeholder="Name" name="type_name" id="type_name" value="@if(isset($typeval->type_name)){{$typeval->type_name}}@endif" class="form-control">
											</div>
											<div class="form-group">
												<label>Description</label>
												<textarea placeholder="Description" name="type_desc" id="type_desc" class="form-control">@if(isset($typeval->type_desc)){{$typeval->type_desc}}@endif</textarea>
											</div>
											<div class="form-group">
												<label>Status</label>
												<br>
												@if(isset($typeval->status))
													@if($typeval->status==1)
														<input type="radio" name="status" id="status" value="1" checked>Active
														<input type="radio" name="status" id="status" value="2">In-Active
													@elseif($typeval->status==2)
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@else
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@endif
												@else
													<input type="radio" name="status" id="status" value="1">Active
													<input type="radio" name="status" id="status" value="2" checked>In-Active
												@endif
											</div>
										</div>
										<div class="box-footer">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
										</div>
									</form>
									@endif
								@endif
								<!--<a id="modal-type" href="#modal-container-type" role="button" class="btn btn-primary" data-toggle="modal">Add Type</a>
								<div style="clear:both;">&nbsp;</div>-->
								<table id="type" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
								<tbody>
									@if(isset($type))
										@foreach($type as $type_data)
											<tr>
												<td>
													@if(isset($type_data['typeName']))
														{{$type_data['typeName']}}
													@endif
												</td>
												<td>
													@if(isset($type_data['typeDescription']))
														{{ $type_data['typeDescription']}}
													@endif
												</td>
												<td>
													@if(isset($type_data['typeStatus']))
														@if($type_data['typeStatus']==1)
															Active
														@elseif($type_data['typeStatus']==2)
															In-Active
														@endif
													@endif
												</td>
												<td>
													@if(isset($type_data['typeCreatedOn']))
														{{ $type_data['typeCreatedOn'] }}
													@endif
												</td>
												<td>
													@if(isset($type_data['typeId']))
														<a href="{{asset('/admin/del_type/')}}/@if(isset($type_data['typeId'])){{ $type_data['typeId']}}?set_id=5 @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;
														<a href="{{asset('/admin/edit_type/')}}/@if(isset($type_data['typeId'])){{ $type_data['typeId']}}?set_id=5 @endif" title="edit">
															<i class="fa fa-edit"></i>
														</a>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
				<!--type list code end-->

				<!--status list code starts-->
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Status</h3>
						</div><!-- /.box-header -->
							<div class="box-body">
								@if(isset($set_id))
									@if($set_id==6)
									<form action="" method="PUT" id="status-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="settings_type" id="settings_type" value="6">
										<div class="box-body">
											<div class="form-group">
												<label>Name</label>
												<input type="text" placeholder="Name" name="status_name" id="status_name" value=" @if(isset($statusval->status_name)){{$statusval->status_name}}@endif " class="form-control">
											</div>
											<div class="form-group">
												<label>Description</label>
												<textarea placeholder="Description" name="status_desc" id="status_desc" class="form-control"> @if(isset($statusval->status_desc)){{$statusval->status_desc}}@endif </textarea>
											</div>
											<div class="form-group">
												<label>Status</label>
												<br>
												@if(isset($statusval->status))
													@if($statusval->status==1)
														<input type="radio" name="status" id="status" value="1" checked>Active
														<input type="radio" name="status" id="status" value="2">In-Active
													@elseif($statusval->status==2)
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@else
														<input type="radio" name="status" id="status" value="1">Active
														<input type="radio" name="status" id="status" value="2" checked>In-Active
													@endif
												@else
													<input type="radio" name="status" id="status" value="1">Active
													<input type="radio" name="status" id="status" value="2" checked>In-Active
												@endif
											</div>
										</div>
										<div class="box-footer">
											<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
										</div>
									</form>
									@endif
								@endif
								<table id="status" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Name</th>
											<th>Description</th>
											<th>Status</th>
											<th>Created On</th>
											<th>Action</th>
										</tr>
									</thead>
								<tbody>
									@if(isset($status))
										@foreach($status as $status_data)
											<tr>
												<td>
													@if(isset($status_data['statusName']))
														{{ $status_data['statusName']}}
													@endif
												</td>
												<td>
													@if(isset($status_data['statusDescription']))
														{{ $status_data['statusDescription']}}
													@endif
												</td>
												<td>
													@if(isset($status_data['statusStatus']))
														@if($status_data['statusStatus']==1)
															Active
														@elseif($status_data['statusStatus']==2)
															In-Active
														@endif
													@endif
												</td>
												<td>
													@if(isset($status_data['statusCreatedOn']))
														{{ $status_data['statusCreatedOn'] }}
													@endif
												</td>
												<td>
													@if(isset($status_data['statusId']))
														<a href="{{asset('/admin/del_status/')}}/@if(isset($status_data['statusId'])){{ $status_data['statusId']}}?set_id=6 @endif" title="delete">
															<i class="fa fa-remove"></i>
														</a> &nbsp;&nbsp;
														<a href="{{asset('/admin/edit_status/')}}/@if(isset($status_data['statusId'])){{ $status_data['statusId']}}?set_id=6 @endif" title="edit">
															<i class="fa fa-edit"></i>
														</a>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
					<!--status list code end-->

	<script language="javascript">
		$(function(){
			$("#example1").DataTable();
			$('#department').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});
			$('#category').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});

			$('#priority').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});

			$('#source').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});

			$('#type').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false
			});
		});
	</script>


@endsection


