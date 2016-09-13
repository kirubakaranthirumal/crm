@extends('admin.layouts.master')

@section('content')
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
        <!-- Main content -->
			<?php
				$dashTicketCount = array();
			?>
			<!--
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>
                  	@if(isset($dashTicketCount->openStatuscount))
						{{$dashTicketCount->openStatuscount}}
					@endif
                  </h3>
                  <p>Open Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>-->
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>
                  	@if(isset($ticketcountdata->assignedStatus))
						{{$ticketcountdata->assignedStatus}}
					@else
						0
					@endif
                  <!--<sup style="font-size: 20px">%</sup>--></h3>
                  <p>Assigned Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <?php
					if(!empty($ticketcountdata->assignedStatus)){
				?>
						 <a href="{{asset('my_tickets?tab_id=3')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>
						@if(isset($ticketcountdata->inprogressStatus))
							{{$ticketcountdata->inprogressStatus}}
						@else
							0
						@endif
					</h3>
					<p>In-Progress Tickets</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<?php
					if(!empty($ticketcountdata->inprogressStatus)){
				?>
						 <a href="{{asset('my_tickets?tab_id=4')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
			</div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>
                  	@if(isset($ticketcountdata->closedStatus))
						{{$ticketcountdata->closedStatus}}
					@else
						0
					@endif
                  </h3>
                  <p>Closed Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <?php
                	if(!empty($ticketcountdata->closedStatus)){
                ?>
						 <a href="{{asset('my_tickets?tab_id=5')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
			<section class="col-lg-7 connectedSortable">
				<!-- Custom tabs (Charts with tabs)-->
				<!--<div class="nav-tabs-custom">
					<ul class="nav nav-tabs pull-right">
						<li class="pull-left header"><i class="fa fa-inbox"></i> Tickets</li>
					</ul>
					<div class="tab-content no-padding">
						<div class="chart tab-pane active" id="revenue-chart" style="position:relative;height:300px;"></div>
						<div class="chart tab-pane" id="sales-chart" style="position: relative;height:300px;"></div>
					</div>
				</div>-->
				<!-- /.nav-tabs-custom -->

              <!-- Chat box -->
              <!-- /.box (chat box) -->

              <!-- TO DO List -->
             <!-- /.box -->

              <!-- quick email widget -->
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

              <!-- Map box -->

              <!-- /.box -->

              <!-- solid sales graph -->
              <!-- /.box -->

              <!-- Calendar -->
             <!-- /.box -->

            </section><!-- right col -->
          </div><!-- /.row (main row) -->

@endsection
