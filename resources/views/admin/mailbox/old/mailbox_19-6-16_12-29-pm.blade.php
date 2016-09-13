@extends('admin.layouts.master')
@section('content')
<section class="content">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">Inbox</h3>
									<!--<div class="box-tools pull-right">
										<div class="has-feedback">
											<input type="text" class="form-control input-sm" placeholder="Search Mail">
											<span class="glyphicon glyphicon-search form-control-feedback"></span>
										</div>
									</div>--><!-- /.box-tools -->
								</div><!-- /.box-header -->
								<div class="box-body no-padding">
									<div class="mailbox-controls">
										<!-- Check all button -->
										<!--<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
										<div class="btn-group">
											<button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
											<button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
											<button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
										</div>
										<button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
										<div class="pull-right">
											1-50/200
											<div class="btn-group">
												<button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
												<button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
											</div>
										</div>--><!-- /.pull-right -->
									</div>
										<div class="table-responsive mailbox-messages" style"margin-left:2%;">
											<table id="example1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th><button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button></th>
														<th>From</th>
														<th>Subject</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
													<?php
														if(!empty($header_array)){
															foreach($header_array as $header_val){
													?>
															<tr>
																<td><!--<?=(!empty($header_val['Msgno'])?$header_val['Msgno']:"")?>--><input type="checkbox" name="del_<?=(!empty($header_val['Msgno'])?$header_val['Msgno']:"")?>"></td>
																<!--<td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>-->
																<td class="mailbox-name"><a href="{{ url(config('quickadmin.route').'/readmail')}}/<?=(!empty($header_val['Msgno'])?$header_val['Msgno']:"")?>?folderid=2"><?=(!empty($header_val['from'])?$header_val['from']:"")?></a></td>
																<td class="mailbox-subject"><b><a href="{{ url(config('quickadmin.route').'/readmail')}}/<?=(!empty($header_val['Msgno'])?$header_val['Msgno']:"")?>?folderid=2"><?=(!empty($header_val['Subject'])?$header_val['Subject']:"")?></a></b><!-- - Trying to find a solution to this problem...--></td>
																<!--<td class="mailbox-attachment"></td>-->
																<td class="mailbox-date"><?=(!empty($header_val['Date'])?$header_val['Date']:"")?></td>
															</tr>
													<?php
															}
														}
													?>
												</tbody>
											</table>
											<!--<table id="" class="table table-bordered table-striped">
												<tbody>
													<?php
														//print"<pre>";
														//print_r($header_array);
														//exit;

														//echo $folderid;
														//exit;

														if(!empty($header_array)){
															foreach($header_array as $header_val){
																//print"<pre>";
																//print_r($header_val);
																//exit;
													?>
															<tr>
																<td><input type="checkbox"></td>
																<td class="mailbox-name"><a href="read-mail.html"><?=(!empty($header_val['from'])?$header_val['from']:"")?></a></td>
																<td class="mailbox-subject"><b><a href="{{ url(config('quickadmin.route').'/readmail')}}/<?=(!empty($header_val['Msgno'])?$header_val['Msgno']:"")?>?folderid=2"><?=(!empty($header_val['Subject'])?$header_val['Subject']:"")?></a></b></td>
																<td class="mailbox-date"><?=(!empty($header_val['Date'])?$header_val['Date']:"")?></td>
															</tr>
													<?php
															}
														}
														else{
													?>
															<tr>
																<td colspan="4">No Mail Found</td>
															</tr>
													<?php
														}
													?>
												</tbody>
											</table>--><!-- /.table -->
										</div><!-- /.mail-box-messages -->
									</div><!-- /.box-body -->
									<div class="box-footer no-padding">
										<div class="mailbox-controls">
											<!-- Check all button -->
											<!--<button class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
											<div class="btn-group">
												<button class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
												<button class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
												<button class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
											</div>
											<button class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
											<div class="pull-right">
												1-50/200
												<div class="btn-group">
													<button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
													<button class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
												</div>
											</div>--><!-- /.pull-right -->
										</div>
									</div>
								</div><!-- /. box -->
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