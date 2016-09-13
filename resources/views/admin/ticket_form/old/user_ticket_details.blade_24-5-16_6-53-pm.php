@extends('admin.layouts.master')

@section('content')
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
               <i class="fa fa-ticket" aria-hidden="true"></i> <span><b>User Ticket :</b>      
               @if(isset($ticketdata['ticketId']))
          {{$ticketdata['ticketId']}}
        @endif</span>
                  <!--<div class="pull-right" style="margin-right:16px;">

                  <a class="btn btn-success" href="">Esit Ticket</a>

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
                  @if(isset($ticketdata['requestorName']))
                    {{$ticketdata['requestorName']}}
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
                 @if(isset($ticketdata['ticketSource']))
            @if($ticketdata['ticketSource']==1)
              Portal
            @elseif($ticketdata['ticketSource']==2)
             Email
            @elseif($ticketdata['ticketSource']==3)
              Social Media
             @elseif($ticketdata['ticketSource']==4)
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
              @if(isset($ticketdata['ticketCatId']))
                @if($ticketdata['ticketCatId']==1)
                  Network Issue
                @elseif($ticketdata['ticketCatId']==2)
                  Payment
                @elseif($ticketdata['ticketCatId']==3)
                  Browser
                 @elseif($ticketdata['ticketCatId']==4)
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
              @if(isset($ticketdata['status']))
               @if($ticketdata['status']==1)
                Open
               @elseif($ticketdata['status']==2)
                Assiged
               @elseif($ticketdata['status']==3)
                InProgress
               @elseif($ticketdata['status']==4)
                Closed
               @elseif($ticketdata['status']==5)
                Waiting On Customer
               @elseif($ticketdata['status']==6)
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
               @if(isset($ticketdata['modifiedBy']))
                 <!--{{$ticketdata['modifiedBy']}}-->
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
              @if(isset($ticketdata['modifiedOn']))
                 {{$ticketdata['modifiedOn']}}
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
               @if(isset($ticketdata['ticketSubject']))
                {{$ticketdata['ticketSubject']}}
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
               @if(isset($ticketdata['type']))
                @if($ticketdata['type']==1)
                  Question
                @elseif($ticketdata['type']==2)
                  Indicent
                @elseif($ticketdata['type']==3)
                  Problem
                @elseif($ticketdata['type']==4)
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
               @if(isset($ticketdata['priority']))
                @if($ticketdata['priority']==1)
                  Low
                @elseif($ticketdata['priority']==2)
                  Medium
                @elseif($ticketdata['priority']==3)
                  High
                 @elseif($ticketdata['priority']==4)
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
              @if(isset($ticketdata['ticketGroupId']))
                @if($ticketdata['ticketGroupId']==1)
                  Technical Support
                @elseif($ticketdata['ticketGroupId']==2)
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
               @if(isset($ticketdata['ticketAssignedauser']))
             <!--{{$ticketdata['ticketAssignedauser']}}-->
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
              @if(isset($ticketdata['portelUserId']))
                   <!--{{$ticketdata['portelUserId']}}-->
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
              @if(isset($ticketdata['createdOn']))
               {{$ticketdata['createdOn']}}
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
                  @if(isset($ticketdata['ticketText']))
                   {{$ticketdata['ticketText']}}
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
                  <h3 class="box-title"><b>Post Reply</b></h3>
                    <div class="pull-right">
                      <form>
                         <div class="form-group">
                          <select class="form-control">
                            <option>Open</option>
                            <option>Assigned</option>
                            <option>InProgress</option>
                          </select>
                    </div>  
                      </form>
                  </div>
                </div><!-- /.box-header -->
                
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="col-md-12">
           
                      <div class="form-group">
                      <label>Description  <span id="required">*</span></label>
                             <textarea class="form-control" rows="5" cols="45"></textarea>
                    </div>
            
                
                  </div><!-- /.box-body -->
                
                    <button type="submit" class="btn btn-primary">Post</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
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
                  </div>
                    <div class="col-md-12">
                      <div class="user-block">
                        <span class=''>
                          <span>Tue, 12 Apr 2016 &nbsp; 15:30 <b>- &nbsp; David Smith </b></span>

                        </span>
                        <br>
                        <span>
                        	<small>David Smith,
                        			Your Tickets has been assign to our technical support time.
                        		</small>
                        </span>
                      </div>
                      <br>
                             <div class="user-block">
                        <span class=''>
                          <span>Tue, 12 Apr 2016 &nbsp; 15:30 <b>- &nbsp; John </b></span>

                        </span>
                        <br>
                        <span>
                        	<small>John,
                        			Your issue will be resolve with 24 hours.
                        		</small>
                        </span>
                      </div>
                      <br>
                             <div class="user-block">
                        <span class=''>
                          <span>Tue, 12 Apr 2016 &nbsp; 15:30 <b>- &nbsp; David Smith </b></span>

                        </span>
                        <br>
                        <span>
                        	<small>David Smith,
                        			ticket raised regards of the live streaming not working properly .
                        		</small>
                        </span>
                      </div>
                      <br>
                             <div class="user-block">
                        <span class=''>
                          <span>Tue, 12 Apr 2016 &nbsp; 15:30 <b>- &nbsp; John </b></span>

                        </span>
                        <br>
                        <span>
                        	<small>John,
                        			In that issue take care of the technical dept.i will assign ticket to tech dept .
                        		</small>
                        </span>
                    </div>
          <br>



              </div>

          </div><!-- /.row -->
          </div>
          </section>


@endsection