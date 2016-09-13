@extends('admin.layouts.master')
@section('content')
<section class="content">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script language="javascript">
	function load_employee(id){

		var url_str = "groupId="+id;

		$.ajax({
			type: "GET",
			url: "{{asset('admin/load_group_user_email')}}",
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
<script language="javascript">
	$("form").submit(function(){
		//alert("Submitted");
	});

	/*
	//Bind the event handler to the "submit" JavaScript event
	$("form").submit(function(event){
		// Get the Login Name value and trim it
		var name = $.trim($("#group").val());
		//Check if empty of not
		if(name  === ""){
			alert('Text-field is empty.');
			return false;
		}
	});
	*/

	/*
	$("form").submit(function(event){
		var group_val = $('#group').val();
		if(group_val==""){
			$("#msg").html('<h4 id="error_msg">Filled Required</h4>');
			return false;
		}
		else{
			$("#msg").html('<h4 id="error_msg">Success</h4>');
		}
	});
	*/


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
					$("#compose-form").validate({
						rules: {
							group:{
								required: true
							},
							employee: {
								required: true
							},
							comSubject: {
								required: true
							}
						},
						messages: {
							/*
							requester_name: "Please enter your requester name",
							subject: "Please enter your subject",
							source: "Please provide source",
							category: "Please provide category",
							priority: "Please enter priority",
							group: "Please select group",
							type: "Please select type",
							status: "Please select status",
							employee: "Please select employee",
							description: "Please enter description"
							*/
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
		#compose-form label.error{
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
		<!-- Content Wrapper. Contains page content -->
		  <!--<div class="content-wrapper">    -->
		        <!-- Content Header (Page header) -->
		   <!--	</div><!-- /.content-wrapper -->
		        <!-- Main content -->
				<div class="row">
				<div class="col-md-12">
					@if(session('mailSendSuccess'))
						<div class="flash-message">
							<div class="alert alert-success">
								Mail sent successfully
								<script language="javascript">
									window.setTimeout(function(){window.location.href = "{{asset('/empsendmail/')}}";}, 1000);
								</script>
							</div>
						</div>
					@endif
					@if(session('mailSendError'))
						<div class="flash-message">
							<div class="alert alert-danger">
								Unable to send mail
							</div>
						</div>
					@endif
					<div class="col-md-12">
						<div class="box box-solid">
							<div class="box-body no-padding">

							</div><!-- /.col -->

							<div class="col-md-12">
								<form action="" method="POST" name="compose-form" id="compose-form" novalidate="novalidate" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

							  <div class="box box-primary">
								<div class="box-header with-border">
								  <h3 class="box-title">Compose New Message</h3>
								</div><!-- /.box-header -->
								<div class="box-body">
									<div class="form-group">
										<select class="form-control" name="group" id="group" onchange="load_employee(this.value)">
											<option value="">Select Group</option>
											<?php
												if(!empty($department)){
													foreach($department as $depart){
														$sel_dept="";
														if((!empty($post['group'])) && (!empty($depart['deptId']))){
															if($post['group'] == $depart['deptId']){
																$sel_dept="selected";
															}
														}
											?>
														<option value="<?=(!empty($depart['deptId'])?$depart['deptId']:"")?>" <?=(!empty($sel_dept)?$sel_dept:"")?>><?=(!empty($depart['deptName'])?$depart['deptName']:"")?></option>

											<?php
													}
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<div id="employee_div">
											<select class="form-control" name="employee" id="employee">
												<option value="">Select Employee Name</option>
											</select>
										</div>
									</div>
								  <div class="form-group">
									<input class="form-control" name="comSubject" id="comSubject" placeholder="Subject:">
								  </div>
								  <div class="form-group">
									<textarea class="form-control" id="compose-textarea" name="comTextarea" style="height: 300px">
									</textarea>
								  </div>
								  <!--<div class="form-group">
									<div class="btn btn-default btn-file">
									  <i class="fa fa-paperclip"></i> Attachment
									  <input type="file" name="comAttachment id="comAttachment">
									</div>
									<p class="help-block">Max. 32MB</p>
								  </div>-->
								</div><!-- /.box-body -->
								<div class="box-footer">
								  <div class="pull-right">
									<!--<button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>-->
									<button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
								  </div>
								  <!--<button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>-->
								</div><!-- /.box-footer -->
							  </div><!-- /. box -->
							  </form>
            				</div><!-- /.col -->

						</div><!-- /.row -->
						</div>

				<script language="javascript">
					$("#searchsubmit").click(function(){
						/*if blank return false else true*/

						var group_val = $('#group').val();
						var employee_val = $('#employee').val();
						var priority_val = $('#priority').val();
						var source_val = $('#source').val();
						var created_on_val = $('#created_on').val();

						if((group_val=='')&&(employee_val=='')&&(priority_val=='')&&(source_val=='')&&(created_on_val=='')){
							$("#login_msg").html('<span style="margin-left:23px;padding-top:5px;color:red;">Please select atleast one field to proceed with filter</span>');
						}
						else{
							$("#login_msg").html('');
							$("#ticket-form").submit();
						}
					});

					/*
					$(function () {
						$("#example1").DataTable();
						$('#example2').DataTable({
							"paging": true,
							"lengthChange": false,
							"searching": false,
							"ordering" : true,
							"info": true,
							"autoWidth": false
						});
					});
					*/

					$(function(){
						$('#example1').DataTable( {
							"aaSorting": [[ 3, "desc" ]],
							"aoColumnDefs" : [{
								'bSortable' : false,
								'aTargets' : [ 0 ]
							}]
						});
					});

					$(function(){
						$('#created_on').datepicker({
							format: 'yyyy-mm-dd'
						});
					});
				</script>

    <!-- jQuery 2.1.4 -->
    <script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- iCheck -->
    <script src="../../plugins/iCheck/icheck.min.js"></script>
    <!-- Page Script -->
    <script>
      $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
          var clicks = $(this).data('clicks');
          if (clicks) {
            //Uncheck all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
            $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          } else {
            //Check all checkboxes
            $(".mailbox-messages input[type='checkbox']").iCheck("check");
            $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
          }
          $(this).data("clicks", !clicks);
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
          e.preventDefault();
          //detect type
          var $this = $(this).find("a > i");
          var glyph = $this.hasClass("glyphicon");
          var fa = $this.hasClass("fa");

          //Switch states
          if (glyph) {
            $this.toggleClass("glyphicon-star");
            $this.toggleClass("glyphicon-star-empty");
          }

          if (fa) {
            $this.toggleClass("fa-star");
            $this.toggleClass("fa-star-o");
          }
        });
      });
    </script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
@endsection