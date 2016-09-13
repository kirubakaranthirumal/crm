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
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>E-Mail Notification</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Tickets Management</a>
			</li>
			<li>
				<a href="#">E-Mail Notification</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
			@if (session('createTicktSuccess'))
				<div class="flash-message">
					 <div class="alert alert-success">
						Ticket created successfully
						<script>
							window.setTimeout(function(){
							window.location.href = "{{asset('/admin/notification/')}}";
							}, 2000);
						</script>
					</div>
				</div>
			@endif
			<section class="tile">

			<!-- tile header -->
			<div class="tile-header dvd dvd-btm">
				<h1 class="custom-font"><strong>E-Mail </strong>Notification</h1>
				<ul class="controls">
					<li class="dropdown">

						<a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
							<i class="fa fa-spinner fa-spin"></i>
						</a>

						<ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
							<li>
								<a href="{{asset('/admin/add_tickets/')}}" class="btn btn-primary" target="_blank">
									Create Ticket
								</a>
							</li>
							<li>
								<a role="button" tabindex="0" class="tile-toggle">
									<span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
									<span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
								</a>
							</li>
							<li>
								<a role="button" tabindex="0" class="tile-refresh">
									<i class="fa fa-refresh"></i> Refresh
								</a>
							</li>
							<li>
								<a role="button" tabindex="0" class="tile-fullscreen">
									<i class="fa fa-expand"></i> Fullscreen
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
				<div class="table-responsive">
				
					<!-- /.box-header -->
					<link rel="stylesheet" href="{{asset('/malihu-custom-scrollbar-plugin-master/examples/style.css')}}">
					<link rel="stylesheet" href="{{asset('/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.css')}}">


						<!-- Google CDN jQuery with fallback to local -->
						<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
						<script>window.jQuery || document.write('<script src="{{asset('/malihu-custom-scrollbar-plugin-master/js/minified/jquery-1.11.0.min.js')}}"><\/script>')</script>
						<!-- custom scrollbar plugin -->
						<script src="{{asset('/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.concat.min.js')}}"></script>

						<script>
							(function($){
								$(window).on("load",function(){

									$.mCustomScrollbar.defaults.theme="light-2"; //set "light-2" as the default theme

									$(".demo-y").mCustomScrollbar({
										axis:"y",
										advanced:{autoExpandHorizontalScroll:true}
									});

									$(".demo-x").mCustomScrollbar({
										axis:"x",
										advanced:{autoExpandHorizontalScroll:true}
									});

									$(".demo-yx").mCustomScrollbar({
										axis:"yx"
									});

									$(".scrollTo a").click(function(e){
										e.preventDefault();
										var $this=$(this),
											rel=$this.attr("rel"),
											el=rel==="content-y" ? ".demo-y" : rel==="content-x" ? ".demo-x" : ".demo-yx",
											data=$this.data("scroll-to"),
											href=$this.attr("href").split(/#(.+)/)[1],
											to=data ? $(el).find(".mCSB_container").find(data) : el===".demo-yx" ? eval("("+href+")") : href,
											output=$("#info > p code"),
											outputTXTdata=el===".demo-yx" ? data : "'"+data+"'",
											outputTXThref=el===".demo-yx" ? href : "'"+href+"'",
											outputTXT=data ? "$('"+el+"').find('.mCSB_container').find("+outputTXTdata+")" : outputTXThref;
										$(el).mCustomScrollbar("scrollTo",to);
										output.text("$('"+el+"').mCustomScrollbar('scrollTo',"+outputTXT+");");
									});

								});
							})(jQuery);
						</script>
						
							<div class="tab-content">
								<table id="example1" class="table table-custom table-striped">
									<thead>
										<tr>
											<th>From</th>
											<th>Subject</th>
											<th>Message Body</th>
											<th>Received On</th>
											<!--<th>Action</th>-->
										</tr>
									</thead>
									<tbody>
										<?php
											/*
											print"<pre>";
											print_r($notificationdata);
											exit;
											*/
										?>
										@if(isset($notificationdata))
											@foreach($notificationdata as $data)
												<tr>
													<td>
														<div style="border:0px solid red;float:left;width:150px;word-wrap:break-word;">
															@if(isset($data->fromAddress))
																{{$data->fromAddress}}
															@endif
														</div>
													</td>
													<td>
														<div style="border:0px solid red;float:left;width:150px;word-wrap:break-word;">
															@if(isset($data->subjectLine))
																{{$data->subjectLine}}
															@endif
														</div>
													</td>
													<td>
														<?php
															//echo strlen($data->detailContent);
															//echo strlen($data->detailContent);
															$content_div_height="height:50px;";
															if((!empty(strlen($data->detailContent))) && (strlen($data->detailContent)>0)){
																if(strlen($data->detailContent)>500){
																	$content_div_height="height:150px;";
																}
															}
														?>
														<div class="content-new demo-yx" style="border:0px solid red;<?=(!empty($content_div_height)?$content_div_height:"")?>">
															<p>
																<?php
																	echo $data->detailContent;
																?>
															</p>
														</div>
													</td>
													<td>
														<div style="border:0px solid red;float:left;width:150px;word-wrap:break-word;">
															@if(isset($data->sendDate))
																{{$data->sendDate}}
															@endif
														</div>
													</td>
													<!--<td>
														<a href="{{ url(config('quickadmin.route').'/createticketfromnotification') }}/@if(isset($data->notificationId)){{ $data->notificationId}}@endif" title="Create Ticket" class="btn btn-primary">
															Create Ticket
														</a>
													</td>-->
												</tr>
											@endforeach
										@endif
									</tbody>
									<!--
									<tfoot>
										<tr>
											<th>Id</th>
											<th>Request From</th>
											<th>Subject</th>
											<th>Aging</th>
											<th>Priority</th>
											<th>Created On</th>
											<th>Created By</th>
											<th>Action</th>
										</tr>
									</tfoot>-->
								</table>


							</div>
						</div>
            		</div><!-- /.box-body -->
					</section>
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

			$(function () {
				$("#example1").DataTable();
				$('#example2').DataTable({
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": true,
					"info": true,
					"autoWidth": false
				});
			});

			$(function(){
				$('#created_on').datepicker({
					format: 'yyyy-mm-dd'
				});
			});
		</script>
@endsection


