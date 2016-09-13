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
	<style>
		#subject
		{
		color:#6c6d6f;
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
		          <!--<ol class="breadcrumb" style="margin-bottom:0px;">
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
										<a href="#">Mailbox</a>
									</li>
								</ul>
							</div>
						</div>
      		<!--	</div><!-- /.content-wrapper -->
		        <!-- Main content -->

				<div class="page page-full page-mail">
                    <div class="tbox tbox-sm">
					<!-- left side -->
                        <div class="tcol w-md bg-tr-white lt b-r">
							<!-- left side header-->
                            <div class="p-15 bg-white" style="min-height: 61px">
                                <button class="btn btn-sm btn-default pull-right visible-sm visible-xs" data-toggle="collapse" data-target="#mail-nav" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-bars"></i></button>
                                <a href="{{asset('admin/composemail')}}" class="btn btn-sm btn-lightred b-0 br-2 text-strong">Compose</a>
                            </div>
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
														else{
															$active_class = "class=\"active\"";
														}

														//echo $fid;

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
                        <div class="tcol">
                            <!-- right side header -->
                            <div class="p-15 bg-white b-b">

                                <div class="btn-group pull-right">
                                   <!-- <button type="button" class="btn btn-default btn-sm br-2-l"><i class="fa fa-angle-left"></i></button>
                                    <button type="button" class="btn btn-default btn-sm br-2-r"><i class="fa fa-angle-right"></i></button>-->
                                </div>
                               <div class="btn-toolbar">
                                   <!-- <div class="btn-group mr-10">
                                        <label class="checkbox checkbox-custom-alt m-0 mt-5"><input type="checkbox" id="select-all"><i></i> Select All</label>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-sm br-2"><i class="fa fa-refresh"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-sm br-2">More <span class="caret"></span></button>
                                    </div>-->
                                </div>
                            </div>
                            <!-- /right side header -->

                            <!-- right side body -->
                            <div>
                                <!-- mails -->
                                <ul class="list-group no-radius no-border" id="mails-list">

								<?php
									if(!empty($header_array)){
										foreach($header_array as $header_val){
								?>
                                    <!-- mail in mails -->
                                    <li class="list-group-item b-primary">
                                        <div class="media">
                                            <div class="pull-left">
                                                <div class="controls">
                                                    <!--<a href="javascript:;" class="favourite text-orange toggle-class" data-toggle="active"><i class="fa fa-star-o"></i></a>
                                                    <label class="checkbox checkbox-custom-alt checkbox-custom-sm m-0 mail-select"><input type="checkbox"><i></i></label>-->
                                                </div>
                                                <div class="thumb thumb-sm">
                                                    <img src="{{asset('admin-lte/assets/images/random-avatar1.jpg')}}" class="img-circle">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-heading m-0">
                                                    <a href="{{ url(config('quickadmin.route').'/readmail')}}/<?=(!empty($header_val['Msgno'])?str_replace(" ","",$header_val['Msgno']):"")?>?folderid=<?=(!empty($fid)?$fid:"")?>"><?=(!empty($header_val['from'])?$header_val['from']:"")?></a>
                                                    <span class="pull-right text-sm text-muted">
                                                      <span class="hidden-xs"><?=(!empty($header_val['Date'])?$header_val['Date']:"")?></span>
                                                      <i class="fa fa-paperclip ml-5"></i>
                                                    </span>
                                                </div>
                                                <small><b><a id="subject" href="{{ url(config('quickadmin.route').'/readmail')}}/<?=(!empty($header_val['Msgno'])?str_replace(" ","",$header_val['Msgno']):"")?>?folderid=<?=(!empty($fid)?$fid:"")?>"><?=(!empty($header_val['Subject'])?$header_val['Subject']:"")?></a></b></small>
                                            </div>
                                        </div>

                                    </li>

													<?php
															}
														}
													?>
								</ul>
						</div>
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

		<script>
            $(window).load(function(){

                $('#select-all').change(function() {
                    if ($(this).is(":checked")) {
                        $('#mails-list .mail-select input').prop('checked', true);
                    } else {
                        $('#mails-list .mail-select input').prop('checked', false);
                    }
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