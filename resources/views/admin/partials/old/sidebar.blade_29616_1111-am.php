<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<?php
				$username = "";
				if(!empty(session()->get('userName'))){
					$username = session()->get('userName');
				}
				if(!empty($username)){
			?>
					<div class="pull-left image">
						<img src="{{ asset("/admin-lte/dist/img/images.png") }}" class="img-circle" alt="User Image" />
					</div>
			<?php
				}
			?>
			<!-- Status -->
			<?php
				if(!empty($username)){
			?>
					<div class="pull-left info">
						<p><?=(!empty($username)?$username:"")?></p>
						<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
					</div>
			<?php
				}
			?>
		</div>
		<?php
			$userId = session()->get('userId');

			$usertype = "";
			if(!empty(session()->get('userType'))){
				$usertype = session()->get('userType');
			}


			$ipArray = $cpArray = array();

			if(!empty($userId)){
				$cpArray['userSesId'] = $userId;
			}

			$eventresults="";
			if(!empty($cpArray)){
				$eventresults = ListEventPost("http://106.51.0.187:8090/cgwfollowon/activeevents",$cpArray);
			}

			$eventResponseArray=array();
			$eventArray = array();
			if(!empty($eventresults)){
				$eventResponseArray = json_decode($eventresults);
			}

			if(!empty($eventResponseArray->activeEvents)){
				foreach($eventResponseArray->activeEvents as $responseVal){
					$eventArray[] = $responseVal;
				}
			}

			//print"<pre>";
			//print_r($eventArray);
			//exit;

			function ListEventPost($url,$params){

				$json_string = '';

				if(!empty($params['userSesId'])){
					$fields['userSesId'] = $params['userSesId'];
				}

				if(!empty($fields)){
					$json_string = json_encode($fields);
				}

				$service_url = $url;

				$curl = curl_init($service_url);

				curl_setopt($curl, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Accept-Language: en_US')
				);

				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $json_string);

				$curl_response = curl_exec($curl);

				curl_close($curl);

				return $curl_response;
			}
		?>
		@if(isset($usertype))
			@if($usertype == 1)
				<ul class="sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li>
						<a href="{{ url(config('quickadmin.route').'/dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Ticket Admin Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/add_user') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Add User</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/view_user') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>View Users</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/user_log_status') }}"><i class="fa fa-genderless"></i> <span>Ticket Admin Status</span></a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/add_tickets') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/view_tickets') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>View Tickets</span></a></li>
							<li class="treeview">
								<a href="#"><i class="fa fa-tags" aria-hidden="true"></i><span>Email Notifications</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="{{ url(config('quickadmin.route').'/emailnotification') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>E-Mail Tickets</span></a></li>
								</ul>
							</li>
							<li class="treeview">
								<a href="#"><i class="fa fa-wifi" aria-hidden="true"></i><span>Social Media</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="http://nu-live.com/laracast/public/twitter/index.php"><i class="fa fa-twitter" aria-hidden="true"></i> <span>Twitter</span></a></li>
									<li><a href="../facebook/index.php"><i class="fa fa-facebook" aria-hidden="true"></i> <span>Facebook</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-lock" aria-hidden="true"></i><span>Access Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/user_privileges') }}"><i class="fa fa-lock" aria-hidden="true"></i> <span>Manage Privileges</span></a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-book" aria-hidden="true"></i><span>App Event Service</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li class="treeview">
								<a href="#"><i class="fa fa-paint-brush" aria-hidden="true"></i><span>Application</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="{{ url(config('quickadmin.route').'/create_app') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create App</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/list_app') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>App List</span></a></li>
								</ul>
							</li>
							<li class="treeview">
								<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i><span>Event</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Event</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/event_all_list') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>All Events List</span></a></li>
								</ul>
							</li>
							<li class="treeview">
								<a href="#"><i class="fa fa-bolt" aria-hidden="true"></i><span>Service</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="{{ url(config('quickadmin.route').'/create_service') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Service</span></a></li>
									<li><a href="{{ url(config('quickadmin.route').'/service_all_list') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>All Services List</span></a></li>
								</ul>
							</li>
							<!--<li><a href="{{ url(config('quickadmin.route').'/list_app') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>App List</span></a></li>
							<?php
								//if(!empty($eventArray)){
							?>
									<li><a href="{{ url(config('quickadmin.route').'/create_app') }}"><i class="fa fa-plus-square" aria-hidden="true"></i><span>Create App</span></a></li>
							<?php
								//}
							?>
							<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Event</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/create_service') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Service</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/event_all_list') }}"><i class="fa fa-list" aria-hidden="true"></i> <span> All Events</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/service_all_list') }}"><i class="fa fa-list" aria-hidden="true"></i> <span> All Services</span></a></li>
							-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/settings') }}"><i class="fa fa-ticket" aria-hidden="true"></i><span>Ticket Settings</span></a></li>
							<li class="treeview">
								<a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>E-Mail Template</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
								<li><a href="{{ url(config('quickadmin.route').'/create_template') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Create Template</span></a></li>
								<li><a href="{{ url(config('quickadmin.route').'/list_template') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Template List</span></a></li>
								<li><a href="{{ url(config('quickadmin.route').'/sendmail') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Send E-Mail</span></a></li>
								</ul>
							</li>
						</ul>
					</li>
				<li class="treeview">
				   <a href="#"><i class="fa fa-edit" aria-hidden="true"></i><span>CMS</span> <i class="fa fa-angle-left pull-right"></i></a>
				   <ul class="treeview-menu">
					  <li><a href="{{ url(config('quickadmin.route').'/contentmanage') }}"><i class="fa fa-edit" aria-hidden="true"></i><span>CMS List</span></a></li>
				   </ul>
				</li>
				<li class="treeview">
					<a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>Mail Box</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url(config('quickadmin.route').'/composemail') }}"><i class="fa fa-envelope"></i> <span>Compose</span></a></li>
						<li><a href="{{ url(config('quickadmin.route').'/mailbox') }}"><i class="fa fa-envelope"></i> <span>Read</span></a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Customer Management</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url(config('quickadmin.route').'/customer_info') }}"><i class="fa fa-user-secret"></i> <span>View Customer Details</span></a></li>
						<li><a href="{{ url(config('quickadmin.route').'/customer_log_status') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>View Customer Status</span></a></li>
						<li><a href="{{ url(config('quickadmin.route').'/feedback_list') }}"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span>View Customer Feedback</span></a></li>
					</ul>
				</li>
				<li><a href="{{ url(config('quickadmin.route').'/ticket_report') }}"><i class="fa fa-book"></i> <span>Reports</span></a></li>
				<!--<li class="treeview">
					<a href="#"><i class="fa fa-book" aria-hidden="true"></i><span>Reports</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="{{ url(config('quickadmin.route').'/ticket_report') }}"><i class="fa fa-book"></i> <span>Ticket Reports</span></a></li>
					</ul>
				</li>-->
			</ul>
			@elseif($usertype == 2)
				<ul class="sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li>
						<a href="{{ url('emp-dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<!--<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a></li>
						</ul>
					</li>-->
					<?php
						$user_list_show = $ticket_list_show = $app_list_show = $event_list_show = "";
						$user_add_show = $ticket_add_show = $app_add_show = $event_add_show = "";

						$user_list_show = session()->get('userView');
						$ticket_list_show = session()->get('ticketView');
						$app_list_show = session()->get('appView');
						$event_list_show = session()->get('eventView');

						$user_add_show = session()->get('userCreate');
						$ticket_add_show = session()->get('ticketCreate');
						$app_add_show = session()->get('appCreate');
						$event_add_show = session()->get('eventCreate');

						if(!empty($user_list_show)){
					?>
						<li class="treeview">
							<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Ticket Admin Management</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php
									if(!empty($user_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/add_user') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Add User</span></a></li>
								<?php
									}
								?>
								<li><a href="{{ url(config('quickadmin.route').'/puser') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>View User</span></a></li>

							</ul>
						</li>
					<?php
						}
					?>
					<li class="treeview">
						<li><a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a></li>
					</li>
					<?php
						if(!empty($ticket_list_show)){
					?>
						<li class="treeview">
							<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets Management</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<!--<li><a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a></li>-->
								<?php
									if(!empty($ticket_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/padd_tickets') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($ticket_list_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/pticket') }}"><i class="fa fa-list" aria-hidden="true"></i> <span>View Tickets</span></a></li>
								<?php
									}
								?>

								<!--<li><a href="{{ url(config('quickadmin.route').'/settings') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Ticket Settings</span></a></li>-->
							</ul>
						</li>
					<?php
						}
					?>
					<?php
						if((!empty($app_add_show))||(!empty($app_list_show)) ||(!empty($event_add_show))){
					?>
						<li class="treeview">
							<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php
									if(!empty($app_add_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/create_app') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create App</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($app_list_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/list_app') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>App List</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($event_add_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create Event</span></a></li>
								<?php
									}
								?>
							</ul>
						</li>
					<?php
						}
					?>
				</ul>
			@elseif($usertype == 3)
				<ul class="sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li>
						<a href="{{ url('emp-dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<!--<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a></li>
						</ul>
					</li>-->
					<?php

						$user_list_show = $ticket_list_show = $app_list_show = $event_list_show = "";
						$user_add_show = $ticket_add_show = $app_add_show = $event_add_show = "";

						$user_list_show = session()->get('userView');
						$ticket_list_show = session()->get('ticketView');
						$app_list_show = session()->get('appView');
						$event_list_show = session()->get('eventView');

						$user_add_show = session()->get('userCreate');
						$ticket_add_show = session()->get('ticketCreate');
						$app_add_show = session()->get('appCreate');
						$event_add_show = session()->get('eventCreate');

						if(!empty($user_list_show)){
					?>
						<li class="treeview">
							<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="{{ url(config('quickadmin.route').'/puser') }}"><i class="fa fa-user" aria-hidden="true"></i> <span>View User</span></a></li>
								<?php
									if(!empty($user_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/add_user') }}"><i class="fa fa-user" aria-hidden="true"></i> <span>Add User</span></a></li>
								<?php
									}
								?>
							</ul>
						</li>
					<?php
						}
					?>
					<?php
						//if(!empty($ticket_list_show)){
					?>
						<li class="treeview">
							<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a></li>
								<?php
									if(!empty($ticket_list_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/pticket') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>View Tickets</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($ticket_add_show)){
								?>
									<li><a href="{{ url(config('quickadmin.route').'/padd_tickets') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
								<?php
									}
								?>
								<!--<li><a href="{{ url(config('quickadmin.route').'/settings') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Ticket Settings</span></a></li>-->
							</ul>
						</li>
					<?php
						//}
					?>
					<?php
						if((!empty($app_add_show))||(!empty($app_list_show)) ||(!empty($event_add_show))){
					?>
						<li class="treeview">
							<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<?php
									if(!empty($app_add_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/create_app') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create App</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($app_list_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/papp') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>App List</span></a></li>
								<?php
									}
								?>
								<?php
									if(!empty($event_add_show)){
								?>
										<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create Event</span></a></li>
								<?php
									}
								?>
							</ul>
						</li>
					<?php
						}
					?>
				</ul>
			@endif
		@endif
	</section>
	<!-- /.sidebar -->
</aside>

