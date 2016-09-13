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
<script language="javascript">
	function startchat(id){
		$("#chat").hide("slow")
		var myInterval;
			clearInterval(myInterval);
			var url_str = "chatId="+id;

			$.ajax({
				type: "GET",
				url: "{{asset('admin/custchathisupd')}}",
				data: url_str,
				success: function(data){
					//$('#event_div').html(data);
					var result=data.split("~");
					$("#"+id).parents("tr").remove();
					$("#entryform").hide();
					$("#chatfile").val(result[0]);
					$("#name1").val(result[1]);

					loadLog(result[0]);

					myInterval=setInterval (function() { loadLog(result[0]); }, 2500);
					$("#chat").show("slow");
				}
			});
		}

		/*
		$(".hit").click(function(){
		   var value=$(this).closest('tr').children('td:first').text();
		   alert(value);
		});
		*/
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
	<div class="row">
		<!-- left column -->
		<div class="col-md-12">
			<div class="box">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Customer Chat</h3>
				</div><!-- /.box-header -->
					<div class="box-body">
						<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
						<body ng-app="myapp">
						<?php $i=0;?>

						<div class="box box-primary" style="padding:1%;">
							<div class="box-header with-border">
								<h3 class="box-title">Chat</h3>
							</div><!-- /.box-header -->
							<div class="tab-content">
								<div ng-controller="ChatController">
									<table border="1" width="100%" class="table table-bordered table-striped">
										<tr><th style="text-align:left;">ID</th><th style="text-align:left;">Email</th><th style="text-align:left;">Subject</th><th style="text-align:left;">Start Chat</th></tr>
										<tr ng-repeat="ch in chats">
											<td ng-bind="ch.id"></td><td ng-bind="ch.email"></td><td ng-bind="ch.subject"></td><td><a style="cursor:pointer;" class="hit" id="<%ch.id%>" onclick="startchat(this.id)">Start</a></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
						<div style="clear:both;">&nbsp;</div>
						<!--
						<div class="box box-primary" style="padding:1%;">
							<div class="box-header with-border">
								<h3 class="box-title">History</h3>
							</div>
							<div class="tab-content">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Id</th>
											<th>E-Mail</th>
											<th>Subject</th>
										</tr>
									</thead>
									<tbody>
										<?php
											//print"<pre>";
											//print_r($chat_history);
										?>
										@if(isset($chat_history))
											@foreach($chat_history as $data)
												<tr>
													<td>
														@if(isset($data['id']))
															{{$data['id']}}
														@endif
													</td>
													<td>
														@if(isset($data['email']))
															{{$data['email']}}
														@endif
													</td>
													<td>
														@if(isset($data['subject']))
															{{$data['subject']}}
														@endif
													</td>
													<td>
														<a href="{{asset('/admin/edit_ticket/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="Edit Ticket">
															<i class="fa fa-edit"></i>
														</a>&nbsp;&nbsp;
														<a href="{{asset('/admin/ticket_details/')}}/@if(isset($data->ticketId)){{ $data->ticketId}}@endif" title="View Ticket">
															<i class="fa fa-user-secret"></i>
														</a>
													</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
							</div>
						</div>
								<script language="javascript">
									$(function(){
										$('#example1').DataTable( {
											"aaSorting": [[ 0, "desc" ]],
											"aoColumnDefs" : [{
												'bSortable' : false,
												'aTargets' : [ 0 ]
											}]
										});
									});
									$(function () {
										$("#example1").DataTable();
										$('#example2').DataTable({
											"paging": true,
											"lengthChange": false,
											"searching": false,
											"ordering" : true,
											"info": true,
											"autoWidth": false,
										});
									});
									$(function(){
										$('#created_on').datepicker({
											format: 'yyyy-mm-dd'
										});
									});
								</script>
								-->

								<!--<div ng-controller="TicketController">
									<div style='width:150px;padding:10px;background:red;color:white;float:left' ng-bind="'Open Tickets : '+opencount"></div>
									<div style='width:150px;padding:10px;background:green;color:white;float:left' ng-bind="'On Hold tickets : '+onholdcount"></div>
									<div style='width:150px;padding:10px;background:blue;color:white;float:left' ng-bind="'Closed Tickets : '+closedcount"></div>
								</div>-->
								<script language="javascript">
									angular.module("myapp", [], function($interpolateProvider) {
										$interpolateProvider.startSymbol('<%');
										$interpolateProvider.endSymbol('%>');
									})
									.controller("ChatController", function($scope,$http,$interval,$timeout){
									$http.get("http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/admin/fetchchats",{
										headers:{
											'Content-type': 'application/json'
										}
									}).then(function(response){
										console.log(response.data);
										$scope.chats=response.data.chats;
										$scope.chatcount=response.data.chatcount;
										$interval(callAtTimeout, 5000);
									});

									function callAtTimeout(){
										$http.get("http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/admin/fetchchats",{
										headers:{
											'Content-type': 'application/json'
										}
										}).then(function(response){
											console.log(response.data);
											$scope.chats=response.data.chats;
											$scope.chatcount=response.data.chatcount;
										});
									}
								})
								.controller("TicketController", function($scope,$http,$interval,$timeout){
									$http.get("http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/admin/tick_cnt",{
										headers:{
											'Content-type': 'application/json'
										}
									}).then(function(response){
										console.log(response.data);
										$scope.opencount=response.data.open;
										$scope.onholdcount=response.data.onhold;
										$scope.closedcount=response.data.closed;
										$interval(callAtTimeout, 5000);
									});

									function callAtTimeout(){
										$http.get("http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/admin/tick_cnt", {
											headers:{
												'Content-type': 'application/json'
											}
										}).then(function(response){
										console.log(response.data);
											$scope.opencount=response.data.open;
											$scope.onholdcount=response.data.onhold;
											$scope.closedcount=response.data.closed;
										});
									}
								});
							</script>
						</body>
						</html>
						<!--chat window invoke script starts here-->
						<script src="{{asset('/chat/js/script.js')}}"></script>
						<style>
							#loginform,#chat{
								padding:10px;
								background:#3c8dbc;
								width:30%;
								position:fixed;
								right:0px;
								bottom:0px;
								color:white;
							}

							#chatbox {
								text-align:left;
								margin:0 auto;
								margin-bottom:25px;
								padding:10px;
								background:#fff;
								height:365px;
								color:black;
								border:1px solid #ACD8F0;
								overflow:auto;
							}
						</style>
						<?php
							error_reporting(0);
							session_start();
						?>
						<div id="loginform" style="background:transparent;">
							<div id="entryform" style="padding-bottom:20px;">
						    <form  onsubmit="javascript:return addchatroom();" action="" method="post">
						    	<span id="close" style="float:right;">X</span>
						        <p>Please enter your name & subject to start chat:</p>
						        <div style="padding-bottom:10px;padding-left:20px;padding-top:10px;">
						        	<div style="text-align:left;float:left;width:20%;">
						        		<label for="name">Name:</label></div>
						        		<div  style="width:70%;">
						        			<input type="text" name="name" id="name"/>
						        			<input type="hidden" name="rating" id="rating" value="5"/>
						        		</div>
						        	</div>
						        	<div style="padding-bottom:10px;padding-left:20px;padding-top:10px;">
										<div style="text-align:left;float:left;width:20%;">
											<label for="name">Subject:</label></div>
										<div  style="width:70%;">
											<input type="text" name="subject" id="msg"/>
										</div>
						        	</div>
						        	<div style="padding-bottom:10px;padding-left:20px;">
						        		<div style="text-align:left;float:left;width:20%"></div>
						        			<div style="width:70%;">
						        				<input type="hidden" name="username" id="username" value='.$_SESSION['chat_uid'].' />
						        				<input type="submit" name="submitmsg" id="submitmsg" style="float:right;" value="Start Chat" />
						        			</div>
						        		</div>
						        		<div id="error" class="error"></div>
						    		</form>
						    	</div>
						    	<div id="minimizebar" style="background:blue;"><div id="button" style="display:none;" ><input type="button" value="Live Chat" id="livechat1" /></div><div style="height:30px;float:right;clear:both"><span  id="maxchat1" style="width:50px;background:#333;padding:5px 10px 5px 10px;margin-right:5px;cursor:pointer">+</span></div></div>
						    </div>
						    <div id="chat">
						    <div style="height:30px;float:right;clear:both;width:100%;text-align:right"><span  id="minchat" style="width:50px;background:#333;padding:5px 10px 5px 10px;margin-right:5px;cursor:pointer">-</span><span  id="closechat" style="width:50px;background:#333;padding:5px 10px 5px 10px;cursor:pointer">X</span></div>
							<div id="chatbox"></div>
							<div width="100%"><input type="hidden" name="chatfile" id="chatfile"  />
								<input type="text" id="msg1" style="color: #333;height:50px;width:84%;"><input type="button"  style="background:#333 none repeat scroll 0 0;border:medium none; color: white;height: 50px;margin-left: 5px;" id="submitmsg1" value="submit"><input type="hidden" name="name1" id="name1"></div>
							</div>
							<div id="basic-modal-content"></div>
							<script type='text/javascript' src="{{asset('/chat/js/jquery.js')}}"></script>
							<script type='text/javascript' src="{{asset('/chat/js/jquery.simplemodal.js')}}"></script>
							<script>
								$(document).ready(function(){
									$("#entryform").hide();
								      $("#chat").hide();
								      $("#livechat").click(function() {
								  			 $("#entryform").show("slow");
									  });
									  $("#close").click(function() {
									    			 $("#entryform").hide("slow");
									  });

									  $("#minchat").click(function() {
									  	    			 $("#chat").hide("slow");
									  	    			 $("#minimizebar").show();

									  });
									   $("#closechat").click(function() {

									   var res=confirm("Are you sure want to close?");
									   if(res){
									  									  	    			 $("#chat").hide("slow");
									  									  	    			 $("#minimizebar").hide();
									  								$.get( "closechat.php", function( data ) {
									  								});
										}
										else
										{
											//$("#minimizebar").show();
										}

									  });

									  $("#maxchat1").click(function() {
									  									  	    			 $("#chat").show("slow");
									  									  	    			 //$("#minimizebar").show();
									  								$.get( "closechat.php", function( data ) {
									  								});


									  });
								});


									$("#submitmsg").click(function(){
									var str4 = "http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/chat/post.new.php";
									        var streamname = "firstchat";

									        var postfilename = str4.concat("?stream=",streamname);
										var clientmsg = $("#msg").val();
										var clientname = $("#name").val();
										var rating = $("#rating").val();
								        if(clientmsg!=''){
										$.post(postfilename, {subject: clientmsg,name:clientname,rating:rating,type:'new',usertype:'admin',chatfile:'<?php echo "chat_".rand(0,99999999999);?>'},function( data ) {
											console.log(data);
											 loadLog(data);
								   //setInterval (loadLog(data), 2500);
								});
								                $("#msg").attr("value", "");
								                document.getElementById("msg").value = "";
								               // setInterval (loadLog, 2500);
								                //loadLog();
								                $("#entryform").hide();
								                $("#chat").show("slow");

								    }
								    return false;
									});
									$("#submitmsg").keypress(function(){
										var str4 = "http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/chat/post.new.php";
										        var streamname = "firstchat";

										        var postfilename = str4.concat("?stream=",streamname);
											var clientmsg = $("#msg").val();
											var clientname = $("#name").val();
											var rating = $("#rating").val();
									        if(clientmsg!=''){
											$.post(postfilename, {subject: clientmsg,name:clientname,rating:rating,usertype:'admin',type:'new',chatfile:'<?php echo "chat_".rand(0,99999999999);?>'},function( data ) {
											console.log(data);
											 loadLog(data);

								});
									                $("#msg").attr("value", "");
									                document.getElementById("msg").value = "";

									                //loadLog();
									                $("#entryform").hide();
									                $("#chat").show("slow");
									                $("#msg1").focus();

									    }
									    return false;
									});
									$("#submitmsg1").click(function(){
											var str4 = "http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/chat/post.new.php";
											        var streamname = "firstchat";

											        var postfilename = str4.concat("?stream=",streamname);
												var clientmsg = $("#msg1").val();
												var clientname = $("#name1").val();
												var filename = $("#chatfile").val();
												var rating = $("#rating").val();
										        if(clientmsg!=''){
												$.post(postfilename, {subject: clientmsg,usertype:'admin',name:clientname,rating:rating,type:'onhold',filename:filename},function( data ) {

								   loadLog($("#chatfile").val());
								});
										                $("#msg1").attr("value", "");
										                document.getElementById("msg1").value = "";
										                //loadLog();


										                $("#msg1").focus();

										    }
										    return false;
									});
								$(document).keypress(function(e){
									if ( e.keyCode === 13 ) // w
									{
									var str4 = "http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/chat/post.new.php";
									        var streamname = "firstchat";

									        var postfilename = str4.concat("?stream=",streamname);
										var clientmsg = $("#msg1").val();
										var clientname = $("#name1").val();
										var rating = $("#rating").val();
										var filename = $("#chatfile").val();
								        if(clientmsg!=''){
										$.post(postfilename, {subject: clientmsg,name:clientname,usertype:'admin',rating:rating,type:'onhold',filename:filename},function( data ) {
											console.log(data);
								   loadLog($("#chatfile").val());

								});
								                $("#msg1").attr("value", "");
								                document.getElementById("msg1").value = "";

								                //loadLog();


								                $("#msg1").focus();

								    }
								    return false;
								    }
									});

									//loadLog();

									function loadLog(filename){

									                var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
									                var str1 = "http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/chat/loghtml/log.";
									                var str2 = "firstchat";
									//alert(str2);
									                var str3 = ".html";

									                        var filename =  "http://106.51.0.187:8000/Cricketgate_CRM_new/branches/public/chat/loghtml/log."+filename+".html";


									                $.ajax({
									                        url: filename,
									                        cache: false,
									                        success: function(html){
									                                $("#chatbox").html(html); //Insert chat log into the #chatbox div

													//Auto-scroll
													var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
													if(newscrollHeight > oldscrollHeight){
														$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
													}
											  	},
											});
			}
						</script>


						<!--chat window invoke script end here-->









@endsection


