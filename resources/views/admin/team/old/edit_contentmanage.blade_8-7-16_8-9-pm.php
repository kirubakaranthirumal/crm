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
	                    //menu_parent: "required",
	                    menu_name: "required",
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
	                    //menu_parent: "Please Select Parent Menu",
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
				@elseif (session('menuNameUpdateError'))
					<div class="flash-message">
						 <div class="alert alert-danger">
							Error : Menu name already exist
							<?php
								if(!empty($cid)){
							?>
									<script>
										window.setTimeout(function(){window.location.href = "{{asset('/admin/contentmanage/')/$cid}}";}, 1000);
									</script>
							<?
								}
							?>
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
									//print"<pre>";
									//print_r($menuval);
									/*
									print"<pre>";
									print_r($parent_menu);
									exit;
									*/

									//echo $menucontent['menuId']."<br>";
									//echo $menuval['menuId'];
									//exit;
								?>

								@if(isset($set_id))
									@if($set_id==1)

									<form action="" method="PUT" id="contentmanage-form" novalidate="novalidate">
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<!--<input type="hidden" name="settings_type" id="settings_type" value="1">-->
										<div class="box-body">
													<div class="form-group">
															<label>Parent</label>
															<select name="menu_parent" id="menu_parent" class="form-control">
																<option value="0">Select Parent</option>
																<?php
																	if(!empty($parent_menu)){
																		foreach($parent_menu as $parent_menu_data){
																			$menu_parent_sel="";
																			if((!empty($parent_menu_data['menuId'])) && (!empty($menuval['menuParent']))){
																				if($parent_menu_data['menuId'] == $menuval['menuParent']){
																					$menu_parent_sel="selected";
																				}
																			}
																?>
																			<option value="<?=(!empty($parent_menu_data['menuId'])?$parent_menu_data['menuId']:"")?>" <?=(!empty($menu_parent_sel)?$menu_parent_sel:"")?>><?=(!empty($parent_menu_data['menuName'])?$parent_menu_data['menuName']:"")?></option>
																<?php
																		}
																	}
																?>
															</select>
														</div>
												<div class="form-group">
															<label>Name</label>&nbsp;<span id="required">*</span>
															<input type="text" placeholder="Name" name="menu_name" id="menu_name" class="form-control" value="<?=(!empty($menuval['menuName'])?$menuval['menuName']:"")?>">
											    </div>
												<div class="form-group">
															<label>Title</label>&nbsp;<span id="required">*</span>
															<input type="text" placeholder="Title" name="menu_title" id="menu_title" class="form-control" value="<?=(!empty($menuval['menuTitle'])?$menuval['menuTitle']:"")?>">
												</div>
												<!--<div class="form-group">
													<label>Description</label>&nbsp;<span id="required">*</span>
													<textarea placeholder="Description" name="menu_desc" id="menu_desc" class="form-control"><?=(!empty($menuval['menuDescription'])?$menuval['menuDescription']:"")?></textarea>
												</div>-->
												<div class="form-group">
													<label>Description <span id="required">*</span></label>
													<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
													<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
													<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12" >@if(isset($menuval['menuDescription'])){{$menuval['menuDescription']}}@endif</textarea>
													<script>
														initSample();
													</script>
												</div>
												<div class="form-group">
													<label>Sort</label>&nbsp;<span id="required">*</span>
													<input type="text" placeholder="Sort Order" name="menu_sort" id="menu_sort" class="form-control" value="<?=(!empty($menuval['menuSortOrder'])?$menuval['menuSortOrder']:"")?>">
												</div>
												<div class="form-group">
														<label>Visible Frontend</label>
														<br>
														<?php
															$visible_yes_checked="";
															$visible_no_checked="";
															if(!empty($menuval['menuVisible'])){
																if($menuval['menuVisible']==1){
																	$visible_yes_checked="checked";
																	$visible_no_checked="";
																}
																elseif($menuval['menuVisible']==2){
																	$visible_yes_checked="";
																	$visible_no_checked="checked";
																}
															}
															else{
																$visible_yes_checked="";
																$visible_no_checked="checked";
															}
														?>
														<input type="radio" name="menu_visible" id="menu_visible" value="1" <?=(!empty($visible_yes_checked)?$visible_yes_checked:"")?>> Visible</input>&nbsp;&nbsp;
														<input type="radio" name="menu_visible" id="menu_visible" value="2" <?=(!empty($visible_no_checked)?$visible_no_checked:"")?>> In-Visible</input>
													</div>
													<div class="form-group">
														<label>Status</label>
														<br>
														<?php
															$active_checked="";
															$inactive_checked="";
															if(!empty($menuval['menuStatus'])){
																if($menuval['menuStatus']==1){
																	$active_checked="checked";
																	$inactive_checked="";
																}
																elseif($menuval['menuStatus']==2){
																	$active_checked="";
																	$inactive_checked="checked";
																}
															}
															else{
																$active_checked="";
																$inactive_checked="checked";
															}
														?>
														<input type="radio" name="status" id="status" value="1" <?=(!empty($active_checked)?$active_checked:"")?>> Active
														<input type="radio" name="status" id="status" value="2" <?=(!empty($inactive_checked)?$inactive_checked:"")?>> In-Active
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


