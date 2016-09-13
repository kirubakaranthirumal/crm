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
			url: "{{asset('admin/load_group_user')}}",
			data: url_str,
			success: function(data){
				$('#employee_div').html(data);
			}
		});
	}

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
							comTo: {
								required: true,
								email: true
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
			border-radius:2px;
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
		        <section class="content-header">
		          <!--<h1>
		            Mailbox
		            <small>13 new messages</small>
		          </h1>-->
		        <!--  <ol class="breadcrumb" style="margin-bottom:0px;">
		            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		            <li class="active">Mailbox</li>
		          </ol>-->
		        </section>
		                <div class="page page-forms-common">
						        	<div class="pageheader">
										<h2>Mailbox</h2>
										<div class="page-bar">
											<ul class="page-breadcrumb">
												<li>
													<a href="#"><i class="fa fa-home"></i> CRM</a>
												</li>
												<li>
													<a href="#">Compose</a>
												</li>

											</ul>
						</div>
						</div>
      		<!--	</div><!-- /.content-wrapper -->
		        <!-- Main content -->

					@if (session('composeSuccess'))
						<div class="flash-message">
							 <div class="alert alert-success">
								Mail Sent successfully
								<script>
									window.setTimeout(function(){window.location.href = "{{asset('/admin/composemail/')}}";}, 2000);
								</script>
							</div>
						</div>
					@endif
					<div class="page page-full page-mail">
                    <div class="tbox tbox-sm">
					<!-- left side -->
                        <div class="tcol w-md bg-tr-white lt b-r">
							<!-- left side header-->

                            <!-- /left side header -->
                            <!-- left side body -->
                            <div class="p-15 collapse collapse-xs collapse-sm" id="mail-nav">

		                  		<?php
									if(!empty($sidebarmail)){
										//print"<pre>";
										//print_r($sidebarmail);
										//exit;
									}
									if(!empty($sidebarmail)){
							?>
									  <ul class="nav nav-pills nav-stacked">
										<?php
											$mail_link = "";
											$mail_disp = "";
											foreach($sidebarmail as $sidebarmailval){
										?>
												<?php

													if(!empty(substr($sidebarmailval['mailboxval'],48))){
														//$mail_link = urlencode(substr($sidebarmailval['mailboxval'],48));
														$mail_link = substr($sidebarmailval['mailboxval'],48);
													}
													else{
														$mail_link = "INBOX";
													}

													if(!empty($sidebarmailval['mailboxval'])){
														$mail_disp = substr($sidebarmailval['mailboxval'],48);
													}

													$active_class = "";
													if(!empty($fid)){
														if($fid == $mail_link){
															$active_class = "class=\"active\"";
														}
													}
													//else{
													//	$active_class = "class=\"active\"";
													//}

													if(!empty($sidebarmailval['foldercount'])){
												?>

												<li <?=(!empty($active_class)?$active_class:"")?>>
													<a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=<?=(!empty($mail_link)?$mail_link:"INBOX")?>">
														<i class="fa fa-inbox"></i>
														<?=(!empty($mail_disp)?$mail_disp:"Inbox")?>
														<span class="label label-primary pull-right">
															<?=(!empty($sidebarmailval['foldercount'])?$sidebarmailval['foldercount']:"0")?>
														</span>
													</a>
												</li>
										<?php
												}
											}
										?>
									  </ul>
								  <?php
										}
								  ?>
								  </div><!-- /.box-body -->
								</div><!-- /. box -->
							<!-- right side -->
                        <div class="tcol" style="background:#fff;">
                            <!-- right side header -->
                            <div class="p-15 bg-white b-b">
                                <div class="btn-toolbar">
                                    <div class="btn-group">
                                    	<h4 class="box-title">Compose New Message</h4>
                                      <!--  <button class="btn btn-default btn-sm br-2-l w-60"><i class="fa fa-file"></i></button>
                                        <button class="btn btn-default btn-sm br-2-r w-60"><i class="fa fa-trash"></i></button>-->
                                    </div>
                                </div>
                            </div>
                            <!-- /right side header -->

                            <!-- right side body -->
                            <div class="p-15">
							<div class="box-header with-border">
								<!--<h3 class="box-title">Compose New Message</h3>-->
							</div><!-- /.box-header -->
								<form action="#" class="form-horizontal mt-20" method="POST" name="compose-form" id="compose-form" novalidate="novalidate" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="box box-primary col-md-12">

										<div class="box-body">
											<div class="form-group">
												<input class="form-control" name="comTo" id="comTo" placeholder="To:">
											</div>
											<div class="form-group">
												<input class="form-control" name="comSubject" id="comSubject" placeholder="Subject:">
											</div>
											<!--<div class="form-group">
												<textarea class="form-control" id="compose-textarea" name="comTextarea" style="height: 300px"></textarea>
											</div>-->
											<div class="form-group">
												<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
												<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
												<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12" ></textarea>
												<script>
													initSample();
												</script>
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
											<button type="submit" name="submit" value="Submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-envelope-o"></i></button>
											<!--<button type="submit" class="btn btn-primary"> Send</button>-->
										</div><!-- /.box-footer -->
									</div><!-- /. box -->
							  	</form>
            				</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
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