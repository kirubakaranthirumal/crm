@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">
			 @if (session('DeleteUserSuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        User Deleted Successfully
              <script>
              window.setTimeout(function(){
			  window.location.href = "{{asset('/privilege_user_list/')}}";
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
<section class="tile">

			<!-- tile header -->
			<div class="tile-header dvd dvd-btm">
				<h1 class="custom-font"><strong>Users</strong> Table</h1>
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
              <table id="example1" class="table table-custom table-striped dt-responsive">
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
                  	@if(isset($data->createdOn))
                  		{{ $data->createdOn }}
                  	@endif
                  </td>
                  <td>
                  	<?php
						$users_edit_show = $users_delete_show = "";

						$users_edit_show = session()->get('userEdit');
						$users_delete_show = session()->get('userDelete');
					?>
                  	@if(isset($data->userId))
						@if($data->userId!=1)
							<a class="btn btn-rounded-20 btn-default btn-sm bg-primary" style="width:30px;" href="{{asset('/privilege_user_details/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="user details">
								<i class="fa fa-eye" style="margin-left: -2px;"></i>
							</a>
							<?php
								if(!empty($users_edit_show)){
							?>
									<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/privilege_edit_user/')}}/@if(isset($data->userId))
										{{ $data->userId}}
										@endif" title="edit">
										<i class="fa fa-pencil" style="margin-left: -2px;"></i>
									</a>
							<?php
								}
							?>
							
							<?php
								if(!empty($users_delete_show)){
							?>
									<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/privilege_user_list/')}}/@if(isset($data->userId)){{ $data->userId}} @endif" title="delete">
										<i class="fa fa-times"></i>
									</a> &nbsp;&nbsp;
							<?php
								}
							?>
							
							
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
                  </section>
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


