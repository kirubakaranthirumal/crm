@extends('admin.layouts.master')

@section('content')
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
               <i class="fa fa-user" aria-hidden="true"></i> <span><b>User :</b>
               	@if(isset($userdata['userId']))
					{{$userdata['userId']}}
				@endif
               </span>
                  <div class="pull-right" style="margin-right:16px;">
                  <a class="btn btn-success" href="">Edit User</a>
                   <!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>-->
                  </div>

              </h2>

            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-6 invoice-col">
              <span><b>First Name :</b>
              						@if(isset($userdata['firstName']))
              							{{$userdata['firstName']}}
              						@endif
              						</span><br>
              <span><b>E-Mail :</b>
              						@if(isset($userdata['email']))
				        				{{$userdata['email']}}
              						@endif
              </span><br>
              <span><b>Gender :</b>
              						@if(isset($userdata['gender']))
              							@if($userdata['gender']==1)
              								Male
              							@elseif($userdata['gender']==2)
              								Female
              							@endif
              						@endif
              </span><br>
              <!--<span><b>Last Logged In :</b>
              								@if(isset($userdata['email']))
												{{$userdata['email']}}
              								@endif
              								12/04/2016 15:00</span><br>
              <span><b>Created By :</b> Smith</span><br>-->
			  <span><b>Modified On :</b>
			  @if(isset($userdata['modifiedOn']))
			  	{{$userdata['modifiedOn']}}
			  @endif
			  </span><br>
            </div><!-- /.col -->
    <!-- /.col -->
            <div class="col-sm-6 invoice-col">
              <span><b>Last Name :</b> {{ $userdata['lastName'] }}</span><br>
              <span><b>Type :</b>
              			@if(isset($userdata['userType']))
						@if($userdata['userType']==1)
							Admin
						@elseif($userdata['userType']==2)
							Employee
						@endif
						@endif
              </span><br>
              <span><b>Status :</b>
              		@if(isset($userdata['status']))
						@if($userdata['status']==1)
							Active
						@elseif($userdata['status']==2)
							In-Active
						@else
							In-Active
						@endif
					@endif
              </span><br>
              <span><b>Created On :</b>
              @if(isset($userdata['createdOn']))
			  	{{$userdata['createdOn']}}
			  @endif
			  </span><br>
              <!--<span><b>Modified By :</b> Smith</span><br>-->
            </div><!-- /.col -->
                      </div><!-- /.row -->

                 <br>
          <div class="row">
          <div class="col-sm-8">
          	<!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>-->
			</div>
          	</div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
   				     <div class="box-body">
				<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">User History</h3>
                  </div>
                      <div class="user-block">
                        <span class=''>
                          <span>Tue, 12 Apr 2016 &nbsp; 15:30</span>
                        </span>
                        <br>
                        <span>
							<small><b>Logged In</b></small>
                        </span>
                      </div>
                      <br>
                      <div class="user-block">
						  <span class=''>
							<span>Tue, 12 Apr 2016 &nbsp; 15:40</span>
						  </span>
						  <br>
						  <span>
							<small><b>Updated user details named smith</b></small>
						  </span>
						</div>
                      <br>
						<div class="user-block">
						  <span class=''>
							<span>Tue, 12 Apr 2016 &nbsp; 15:40</span>
						  </span>
						  <br>
						  <span>
							<small><b>Logged Out</b></small>
						  </span>
						</div>
                      <br>
              </div>

          </div><!-- /.row -->
          </div>
          </section>


@endsection