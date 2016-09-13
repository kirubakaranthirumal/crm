@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>Customer Status</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Customer Management</a>
			</li>
			<li>
				<a href="#">Customer Status</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
			<!--	 @if (session('DeleteUserSuccess'))
					 <div class="col-md-12">
                <div class="flash-message">
                   <div class="alert alert-success">
                        User Deleted Successfully
              <script>
              window.setTimeout(function(){
window.location.href = "{{asset('/admin/user_log_status/')}}";
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
                @endif-->
				
		<div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs tabs-dark">
                  <li class="active"><a href="#active" data-toggle="tab">Online Users</a></li>
                  <!--<li><a href="#inactive" data-toggle="tab">In-Active Customer</a></li>-->
				  <!--  <li><a href="#settings" data-toggle="tab">Settings</a></li>-->
                </ul>
                <div class="tab-content tile">
                  <div class="active tab-pane tile-body" id="active">
				<table id="example1" class="table table-custom table-stribed dt-responsive">
                <thead>
                <tr>
                  <th>Id</th>
				  <th>Name</th>
                  <th>E-mail</th>
				  <!--   <th>Action</th>-->
                </tr>
                </thead>
                <tbody>
                 @if(isset($activeuser))
                 	@foreach ($activeuser as $data)
					 
					
                <tr>
					<td>
                  		@if(isset($data->userId))
                  			{{ $data->userId}}
                  		 @endif
                  		</td>			
                  <td>
                  		@if(isset($data->name))
                  			{{ $data->name}}
                  		 @endif
                  		</td>
                  <td>
                   @if(isset($data->userEmail))
					{{ $data->userEmail}}
                   @endif
                  </td>
                <!--  <td>
                  	@if(isset($data->userId))
						@if($data->userId!=1)
							<a href="{{asset('/admin/user_log_status/')}}/@if(isset($data->userId)){{ $data->userId}} @endif" title="delete">
								<i class="fa fa-remove"></i>
							</a> &nbsp;&nbsp;
							<a href="{{asset('/admin/edit_user/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="edit">
								<i class="fa fa-edit"></i>
							</a> &nbsp;&nbsp;
							<a href="{{asset('/admin/user_details/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="user details"><i class="fa fa-user-secret"></i>
							</a>
						@endif
					@endif
                   </td>-->
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
                  </div><!-- /.tab-pane -->
               
			   <!--
			   <div class="tab-pane tile-body" id="inactive"> -->
                    <!-- The timeline -->
				<!--
				<table id="example2" class="table table-custom table-stribed dt-responsive">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Type</th>
                  <th>Gender</th>
                  <th>Last Logged</th> -->
                 <!-- <th>Action</th>--> 
                <!--
				</tr>
                </thead>
                <tbody>
                 @if(isset($inactiveuser))
                 	@foreach ($inactiveuser as $data)
					 @if($data->userId!=1)
                <tr>
                  <td>
                  		@if(isset($data->userName))
                  			{{ $data->userName}}
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
                  <td>@if(isset($data->gender))
                            @if($data->gender==1)
                              Male
                            @elseif($data->gender==2)
                              Female
                            @endif
                          @endif</td>
                  <td>
                  	@if(isset($data->lastLoggedOn))
					  <?php
                          //$date=date_create($data->lastLoggedOn);
                          ///echo date_format($date,"Y-m-d h:i A");
                          ?>
                  	@endif
                  </td>-->
                 <!-- <td>
                  	@if(isset($data->userId))
						@if($data->userId!=1)
							<a href="{{asset('/admin/user_log_status/')}}/@if(isset($data->userId)){{ $data->userId}} @endif" title="delete">
								<i class="fa fa-remove"></i>
							</a> &nbsp;&nbsp;
							<a href="{{asset('/admin/edit_user/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="edit">
								<i class="fa fa-edit"></i>
							</a> &nbsp;&nbsp;
							<a href="{{asset('/admin/user_details/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="user details"><i class="fa fa-user-secret"></i>
							</a>
						@endif
					@endif
                   </td>-->
                <!--</tr>
					@endif
                	@endforeach
                @endif
                </tbody>-->
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
              <!--</table>-->
                  <!--</div>--><!-- /.tab-pane -->

                  <!--<div class="tab-pane" id="settings">
						Settings
                  </div>--><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div>
			</div>

<script>
  $(function () {
    $("#example1").DataTable();
	$("#example2").DataTable();
   /*  $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    }); */
  });
</script>
@endsection


