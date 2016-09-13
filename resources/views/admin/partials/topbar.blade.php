
<!-- ===============================================
            ================= HEADER Content ===================
            ================================================ -->
            <section id="header">
                <header class="clearfix">

                    <!-- Branding -->
                    <div class="branding">
                        <a href="{{ url(config('quickadmin.route').'/dashboard') }}" class="brand">
                            <span><strong>CRM</strong></span>
                        </a>
                        <a role="button" tabindex="0" class="offcanvas-toggle visible-xs-inline"><i class="fa fa-bars"></i></a>
                    </div>
                    <!-- Branding end -->


				<!-- Left-side navigation -->
                    <ul class="nav-left pull-left list-unstyled list-inline">
                        <li class="sidebar-collapse divided-right">
                            <a role="button" tabindex="0" class="collapse-sidebar">
                                <i class="fa fa-outdent"></i>
                            </a>
                        </li>
					</ul>

						 <!-- Search -->
                    <!-- <div class="search" id="main-search">
                        <input type="text" class="form-control underline-input" placeholder="Search...">
                    </div> -->
                    <!-- Search end -->




                    <!-- Right-side navigation -->
                    <ul class="nav-right pull-right list-inline">
                       

			<?php
				$username = "";
				if(!empty(session()->get('userName'))){
					$username = session()->get('userName');
				}

				$userid = "";
				if(!empty(session()->get('userId'))){
					$userid = session()->get('userId');
				}
			?>
			<?php
				if(!empty($username)){
			?>
              <li class="dropdown user user-menu nav-profile">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="{{asset("/admin-lte/dist/img/images.png")}}" class="img-circle size-30x30" alt="User Image">
					<span class="hidden-xs"><?=(!empty($username)?$username:"")?> <i class="fa fa-angle-down"></i></span>
				</a>
				<ul class="dropdown-menu animated littleFadeInRight" role="menu">
					<!-- User image -->
					<li>
						<a href="{{asset('/admin/user_profile/')}}" ><i class="fa  fa-user-secret"></i><span class="title">My Profile</span></a>
					</li>
					<li>
						<a href="{{asset('/admin/change_password/')}}/<?=(!empty($userid)?$userid:"")?>"><i class="fa  fa-key"></i><span class="title">Change Password</span></a>
					</li>
					<li>
						  <a href="{{ url('user_logout') }}" ><i class="fa  fa-sign-out"></i><span class="title">Logout</span></a>
					</li>
					<!-- Menu Footer-->
				<!--	<li class="user-footer">
						<div class="pull-left">
							<!--<a href="#" class="btn btn-default btn-flat">Profile</a>-->
							<!--<a href="{{ url('admin/settings') }}" class="btn btn-default btn-flat">Settings</a>
						</div>
						<div class="pull-right">
							<a href="{{ url('user_logout') }}" class="btn btn-default btn-flat"><span class="title">Logout</span></a>
						</div>
					</li>-->
				</ul>
              </li>
		  <?php
			}
		  ?>
					<li class="toggle-right-sidebar">
						<a role="button" tabindex="0">
							<i class="fa fa-comments"></i>
						</a>
					</li>
              <!-- Control Sidebar Toggle Button -->
            <!-- <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
      </header>
	   </section>
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