@include('admin.partials.header')
<?php
	//print"<pre>";
	//print_r(session::all());
	//exit;

	$userType = Session::get("userType");

	//echo $userType;
	//exit;

	if((!empty($userType)) && ($userType==1)){
?>
		@include('admin.partials.topbar')
<?php
	}
	else{
?>
		@include('admin.partials.topbar_emp')
<?php
	}
?>
<div class="clearfix"></div>
 <body class="hold-transition skin-blue sidebar-mini">
<div class="page-container">

    @include('admin.partials.sidebar')

      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <!-- <section class="content-header">
      <h1>

                {{ preg_replace('/([a-z0-9])?([A-Z])/','$1 $2',str_replace('Controller','',explode("@",class_basename(app('request')->route()->getAction()['controller']))[0])) }}

      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>-->

    <!-- Main content -->
    <section class="content">
		<div class="row">
			@if (Session::has('message'))
				<div class="note note-info">
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif
			@yield('content')
		</div>
    </section>
    <!-- /.content -->
  </div>
</div>

<div class="scroll-to-top"
     style="display: none;">
    <i class="fa fa-arrow-up"></i>
</div>
@include('admin.partials.javascripts')

@yield('javascript')
@include('admin.partials.footer')


