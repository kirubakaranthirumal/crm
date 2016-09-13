@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">
<div class="col-md-6">

                            <!-- tile -->
                            <section class="tile simple">

                                <!-- tile widget -->
                                <div class="tile-widget bg-slategray p-20">

                                    <div class="media">
                                        <div class="pull-left thumb">
                                            <img class="media-object img-circle" src="assets/images/ici-avatar.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="media-heading mb-0 mt-10">
                                                <span><b>User :</b>
													@if(isset($userdata->userId))
														{{$userdata->userId}}
													@endif
												   </span>
                                            </h3>
                                        </div>
                                    </div>

                                </div>
                                <!-- /tile widget -->

                                <!-- tile body -->
                                <div class="tile-body p-0">
								

         <div class="list-group no-radius no-border">

                    <li class="list-group-item" style="border-top:none;">
                      <b>Name</b> <a class="pull-right">@if((isset($userdata->firstName))&&(isset($userdata->lastName)))
              							{{$userdata->firstName}} {{$userdata->lastName}}
									@endif</a>
                    </li>
                    <li class="list-group-item">
                          <b>Email</b> <a class="pull-right">@if(isset($userdata->email))
				        				{{$userdata->email}}
              						@endif</a>
                    </li>
                    <li class="list-group-item">
                      <b>Gender</b> <a class="pull-right">
					 @if(isset($userdata->gender))
              							@if($userdata->gender==1)
              								Male
              							@elseif($userdata->gender==2)
              								Female
              							@endif
              						@endif</a>
                    </li>
				   <li class="list-group-item">
                      <b>Modified On</b> <a class="pull-right">
					  @if(isset($userdata->modifiedOn))
						     <?php
                          $date=date_create($userdata->modifiedOn);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>
					  @endif
						</a>
                    </li>

                    <li class="list-group-item" style="border-top:none;">
                      <b>Type</b> <a class="pull-right">@if(isset($userdata->userType))
						@if($userdata->userType==1)
							Admin
						@elseif($userdata->userType==2)
							Supervisior
						@elseif($userdata->userType==3)
							Employee
						@endif
						@endif
						</a>
                    </li>
                    <li class="list-group-item">
                          <b>Status</b> <a class="pull-right">@if(isset($userdata->status))
						@if($userdata->status==1)
							Active
						@elseif($userdata->status==2)
							In-Active
						@endif
					@endif
					</a>
                    </li>
                    <li class="list-group-item">
                      <b>Created On </b> <a class="pull-right">
					  @if(isset($userdata->createdOn))
						<?php
                          $date=date_create($userdata->createdOn);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>
			  @endif</a>
                    </li>
				  
					</ul>
            </div><!-- /.col -->
                      </div><!-- /.row -->
                      </div><!-- /.row -->


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
						 

				  @if(isset($logsdata))
                 	@foreach ($logsdata as $logs)
                     <li class="p-10 b-b">
						<div class="media">
							<div class="media-body">
							
                          <div> @if(isset($logs->Date))
							  		<?php
                          $date=date_create($logs->Date);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>
							@endif
						</div>
                      
                        <span>
							<small><b>@if(isset($logs->UserAction))
							{{$logs->UserAction}}
							@endif</b> - @if(isset($logs->msg)){{$logs->msg}}@endif </small>
                        </span>
                      </div>
							</div>
                    
					</li>
					  @endforeach 
					  @endif
					  </ul>
              </div>

          
          </section>

</div><!-- /.row -->
          </div>
@endsection