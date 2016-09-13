@extends('admin.layouts.master')

@section('content')
<!-- title row -->
           <!--<div class="row">
           <div class="col-xs-12">
              <h2 class="page-header">
			  	 @if(isset($userdata))
                 	@foreach ($userdata as $data)
               <i class="fa fa-user" aria-hidden="true"></i> <span><b>User :</b>
			   
               	@if(isset($data->userId))
					{{$data->userId}}
				@endif
				@endforeach
                @endif
               </span>
              </h2>

            </div>
          </div>-->
          <!-- info row -->
          <!--<div class="row invoice-info">
            <div class="col-sm-6 invoice-col">
			 @if(isset($userdata))
                 	@foreach ($userdata as $data)
              <span><b>First Name :</b>
              						@if(isset($data->firstName))
              							{{$data->firstName}}
              						@endif
              						</span><br>
              <span><b>E-Mail :</b>
              						@if(isset($data->email))
				        				{{$data->email}}
              						@endif
              </span><br>
              <span><b>Gender :</b>
              						@if(isset($data->gender))
              							@if($data->gender==1)
              								Male
              							@elseif($data->gender==2)
              								Female
              							@endif
              						@endif
              </span><br>
              <!--<span><b>Last Logged In :</b>
              								@if(isset($userdata['email']))
												{{$userdata['email']}}
              								@endif
              								12/04/2016 15:00</span><br>
              <span><b>Created By :</b> Smith</span><br>
			  <span><b>Modified On :</b>
			  @if(isset($data->modifiedOn))
			  	{{$data->modifiedOn}}
			  @endif
			  </span><br>
            </div>
            <div class="col-sm-6 invoice-col">
              <span><b>Last Name :</b>
             						@if(isset($data->lastName))
			 			        		{{$data->lastName}}
              						@endif
              </span><br>
              <span><b>Type :</b>
              			@if(isset($data->userType))
						@if($data->userType==1)
							Admin
						@elseif($data->userType==2)
							Employee
						@endif
						@endif
              </span><br>
              <span><b>Status :</b>
              		@if(isset($data->userStatus))
						@if($data->userStatus==1)
							Active
						@elseif($data->userStatus==2)
							In-Active
						@endif
					@endif
              </span><br>
              <span><b>Created On :</b>
              @if(isset($data->createdOn))
			  	{{$data->createdOn}}
			  @endif
			  
			  	@endforeach
                @endif
			  </span><br>
              <!--<span><b>Modified By :</b> Smith</span><br>
            </div>
                      </div>--><!-- /.row -->
<div class="page page-tables-datatables">
                            <!-- tile -->
                            <section class="tile simple">

                                <!-- tile widget -->
                                <div class="tile-widget  bg-slategray  p-30 text-center">

                                    <div class="thumb thumb-xl">

                                            <img class="profile-user-img img-responsive img-circle" src="{{asset("/admin-lte/dist/img/images.png")}}" alt="User profile picture">
                                        </div>
                                    
										<h3 class="mb-0" style="text-transform: capitalize;">
										@if((isset($data->firstName))&&(isset($data->lastName)))
												{{$data->firstName}} {{$data->lastName}}
											@endif
										</h3>
                                            <small class="text-muted">
											@if(isset($data->userType))
												@if($data->userType==1)
													Admin
												@elseif($data->userType==2)
													Supervisior
												@elseif($data->userType==3)
													Employee
												@endif
											@endif
											</small>
                                </div>
                                   


                                <!-- tile body -->
       <div class="tile-body p-0" style="margin-top: 20px;">

		<div class="col-md-4">
              <!-- Profile Image -->
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Name</b> <a class="pull-right">@if((isset($data->firstName))&&(isset($data->lastName)))
              							{{$data->firstName}} {{$data->lastName}}
									@endif</a>
                    </li>
                    <li class="list-group-item">
                          <b>Email</b> <a class="pull-right">@if(isset($data->email))
				        				{{$data->email}}
              						@endif</a>
                    </li>
                    <li class="list-group-item">
                      <b>Gender</b> <a class="pull-right">
					  @if(isset($data->gender))
              							@if($data->gender==1)
              								Male
              							@elseif($data->gender==2)
              								Female
              							@endif
              						@endif</a>
                    </li>
                  </ul>
				    	
                </div><!-- /.box-body -->
             
		<div class="col-md-4">
              <!-- Profile Image -->
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Type</b> <a class="pull-right">@if(isset($data->userType))
					@if($data->userType==1)
						Admin
					@elseif($data->userType==2)
						Supervisior
					@elseif($data->userType==3)
						Employee
					@endif
				@endif</a>
                    </li>
                    <li class="list-group-item">
                      <b>Status</b> <a class="pull-right">@if(isset($data->status))
					@if($data->status==1)
							Active
						@elseif($data->status==2)
							In-Active
						@endif
					@endif</a>
                    </li>
                    <li class="list-group-item">
                      <b>Created By</b> <a class="pull-right"> @if(isset($data->createdBy))
					{{$data->createdBy}}
             	@endif</a>
                    </li>
                  </ul>
                </div><!-- /.box-body -->
			  		<div class="col-md-4">
              <!-- Profile Image -->
                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Created On</b> <a class="pull-right"> 
					  @if(isset($data->createdOn))
                          <?php
                          $date=date_create($data->createdOn);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>

                         @endif
				    </a>
                    </li>
                    <li class="list-group-item">
                      <b>Modified On</b> <a class="pull-right"> @if(isset($data->modifiedOn))
                          <?php
                          $date=date_create($data->modifiedOn);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>
                         @endif</a>
                    </li>
                    <li class="list-group-item">
                      <b>Last Logged on</b> <a class="pull-right">	 @if(isset($data->lastLoggedOn))
                          <?php
                          $date=date_create($data->lastLoggedOn);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>

                         @endif</a>
                    </li>
							  
                  </ul>
				
                </div><!-- /.box-body -->
              <!-- About Me Box -->
			  <div class="col-md-12">
			   <a class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" href="{{asset('/admin/edit_user/')}}/@if(isset($data->userId))
				{{ $data->userId}}
				@endif">Edit Profile <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			  </div>
				<div class="clearfix"></div>
			   </div><!-- /.box -->
		
		</div>
         		
          </section>
</div>

@endsection