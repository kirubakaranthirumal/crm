@extends('admin.layouts.master')

@section('content')
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
               <i class="fa fa-ticket" aria-hidden="true"></i> <span><b>Ticket :</b>
				<?php
					print"<pre>";
					print_r($ticketdata);
					exit;
				?>
               @if(isset($ticketdata->ticketId))
          {{$ticketdata['ticketId']}}
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
              @if(isset($ticketdata->ticketStatus))
               @if($ticketdata->ticketStatus==1)
                Open
               @elseif($ticketdata->ticketStatus==2)
                Assiged
               @elseif($ticketdata->ticketStatus==3)
                InProgress
               @elseif($ticketdata->ticketStatus==4)
                Closed
               @elseif($ticketdata->ticketStatus==5)
                Waiting On Customer
               @elseif($ticketdata->ticketStatus==6)
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
                 <!--{{$ticketdata->modifiedBy}}-->
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
                 {{$ticketdata->modifiedOn}}
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
               @if(isset($ticketdata->ticketAssignedauser))
             <!--{{$ticketdata->ticketAssignedauser}}-->
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
               {{$ticketdata->createdOn}}
              @endif
                </span>
              </div>
             </div>
			  <div style="border:0px solid red;width:100%;float:left;">
			   <div style="border:0px solid red;width:18%;float:left;">
				 <b>Dead Line </b>
			   </div>
			   <div style="border:0px solid red;width:3%;float:left;">
				 <b>:</b>
			   </div>
			   <div style="border:0px solid red;width:65%;float:left;">
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
                    <div class="pull-right">
                      <form>
                         <div class="form-group">
                          <select class="form-control">
                            <option>Re-Assign</option>
                            <option>In-Progress</option>
                            <option>Close</option>
                            <option>Waiting for customer reply</option>
                            <option>Waiting for 3rd party response</option>
                          </select>
                    </div>
                      </form>
                  </div>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form role="form" action="#" method="PUT">
                  <div class="box-body">
                    <div class="col-md-12">

                      <div class="form-group">
                      <label>Description  <span id="required">*</span></label>
                             <textarea class="form-control"  id="description1 post_content" name="description1" rows="5" cols="45"></textarea>
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
                        //print_r($historydata);
                    ?>

                       @if(isset($historydata->ticketList))
               @foreach($historydata->ticketList as $history)
                  <div class="user-block">
                        <span class=''>
                          <span>@if(isset($history->createdOn))
                          <?php
                          $date=date_create($history->createdOn);
                          echo date_format($date,"Y-m-d h:i A");
                          ?>

                         @endif <b>- &nbsp;
                           @if(isset($history->createdBy))
                          @if($history->createdBy==1)
                            Admin
                          @elseif($history->createdBy==2)
                            Kirubakaran
                          @endif
                        @endif

                         </b></span>

                        </span>
                        <br>
                        <span>
                          <small>

                            @if(!empty($history->ticketId&&$history->userAction&&$history->createdBy ))
                              @if(isset($history->ticketId))
                          Ticket ID# {{$history->ticketId}}
                         @endif
                         @if(isset($history->userAction))
                          has been {{$history->userAction}}
                         @endif
                         @endif

                              @if(isset($history->description))
                          {{$history->description}}  by
                          @if(isset($history->createdBy))
                          @if($history->createdBy==1)
                            Admin
                          @elseif($history->createdBy==2)
                            Kirubakaran
                          @endif
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
       $("#post_content").wysihtml5();
      });
</script>
@endsection