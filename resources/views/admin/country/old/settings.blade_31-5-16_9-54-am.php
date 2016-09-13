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
<style>
	#department-form label.error{
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
@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
			 @if (session('DeleteUserSuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        User Deleted Successfully
              <script>
              window.setTimeout(function(){
window.location.href = "{{asset('/admin/view_user/')}}";
               }, 1000);
             </script>
                  </div>
                </div>
              @endif
                @if (session('DeleteUserError'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Update ticket
                    </div>
                  </div>
                @endif
				<div class="col-md-6">
					<!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">DepartMent</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form action="" method="POST" id="department-form" novalidate="novalidate">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="box-body">
								<div class="form-group">
									<label>Name</label>
									<input type="text" placeholder="Name" name="dept_name" id="dept_name" class="form-control">
								</div>
								<div class="form-group">
									<label>Description</label>
									<textarea placeholder="Description" name="dept_desc" id="dept_desc" class="form-control"></textarea>
								</div>
								<div class="form-group">
									<label>Status</label>
									<input type="radio" name="status" id="status" value="1">Active
									<input type="radio" name="status" id="status" value="2" checked>In-Active
								</div>
							</div><!-- /.box-body -->
							<div class="box-footer">
								<input type="submit" name="submit" name="submit" value="Submit" class="btn btn-primary">
							</div>
						</form>
					</div><!-- /.box -->
				</div><!-- /.box -->


@endsection


