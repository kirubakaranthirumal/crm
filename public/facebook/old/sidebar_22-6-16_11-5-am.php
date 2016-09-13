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
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/add_user"><i class="fa fa-user" aria-hidden="true"></i> <span>Add User</span></a></li>
							<li><a href="../admin/view_user"><i class="fa fa-user" aria-hidden="true"></i> <span>View User</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/add_tickets"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
							<li><a href="../admin/view_tickets"><i class="fa fa-ticket" aria-hidden="true"></i> <span>View Tickets</span></a></li>
							<li><a href="../admin/settings"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Ticket Settings</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-lock" aria-hidden="true"></i><span>User Privilege</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/user_privileges"><i class="fa fa-lock" aria-hidden="true"></i> <span>Assign Privilege</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Notifications</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/notification"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Portal Notification</span></a></li>
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="../admin/create_app"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create App</span></a></li>
							<li><a href="../admin/list_app"><i class="fa fa-ticket" aria-hidden="true"></i> <span>App List</span></a></li>
							<li><a href="../admin/create_event"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create Event</span></a></li>
						</ul>
					</li>
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

