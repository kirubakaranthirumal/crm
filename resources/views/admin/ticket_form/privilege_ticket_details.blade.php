@extends('admin.layouts.master')

@section('content')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
  <script language="javascript">
    (function($,W,D){
      var JQUERY4U = {};

      $.validator.addMethod(
          "notEqualTo",
          function(elementValue,element,param) {
          return elementValue != param;
          },
          "Value cannot be {0}"
      );
      JQUERY4U.UTIL =
      {
        setupFormValidation: function()
        {
          //form validation rules
          $("#ticket-comments").validate({
            rules: {
              description1: "required",
              status: {
                required: true,
                notEqualTo: 20
              }
            },
            messages: {
              description1: "Enter Comment",
              status: "Select status"
            },
            submitHandler: function(form){
              form.submit();
            }
          });
        }
      }
      //when the dom has loaded setup form validation rules
      $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
      });

    })(jQuery, window, document);
  </script>
    <style>
    #ticket-comments label.error{
      color: #FB3A3A;
      display: inline-block;
      //margin: 4px 0 5px 125px;
      padding: 0;
      text-align: left;
      width: 250px;
    }

    .form-control{
      background-color: #fff;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 2px;
      color: #555;
      display: block;
      font-size: 14px;
      height: 34px;
      line-height: 1.42857;
      padding: 6px 12px;
      transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
      width: 96%;
    }
  </style>
<div class="page page-tables-datatables">
<div class="col-md-6">

<!-- tile -->
<section class="tile simple">

	<!-- tile widget -->
	<div class="tile-widget bg-slategray p-20">

		<div class="media">
			<div class="pull-left thumb">
				<!-- <img class="media-object img-circle" src="{{asset("/admin-lte/assets/images/ici-avatar.jpg")}}" alt=""> -->
				 <h1 style="margin:0px;"><i class="fa fa-ticket" aria-hidden="true"></i> </h1>
			</div>
			<div class="media-body">
				<h3 class="media-heading mb-0 mt-10">
					
				   <span><b>Ticket :</b>
				   <?php
				  // print"<pre>";
				   //print_r($historydata);
				  // exit;
				   ?>
				   @if(isset($ticketdata->ticketId))
					  {{$ticketdata->ticketId}}
				   @endif
					</span>
					<div style="float:right;margin-right:1%;">
						<?php
							$usertype = session()->get('userType');
						?>
						@if($usertype == 1 || $usertype == 2)
						<a href="{{asset('/edit_ticket/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif" class="btn btn-cyan">
							Edit Ticket
						</a>
						@endif
					</div>
				</h3>
			</div>
			
		</div>

	</div>
	<!-- /tile widget -->

	<!-- tile body -->
	<div class="tile-body p-0">	
        <div class="list-group no-radius no-border">
			<li class="list-group-item" style="border-top:none;">
				<b>Name :</b>
             
                <span>
                  @if(isset($ticketdata->requestorName))
                    {{$ticketdata->requestorName}}
                  @endif
                </span>
			</li>
            
			<li class="list-group-item">
                <b>Source :</b>             
					<span>
					 @if(isset($ticketdata->ticketSource))
					@if($ticketdata->ticketSource==1)
					  Portal
					@elseif($ticketdata->ticketSource==2)
					 Email
					@elseif($ticketdata->ticketSource==3)
					  Social Media
					 @elseif($ticketdata->ticketSource==4)
					  Live Chat
					@endif
					 @endif
					</span>
              </li>
			
			<li class="list-group-item">
                <b>Category :</b>
             
                <span>
              @if(isset($ticketdata->ticketCatId))
                @if($ticketdata->ticketCatId==1)
                  Network Issue
                @elseif($ticketdata->ticketCatId==2)
                  Payment
                @elseif($ticketdata->ticketCatId==3)
                  Browser
                 @elseif($ticketdata->ticketCatId==4)
                  Streaming
                @endif
              @endif
                </span>
              </li>
			  <li class="list-group-item">             
                <b>Status :</b>             
					<span>
				  @if(isset($ticketdata->status))
				   @if($ticketdata->status==1)
					Open
				   @elseif($ticketdata->status==2)
					Assiged
				   @elseif($ticketdata->status==3)
					InProgress
				   @elseif($ticketdata->status==4)
					Closed
				   @elseif($ticketdata->status==5)
					Waiting On Customer
				   @elseif($ticketdata->status==6)
					Waiting On 3rd Party
				   @endif
				 @endif
                </span>
              </li>
             <li class="list-group-item">
                <b>Modified By :</b>
             
                <span>
				   @if(isset($ticketdata->modifiedBy))
					 {{$ticketdata->modifiedBy}}
				  @endif
                </span>
              </li>
			  <li class="list-group-item">           
                <b>Modified On :</b>
            
                <span>
                 @if(isset($ticketdata->modifiedOn))
				   <?php
						  $date=date_create($ticketdata->modifiedOn);
						  echo date_format($date,"Y-m-d h:i A");
						  ?>
				  @endif
                </span>
              </li>
			  <li class="list-group-item">        
                <b>Subject :</b>
             
                <span>
               @if(isset($ticketdata->ticketSubject))
                {{$ticketdata->ticketSubject}}
               @endif
                </span>
              </li>
           <li class="list-group-item">
		   
                <b>Type :</b>
              
                <span>
               @if(isset($ticketdata->type))
                @if($ticketdata->type==1)
                  Question
                @elseif($ticketdata->type==2)
                  Indicent
                @elseif($ticketdata->type==3)
                  Problem
                @elseif($ticketdata->type==4)
                  Feature Request
                @endif
               @endif
                </span>
              </li>
				
			<li class="list-group-item">
                <b>Priority :</b>
              
                <span>
               @if(isset($ticketdata->priority))
                @if($ticketdata->priority==1)
                  Low
                @elseif($ticketdata->priority==2)
                  Medium
                @elseif($ticketdata->priority==3)
                  High
                 @elseif($ticketdata->priority==4)
                  Urgent
                @endif
              @endif
                </span>
              </li>
            <li class="list-group-item">
                <b>Dept :</b>
              
                <span>
              @if(isset($ticketdata->ticketGroupId))
                @if($ticketdata->ticketGroupId==1)
                  Technical Support
                @elseif($ticketdata->ticketGroupId==2)
                  Network Support
                @endif
              @endif
                </span>
              </li>
            <li class="list-group-item">
                <b>Assign Staff :</b>
            
                <span>
               @if(isset($ticketdata->ticketAssignedUser))
             	{{$ticketdata->ticketAssignedUser}}
              @endif
                </span>
            </li>
            <li class="list-group-item">
                <b>Portal User :</b>            
                <span>
              @if(isset($ticketdata->requestorName))
                   {{$ticketdata->requestorName}}
              @endif
                </span>
              </li>
           <li class="list-group-item">
                <b>Created On :</b>
             
                <span>
			  @if(isset($ticketdata->createdOn))
				   <?php
						  $date=date_create($ticketdata->createdOn);
						  echo date_format($date,"Y-m-d h:i A");
						  ?>
			  @endif
				</span>
			  </li>
            <li class="list-group-item">
				 <b>Dead Line :</b>
			  
				 <span>
					@if(isset($ticketdata->deadline))
					<?php

						//print"<pre>";
						//print_r($ticketdata);
						//exit;

					$deadline_date=date_create($ticketdata->deadline);
					echo date_format($deadline_date,"Y-m-d h:i A");
					?>
					@endif
				 </span>
			</li>
           <li class="list-group-item">
               <b>Description &nbsp;:</b>
                <span>
                  @if(isset($ticketdata->ticketText))
                   <div style="word-wrap:break-word;width:100%"><?php echo $ticketdata->ticketText; ?></div>
                  @endif
                </span>
            </li><!-- /.box -->
              </div>
              </div>
              </div>

          <!-- Table row -->
       <div class="col-md-6">

                            <!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Add Comments </strong></h1>
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

                <form role="form" action="#" method="PUT" id="ticket-comments">
                  <div class="box-body">
                    <div class="col-md-12">

                  @if (session('PostreplySuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        Comment Added Successfully
              <script>
              window.setTimeout(function(){
window.location.href = "{{asset('/emp_ticket_details/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif";
               }, 2000);
             </script>
                  </div>
                </div>
              @endif
                @if (session('PostreplyError'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Update ticket
                    </div>
                  </div>
                @endif
                           <div class="form-group">
                           <label>Status  <span id="required">*</span></label>
                          <select class="form-control" name="status" id="status">
                           <option value="">Select Status</option>
                            <option value="2">Re-Assign</option>
                            <option value="3">In-Progress</option>
                            <option value="4">Closed</option>
                            <option value="5">Waiting for customer reply</option>
                            <option value="6">Waiting for 3rd party response</option>
                          </select>
                    </div>
                      <div class="form-group">
                      <label>Description  <span id="required">*</span></label>
                             <textarea class="form-control"  id="description1" name="description1" rows="5" cols="45"></textarea>
                    </div>

				<div class="form-group">
					  <button type="submit" name="submit" value="Post" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Post <i class="fa fa-paper-plane" aria-hidden="true"></i></button>

					<button type="reset" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" name="reset" value="Reset">Reset <i class="fa fa-refresh" aria-hidden="true"></i></button>

                  </div>
				  
                  </div><!-- /.box-body -->

				   
                  </div>
				  <div class="clearfix"></div>
                </form>
              </div>
              </section>
              </div>
              
			  
          <div class="col-md-6">
           <section class="tile tile-simple">

			<!-- tile widget -->
			<div class="tile-widget dvd dvd-btm">
			
                  <h3>Ticket History</h3>
                 </div>
			<!-- /tile widget -->

			<!-- tile body -->
			<div class="tile-body p-0">

				<ul class="list-unstyled">
				
                    <?php
                       //print"<pre>";
                       //print_r($ticketdata);
                       //exit;
                    ?>
                       @if(isset($historydata->ticketList))
               @foreach($historydata->ticketList as $history)
					<li class="p-10 b-b">
						<div class="media">
							<div class="media-body">
							
                          <div>
			                             @if(isset($history->createOn))
			                             <?php
			                             $date=date_create($history->createOn);
			                             echo date_format($date,"Y-m-d h:i A");
			                             ?>

			                            @endif <b>- &nbsp;
			           @if(isset($history->createdBy))
			           {{$history->createdBy}}
			          @endif


			                            </b>
						</div>
                      
                        <span>
							<small>
                              @if(isset($history->ticketId))
                          Ticket ID# {{$history->ticketId}}
                         @endif
                         @if(isset($history->userAction))
                          has been {{$history->userAction}}
                         @endif
                        			@if(isset($history->description))
                          {{$history->description}}  by
                          @if(isset($history->ticketAssignedBy))
						  {{$history->ticketAssignedBy}}
                        @endif
                         @endif
                        		</small>
                        </span>
                      </div>
					  </div>
                    
					</li>
                       @endforeach
                       <div class="user-block">
                        <span class=''>
                          <span>@if(empty($history))
                                   No Tickets History Found...
                                  @endif
                         </b></span>

                        </span>
                        <br>
                        <span>
                          <small>

                            </small>
                        </span>
                      </div>
					  
					 </ul>

         @endif



              </div>

          </section><!-- /.row -->
          </div>
          </div>

<script>
 $(function () {
        //Add text editor
       // $("#description1").wysihtml5();
      });
</script>
@endsection