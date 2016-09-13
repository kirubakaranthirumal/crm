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
      border-radius: 4px;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
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
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
               <i class="fa fa-ticket" aria-hidden="true"></i> <span><b>Ticket :</b>
               <?php
              // print"<pre>";
               //print_r($historydata);
              // exit;
               ?>
               @if(isset($ticketdata->ticketId))
                  {{$ticketdata->ticketId}}
               @endif
        </span>
                  <!--<div class="pull-right" style="margin-right:16px;">

                  <a class="btn btn-success" href="">Edit Ticket</a>

                   <!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>
                  </div>-->

              </h2>

            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
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
                  @if(isset($ticketdata->requestorName))
                    {{$ticketdata->requestorName}}
                  @endif
                </span>
              </div>
             </div>
             <div style="border:0px solid red;width:100%;float:left;">
                <div style="border:0px solid red;width:18%;float:left;">
                <b>Source </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
               <b> :</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
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
              </div>
             </div>

                <div style="border:0px solid red;width:100%;float:left;">
                <div style="border:0px solid red;width:18%;float:left;">
                <b>Category </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
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
              </div>
             </div>
            <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Modified By </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
               @if(isset($ticketdata->modifiedBy))
                 {{$ticketdata->modifiedBy}}
              @endif
                </span>
              </div>
             </div>
            <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Modified On </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
                 @if(isset($ticketdata->modifiedOn))
			   <?php
					  $date=date_create($ticketdata->modifiedOn);
					  echo date_format($date,"Y-m-d h:i A");
					  ?>
              @endif
                </span>
              </div>
             </div>
            <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Subject </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
               @if(isset($ticketdata->ticketSubject))
                {{$ticketdata->ticketSubject}}
               @endif
                </span>
              </div>
             </div>
            </div><!-- /.col -->
    <!-- /.col -->
            <div class="col-sm-6 invoice-col">
              <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Type </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
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
              </div>
             </div>
              <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Priority </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
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
              </div>
             </div>
             <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Dept </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
              @if(isset($ticketdata->ticketGroupId))
                @if($ticketdata->ticketGroupId==1)
                  Technical Support
                @elseif($ticketdata->ticketGroupId==2)
                  Network Support
                @endif
              @endif
                </span>
              </div>
             </div>
            <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Assign Staff </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
               @if(isset($ticketdata->ticketAssignedUser))
             	{{$ticketdata->ticketAssignedUser}}
              @endif
                </span>
              </div>
             </div>
            <div style="border:0px solid red;width:100%;float:left;">
              <div style="border:0px solid red;width:18%;float:left;">
                <b>Portal User </b>
              </div>
              <div style="border:0px solid red;width:3%;float:left;">
                <b>:</b>
              </div>
              <div style="border:0px solid red;width:65%;float:left;">
                <span>
              @if(isset($ticketdata->portelUserId))
                   <!--{{$ticketdata->portelUserId}}-->
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
              @if(isset($ticketdata->createdOn))
                   <?php
                          $date=date_create($ticketdata->createdOn);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>
              @endif
                </span>
              </div>
             </div>
            </div><!-- /.col -->
                      </div><!-- /.row -->
         <div class="row invoice-info">
            <!-- left column -->
              <div class="col-sm-12 invoice-col">
              <!-- general form elements -->
                <div class="box-header with-border ">
                  <span class="box-title" style="font-size:15px;margin-left:-10px;"><b>Description &nbsp;:</b></span>
                <span>
                  @if(isset($ticketdata->ticketText))
                   {{$ticketdata->ticketText}}
                  @endif
                </span>
              </div><!-- /.box -->
              </div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12">
   				     <div class="box-body">
                  <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><b>Add Comments</b></h3>
                    <!--<div class="pull-right">
                      <form>

                      </form>
                  </div>-->
                </div><!-- /.box-header -->

                <!-- form start -->
                <form role="form" action="" method="PUT" id="ticket-comments">
                  <div class="box-body">
                    <div class="col-md-12">

                  @if (session('PostreplySuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        Comment Added Successfully
              <script>
              window.setTimeout(function(){
window.location.href = "{{asset('/admin/emp_ticket_details/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif";
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


                  </div><!-- /.box-body -->

                    <input type="submit" class="btn btn-primary" name="submit" value="Post"></input>
                    <input type="reset" class="btn btn-primary" name="reset" value="Reset"></input>
                  </div>
                </form>
              </div>
              <div class="box-header with-border">
                  <h3 class="box-title">
                  <b>Ticket History</b></h3>
                  </div>
                  <!--<div class="pull-right">
                  <a class="btn btn-success" href="{{ url(config('quickadmin.route').'/post_reply') }}">Post Reply</a>
                   <a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>
                  </div>-->
                    <div class="col-md-12">
                    <?php
                       //print"<pre>";
                       //print_r($ticketdata);
                       //exit;
                    ?>
                       @if(isset($historydata->ticketList))
               @foreach($historydata->ticketList as $history)

                  <div class="user-block">
               <span class=''>
			                             <span>
			                             @if(isset($history->createOn))
			                             <?php
			                             $date=date_create($history->createOn);
			                             echo date_format($date,"Y-m-d h:i A");
			                             ?>

			                            @endif <b>- &nbsp;
			           @if(isset($history->createdBy))
			           {{$history->createdBy}}
			          @endif


			                            </b></span>

                        </span>
                        <br>
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

         @endif



              </div>

          </div><!-- /.row -->
          </div>
          </section>

<script>
 $(function () {
        //Add text editor
       // $("#description1").wysihtml5();
      });
</script>
@endsection