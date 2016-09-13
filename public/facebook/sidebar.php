<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<?php
				//print"<pre>";
				//print_r($_SESSION);
				//exit;

				$username = "";
				if(!empty($_SESSION['userName'])){
					$username = $_SESSION['userName'];
				}

				/*
					Array
					(
						[token] => jTsQmwAAAAAAvaLhAAABVUh6Wks
						[token_secret] => aQ0R9H1XIbYgBson4Idqf2akXLjedJye
						[userId] => 1
						[userType] => 1
						[userName] => admin admin
						[email] => admin@nutech.com
					)
				*/
				if(!empty($username)){
			?>
					<div class="pull-left image">
						<img src="../admin-lte/dist/img/images.png" class="img-circle" alt="User Image" />
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
			$usertype = "";
			if(!empty($_SESSION['userType'])){
				$usertype = $_SESSION['userType'];
			}
		?>
		<?php
			if(!empty($usertype)){
				if($usertype == 1){
		?>
				<ul class="sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li>
						<a href="../admin/dashboard">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Ticket Admin Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/add_user"><i class="fa fa-user-plus" aria-hidden="true"></i> <span>Add User</span></a></li>
							<li><a href="../admin/view_user"><i class="fa fa-list" aria-hidden="true"></i> <span>View Users</span></a></li>
							<li><a href="../admin/user_log_status"><i class="fa fa-genderless"></i> <span>Ticket Admin Status</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/add_tickets"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
							<li><a href="../admin/view_tickets"><i class="fa fa-list" aria-hidden="true"></i> <span>View Tickets</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						<li class="treeview">
							<a href="#"><i class="fa fa-tags" aria-hidden="true"></i><span>Email Notifications</span> <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="../admin/emailnotification"><i class="fa fa-envelope" aria-hidden="true"></i> <span>E-Mail Tickets</span></a></li>
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
							<li><a href="../admin/user_privileges"><i class="fa fa-lock" aria-hidden="true"></i> <span>Manage Privileges</span></a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/settings"><i class="fa fa-ticket" aria-hidden="true"></i><span>Ticket Settings</span></a></li>
							<li class="treeview">
								<a href="#"><i class="fa fa-envelope" aria-hidden="true"></i><span>E-Mail Template</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
								<li><a href="../admin/create_template"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Create Template</span></a></li>
								<li><a href="../admin/list_template"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Template List</span></a></li>
								<li><a href="../admin/sendmail"><i class="fa fa-envelope" aria-hidden="true"></i> <span>Send E-Mail</span></a></li>
								</ul>
							</li>
							<li class="treeview">
								<a href="#"><i class="fa fa-rocket" aria-hidden="true"></i><span>App Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
								<li><a href="../admin/create_app"><i class="fa fa-plus-square" aria-hidden="true"></i><span>Create App</span></a></li>
								<li><a href="../admin/list_app"><i class="fa fa-list" aria-hidden="true"></i> <span>App List</span></a></li>
								</ul>
							</li>
							<li class="treeview">
								<a href="#"><i class="fa fa-calendar" aria-hidden="true"></i><span>Event Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Event</span></a></li>
								</ul>
							</li>
							<li class="treeview">
								<a href="#"><i class="fa fa-cogs" aria-hidden="true"></i><span>Service Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
								<li><a href="{{ url(config('quickadmin.route').'/create_service') }}"><i class="fa fa-plus-square" aria-hidden="true"></i> <span>Create Service</span></a></li>
								</ul>
							</li>
							<li class="treeview">
							   <a href="#"><i class="fa fa-rocket" aria-hidden="true"></i><span>CMS Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
							   <ul class="treeview-menu">
								  <li><a href="{{ url(config('quickadmin.route').'/contentmanage') }}"><i class="fa fa-plus-square" aria-hidden="true"></i><span>Content Management</span></a></li>
							   </ul>
							</li>
							<li class="treeview">
								<a href="{{ url(config('quickadmin.route').'/mailbox') }}"><i class="fa fa-lock" aria-hidden="true"></i><span>Mail Box Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
							</li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Customer Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/customer_info') }}"><i class="fa fa-user-secret"></i> <span>View Customer Details</span></a></li>
							<li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>Customer Status</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/feedback_list') }}"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span>Customer Feedback</span></a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-lock" aria-hidden="true"></i><span>Reports</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/ticket_report') }}"><i class="fa fa-genderless"></i> <span>Ticket Reports</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li></li>
				</ul>
		<?php
				}
				elseif($usertype == 2){
		?>
		<?php
				}
				elseif($usertype == 3){
		?>

		<?php
				}
			}
		?>
	</section>
	<!-- /.sidebar -->
</aside>

