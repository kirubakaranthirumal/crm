@extends('admin.layouts.master')
@section('content')
<div class="page page-forms-common">

	<div class="pageheader">
		<h2>Chat List<span></h2>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="#"><i class="fa fa-home"></i> CRM</a>
				</li>
				<li>
					<a href="#">Chat Room</a>
				</li>
			</ul>
			
		</div>
		<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
	</div>		
	<section class="tile">
		<div class="box-body">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs tabs-dark">
				  <li class="active"><a href="#active" data-toggle="tab">Client Chat</a></li>
				  <li><a href="#inactive" data-toggle="tab">Internal Chat</a></li>
				</ul>
				<div class="tab-content tile-body table-custom">
					<div class="active tab-pane table-responsive" id="active">
						<div ng-controller="ChatController">
							<table border="1" width="100%" class="table table-bordered table-striped">
								<tr><th style="text-align:left;">ID</th><th style="text-align:left;">Email</th><th style="text-align:left;">Subject</th><th style="text-align:left;">Start Chat</th></tr>
								<tr ng-repeat="ch in chats">
									<td ng-bind="ch.id"></td><td ng-bind="ch.email"></td><td ng-bind="ch.subject"></td><td><a style="cursor:pointer;" class="hit" id="<%ch.id%>" onclick="startchat(this.id)">Start</a></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="tab-pane" id="inactive">
						<div ng-controller="EmpChatController">
							<table border="1" width="100%" class="table table-bordered table-striped">
								<tr><th style="text-align:left;">ID</th><th style="text-align:left;">Email</th><th style="text-align:left;">Subject</th><th style="text-align:left;">Start Chat</th></tr>
								<tr ng-repeat="ech in empchats">
									<td ng-bind="ech.id"></td><td ng-bind="ech.email"></td><td ng-bind="ech.subject"></td><td><a style="cursor:pointer;" class="" id="<%ech.id%>" onclick="startchat(this.id)">Start</a></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection