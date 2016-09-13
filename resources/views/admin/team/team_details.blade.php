@extends('admin.layouts.master')

@section('content')
<!-- tile -->

<div class="page">
<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>

<div class="page page-tables-datatables">

<div class="col-md-6">
<section class="tile simple">

	<!-- tile widget -->
	<div class="tile-widget bg-slategray p-20">
		
		<div class="media">
			<div class="pull-left thumb">
				<img src="{{ asset("/admin-lte/dist/img/images.png") }}" class="img-circle size-50x50" alt="User Image" />
			</div>
			<div class="media-body">
				<h4 class="media-heading mb-0 mt-10">
					User : <strong>	
					@if(isset($userdata->userId))
						{{$userdata->userId}}
					@endif
					</strong>
					<!-- <i class="fa fa-circle text-success pull-right"></i>-->
					<div class="pull-right" style="margin-right:16px;">
                  <a class="btn btn-success" href="{{asset('/admin/edit_user/')}}/@if(isset($userdata->userId)){{$userdata->userId}}@endif">Edit User</a>
                   <!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>-->
                  </div>
				</h4>
				<!-- <small class="text-transparent-white">UI/UX Designer</small>-->
				
			</div>
		</div>

	</div>
	<!-- /tile widget -->

<!-- tile body -->
<div class="tile-body p-0">
	<div class="list-group no-radius no-border">
              <span class="list-group-item"><b>First Name :</b>
              {{$userdata->firstName}}
              						@if(isset($userdata->firstName))
              							{{$userdata->firstName}}
              						@endif
              						</span>
				 <span class="list-group-item"><b>Last Name :</b>
				@if(isset($userdata->lastName))
					{{$userdata->lastName}}
				@endif
              </span>
              <span class="list-group-item"><b>E-Mail :</b>
              						@if(isset($userdata->email))
				        				{{$userdata->email}}
              						@endif
              </span>
              <span class="list-group-item"><b>Gender :</b>
              						@if(isset($userdata->gender))
              							@if($userdata->gender==1)
              								Male
              							@elseif($userdata->gender==2)
              								Female
              							@endif
              						@endif
              </span>
              <!--<span><b>Last Logged In :</b>
              								@if(isset($userdata->email))
												{{$userdata->email}}
              								@endif
              								12/04/2016 15:00</span><br>
              <span><b>Created By :</b> Smith</span><br>-->
			  <span class="list-group-item"><b>Modified On :</b>
			  @if(isset($userdata->modifiedOn))
			  	{{$userdata->modifiedOn}}
			  @endif
			  </span>


             
              <span class="list-group-item"><b>Type :</b>
              			@if(isset($userdata->userType))
						@if($userdata->userType==1)
							Admin
						@elseif($userdata->userType==2)
							Supervisor
						@elseif($userdata->userType==3)
							Employee
						@endif
						@endif
              </span>
              <span class="list-group-item"><b>Status :</b>
              		@if(isset($userdata->status))
						@if($userdata->status==1)
							Active
						@elseif($userdata->status==2)
							In-Active
						@else
							In-Active
						@endif
					@endif
              </span>
              <span class="list-group-item"><b>Created On :</b>
              @if(isset($userdata->createdOn))
			  	{{$userdata->createdOn}}
			  @endif
			  </span>
              <!--<span><b>Modified By :</b> Smith</span><br>-->
            </div><!-- /.col -->
		  </div><!-- /.row -->
		  </section><!-- /.row -->
		  </div>

          <!-- Table row -->
		  <div class="col-md-6">
           <section class="tile tile-simple">

			<!-- tile widget -->
			<div class="tile-widget dvd dvd-btm">

				<h3 class="text-strong m-0">User History </h3>

			</div>
			<!-- /tile widget -->

			<!-- tile body -->
			<div class="tile-body p-0">

				<ul class="list-unstyled">
					<li class="p-10 b-b">
						<div class="media">
							<div class="media-body">
								<h5 class="media-heading mb-0">Tue, 12 Apr 2016 &nbsp; 15:30</h5>
								<small><b>Logged In</b></small>
							</div>
                      </div>
					</li>
					
					<li class="p-10 b-b">
						<div class="media">
							<div class="media-body">
								<h5 class="media-heading mb-0">Tue, 12 Apr 2016 &nbsp; 15:40</h5>
								<small><b>Updated user details named smith</b></small>
							</div>
                      </div>
					</li>
					<li class="p-10 b-b">
						<div class="media">
							<div class="media-body">
								<h5 class="media-heading mb-0">Tue, 12 Apr 2016 &nbsp; 15:40</h5>
								<small><b>Logged Out</b></small>
							</div>
                      </div>
					</li>
              </div>
          </section>
		  </div>


@endsection