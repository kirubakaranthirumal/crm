@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">

                    <div class="pageheader">

                        <h2>Users</h2>

                        <div class="page-bar">

                            <ul class="page-breadcrumb">
                                <li>
                                    <a href="#"><i class="fa fa-home"></i> CRM</a>
                                </li>
                                <li>
                                    <a href="#">Ticket Admin Management</a>
                                </li>
                                <li>
                                    <a href="#">Users</a>
                                </li>
                            </ul>

                        </div>
						<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
                    </div>

				 @if (session('DeleteUserSuccess'))
					 <div class="col-md-12">
                <div class="flash-message">
                   <div class="alert alert-success">
                        User Deleted Successfully
						<script>
							window.setTimeout(function(){
							window.location.href = "{{asset('/admin/view_user/')}}";
							}, 1000);
						</script>
                  </div>
                </div>
				</div>
              @endif
                @if (session('DeleteUserError'))
					<div class="col-md-12">
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Update ticket
                    </div>
                  </div>
				  </div>
                @endif
        <!-- tile -->
		<section class="tile">

			<!-- tile header -->
			<div class="tile-header dvd dvd-btm">
				<h1 class="custom-font"><strong>Users</strong></h1>
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
                <thead class="thead-inverse">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Last Logged</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 @if(isset($userdata))
                 	@foreach ($userdata as $data)
                <tr>
                  <td>
					@if(isset($data->userId))
						{{$data->userId}}
					@endif
				  </td>
                  <td>
                  		@if(isset($data->firstName))
                  			{{ $data->firstName}}
                  		 @endif
                  		 @if(isset($data->lastName))
						    {{ $data->lastName}}
                  		 @endif
                  		</td>
                  <td>
                   @if(isset($data->email))
					{{ $data->email}}
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
                          @endif</td>
                  <td>@if(isset($data->status))
                            @if($data->status==1)
                              Active
                            @elseif($data->status==2)
                              In-Active
                            @endif
                          @endif</td>
                  <td>
                  	@if(isset($data->createdOn))
                  		{{ $data->createdOn }}
                  	@endif
                  </td>
                  <td style="width:160px;">
                  	@if(isset($data->userId))
						@if($data->userId!=1)
							
							
							<a class="btn btn-rounded-20 btn-default btn-sm bg-primary" style="width:30px;" href="{{asset('/admin/user_details/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="View user details"><i class="fa fa-eye" style="margin-left: -2px;"></i>
							</a>
							<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/edit_user/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="edit">
								<i class="fa fa-pencil"></i>
							</a>
							
							<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/view_user/')}}/@if(isset($data->userId)){{ $data->userId}} @endif" title="delete">
								<i class="fa fa-times"></i>
							</a>
						@endif
					@endif
                   </td>
                </tr>
                	@endforeach
                @endif
                </tbody>
                
              </table>
            </div>
			</div>
            <!-- /.box-body -->
			</section>
			</div>
<script>

	$(function(){
		$('#example1').DataTable( {
			"aaSorting": [[ 0, "desc" ]],
			"aoColumnDefs" : [{
		   		'bSortable' : false,
		   		'aTargets' : [ 6 ]
		 	}]
    	});
   });

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


