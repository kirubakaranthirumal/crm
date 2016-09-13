@extends('admin.layouts.master')

@section('content')
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
               <i class="fa fa-ticket" aria-hidden="true"></i> <span><b>Ticket :</b> 462312</span>
                  <div class="pull-right" style="margin-right:16px;">

                  <a class="btn btn-success" href="">Edit Ticket</a>

                   <!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>-->
                  </div>

              </h2>

            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-6 invoice-col">
              <span><b>Type :</b> </span><br>
              <span><b>Status :</b> Open</span><br>
              <span><b>Priority :</b> Urgent</span><br>
              <span><b>Department :</b> Tech Support</span><br>
              <span><b>Created On :</b> 12/04/2016 15:00</span><br>
              <span><b>Assign Staff :</b> John Anderson</span><br>
              <span><b>Last Response :</b> 09/05/2016 8:43</span><br>
              <span><b>Due Date :</b> 20/04/2016 12:00</span><br>

            </div><!-- /.col -->
    <!-- /.col -->
            <div class="col-sm-6 invoice-col">
             <span><b>Name :</b> David Smith </span><br>
              <span><b>Email :</b> david_smith@gmail.com</span><br>
              <span><b>Phone :</b> 9631321321</span><br>
              <span><b>Help Notes :</b> Streaming</span><br>
              <span><b>Source :</b> Email</span><br>
            </div><!-- /.col -->
                      </div><!-- /.row -->

                 <br>
          <div class="row">
          <div class="col-sm-8">
          	<span><b>Subject :</b> Requesting for Live streaming issue</span><br><br>


                   <!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>-->

          	</div>
          	</div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
   				     <div class="box-body">
				<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">
                  Ticket History</h3>
                  <div class="pull-right">
                  <a class="btn btn-success" href="{{ url(config('quickadmin.route').'/post_reply') }}">Post Reply</a>
                   <!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>-->
                  </div>
                  </div>

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


          </div>
          <br>



              </div>

          </div><!-- /.row -->
          </div>
          </section>


@endsection