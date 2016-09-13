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
						menu_title:"required",
						menu_desc:"required",
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
	                    menu_name: "Please enter menu name",
						menu_title: "Please enter menu title",
						menu_desc: "Please enter menu desc",
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
				@if(session('contentManageUpdSuc'))
					<div class="flash-message">
						<div class="alert alert-success">
							Menu Updated Successfully
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/contentmanage/')}}";}, 1000);
							</script>
						</div>
					</div>
					@endif
				<div class="col-md-12">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Menu</h3>
						</div><!-- /.box-header -->
						
							<div class="box-body">
								<!--<a id="modal-department" href="#modal-container-department" role="button" class="btn btn-primary" data-toggle="modal">Add DepartMent</a>-->
								
								<?php
									print"<pre>";
									print_r($menuval);
								?>
						
								@if(isset($set_id))
									@if($set_id==1)

									<form action="" method="PUT" id="contentmanage-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<!--<input type="hidden" name="settings_type" id="settings_type" value="1">-->
										<div class="box-body">
													<div class="form-group">
															<label>Menu Parent</label>
															<select name="menu_parent" id="menu_parent" class="form-control">
															<option value="">Select Parent</option>
																@if(isset($menuval->menu_parent_id))
																		@if(isset($menucontent['menuId']))
																				@if($menucontent['menuId'] == $menuval->menu_id)
																					<option value="{{$menu_data['menuId']}}" selected>{{$menu_data['menuName']}}</option>
																				@endif
																		@endif
																	@foreach($menucontent as $menu_data)
																		@if($menu_data['menuParent']==0)
																		<option value="{{$menu_data['menuId']}}">{{$menu_data['menuName']}}</option>
																			@endif
																		@endforeach
																	@endif
															</select>
														</div>
												<div class="form-group">
															<label>Menu Name</label>
															<input type="text" placeholder="Menu Name" name="menu_name" id="menu_name" class="form-control"
															value="<?(!empty($menuName[]))?>">
											    </div>
												<div class="form-group">
															<label>Menu Title</label>
															<input type="text" placeholder="Menu Title" name="menu_title" id="menu_title" class="form-control"
															value="">
												</div>
												<div class="form-group">
														<label>Description</label>
														<textarea placeholder="Description" name="menu_desc" id="menu_desc" class="form-control"></textarea>
												</div>
													<div class="form-group">
															<label>Menu Sort</label>
															<input type="text" placeholder="Sort" name="menu_sort" id="menu_sort" class="form-control"
															value="">
														</div>
												<div class="form-group">
														<label>Menu Visible Frontend</label>
														<br>

														<input type="radio" name="menu_visible" id="menu_visible" value="1" checked> Visible</input>&nbsp;&nbsp;
														<input type="radio" name="menu_visible" id="menu_visible" value="2" > In-Visible</input>

														<input type="radio" name="menu_visible" id="menu_visible" value="1" > Visible</input>&nbsp;&nbsp;
														<input type="radio" name="menu_visible" id="menu_visible" value="2" checked > In-Visible</input>

														<input type="radio" name="menu_visible" id="menu_visible" value="1"> Visible</input>&nbsp;&nbsp;
														<input type="radio" name="menu_visible" id="menu_visible" value="2" checked> In-Visible</input>
														
													</div>
													<div class="form-group">
														<label>Status</label>
														<br>
														
														<input type="radio" name="status" id="status" value="1" checked> Active
														<input type="radio" name="status" id="status" value="2"> In-Active
													
														<input type="radio" name="status" id="status" value="1"> Active
														<input type="radio" name="status" id="status" value="2" checked> In-Active
													
														<input type="radio" name="status" id="status" value="1"> Active
														<input type="radio" name="status" id="status" value="2" checked> In-Active															
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
											<th>Menu Name</th>
											<th>Menu Title</th>
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
															{{$menu_data['menuCreatedOn']}}
														@endif
													</td>
													<td>
														@if(isset($menu_data['menuId']))
															<a href="{{asset('/admin/edit_menu/')}}/@if(isset($menu_data['menuId'])){{ $menu_data['menuId']}}?set_id=1 @endif" title="edit">
																<i class="fa fa-edit"></i>
															</a>&nbsp;&nbsp;
															<a href="{{asset('/admin/del_menu/')}}/@if(isset($menu_data['menuId'])){{ $menu_data['menuId']}}?set_id=1 @endif" title="delete">
																<i class="fa fa-remove"></i>
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
	</section>

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
		});
	</script>


@endsection


