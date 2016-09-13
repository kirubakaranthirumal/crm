@extends('admin.layouts.master')

@section('content')
        <section class="invoice">
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
					  <div class="row invoice-info">
      
  <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                  <h3 class="widget-user-username">@if((isset($data->firstName))&&(isset($data->lastName)))
              							{{$data->firstName}} {{$data->lastName}}
              						@endif</h3>
                  <h5 class="widget-user-desc">@if(isset($data->userType))
              							@if($data->userType==1)
              								Admin
              							@elseif($data->userType==2)
              								Employee
              							@endif
              						@endif
					  </h5>
					  <div class="pull-right">
					  	<!--<a class="btn btn-success" href="{{asset('/admin/change_password/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif">Change Password</a>-->
								<a class="btn btn-success" href="{{asset('/admin/edit_user/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif">Edit Profile</a>
							</div>
                </div>
		<div class="col-sm-6 invoice-col">

              <div style="border:0px solid red;width:100%;float:left;">
                <div style="border:0px solid red;width:18%;float:left;">
                <b>Name</b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
                 @if((isset($data->firstName))&&(isset($data->lastName)))
              							{{$data->firstName}} {{$data->lastName}}
									@endif
                </span>
              </div>
             </div>
             <div style="border:0px solid red;width:100%;float:left;">
                <div style="border:0px solid red;width:18%;float:left;">
                <b> E-Mail</b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
               <b> :</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
							@if(isset($data->email))
				        				{{$data->email}}
              						@endif
                </span>
              </div>
             </div>

                <div style="border:0px solid red;width:100%;float:left;">
                <div style="border:0px solid red;width:18%;float:left;">
                <b>Gender </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
							@if(isset($data->gender))
              							@if($data->gender==1)
              								Male
              							@elseif($data->gender==2)
              								Female
              							@endif
              						@endif
                </span>
              </div>
             </div>
              <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Last Logged In </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
              @if(isset($data->lastLoggedOn))
					{{$data->lastLoggedOn}}
				@endif
                </span>
              </div>
             </div>
            <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Created By  </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
               @if(isset($data->createdBy))
					{{$data->createdBy}}
             	@endif
                </span>
              </div>
             </div>
      
            </div><!-- /.col -->
    <!-- /.col -->
            <div class="col-sm-6 invoice-col">
			      <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Modified On </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
                 @if(isset($data->modifiedOn))
			  	{{$data->modifiedOn}}
			  @endif
                </span>
              </div>
             </div>
            <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Type </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
               @if(isset($data->userType))
						@if($data->userType==1)
							Admin
						@elseif($data->userType==2)
							Employee
						@endif
						@endif
                </span>
              </div>
             </div>
              <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Status </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
				 @if(isset($data->status))
					@if($data->status==1)
							Active
						@elseif($data->status==2)
							In-Active
						@endif
					@endif
                </span>
              </div>
             </div>
              <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Created On </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
               @if(isset($data->createdOn))
			  	{{$data->createdOn}}
			  @endif
                </span>
              </div>
             </div>
             </div>
			</div>
			</div>
          </section>


@endsection