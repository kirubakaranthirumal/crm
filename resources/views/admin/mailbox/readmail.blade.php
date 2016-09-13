@extends('admin.layouts.master')
@section('content')
<section class="content">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script language="javascript">

	function fn_get_form_values(fobj,valFunc){			
		var str = "";
		var valueArr = null;
		var val = "";
		var cmd = "";	
		
		//alert(fobj);	
		
		for(var i = 0;i < fobj.elements.length;i++){
			
			//alert(fobj.elements[i].type);
			
			switch(fobj.elements[i].type){
				
				case "text":
					if(valFunc){
						//use single quotes for argument so that the value of
						//fobj.elements[i].value is treated as a string not a literal
						cmd = valFunc + "(" +'fobj.elements[i].value' + ")";
						val = eval(cmd)
					}

					str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";

					break;

				case "password":
					if(valFunc)
					{
						//use single quotes for argument so that the value of
						//fobj.elements[i].value is treated as a string not a literal
						cmd = valFunc + "(" +'fobj.elements[i].value' + ")";
						val = eval(cmd)
					}

					str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";

					break;

				case "hidden":
					str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";
					break;

				case "file":
					str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";
					break;

				case "select-one":
					str += fobj.elements[i].name +"=" +fobj.elements[i].options[fobj.elements[i].selectedIndex].value+ "&";
					break;

				case "radio":
					if(fobj.elements[i].checked){
						str += fobj.elements[i].name +"=" +fobj.elements[i].value+ "&";
					}
					break;

				case "checkbox":
					if(fobj.elements[i].checked){
						str += fobj.elements[i].name +"=" +fobj.elements[i].value+ "&";
					}
					break;

				case "textarea":
					//str += fobj.elements[i].name +"=" +escape(fobj.elements[i].value)+ "&";
					if(valFunc){
						//use single quotes for argument so that the value of
						//fobj.elements[i].value is treated as a string not a literal
						cmd = valFunc + "(" +'fobj.elements[i].value' + ")";
						val = eval(cmd)
					}

					str += fobj.elements[i].name +"=" + escape(fobj.elements[i].value) + "&";

					break;
			}
		}
		str = str.substr(0,(str.length - 1));
		return str;
	}	

	function load_reply(act,frmobj){
		
		var url_str="action="+act;
		
		if(act=="add_reply"){
			var poststr = fn_get_form_values(frmobj,'');
			var url_str =url_str+"&"+poststr;	
		}
		
		alert(url_str);

		$.ajax({
			type: "POST",
			url: "{{asset('admin/replymail')}}",
			data: url_str,
			success: function(data){
				$('#reply_div').html(data);
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
		          <!--<ol class="breadcrumb">
		            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		            <li class="active">Mailbox</li>
		          </ol>-->

		        </section>
      		<!--	</div><!-- /.content-wrapper -->
		        <!-- Main content -->

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
								<li>
									<a href="#"><?=(!empty($folderid)?$folderid:"")?></a>
								</li>
							</ul>
						</div>
					</div>


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

														//echo $folderid;
														//echo $mail_link;
														//exit;

														$active_class = "";
														if(!empty($folderid)){
															if($folderid == $mail_link){
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
                        <div class="tcol">
                            <!-- right side header -->
                            <div class="p-15 bg-white b-b">

                                <!--<div class="btn-toolbar">
                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-default btn-sm br-2-l"><i class="fa fa-angle-left"></i></button>
                                        <button type="button" class="btn btn-default btn-sm br-2-r"><i class="fa fa-angle-right"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <a ui-sref="app.mail.inbox" class="btn btn-default btn-sm br-2 w-60" href="#/app/mail/inbox"><i class="fa fa-long-arrow-left"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-sm br-2-l w-60"><i class="fa fa-download"></i></button>
                                        <button class="btn btn-default btn-sm w-60"><i class="fa fa-exclamation-triangle"></i></button>
                                        <button class="btn btn-default btn-sm br-2-r w-60"><i class="fa fa-trash-o"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-sm br-2-l w-60"><i class="fa fa-folder mr-5"></i>  <span class="caret"></span></button>
                                        <button class="btn btn-default btn-sm br-2-r w-60"><i class="fa fa-tags mr-5"></i>  <span class="caret"></span></button>
                                    </div>
                                </div>-->

                            </div>
                            <!-- /right side header -->
							<div class="p-15 b-b" style="background:#fff;">
                                <div class="media">
										<?php
											//print"<pre>";
											//print_r($header_data);
											//exit;
										?>
										<?php
											//print"<pre>";
											//print_r($head_val->toaddress);
										?>	
										<?php
											if(!empty($header_data['Subject'])){
										?>
												<!--<h3 class="box-title"><?=$header_data['Subject']?></h3>-->
										<?php
											}
										?>

										<?php
											if(!empty($msg_header)){
										?>
												<div class="table-responsive mailbox-messages" style"margin-left:2%;">
													<h3 class="box-title"><?=$msg_header?></h3>
												</div><!-- /.mail-box-messages -->
										<?php
											}
										?>
									<!--<div class="box-tools pull-right">
										<div class="has-feedback">
											<input type="text" class="form-control input-sm" placeholder="Search Mail">
											<span class="glyphicon glyphicon-search form-control-feedback"></span>
										</div>
									</div>--><!-- /.box-tools -->
								<div>
									<!--<a id="reply-mail" onClick="reply_to()" href="#modal-container-reply-mail" data-toggle="modal" data-target="#modal-container-reply-mail" data-options="splash-2 splash-ef-11">Reply</a>-->
									<!--<a id="reply-mail" href="admin/replymail">Reply</a>-->									
									<?php
										print"<pre>";
										print_r($head_val);
									?>									
									<!--<a href="{{ url(config('quickadmin.route').'/replymail')}}?fid=">
										Reply
									</a>-->
									<!--<a href="{{ url(config('quickadmin.route').'/replymail')}}?fid=<?=(!empty($mail_link)?$mail_link:"INBOX")?>">
										Reply
									</a>-->									
								</div>								
								<div class="box-body no-padding">
									<div class="mailbox-controls">
									</div>
										<div class="table-responsive mailbox-messages" style"margin-left:2%;">

										</div><!-- /.mail-box-messages -->
									</div><!-- /.box-body -->
									<div class="box-footer no-padding">
										<div class="mailbox-controls">
											<?php
												if(!empty($msg_detail)){
											?>
													<div class="table-responsive mailbox-messages" style"margin-left:2%;">
														<?=$msg_detail?>
													</div><!-- /.mail-box-messages -->
											<?php
												}
											?>
										</div>
									</div>
								</div><!-- /. box -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">	
			<div class="modal splash fade" id="modal-container-reply-mail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">
								Reply
							</h4>
						</div>
						<form action="" method="POST" id="reply_mail_form" name="reply_mail_form" novalidate="novalidate" enctype="multipart/form-data">
							<div class="modal-body">							
								<div class="form-group">
									<script src="{{asset('/ckeditor_4.5.9_full/ckeditor.js')}}"></script>
									<script src="{{asset('/ckeditor_4.5.9_full/samples/js/sample.js')}}"></script>
									<textarea class="form-control" rows="5" cols="45" name="editor" id="editor" tabindex="12" ></textarea>
									<script language="javascript">
										initSample();
									</script>		
								</div>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="comTo" id="comTo" value="<?=(!empty($head_val->toaddress)?$head_val->toaddress:'')?>">
								<div class="form-group">
									<input class="form-control" name="comSubject" id="comSubject" placeholder="Subject:">
								</div>
								<div class="box-footer">
									<button type="submit" name="submit" value="Submit" onclick="load_reply('add_reply',this.form)" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Submit <i class="fa fa-envelope-o"></i></button>
									<button type="button" class="btn btn-red btn-ef btn-ef-3 btn-ef-3c mb-10" data-dismiss="modal" aria-hidden="true">Cancel</button>
								</div><!-- /.box-footer -->								
							
							</div>
						</form>	
					</div>
				</div>
			</div>
			
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