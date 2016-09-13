 <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="{{ url(config('quickadmin.route').'/dashboard') }}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="{{ asset("/admin-lte/dist/img/logo.jpg") }}" alt="User Image" /></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg pull-left"><img src="{{ asset("/admin-lte/dist/img/logo.jpg") }}" alt="User Image" /><b style="font-size:25px;"> CRM</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 0 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">0</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 0 new tickets</li>
                 </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
			<?php
				$username = "";
				if(!empty(session()->get('userName'))){
					$username = session()->get('userName');
				}
			?>
			<?php
				if(!empty($username)){
			?>
              <li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{asset("/admin-lte/dist/img/images.png")}}" class="user-image" alt="User Image">
						<span class="hidden-xs"><?=(!empty($username)?$username:"")?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="{{asset("/admin-lte/dist/img/images.png")}}" class="img-circle" alt="User Image">
							<p>
								<?=(!empty($username)?$username:"")?>
								<!--<small>Member since Nov. 2012</small>-->
							</p>
						</li>
						<!-- Menu Body -->
						<!--<li class="user-body">
							<div class="col-xs-4 text-center">
								<a href="#">Followers</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Sales</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Friends</a>
							</div>
						</li>-->
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
								<a href="{{ url('admin/settings') }}" class="btn btn-default btn-flat">Settings</a>
							</div>
							<div class="pull-right">
								<!--<a href="{{ url('logout') }}" class="btn btn-default btn-flat"><span class="title">{{ trans('quickadmin::admin.partials-sidebar-logout') }}</span></a>-->
								<a href="{{ url('user_logout') }}" class="btn btn-default btn-flat"><span class="title">Logout</span></a>
							</div>
						</li>
					</ul>
              </li>
		  <?php
			}
		  ?>
              <!-- Control Sidebar Toggle Button -->
            <!-- <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
      </header>




<!--<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-header-inner">
            <div class="navbar-header">
                <a href="{{ url(config('quickadmin.homeRoute')) }}" class="navbar-brand">
                    {{ trans('quickadmin::admin.partials-topbar-title') }}
                </a>
            </div>
            <a href="javascript:;"
               class="menu-toggler responsive-toggler"
               data-toggle="collapse"
               data-target=".navbar-collapse">
            </a>

            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                </ul>
            </div>
        </div>
    </div>
</div>-->