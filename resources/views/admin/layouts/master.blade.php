@include('admin.partials.header')
<?php
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

    @include('admin.partials.sidebar')

    <?php
		//print"<pre>";
		//print_r(session::all());
		//exit;
	?>
    <!-- Main content -->
    <section id="content">

		@if (Session::has('message'))
			<div class="note note-info">
				<p>{{ Session::get('message') }}</p>
			</div>
		@endif
		@yield('content')

		<div class="loginform" id="chatContainer" style="background:transparent;">
		</div>			

    </section>
    <!-- /.content -->

<div class="scroll-to-top"
     style="display: none;">
    <i class="fa fa-arrow-up"></i>
</div>
@include('admin.partials.javascripts')

@yield('javascript')
@include('admin.partials.footer')



