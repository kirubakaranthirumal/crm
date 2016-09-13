@extends('admin.layouts.master')

@section('content')
<div class="page page-tables-datatables">
<div class="col-md-6">

	<!-- tile -->
	<section class="tile simple">

		<!-- tile widget -->
		<div class="tile-widget bg-slategray p-20">

			<div class="media">
				<!--<div class="pull-left thumb">
					<img class="media-object img-circle" src="assets/images/ici-avatar.jpg" alt="">
				</div> -->
				<div class="media-body">
					<h4 class="media-heading mb-0 mt-10">
					 <i class="fa fa-ticket" aria-hidden="true"></i> <span><b>Feedback ID :</b>
					 @if(isset($feedlist->feed_id))
						  {{$feedlist->feed_id}}
					   @endif
					</h4>
					<!-- <small class="text-transparent-white">UI/UX Designer</small>-->
				</div>
			</div>

		</div>
		<!-- /tile widget -->

		<!-- tile body -->
		<div class="tile-body p-0">
			<div class="list-group no-radius no-border">
				
              
               <?php
              // print"<pre>";
               //print_r($historydata);
              // exit;
               ?>
               

                  <!--<div class="pull-right" style="margin-right:16px;">

                  <a class="btn btn-success" href="">Edit Ticket</a>

                   <!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>
                  </div>-->
			<a href="#" class="list-group-item">
				 <b>Name :</b>
				 <span>
                  @if(isset($feedlist->feed_user_name))
                    {{$feedlist->feed_user_name}}
                  @endif
                </span>
			</a>
			
			<a href="#" class="list-group-item">
				 <b>Email :</b>
				<span>
                   @if(isset($feedlist->feed_email))
                    {{$feedlist->feed_email}}
                  @endif
                </span>
			</a>
			
			<a href="#" class="list-group-item">
				<b>Mobile No :</b>
				<span>
                  @if(isset($feedlist->feed_mobile))
                    {{$feedlist->feed_mobile}}
                  @endif
                </span>
			</a>
			<a href="#" class="list-group-item">
				<b>Subject :</b>
				<span>
                @if(isset($feedlist->feed_subject))
                    {{$feedlist->feed_subject}}
                  @endif
                </span>
			</a>
			
			<a href="#" class="list-group-item">
				<b>Type :</b>
				<span>
                   @if(isset($feedlist->feed_type))
						@if($feedlist->feed_type==1)
							General Feedback
						@elseif($feedlist->feed_type==2)
							Ticket Feedback
						@endif
                  @endif
                </span>
			</a>
			
			<a href="#" class="list-group-item">
				 <b>Created On </b>
				 <span>
				  @if(isset($feedlist->feed_created_on))
					   <?php
							  $date=date_create($feedlist->feed_created_on);
							  echo date_format($date,"Y-m-d h:i A");
							  ?>
				  @endif
                </span>
			</a>
			<a href="#" class="list-group-item">
				  <b>Description </b>
				 <span>
                @if(isset($feedlist->feed_desc))
                    {{$feedlist->feed_desc}}
                  @endif
                </span>
			</a>
      
          </div>
          </div>
          </section>
          </div>
          </div>


@endsection