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
		<!-- search form (Optional) -->
		<!--<form action="#" method="get" class="sidebar-form">
		<div class="input-group">
		<input type="text" name="q" class="form-control" placeholder="Search..."/>
		<span class="input-group-btn">
		<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
		</span>
		</div>
		</form>-->
		<!-- /.search form -->
		<!-- Sidebar Menu -->
		<!-- /.sidebar-menu -->

		<?php
			$usertype = "";
			if(!empty(session()->get('userType'))){
				$usertype = session()->get('userType');
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
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i><span>Users</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/add_user') }}"><i class="fa fa-user" aria-hidden="true"></i> <span>Add User</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/view_user') }}"><i class="fa fa-user" aria-hidden="true"></i> <span>View User</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/add_tickets') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Add Ticket</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/view_tickets') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>View Tickets</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/settings') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Ticket Settings</span></a></li>

							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-lock" aria-hidden="true"></i><span>User Privilege</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/user_privileges') }}"><i class="fa fa-lock" aria-hidden="true"></i> <span>Assign Privilege</span></a></li>
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Notifications</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/notification') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Portal Notification</span></a></li>
							<!--<li><a href="{{ url(config('quickadmin.route').'/view_tickets') }}"><i class="fa fa-envelope" aria-hidden="true"></i> <span>E-Mail Notification</span></a></li>-->
							<!--<li><a href="#">Link in level 2</a></li>-->
						</ul>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-wrench" aria-hidden="true"></i><span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/create_app') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create App</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/list_app') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>App List</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create Event</span></a></li>
							<!--<li><a href="{{ url(config('quickadmin.route').'/list_event') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Event List</span></a></li>-->
							<!--<li><a href="#">Link in level 2</a></li>-->
							</ul>
					</li>
					<!--<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Event Management</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url(config('quickadmin.route').'/create_event') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Create Event</span></a></li>
							<li><a href="{{ url(config('quickadmin.route').'/list_event') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>Event List</span></a></li>
						</ul>
					</li>-->
					<li></li>
				</ul>
			@elseif($usertype == 2)
				<ul class="sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li>
						<a href="{{ url('emp-dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a></li>
						</ul>
					</li>
					<li></li>
				</ul>
			@elseif($usertype == 3)
				<ul class="sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
					<li>
						<a href="{{ url('emp-dashboard') }}">
							<i class="fa fa-dashboard"></i> <span>Dashboard</span>
						</a>
					</li>
					<li class="treeview">
						<a href="#"><i class="fa fa-ticket" aria-hidden="true"></i><span>Tickets</span> <i class="fa fa-angle-left pull-right"></i></a>
						<ul class="treeview-menu">
							<li><a href="{{ url('my_tickets?tab_id=3') }}"><i class="fa fa-ticket" aria-hidden="true"></i> <span>My Tickets</span></a></li>
						</ul>
					</li>
					<li></li>
				</ul>
			@endif
		@endif
	</section>
	<!-- /.sidebar -->
</aside>

