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
	            $("#country-form").validate({
	                rules: {
	                    country_name:"required",
	                    country_flag:"required",
	                    country_short_name:"required",
	                    country_code:"required",
	                    country_mobile_digits:"required"
	                },
	                messages:{
	                    country_name: "Please provide country name",
	                    country_flag: "Please provide country flag",
	                    country_short_name: "Please provide short name",
	                    country_code: "Please provide country code",
	                    country_mobile_digits: "Please enter mobile digits"
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
	#country-form label.error{
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
<div class="page page-forms-common">
	<div class="pageheader">
		<h2>Country Management</h2>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="#"><i class="fa fa-home"></i> CRM</a>
				</li>
				<li>
					<a href="#">Country Management</a>
				</li>
				<li>
					<a href="#">Update Country</a>
				</li>
			</ul>

		</div>
		<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
	</div>
	<!-- tile -->
	<section class="tile">
		@if(session('countryUpdateSuccess'))
			<div class="flash-message">
				<div class="alert alert-success">
					{{session('countryUpdateSuccess')}}
					<script language="javascript">
						window.setTimeout(function(){window.location.href = "{{asset('/admin/view_country/')}}";}, 1000);
					</script>
				</div>
			</div>
			<div style="clear:both;">&nbsp;</div>
		@endif
		@if(session('countryUpdError'))
			<div class="flash-message">
				<div class="alert alert-danger">
				 {{session('countryUpdError')}}
				</div>
			</div>
		@endif
		<div style="clear:both;"></div>
			<!-- tile header -->
			<div class="tile-header dvd dvd-btm">
			<h1 class="custom-font"><strong>Update Country</strong></h1>
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
									<i class="fa fa-refresh"></i>Refresh
								</a>
							</li>
							<li>
								<a role="button" tabindex="0" class="tile-fullscreen">
									<i class="fa fa-expand"></i>Fullscreen
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
				<form action="#" method="PUT" id="country-form" class="form-horizontal" novalidate="novalidate" enctype="multipart/form-data">
					<div class="col-md-6">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label>Name <span id="required">*</span></label>
							<!--
								stdClass Object
								(
									[msg] => Country list
									[countryCode] => 123456
									[StortName] => IN
									[countryName] => India
									[countryFlags] => India
									[createdOn] => 2016-08-13 15:42:58.459
									[countryId] => 2
									[status] => 200
								)
							-->
							<input type="text" name="country_name" id="country_name" class="form-control" placeholder="Name" tabindex="1" value="<?=(!empty($countrydata->countryName)?$countrydata->countryName:"")?>">
						</div>
						<hr class="line-dashed line-full"/>
						<div class="form-group">
							<label>Flag<span id="required">*</span></label>
							<input type="file" name="country_flag" id="country_flag" class="form-control" placeholder="Flag" tabindex="3" value="<?=(!empty($countrydata->countryFlags)?$countrydata->countryFlags:"")?>">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Short Name</label> <span id="required">*</span></label>
							<input type="text" name="country_short_name" id="country_short_name" class="form-control" placeholder="Short Name" tabindex="2" value="<?=(!empty($countrydata->StortName)?$countrydata->StortName:"")?>">
						</div>
						<hr class="line-dashed line-full"/>
						<div class="form-group">
							<label>Code</label> <span id="required">*</span></label>
							<input type="text" name="country_code" id="country_code" class="form-control" placeholder="Code" tabindex="4" value="<?=(!empty($countrydata->countryCode)?$countrydata->countryCode:"")?>">
						</div>	
						<hr class="line-dashed line-full"/>
					</div>
					<div class="box-footer">
						<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-arrow-right"></i></button>
						{!! HTML::link('admin/view_country', 'Cancel', array('class' => 'btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10')) !!}
					</div>
				</form>
				<div style="clear:both">&nbsp;</div>
			</div>
		</section>
	</div>
@endsection


