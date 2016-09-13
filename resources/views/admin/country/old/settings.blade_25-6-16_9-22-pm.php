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
            	@if(session('departmentSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Group Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('categorySuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Category Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('prioritySuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Priority Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('sourceSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Source Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('typeSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Type Created Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				@if(session('departmentDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Group Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('categoryDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Category Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('priorityDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Priority Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('sourceDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Source Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@elseif(session('typeDelSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Type Deleted Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/settings/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				<div class="col-md-12">
					<a id="modal-department" href="#modal-container-department" role="button" class="btn btn-primary" data-toggle="modal">Add Group</a>
					<a id="modal-category" href="#modal-container-category" role="button" class="btn btn-primary" data-toggle="modal">Add Category</a>
					<a id="modal-priority" href="#modal-container-priority" role="button" class="btn btn-primary" data-toggle="modal">Add Priority</a>
					<a id="modal-source" href="#modal-container-source" role="button" class="btn btn-primary" data-toggle="modal">Add Source</a>
					<a id="modal-type" href="#modal-container-type" role="button" class="btn btn-primary" data-toggle="modal">Add Type</a>
					<div style="clear:both;">&nbsp;</div>
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Group</h3>
						</div><!-- /.box-header -->
							<div class="box-body">
								<!--<a id="modal-department" href="#modal-container-department" role="button" class="btn btn-primary" data-toggle="modal">Add DepartMent</a>-->
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
									<!--<a id="modal-category" href="#modal-container-category" role="button" class="btn btn-primary" data-toggle="modal">Add Category</a>-->
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
									<!--<a id="modal-priority" href="#modal-container-priority" role="button" class="btn btn-primary" data-toggle="modal">Add Priority</a>-->
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
									<!--<a id="modal-source" href="#modal-container-source" role="button" class="btn btn-primary" data-toggle="modal">Add Source</a>-->
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
									<!--<a id="modal-type" href="#modal-container-type" role="button" class="btn btn-primary" data-toggle="modal">Add Type</a>-->
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
															{{ $type_data['typeName']}}
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
					<!--
					<link href="{{asset('/modal/css/bootstrap.min.css')}}" rel="stylesheet">
					<link href="{{asset('/modal/css/style.css')}}" rel="stylesheet">-->
					<!--Add/Edit Department code starts-->
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="modal fade" id="modal-container-department" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												<h4 class="modal-title" id="myModalLabel">
													Add Group
												</h4>
											</div>
											<div class="modal-body">
												<form action="" method="POST" id="department-form" novalidate="novalidate">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="settings_type" id="settings_type" value="1">
													<div class="box-body">
														<div class="form-group">
															<label>Name</label> <span id="required">*</span>
															<input type="text" placeholder="Name" name="dept_name" id="dept_name" class="form-control">
														</div>
														<div class="form-group">
															<label>Description</label> <span id="required">*</span>
															<textarea placeholder="Description" name="dept_desc" id="dept_desc" class="form-control"></textarea>
														</div>
														<div class="form-group">
															<label>Status</label> <span id="required">*</span>
															<br>
															<input type="radio" name="status" id="status" value="1">Active
															<input type="radio" name="status" id="status" value="2" checked>In-Active
														</div>
													</div>
													<div class="box-footer">
														<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
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

					<!--Add/Edit Category code starts-->
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="modal fade" id="modal-container-category" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												<h4 class="modal-title" id="myModalLabel">
													Add Category
												</h4>
											</div>
											<div class="modal-body">
												<form action="" method="POST" id="category-form" novalidate="novalidate">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="settings_type" id="settings_type" value="2">
													<div class="box-body">
														<div class="form-group">
															<label>Name</label> <span id="required">*</span>
															<input type="text" placeholder="Name" name="cat_name" id="cat_name" class="form-control">
														</div>
														<div class="form-group">
															<label>Description</label> <span id="required">*</span>
															<textarea placeholder="Description" name="cat_desc" id="cat_desc" class="form-control"></textarea>
														</div>
														<div class="form-group">
															<label>Status</label> <span id="required">*</span>
															<br>
															<input type="radio" name="status" id="status" value="1">Active
															<input type="radio" name="status" id="status" value="2" checked>In-Active
														</div>
													</div>
													<div class="box-footer">
														<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
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
					<!--Add/Edit Category code end-->

					<!--Add/Edit Priority code starts-->
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="modal fade" id="modal-container-priority" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
													<h4 class="modal-title" id="myModalLabel">
														Add Priority
													</h4>
												</div>
												<div class="modal-body">
													<form action="" method="POST" id="priority-form" novalidate="novalidate">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<input type="hidden" name="settings_type" id="settings_type" value="3">
														<div class="box-body">
															<div class="form-group">
																<label>Name</label> <span id="required">*</span>
																<input type="text" placeholder="Name" name="priority_name" id="priority_name" class="form-control">
															</div>
															<div class="form-group">
																<label>Description</label> <span id="required">*</span>
																<textarea placeholder="Description" name="priority_desc" id="priority_desc" class="form-control"></textarea>
															</div>
															<div class="form-group">
																<label>Status</label> <span id="required">*</span>
																<br>
																<input type="radio" name="status" id="status" value="1">Active
																<input type="radio" name="status" id="status" value="2" checked>In-Active
															</div>
														</div>
														<div class="box-footer">
															<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
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
					<!--Add/Edit Priority code end-->

					<!--Add/Edit Source code starts-->
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="modal fade" id="modal-container-source" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
													<h4 class="modal-title" id="myModalLabel">
														Add Source
													</h4>
												</div>
												<div class="modal-body">
													<form action="" method="POST" id="source-form" novalidate="novalidate">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<input type="hidden" name="settings_type" id="settings_type" value="4">
														<div class="box-body">
															<div class="form-group">
																<label>Name</label> <span id="required">*</span>
																<input type="text" placeholder="Name" name="source_name" id="source_name" class="form-control">
															</div>
															<div class="form-group">
																<label>Description</label> <span id="required">*</span>
																<textarea placeholder="Description" name="source_desc" id="source_desc" class="form-control"></textarea>
															</div>
															<div class="form-group">
																<label>Status</label> <span id="required">*</span>
																<br>
																<input type="radio" name="status" id="status" value="1">Active
																<input type="radio" name="status" id="status" value="2" checked>In-Active
															</div>
														</div>
														<div class="box-footer">
															<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
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
					<!--Add/Edit Source code end-->

					<!--Add/Edit Type code starts-->
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="modal fade" id="modal-container-type" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
													<h4 class="modal-title" id="myModalLabel">
														Add Type
													</h4>
												</div>
												<div class="modal-body">
													<form action="" method="POST" id="type-form" novalidate="novalidate">
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<input type="hidden" name="settings_type" id="settings_type" value="5">
														<div class="box-body">
															<div class="form-group">
																<label>Name</label> <span id="required">*</span>
																<input type="text" placeholder="Name" name="type_name" id="type_name" class="form-control">
															</div>
															<div class="form-group">
																<label>Description</label> <span id="required">*</span>
																<textarea placeholder="Description" name="type_desc" id="type_desc" class="form-control"></textarea>
															</div>
															<div class="form-group">
																<label>Status</label> <span id="required">*</span>
																<br>
																<input type="radio" name="status" id="status" value="1">Active
																<input type="radio" name="status" id="status" value="2" checked>In-Active
															</div>
														</div>
														<div class="box-footer">
															<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
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
					<!--Add/Edit Type code end-->

					<script language="javascript">
						$(function(){
						$('#department').DataTable( {
							"aaSorting": [[ 3, "desc" ]],
							 "aoColumnDefs" : [
								 {
								   'bSortable' : false,
								   'aTargets' : [ 4 ]
								 }]
							} );
						});

						$(function(){
						$('#category').DataTable( {
							"aaSorting": [[ 3, "desc" ]],
							 "aoColumnDefs" : [
								 {
								   'bSortable' : false,
								   'aTargets' : [ 4 ]
								 }]
							} );
						});


						$(function(){
						$('#priority').DataTable( {
							"aaSorting": [[ 3, "desc" ]],
							 "aoColumnDefs" : [
								 {
								   'bSortable' : false,
								   'aTargets' : [ 4 ]
								 }]
							} );
						});

						$(function(){
						$('#source').DataTable( {
							"aaSorting": [[ 3, "desc" ]],
							 "aoColumnDefs" : [
								 {
								   'bSortable' : false,
								   'aTargets' : [ 4 ]
								 }]
							} );
						});

						$(function(){
						$('#type').DataTable( {
							"aaSorting": [[ 3, "desc" ]],
							 "aoColumnDefs" : [
								 {
								   'bSortable' : false,
								   'aTargets' : [ 4 ]
								 }]
							} );
						});

						/*
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
						*/
					</script>


@endsection


