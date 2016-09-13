@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
			 @if (session('DeleteUserSuccess'))
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
              @endif
                @if (session('DeleteUserError'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Update ticket
                    </div>
                  </div>
                @endif
  <div class="box">


                <div class="box-header">
                  <h3 class="box-title">Users</h3>
                </div><!-- /.box-header -->
           <div class="box-body">
<!--<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Filter User</h3>
                </div>
                <form role="form">
                  <div class="box-body">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Name or E-Mail</label>
                      <input type="text" class="form-control" placeholder="Filter By Name or E-Mail">
                    </div>
                    <div class="form-group">
                      <label>Gender</label>
					  <select class="form-control">
						<option>Select Gender</option>
						<option>Male</option>
						<option>Female</option>
					  </select>
                    </div>
                    </div>
                    <div class="col-md-6">
                           <div class="form-group">
                      		  <label>Type</label>
                              <select class="form-control">
                                  <option>Filter By Type</option>
                        <option>Admin</option>
                        <option>Employee</option>
                      </select>
                    </div>
                  <div class="form-group">
                      <label>Date</label>
                      <input type="text" class="form-control" placeholder="Filter By Created On Date">
                  </div>

                  <label>Due By:</label>
                  <br>
                    <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Overdue
                    </span><br>

                     <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Today
                    </span><br>
                     <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Tomorrow
                    </span><br>
                     <span>
                      &nbsp;&nbsp;<input type="checkbox">
                      Next 8 hours
                    </span>

                  </div>
                    </div>

                  </div>

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                  </div>
                </form>
              </div>--><!-- /.box -->

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Type</th>
                  <th>Gender</th>
                  <th>Last Logged</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 @if(isset($userdata))
                 	@foreach ($userdata as $data)
                 		@if($data->userId!=1)
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
                   @if(isset($data->email))
					{{ $data->email}}
                   @endif
                  </td>
                  <td>@if(isset($data->userType))
                            @if($data->userType==1)
                              Admin
                            @elseif($data->userType==2)
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
                  	@if(isset($data->createdOn))
                  		{{ $data->createdOn }}
                  	@endif
                  </td>
                  <td>
                  	@if(isset($data->userId))
						@if($data->userId!=1)
							<a href="{{asset('/admin/view_user/')}}/@if(isset($data->userId)){{ $data->userId}} @endif" title="delete">
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
                   </td>
                </tr>
                		@endif
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
            <!-- /.box-body -->
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


