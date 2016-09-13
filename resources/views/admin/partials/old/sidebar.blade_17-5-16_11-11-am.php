

<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("/admin-lte/dist/img/images.png") }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
				<?php
					$username = "";
					if(!empty(session()->get('userName'))){
						$username = session()->get('userName');
					}
				?>
                <p><?=(!empty($username)?$username:"")?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
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
        <ul class="sidebar-menu"
            data-keep-expanded="false"
            data-auto-scroll="true"
            data-slide-speed="200">
              <li><a href="{{ url(config('quickadmin.route').'/dashboard') }}">
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
                    <!--<li><a href="#">Link in level 2</a></li>-->
                </ul>
            </li>
            <li>

            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

