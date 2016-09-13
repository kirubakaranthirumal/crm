@extends('admin.layouts.master')
@section('content')
	<section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
			 @if (session('DeleteServiceSuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        Service has been Disable Sbuccessfully
							<?php
							$page_event_id="";
							if(!empty($event_id)){
								$page_event_id = $event_id;
							}
						?>
              <script>
              window.setTimeout(function(){
				 window.setTimeout(function(){window.location.href = "{{asset('/admin/service_all_list/')}}";}, 1000);
               }, 1000);
             </script>
                  </div>
                </div>
              @endif
                @if (session('DeleteServiceError'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Unable To Disable Service
                    </div>
                  </div>
                @endif
  			<div class="box">

  			    <div class="box-header">
                  <h3 class="box-title">Chat</h3>
                </div><!-- /.box-header -->
            <div class="box-body">

              <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
					<body ng-app="myapp">
				<div ng-controller="ChatController" >


				<table border="1">
				<tr><th style="text-align:left;">Email</th><th style="text-align:left;">Subject</th><th style="text-align:left;">Start Chat</th></tr>
				<tr ng-repeat="ch in chats">
				<td ng-bind="ch.email"></td><td ng-bind="ch.subject"></td><td><a style="cursor:pointer;" href="javascript:startchat();">Start</a></td>
				</tr>
				</table>
				<br>
				Chat Count : <span ng-bind="chatcount"></span>
					  </div>
					  <br><br>
					  <div ng-controller="TicketController">
					  <div style='width:150px;padding:10px;background:red;color:white;float:left' ng-bind="'Open Tickets : '+opencount"></div>
					  <div style='width:150px;padding:10px;background:green;color:white;float:left' ng-bind="'On Hold tickets : '+onholdcount"></div>
					  <div style='width:150px;padding:10px;background:blue;color:white;float:left' ng-bind="'Closed Tickets : '+closedcount"></div>
					  </div>
					   <script>

					angular.module("myapp", [])
					.controller("ChatController", function($scope,$http,$interval,$timeout) {
					$http.get("http://localhost:8095/chatmic/fetchchats.php", {
						headers: {
							'Content-type': 'application/json'
						}
					}).then(function(response) {
					console.log(response.data);
						$scope.chats=response.data.chats;
						$scope.chatcount=response.data.chatcount;
						$interval(callAtTimeout, 5000);
					});

					function callAtTimeout() {
					$http.get("http://localhost:8095/chatmic/fetchchats.php", {
						headers: {
							'Content-type': 'application/json'
						}
					}).then(function(response) {
					console.log(response.data);
						$scope.chats=response.data.chats;
						$scope.chatcount=response.data.chatcount;
						});
					}

					})
					.controller("TicketController", function($scope,$http,$interval,$timeout) {
					$http.get("http://localhost:8095/chatmic/ticketcount.php", {
						headers: {
							'Content-type': 'application/json'
						}
					}).then(function(response) {
					console.log(response.data);
						$scope.opencount=response.data.open;
						$scope.onholdcount=response.data.onhold;
						$scope.closedcount=response.data.closed;
						$interval(callAtTimeout, 5000);
					});
					function callAtTimeout() {
					$http.get("http://localhost:8095/chatmic/ticketcount.php", {
						headers: {
							'Content-type': 'application/json'
						}
					}).then(function(response) {
					console.log(response.data);
						$scope.opencount=response.data.open;
						$scope.onholdcount=response.data.onhold;
						$scope.closedcount=response.data.closed;
						});
					}

					});
					</script>
				</body>


            </div>
            <!-- /.box-body -->
                </div>
                  </div>
<script>
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
</script>
@endsection



