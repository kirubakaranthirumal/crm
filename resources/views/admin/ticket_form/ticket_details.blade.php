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

   	  $.validator.addMethod('maxStrict', function (value, el, param) {
	    return value < param;
	  });

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

          $("#reassign-form").validate({
			  rules: {
				group:{
					required: true,
					notEqualTo: 20
				},
				reassign_desc: "required",
				deadline_on:"required",
				re_status: {
					required: true,
					notEqualTo: 20
				},
				employee: {
					required: true,
					notEqualTo: 20
				},
				deadline:{
					maxStrict: 24,
					number: true
				}
			  },
			  messages:{
			  	group: "Select group",
				description1: "Enter Comment",
				re_status: "Select status",
				employee: "Select Re-assign User",
				deadline_on: "Select Deadline",
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
  <script language="javascript">
	function load_employee(id){

		var url_str = "groupId="+id;

		$.ajax({
			type: "GET",
			url: "{{asset('admin/load_group_user')}}",
			data: url_str,
			success: function(data){
				$('#employee_div').html(data);
			}
		});
	}
	</script>
    <style>
    	#errmsg{
			color:red;
		}

		#ticket-comments label.error{
		  color: #FB3A3A;
		  display: inline-block;
		  //margin: 4px 0 5px 125px;
		  padding: 0;
		  text-align: left;
		  width: 250px;
		}

		#reassign-form label.error{
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
<div class="page">
	<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
<div class="page page-tables-datatables">
<div class="col-md-6">
	<!-- tile -->
	<section class="tile simple">
		<!-- tile widget -->
		<div class="tile-widget bg-slategray p-20">

			<div class="media">
				<div class="media-body">
					<h2 class="media-heading mb-0 mt-10">
						<i class="fa fa-ticket" aria-hidden="true"></i>
						<span><b>Ticket :</b>
						   @if(isset($ticketdata->ticketId))
							  {{$ticketdata->ticketId}}
						   @endif
						</span>
						<!--Imrich <strong>Kamarel</strong>
						 <i class="fa fa-circle text-success pull-right"></i> -->
						<div style="float:right;margin-right:1%;">
							<a href="{{asset('/admin/edit_ticket/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif" class="btn btn-primary">
								Edit Ticket
							</a>
						</div>
					</h2>
					<!-- <small class="text-transparent-white">UI/UX Designer</small> -->
				</div>
			</div>

		</div>
		<!-- /tile widget -->

		<!-- tile body -->
		<div class="tile-body p-0">
			<div class="list-group no-radius no-border">
				<a href="#" class="list-group-item">
					<b>Name :</b>
					<span>
					  @if(isset($ticketdata->requestorName))
						{{$ticketdata->requestorName}}
					  @endif
					</span>
				</a>

				<a href="#" class="list-group-item">
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
				</a>
				<a href="#" class="list-group-item">
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
				</a>
				<a href="#" class="list-group-item">
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
							Resolved
						   @elseif($ticketdata->status==5)
							Waiting On Customer
						   @elseif($ticketdata->status==6)
							Waiting On 3rd Party
						   @elseif($ticketdata->status==7)
							Re Assigned
						   @endif
						 @endif
					</span>
				</a>

				<a href="#" class="list-group-item">
					<b>Modified By :</b>
					<span>
					   @if(isset($ticketdata->modifiedBy))
						 {{$ticketdata->modifiedBy}}
					  @endif
					</span>
				</a>
				<a href="#" class="list-group-item">
					<b>Modified On :</b>
					<span>
					 @if(isset($ticketdata->modifiedOn))
						<?php
							$date=date_create($ticketdata->modifiedOn);
							echo date_format($date,"Y-m-d h:i A");
						?>
					@endif
					</span>
				</a>
				<a href="#" class="list-group-item">
					<b>Subject :</b>
					 <span>
					   @if(isset($ticketdata->ticketSubject))
						{{$ticketdata->ticketSubject}}
					   @endif
					</span>
				</a>

				<a href="#" class="list-group-item">
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
				</a>

				<a href="#" class="list-group-item">
					<b>Assigned To :</b>
					<span>
					   {{$ticketdata->ticketAssignedUser}}
					</span>
				</a>
				<a href="#" class="list-group-item">
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
				</a>

				<a href="#" class="list-group-item">
					<b>Group :</b>
					 <span>
					  @if(isset($ticketdata->ticketGroupId))
						@if($ticketdata->ticketGroupId==1)
						  Technical Support
						@elseif($ticketdata->ticketGroupId==2)
						  Network Support
						@endif
					  @endif
					</span>
				</a>

				<a href="#" class="list-group-item">
					<b>Portal User :</b>
					<span>
					   @if(isset($ticketdata->requestorName))
							{{$ticketdata->requestorName}}
					   @endif
					</span>
				</a>

				<a href="#" class="list-group-item">
					<b>Created On :</b>
					<span>
						@if(isset($ticketdata->createdOn))
						<?php
						$date=date_create($ticketdata->createdOn);
						echo date_format($date,"Y-m-d h:i A");
						?>
						@endif
					</span>
				</a>

				<a href="#" class="list-group-item">
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
				</a>
				<a href="#" class="list-group-item">
				<b>Description &nbsp;:</b>
				<span>
                  @if(isset($ticketdata->ticketText))
                  <?php echo $ticketdata->ticketText; ?>
                  @endif
                </span>
				</a>
		</div>
		</div>
	</section>
	</div>

	 <!-- Table row -->
		  <div class="col-md-6">

		  <!-- tile -->
		<section class="tile">

			<!-- tile header -->
			<div class="tile-header dvd dvd-btm">
				<h1 class="custom-font"><strong>Ticket Reassign </strong></h1>
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

					<form role="form" action="#" method="PUT" id="reassign-form">
					  <div class="box-body">
						<div class="col-md-12">
								@if (session('ReassignSuccess'))
									<div class="flash-message">
										 <div class="alert alert-success">
											Ticket Re-assigned Successfully
											<script language="javascript">
												window.setTimeout(function(){window.location.href = "{{asset('/admin/ticket_details/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif";}, 2000);
											</script>
										</div>
									</div>
								@endif
								@if(session('ReassignError'))
									<div class="flash-message">
										<div class="alert alert-danger">
											Cannot Update ticket
										</div>
									</div>
								@endif
					 			<div class="form-group">
							<label>Group <span id="required">*</span></label>
									@if(isset($department))
								<select class="form-control" name="group" id="group" onchange="load_employee(this.value)" tabindex="8">
									<option value="">Select Group</option>
									@foreach ($department as $data)
										@if($data['deptStatus']==1)
											<option value="{{$data['deptId']}}">{{$data['deptName']}}</option>
										@endif
									@endforeach
								</select>
								@endif
							</div>
							<div class="form-group">
								<label>Re-Assign Employee <span id="required">*</span></label>
								<div id="employee_div">
									<select class="form-control" name="employee" id="employee" tabindex="10">
										<option value="">Select Employee Name</option>
									</select>
								</div>
							</div>
							<input type="hidden" name="re_status" id="re_status" value="2">
						<!--<div class="form-group">
							   <label>Status  <span id="required">*</span></label>
							  <select class="form-control" name="re_status" id="re_status">
							   <option value="">Select Status</option>
								<option value="7">Re-Assign</option>
							  </select>
						</div>-->
						 <div class="form-group">
						  <label>Description  <span id="required">*</span></label>
							  <textarea class="form-control"  id="reassign_desc" name="reassign_desc" rows="5" cols="45"></textarea>
						</div>
						<div class="form-group">
							<label>Deadline</label>
							   <!--<input type="text" class="form-control" name="deadline_on" id="deadline_on">-->
							   <input type="number" min="0" step="1" max="24" name="deadline" id="deadline" class="form-control" placeholder="Enter Deadline in hours" value="" tabindex="14">
							   &nbsp;<span id="errmsg"></span>
						</div>

						<button type="submit" name="reassign_submit" value="Reassign" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Reassign <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
						<!-- <input type="submit" class="btn btn-primary" name="reassign_submit" value="Reassign"></input> -->

						<button type="reset" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" name="reset" value="Reset">Reset <i class="fa fa-refresh" aria-hidden="true"></i></button>
						<!-- <input type="reset" class="btn btn-primary" name="reset" value="Reset"></input> -->
					  </div>
						<div style="clear:both;">&nbsp;</div>
					 	 </div>
               		 	</form>
               		 </div>
				</section>

		  </div>


		<div class="clearfix"></div>
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
							<script language="javascript">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/ticket_details/')}}/@if(isset($ticketdata->ticketId)){{$ticketdata->ticketId}}@endif";}, 2000);
							</script>
						</div>
					</div>
				@endif
				@if(session('PostreplyError'))
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
				<?php
					if(!empty($status)){
						foreach($status as $status_val){
							$sel_stat="";
							/*
							if((!empty($ticketdata->status)) && (!empty($status_val['statusId']))){
								if($ticketdata->status == $status_val['statusId']){
									$sel_stat="selected";
								}
							}
							*/

							if((!empty($status_val['statusId'])) && ($status_val['statusId']!=1)){
								if((!empty($status_val['statusId'])) && ($status_val['statusId']!=7)){
				?>
								<option value="<?=(!empty($status_val['statusId'])?$status_val['statusId']:"")?>" <?=(!empty($sel_stat)?$sel_stat:"")?>><?=(!empty($status_val['statusName'])?$status_val['statusName']:"")?></option>

				<?php
								}
							}
						}
					}
				?>
			</select>
			</div>
			<div class="form-group">
			<label>Description  <span id="required">*</span></label>
			<textarea class="form-control"  id="description1" name="description1" rows="5" cols="45"></textarea>
			</div>

			<button type="submit" name="submit" value="Post" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10">Post <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			<!-- <input type="submit" class="btn btn-primary" name="submit" value="Post"></input>-->
			<button type="reset" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" name="reset" value="Reset">Reset <i class="fa fa-refresh" aria-hidden="true"></i></button>
			</div>
			<div class="clearfix"></div>
			</div>
			</form>
			</div>
			</section>

		</div>

		<div class="col-md-6">
			<section class="tile tile-simple">

			<!-- tile widget -->
			<div class="tile-widget dvd dvd-btm">
				<h3 class="text-strong m-0">Ticket History </h3>
			</div>
			<!-- /tile widget -->

			<!-- tile body -->
			<div class="tile-body p-0">
                       @if(isset($historydata))
               @foreach($historydata as $history)
				<ul class="list-unstyled">
					<li class="p-10 b-b">
						<div class="media">
							<div class="media-body">
								<span class="media-heading mb-0 col-md-6">
									<b>Comment For Ticket ID # :</b>
									@if(isset($history->ticketId))
										{{$history->ticketId}}
									@endif</span>
								<span class="media-heading mb-0 col-md-6">
								<b>Posted On :</b>
									@if(isset($history->createOn))
										<?php
											$date=date_create($history->createOn);
											echo date_format($date,"Y-m-d h:i A");
										?>
									@endif
								</span>

								<span class="media-heading mb-0 col-md-6">
								<b>Posted By :</b>
									@if(isset($history->createdBy))
										<?php
											echo $history->createdBy;
										?>
									@endif
								</span>

								<span class="media-heading mb-0 col-md-6">
								@if(isset($history->description))
										<b>{{$history->description}}</b>
									@endif
								</span>
							</div>
                      </div>
					</li>


				</ul>
				@endforeach
				<div class="user-block">
                        <span class=''>
                          <span>
                          @if(empty($history))
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
          </section>


		</div>

				<div style="clear:both;">&nbsp;</div>

                  <!--<div class="pull-right">
                  <a class="btn btn-success" href="{{ url(config('quickadmin.route').'/post_reply') }}">Post Reply</a>
                   <a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>
                  </div>-->
					<?php
						//print"<pre>";
						//print_r($historydata);
						//exit;
					?>


          </div><!-- /.row -->
          </div>
          </section>

          <script language="javascript">
					$(document).ready(function () {
					  //called when key is pressed in textbox
					  $("#deadline").keypress(function (e){
						 //if the letter is not digit then display error and don't type anything
						 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
							//display error message
							$("#errmsg").html("Type only numeric value").show().fadeOut("slow");
							return false;
						}
					   });

					   /*
					   $("#deadline").keypress(function (e){
							var dead_line = "";
							dead_line = $("#deadline").val();

							if(dead_line>24){
								$("#errmsg").html("Enter number less than 24").show().fadeOut("slow");
								return false;
							}
					   });
					   */

					});
		</script>

<script>
 $(function () {
        //Add text editor
       // $("#description1").wysihtml5();
      });
</script>
@endsection