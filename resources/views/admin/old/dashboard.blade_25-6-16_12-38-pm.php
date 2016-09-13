@extends('admin.layouts.master')

@section('content')
<style>
#thead{
    background-color: #337ab7 !important;
    color: #fff;
}
#thead th
{
	    border-right: 2px solid #d2d6de!important;
}
</style>
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>-->
        </section>

        <!-- Main content -->
			<?php
				$dashTicketCount=array();
				foreach($ticketcountdata as $ticketcountdataval){
					$dashTicketCount = $ticketcountdataval;
				}
			?>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
					<h3>
						@if(isset($dashTicketCount->openStatuscount))
							{{$dashTicketCount->openStatuscount}}
						@else
							0
						@endif
					</h3>
                  <p>Open Tickets</p>
                </div>
                <div class="icon">
                 <!-- <i class="ion ion-bag"></i>-->
                </div>
                <?php
					if(!empty($dashTicketCount->openStatuscount)){
				?>
						 <a href="{{asset('admin/view_tickets?tab_id=2')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>
                  	@if(isset($dashTicketCount->assignedStatuscount))
						{{$dashTicketCount->assignedStatuscount}}
					@else
						0
					@endif
                  <!--<sup style="font-size: 20px">%</sup>--></h3>
                  <p>Assigned Tickets</p>
                </div>
                <div class="icon">
                  <!--<i class="ion ion-stats-bars"></i>-->
                </div>
                <?php
					if(!empty($dashTicketCount->assignedStatuscount)){
				?>
						 <a href="{{asset('admin/view_tickets?tab_id=3')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
              <div class="small-box" style="background-color:rgb(255,140,0);color:#fff;">
                <div class="inner">
                  <h3>
                  	@if(isset($dashTicketCount->inprogressStatuscount))
						{{$dashTicketCount->inprogressStatuscount}}
					@else
						0
					@endif
                  </h3>
                  <p>In-Progress Tickets</p>
                </div>
                <div class="icon">
                  <!--<i class="ion ion-person-add"></i>-->
                </div>
                <?php
					if(!empty($dashTicketCount->inprogressStatuscount)){
				?>
						 <a href="{{asset('admin/view_tickets?tab_id=4')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
              <div class="small-box bg-grey" style="background-color:grey;color:#fff;">
                <div class="inner">
                  <h3>
                  	@if(isset($dashTicketCount->closedStatuscount))
						{{$dashTicketCount->closedStatuscount}}
					@else
						0
					@endif
                  </h3>
                  <p>Closed Tickets</p>
                </div>
                <div class="icon">
               <!-- <i class="ion ion-pie-graph"></i>-->
                </div>
                <?php
					if(!empty($dashTicketCount->closedStatuscount)){
				?>
						 <a href="{{asset('admin/view_tickets?tab_id=5')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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


			<div style="border:0px solid red;float:left;width:100%;">
				<div style="border:0px solid red;float:left;width:49%;">
					<div class="col-md-12">
						                <div class="box">
						                  <div class="box-header">
						                    <h3 class="box-title">Tickets</h3>
						                    <div style="float:right;">
						                    	<a href="{{asset('/admin/view_tickets/')}}" class="btn btn-primary">
						                    		More
						                    	</a>
						                    </div>
						                    <div class="box-tools">
						                     <!-- <ul class="pagination pagination-sm no-margin pull-right">
						                        <li><a href="#">�</a></li>
						                        <li><a href="#">1</a></li>
						                        <li><a href="#">2</a></li>
						                        <li><a href="#">3</a></li>
						                        <li><a href="#">�</a></li>
						                      </ul>-->
						                    </div>
						                  </div><!-- /.box-header -->
						                  <div class="box-body no-padding">
						                    <table class="table">
						                      <tbody><tr id="thead">
						                        <th>#</th>
						                        <th>Subject</th>
						                        <th>Priority</th>
						                        <th>Status</th>
						                         <th>Created On</th>
						                      </tr>
						                      	<?php
													//print"<pre>";
													//print_r($ticketdata);
												?>
												<?php

													$count_val = "0";
													$total_count_val = count($ticketdata);
													if(!empty($ticketdata)){
														foreach($ticketdata as $key => $ticketval){
															$count_val = $key+1;
															if($count_val<=5){
												?>
														<?php
															//print"<pre>";
															//print_r($count_val);
														?>
														<tr>
															<td>
																<a href="{{asset('/admin/ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
																	<?=(!empty($ticketval->ticketId)?$ticketval->ticketId:"")?>
																</a>
															</td>
															<td>
																<a href="{{asset('/admin/ticket_details/')}}/@if(isset($ticketval->ticketId)){{ $ticketval->ticketId}}@endif" title="View Ticket">
																	<?=(!empty($ticketval->ticketSubject)?$ticketval->ticketSubject:"")?>
																</a>
															</td>
															<td>
																<?php
																	if(!empty($ticketval->priority)){
																		if($ticketval->priority==6){
																			echo "Low";
																		}
																		elseif($ticketval->priority==7){
																			echo "Medium";
																		}
																		elseif($ticketval->priority==8){
																			echo "High";
																		}
																		elseif($ticketval->priority==9){
																			echo "Urgent";
																		}
																	}
																?>
															</td>
															<td>
																<?php
																	if(!empty($ticketval->status)){
																		if($ticketval->status==1){
																			echo "Open";
																		}
																		elseif($ticketval->status==2){
																			echo "Assigned";
																		}
																		elseif($ticketval->status==3){
																			echo "Inprogress";
																		}
																		elseif($ticketval->status==4){
																			echo "Closed";
																		}
																		elseif($ticketval->status==5){
																			echo "Waiting for customer reply";
																		}
																		elseif($ticketval->status==6){
																			echo "Waiting for 3rd party reply";
																		}
																	}
																?>
															</td>
															<td>
																<?=(!empty($ticketval->createdOn)?$ticketval->createdOn:"")?>
															</td>
														</tr>

												<?php
															}
														}
													}
													else{
												?>
													<tr>
														<td colspan="4">
															No ticket data found
														</td>
													</tr>
												<?php

													}
												?>

						                    </tbody></table>

						                  </div><!-- /.box-body -->


						                </div><!-- /.box -->









           		 </div>
				</div>
				<div style="border:0px solid red;float:left;width:50%;">

					<div class="col-md-12">
											                <div class="box">
											                  <div class="box-header">
											                    <h3 class="box-title">E-Mail</h3>
											                     <div style="float:right;">
																	<a href="{{asset('/admin/emailnotification/')}}" class="btn btn-primary">
																		More
																	</a>
						                    					</div>
											                    <div class="box-tools">

											                    </div>
											                  </div><!-- /.box-header -->
											                  <div class="box-body no-padding">
											                    <table class="table">
											                      <tbody><tr id="thead">
											                        <th>#</th>
											                        <th>Subject</th>
											                        <th>Message Body</th>
											                         <th>Date</th>
											                      </tr>
																	<?php
																		//print"<pre>";
																		//print_r($maildata);

																		$count_val = "0";
																		$total_count_val = count($maildata);
																		if(!empty($maildata)){
																			foreach($maildata as $key => $ticketval){
																				$count_val = $key+1;
																				if($count_val<=5){
																	?>
																			<?php
																				//print"<pre>";
																				//print_r($count_val);
																			?>
																			<tr>
																				<td>
																					<?=(!empty($ticketval->emailNId)?$ticketval->emailNId:"")?>
																				</td>
																				<td>
																					<?=(!empty($ticketval->subjectLine)?$ticketval->subjectLine:"")?>
																				</td>
																				<td>
																					<?=(!empty($ticketval->fromAddress)?$ticketval->fromAddress:"")?>
																				</td>
																				<td>
																					<?=(!empty($ticketval->sendDate)?$ticketval->sendDate:"")?>
																				</td>
																			</tr>

																	<?php
																					}
																				}
																			}
																			else{
																	?>
																		<tr>
																			<td colspan="4">
																				No email data found
																			</td>
																		</tr>
																	<?php

																		}
																	?>


											                    </tbody></table>

											                  </div><!-- /.box-body -->


											                </div><!-- /.box -->









            </div>


				</div>
			</div>




	<script language="javascript">
			$("#searchsubmit").click(function(){
				/*if blank return false else true*/

				var group_val = $('#group').val();
				var employee_val = $('#employee').val();
				var priority_val = $('#priority').val();
				var source_val = $('#source').val();
				var created_on_val = $('#created_on').val();

				if((group_val=='')&&(employee_val=='')&&(priority_val=='')&&(source_val=='')&&(created_on_val=='')){
					$("#login_msg").html('<span style="margin-left:23px;padding-top:5px;color:red;">Please select atleast one field to proceed with filter</span>');
				}
				else{
					$("#login_msg").html('');
					$("#ticket-form").submit();
				}
			});

			$(function () {
				$("#example1").DataTable();
				$('#example2').DataTable({
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering" : true,
					"info": true,
					"autoWidth": false
				});
			});

			$(function(){
				$('#created_on').datepicker({
					format: 'yyyy-mm-dd'
				});
			});
		</script>


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
