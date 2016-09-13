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
		<!-- Content Wrapper. Contains page content -->
		  <!--<div class="content-wrapper">    -->
		        <!-- Content Header (Page header) -->
		        <section class="content-header">
		          <!--<h1>
		            Mailbox
		            <small>13 new messages</small>
		          </h1>-->
		          <ol class="breadcrumb">
		            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		            <li class="active">Mailbox</li>
		          </ol>
		        </section>
      		<!--	</div><!-- /.content-wrapper -->
		        <!-- Main content -->

				<div class="row">
				<div class="col-md-12">
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
					<div class="col-md-3">
						<a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>
						<div class="box box-solid">
							<div class="box-header with-border">
								<h3 class="box-title">Folders</h3>
								<div class="box-tools">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
		                	<div class="box-body no-padding">
		                  		<?php
										if(!empty($sidebarmail)){
											//print"<pre>";
											//print_r($sidebarmail);
										}
		                  				if(!empty($sidebarmail)){
		                  		?>
										  <ul class="nav nav-pills nav-stacked">
											<?php
												foreach($sidebarmail as $sidebarmailval){
											?>
													<?php
														$all_active_class = "";
														$inbox_active_class = "";
														$drafts_active_class = "";
														$important_active_class = "";
														$sent_active_class = "";
														$spam_active_class = "";
														$starred_active_class = "";
														$trash_active_class = "";

														if(!empty($fid)){
															if($fid == "1"){
																$all_active_class = "class=\"active\"";
															}
															elseif($fid == "2"){
																$inbox_active_class = "class=\"active\"";
															}
															elseif($fid == "3"){
																$drafts_active_class = "class=\"active\"";
															}
															elseif($fid == "4"){
																$important_active_class = "class=\"active\"";
															}
															elseif($fid == "5"){
																$sent_active_class = "class=\"active\"";
															}
															elseif($fid == "6"){
																$spam_active_class = "class=\"active\"";
															}
															elseif($fid == "7"){
																$starred_active_class = "class=\"active\"";
															}
															elseif($fid == "8"){
																$trash_active_class = "class=\"active\"";
															}
														}
														else{
															$inbox_active_class = "class=\"active\"";
														}

														//echo $inbox_active_class;
													?>
													<!--
													<?php
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/All Mail'])){
													?>
															<li <?=(!empty($inbox_active_class)?$inbox_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=1"><i class="fa fa-envelope-o"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/All Mail'])?"All Mail":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/All Mail'])?$sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/All Mail']:"0")?></span></a></li>
													<?php
														}
													?>
													-->
													<?php
														//echo $sidebarmailval['{imap.gmail.com:993/ssl}INBOX'];
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}INBOX'])){
													?>
															<li <?=(!empty($inbox_active_class)?$inbox_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=2"><i class="fa fa-inbox"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}INBOX'])?"INBOX":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}INBOX'])?$sidebarmailval['{imap.gmail.com:993/ssl}INBOX']:"0")?></span></a></li>
													<?php
														}
													?>

													<?php
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Sent Mail'])){
													?>
															<li <?=(!empty($sent_active_class)?$sent_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=5"><i class="fa fa-envelope-o"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Sent Mail'])?"Sent":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Sent Mail'])?$sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Sent Mail']:"0")?></span></a></li>
													<?php
														}
													?>

													<?php
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Drafts'])){
													?>
															<li <?=(!empty($drafts_active_class)?$drafts_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=3"><i class="fa fa-file-text-o"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Drafts'])?"Drafts":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Drafts'])?$sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Drafts']:"0")?></span></a></li>
													<?php
														}
													?>

													<?php
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Important'])){
													?>
															<li <?=(!empty($important_active_class)?$important_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=4"><i class="fa fa-file-text-o"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Important'])?"Important":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Important'])?$sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Important']:"0")?></span></a></li>
													<?php
														}
													?>

													<?php
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Spam'])){
													?>
															<li <?=(!empty($spam_active_class)?$spam_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=6"><i class="fa fa-envelope-o"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Spam'])?"Spam":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Spam'])?$sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Spam']:"0")?></span></a></li>
													<?php
														}
													?>
													<?php
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Starred'])){
													?>
															<li <?=(!empty($starred_active_class)?$starred_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=7"><i class="fa fa-envelope-o"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Starred'])?"Spam":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Starred'])?$sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Starred']:"0")?></span></a></li>
													<?php
														}
													?>

													<?php
														if(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Trash'])){
													?>
															<li <?=(!empty($trash_active_class)?$trash_active_class:"")?>><a href="{{ url(config('quickadmin.route').'/mailbox')}}?fid=8"><i class="fa fa-envelope-o"></i><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Trash'])?"Trash":"")?><span class="label label-primary pull-right"><?=(!empty($sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Trash'])?$sidebarmailval['{imap.gmail.com:993/ssl}[Gmail]/Trash']:"0")?></span></a></li>
													<?php
														}
													?>
											<?php
												}
											?>
										  </ul>
									  <?php
											}
									  ?>
		              				  </div><!-- /.box-body -->
		              				</div><!-- /. box -->
									<div class="box box-solid">
								</div><!-- /.box -->
							</div><!-- /.col -->

							<div class="col-md-9">
								<form action="" method="POST" name="compose-form" id="compose-form" novalidate="novalidate" enctype="multipart/form-data">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">

							  <div class="box box-primary">
								<div class="box-header with-border">
								  <h3 class="box-title">Compose New Message</h3>
								</div><!-- /.box-header -->
								<div class="box-body">
								  <div class="form-group">
									<input class="form-control" name="comTo" id="comTo" placeholder="To:">
								  </div>
								  <div class="form-group">
									<input class="form-control" name="comSubject" id="comSubject" placeholder="Subject:">
								  </div>
								  <div class="form-group">
									<textarea class="form-control" id="compose-textarea" name="comTextarea" style="height: 300px">
									</textarea>
								  </div>
								  <div class="form-group">
									<div class="btn btn-default btn-file">
									  <i class="fa fa-paperclip"></i> Attachment
									  <input type="file" name="comAttachment id="comAttachment">
									</div>
									<p class="help-block">Max. 32MB</p>
								  </div>
								</div><!-- /.box-body -->
								<div class="box-footer">
								  <div class="pull-right">
									<button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
									<button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
								  </div>
								  <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
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