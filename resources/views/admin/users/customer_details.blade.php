@extends('admin.layouts.master')

@section('content')

<div class="page page-tables-datatables">
<div class="pageheader">
	<h2>Customer Info</h2>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="#"><i class="fa fa-home"></i> CRM</a>
			</li>
			<li>
				<a href="#">Customer Management</a>
			</li>
			<li>
				<a href="#">Customer Info</a>
			</li>
		</ul>
	</div>
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>

           <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Search By </strong></h1>
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
						<div id="validation_msg"></div>
       						<form role="form" action="#" method="POST" id="search_details">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="box-body">
								<div class="col-md-12">

								    <!--   <div class="form-group">
										 <label>
										  <input type="radio" name="r1" id="userid" class="minimal" >
										  By User ID
										</label>&nbsp;
										 <label>
										  <input type="radio" name="r1" id="name" class="minimal" >
										  By Name
										</label>&nbsp;
										<label>
										  <input type="radio" name="r1" id="email" class="minimal">
										  By Email
										</label>&nbsp;
										<label>
											<input type="radio" name="r1" id="trans_id" class="minimal">
										  By Transaction ID
										</label>
									  </div>
									  	<div class="form-group" id="input_userid" style="display:none;">
										<label>User ID</label>
										<input type="number" class="form-control" id="userid" name="userid" placeholder="Enter the User ID">
									</div>-->
									<div class="col-md-6">
									<div class="form-group" id="input_userid">
										<label>User ID</label>
										<input type="number" class="form-control" id="userid" name="userid" placeholder="Search By User ID">
									</div>
								    <div class="form-group" id="input_name">
										<label>Name</label>
										<input type="text" class="form-control" id="name" name="name" placeholder="Search By Name">
									</div>
									</div>
									<div class="col-md-6">
									 <div class="form-group"  id="input_email">
										<label>Email</label>
										<input type="text" class="form-control" id="email" name="email" placeholder="Search By Email">
									</div>
								   <div class="form-group"  id="input_trans_id">
										<label>Transaction ID </label>
										<input type="text" class="form-control" id="transaction" name="transaction" placeholder="Search By Transaction ID">
									</div>
									</div>

								</div>
							</div>
							<div class="box-footer">
								<button type="submit" id="customer_search" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" >Get Details</button>
								<button type="reset" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Reset</button>
							</div>
						</form>
              </div><!-- /.box -->
              </section><!-- /.box -->
					<script>

					$("#customer_search").click(function(){
				/*if blank return false else true*/

				var userid = $('#userid').val();
				var name = $('#name').val();
				var email = $('#email').val();
				var transaction = $('#transaction').val();

				if((userid=='')&&(name=='')&&(email=='')&&(transaction=='')){
					$("#validation_msg").html('<span style="margin-left:23px;padding-top:5px;color:red;">Please select atleast one field to proceed with filter</span>');
					return false;

				}
			});
					</script>
            <!-- /.box-header -->
			<?php
			     if(isset($customerdetails))
				 {
					 ?>
			           <div class="box-body">
              <div class="nav-tabs-custom" id="customer_details">
                <ul class="nav nav-tabs tabs-dark">
                  <li class="active"><a href="#user_register" data-toggle="tab">User Register Info</a></li>
                  <li><a href="#login_details" data-toggle="tab">Login Details</a></li>
				  <li><a href="#passes" data-toggle="tab">Passes</a></li>
				  <li><a href="#trans_history" data-toggle="tab">Transaction History</a></li>
                <!--  <li><a href="#settings" data-toggle="tab">Settings</a></li>-->
                </ul>

                <div class="tab-content tile">
                  <div class="active tab-pane tile-body" id="user_register">
				<table id="example1" class="table table-custom table-stribed dt-responsive">
                <thead>
                <tr>
                  <!--<th>User ID</th>-->
                  <th>Name</th>
                  <th>Email</th>
				  <!--<th>Register Type</th>
                  <th>OAuth Type</th>-->
                  <th>IP Address</th>
                </tr>
                </thead>
                <tbody>
                 @if(isset($registerinfo))
                 	@foreach ($registerinfo as $data)
                <tr>
                  <!--<td>
                  		@if(isset($data->userId))
                  			{{ $data->userId}}
                  		 @endif
                  </td>-->
                  <td>
					   @if(isset($data->name))
						{{ $data->name}}
					   @endif
                  </td>
                  <td>
						@if(isset($data->email))
						{{ $data->email}}
					   @endif
				   </td>
                  <td>
					  @if(isset($data->ipAddress))
						{{ $data->ipAddress}}
					   @endif
				   </td>
				 <!-- <td>
					  @if(isset($data->email))
						{{ $data->email}}
					   @endif
				   </td>
				   <td>
					   @if(isset($data->email))
						{{ $data->email}}
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

                  <div class="tab-pane" id="login_details">
                    <!-- The timeline -->
								<table id="example2" class="table table-custom table-stribed dt-responsive">
                <thead>
                <tr>
                  <th>User ID</th>
                  <th>Name</th>
                  <th>Email</th>
                </tr>
                </thead>
                <tbody>

                 @if(isset($logininfo))
                 	@foreach ($logininfo as $data)
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
                      @if(isset($data->email))
					{{ $data->email}}
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

				     <div class="tab-pane" id="passes">
                    <!-- The timeline -->
								<table id="example2" class="table table-custom table-stribed dt-responsive">
                <thead>
                <tr>
                 <!-- <th>User ID</th>
                  <th>Name</th>-->
                  <th>Pass</th>
                </tr>
                </thead>
                <tbody>

                 @if(isset($passinfo))
                 	@foreach ($passinfo as $data)
                <tr>
                 <!-- <td>
                  		@if(isset($data->userId))
                  			{{ $data->userId}}
                  		 @endif
                  		</td>
                  <td>
                   @if(isset($data->name))
					{{ $data->name}}
                   @endif
                  </td>-->
                  <td>
                      @if(isset($data->pass))
					{{ $data->pass}}
                   @endif
				   </td>
                </tr>
                	@endforeach
                @endif
                </tbody>

              </table>
                  </div>

				    <div class="tab-pane" id="trans_history">
                    <!-- The timeline -->
								<table id="example2" class="table table-custom table-stribed dt-responsive">
                <thead>
                <tr>
                 <!-- <th>User ID</th>
                  <th>Name</th>-->
                  <th>Transaction</th>
                </tr>
                </thead>
                <tbody>

                 @if(isset($passinfo))
                 	@foreach ($passinfo as $data)
                <tr>
                 <!-- <td>
                  		@if(isset($data->userId))
                  			{{ $data->userId}}
                  		 @endif
                  		</td>
                  <td>
                   @if(isset($data->name))
					{{ $data->name}}
                   @endif
                  </td>-->
                  <td>
                      @if(isset($data->pass))
					{{ $data->pass}}
                   @endif
				   </td>
                </tr>
                	@endforeach
                @endif
                </tbody>

              </table>
                  </div><!-- /.tab-pane -->

                  <!--<div class="tab-pane" id="settings">
						Settings
                  </div>--><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div>
			<?php
				 }
				 ?>
			</div>
            <!-- /.box-body -->
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


