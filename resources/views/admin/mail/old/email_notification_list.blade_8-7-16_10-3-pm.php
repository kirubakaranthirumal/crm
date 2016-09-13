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
	<div class="row">
		<!-- left column -->
		<div class="col-md-12">
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
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">E-Mail Notification</h3>
					 <div style="float:right;margin-right:1%;">
						<a href="{{asset('/admin/add_tickets/')}}" class="btn btn-primary" target="_blank">
							Create Ticket
						</a>
					</div>
				</div><!-- /.box-header -->

				<div class="box-body"><!-- /.box -->
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

									$(".demo-y").mCustomScrollbar();

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

            		<div class="box-body">
						<div class="nav-tabs-custom">
							<div class="tab-content">
								<table id="example1" class="table table-bordered table-striped">
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
														<div style="border:0px solid red;float:left;width:150px;height:150px;">
															@if(isset($data->fromAddress))
																{{$data->fromAddress}}
															@endif
														</div>
													</td>
													<td>
														<div style="border:0px solid red;float:left;width:150px;height:150px;">
															@if(isset($data->subjectLine))
																{{$data->subjectLine}}
															@endif
														</div>
													</td>
													<td>
														<!--<a href="#" title="here">aaaaaaaa</a>
														@if(isset($data->detailContent))
															{{$data->detailContent}}
														@endif-->
														&nbsp;
														<?php
															$str_content="";
															//if(strlen($data->detailContent) > 5){
															//	$str_content = substr($data->detailContent, 0, 100)."...";
															//}
															//echo strlen($data->detailContent);

															$disp_str_content = $data->detailContent;

															//$new_content = htmlspecialchars($disp_str_content, ENT_QUOTES);
															//echo $new_content;
														?>
														<!--<div style="overflow:auto;">
															<?=$disp_str_content?>
														</div>-->
														<!--
														<link rel="stylesheet" type="text/css" href="{{asset('/scroll/scrollable.css')}}" />
														<style>
															.scrollable  + p img{
															width: 24px;
															height: 24px;
															cursor: pointer;
														}
														</style>
														<script src="{{asset('/scroll/impetus.js')}}"></script>
														<script type="text/javascript" src="{{asset('/scroll/scrollable.js')}}"></script>
														<script language="javascript">
															var scrollv, scrollh
															// register two global vars for two scrollable instances
															jQuery(function(e){
																// on DOM load
																scrollv = new scrollable({
																	wrapperid: "scrollable-v"
																})
																scrollh = new scrollable({
																	wrapperid: "scrollable-h",
																	orient: 'horizontal'
																})
															})
														</script>
														<div id="scrollable-v" class="scrollable">
															<div class="belt">
																<p>The last few years have bared witness not only to major changes in the technologies that power the net, but also the devices that access it. With the myriad of smart phones and tablets of all sorts riding the internet wave...
																</p>
																<p>The last few years have bared witness not only to major changes in the technologies that power the net, but also the devices that access it. With the myriad of smart phones and tablets of all sorts riding the internet wave...
																</p>
																<p>The last few years have bared witness not only to major changes in the technologies that power the net, but also the devices that access it. With the myriad of smart phones and tablets of all sorts riding the internet wave...
																</p>
																<p>The last few years have bared witness not only to major changes in the technologies that power the net, but also the devices that access it. With the myriad of smart phones and tablets of all sorts riding the internet wave...
																</p>
															</div>
														</div>
														<p style="width:250px; text-align:right">
															<img src="{{asset('/scroll/img/roundup.png')}}" onMouseover="scrollv.scrollContent('up')" onMouseout="scrollv.stopScroll()" />
															<img src="{{asset('/scroll/img/rounddown.png')}}"  onMouseover="scrollv.scrollContent('down')" onMouseout="scrollv.stopScroll()" />
														</p>-->
														<div class="content-new demo-y">
															<p>
																<?php
																	echo $str_content = substr($data->detailContent, 0, 1000);
																	//echo $str_content = $data->detailContent;
																?>
															</p>
														</div>
													</td>
													<td>
														<div style="border:0px solid red;float:left;width:150px;height:150px;">
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


