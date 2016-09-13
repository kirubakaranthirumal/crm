
<script language="javascript">
	//$(document).ready(function(){
	//	alert('HI');
	//	setInterval(load_notification(''), 500);
	//});

	function load_notification(){

		var url_str = "";

		$.ajax({
			type: "GET",
			url: "{{asset('load_new_ticket_notify_emp')}}",
			data: url_str,
			success: function(data){
				$('#notify_div').html(data);
			}
		});
	}

	function update_notification(){

		var url_str = "";

		$.ajax({
			type: "GET",
			url: "{{asset('update_new_ticket_notify_emp')}}",
			data: url_str,
			success: function(data){
				$('#upd_notify_div').html(data);
			}
		});
	}

	setInterval(function(){
	    //code goes here that will be run every 5 seconds.
	    load_notification();
	}, 5000);
</script>
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

			 <!-- 
		<div class="search" id="main-search">
			<input type="text" class="form-control underline-input" placeholder="Search...">
		</div>
		-->

        <!-- Right-side navigation -->
                    <ul class="nav-right pull-right list-inline">
					<!--
                        <li class="dropdown users">

                            <a href class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>
                                <span class="badge bg-lightred">2</span>
                            </a>

                            <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInUp" role="menu">

                                <div class="panel-heading">
                                    You have <strong>2</strong> requests
                                </div>

                                <ul class="list-group">

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object thumb thumb-sm">
                                                <img src="{{asset("/admin-lte/assets/images/arnold-avatar.jpg")}}" alt="" class="img-circle">
                                            </span>
                                            <div class="media-body">
                                                <span class="block">Arnold sent you a request</span>
                                                <small class="text-muted">15 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object  thumb thumb-sm">
                                                <img src="{{asset("/admin-lte/assets/images/george-avatar.jpg")}}" alt="" class="img-circle">
                                            </span>
                                            <div class="media-body">
                                                <span class="block">George sent you a request</span>
                                                <small class="text-muted">5 hours ago</small>
                                            </div>
                                        </a>
                                    </li>

                                </ul>

                                <div class="panel-footer">
                                    <a role="button" tabindex="0">Show all requests <i class="fa fa-angle-right pull-right"></i></a>
                                </div>

                            </div>

                        </li>
						-->

                        <!--<li class="dropdown messages">

                            <a href class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="badge bg-lightred">4</span>
                            </a>

                            <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInDown" role="menu">

                                <div class="panel-heading">
                                    You have <strong>4</strong> messages
                                </div>

                                <ul class="list-group">

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object thumb thumb-sm">
                                                <img src="{{asset("/admin-lte/assets/images/ici-avatar.jpg")}}" alt="" class="img-circle">
                                            </span>
                                            <div class="media-body">
                                                <span class="block">Imrich sent you a message</span>
                                                <small class="text-muted">12 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object  thumb thumb-sm">
                                                <img src="{{asset("/admin-lte/assets/images/peter-avatar.jpg")}}" alt="" class="img-circle">
                                            </span>
                                            <div class="media-body">
                                                <span class="block">Peter sent you a message</span>
                                                <small class="text-muted">46 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object  thumb thumb-sm">
                                                <img src="{{asset("/admin-lte/assets/images/random-avatar1.jpg")}}" alt="" class="img-circle">
                                            </span>
                                            <div class="media-body">
                                                <span class="block">Bill sent you a message</span>
                                                <small class="text-muted">1 hour ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object  thumb thumb-sm">
                                                <img src="{{asset("/admin-lte/assets/images/random-avatar3.jpg")}}" alt="" class="img-circle">
                                            </span>
                                            <div class="media-body">
                                                <span class="block">Ken sent you a message</span>
                                                <small class="text-muted">3 hours ago</small>
                                            </div>
                                        </a>
                                    </li>

                                </ul>

                                <div class="panel-footer">
                                    <a role="button" tabindex="0">Show all messages <i class="pull-right fa fa-angle-right"></i></a>
                                </div>

                            </div>

                        </li>
						-->
						<li class="dropdown notifications" id="notify_div">
							<script language="javascript">
								load_notification();
							</script>
						</li>						
						<!--
						
						<li class="dropdown notifications">
						
                            <a href class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell"></i>
                                <span class="badge bg-lightred">3</span>
                            </a>

                            <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInLeft">

                                <div class="panel-heading">
                                    You have <strong>3</strong> notifications
                                </div>

                                <ul class="list-group">

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object media-icon bg-danger">
                                                <i class="fa fa-ban"></i>
                                            </span>
                                            <div class="media-body">
                                                <span class="block">User Imrich cancelled account</span>
                                                <small class="text-muted">6 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object media-icon bg-primary">
                                                <i class="fa fa-bolt"></i>
                                            </span>
                                            <div class="media-body">
                                                <span class="block">New user registered</span>
                                                <small class="text-muted">12 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="list-group-item">
                                        <a role="button" tabindex="0" class="media">
                                            <span class="pull-left media-object media-icon bg-greensea">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                            <div class="media-body">
                                                <span class="block">User Robert locked account</span>
                                                <small class="text-muted">18 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                </ul>

                                <div class="panel-footer">
                                    <a role="button" tabindex="0">Show all notifications <i class="fa fa-angle-right pull-right"></i></a>
                                </div>
								</li>
                            </div>-->

                        

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
              <li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="{{asset("/admin-lte/dist/img/images.png")}}" class="img-circle size-30x30" alt="User Image">
					<span class="hidden-xs"><?=(!empty($username)?$username:"")?> <i class="fa fa-angle-down"></i></span>
				</a>
				<ul class="dropdown-menu">
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