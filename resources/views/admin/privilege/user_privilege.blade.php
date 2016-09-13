@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>Users Privilege</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Access Management</a>
			</li>
			<li>
				<a href="#">Users Privilege</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>


<!-- tile -->
<section class="tile">

	<!-- tile header -->
	<div class="tile-header dvd dvd-btm">
		<h1 class="custom-font"><strong>Users </strong>Privilege</h1>
		<ul class="controls">
			<li class="dropdown">

				<a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
					<i class="fa fa-cog"></i>
					<i class="fa fa-spinner fa-spin"></i>
				</a>

				<ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
					<li>
						<a role="button" tabindex="0" class="tile-toggle">
							<span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
							<span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
						</a>
					</li>
					<li>
						<a role="button" tabindex="0" class="tile-refresh">
							<i class="fa fa-refresh"></i> Refresh
						</a>
					</li>
					<li>
						<a role="button" tabindex="0" class="tile-fullscreen">
							<i class="fa fa-expand"></i> Fullscreen
						</a>
					</li>
				</ul>

			</li>
			<li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
		</ul>
	</div>
	<!-- /tile header -->

	<!-- tile body -->
	<div class="tile-body">
		<div class="table-responsive">

              <table id="example1" class="table table-custom table-striped">
                <thead>
                <tr>
						<th>Name</th>
						<th>Type</th>
                        <th>Email Address</th>
                        <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
					//print"<pre>";
                	//print_r($userdata);
                ?>
                 @if(isset($userdata))
                 	@foreach ($userdata as $data)
                <tr>
                  <td>
                  		@if(isset($data->firstName))
                  			{{ $data->firstName}}
                  		 @endif
                  		 @if(isset($data->lastName))
						    {{ $data->lastName}}
                  		 @endif
                  		</td>
                  <td>
                  		@if(isset($data->userType))
                  			@if($data->userType==1)
                  				Admin
							@elseif($data->userType==2)
								Supervisor
							@elseif($data->userType==3)
								Employee
                  		 	@endif
                  		 @endif
                  		</td>
                  <td>
                   @if(isset($data->email))
					{{ $data->email}}
                   @endif
                  </td>
                  <td>
                  	@if(isset($data->userId))

							<a class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" href="{{asset('/admin/assign_privilege/')}}/@if(isset($data->userId)){{ $data->userId}} @endif" title="Set Privilege">
								Set Privilege <i class="fa fa-cog" aria-hidden="true"></i>
							</a>
					@endif
                   </td>
                </tr>
                	@endforeach
                @endif
                </tbody>
                <!--<tfoot>
                  <tr>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Type</th>
                  <th>Gender</th>
                  <th>Last Logged</th>
                  <th>Created On</th>
				  <th>Action</th>
                </tr>
                </tfoot>-->
              </table>
            </div>
                </div>
                  </div>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
@endsection


