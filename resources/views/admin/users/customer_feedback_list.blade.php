@extends('admin.layouts.master')
@section('content')
<div class="page page-tables-datatables">
<!-- tile -->
                            <section class="tile">

                                <!-- tile header -->
                                <div class="tile-header dvd dvd-btm">
                                    <h1 class="custom-font"><strong>Customer Feedbacks</strong></h1>
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
                               
				 @if (session('feedbackDelSuc'))
					 <div class="col-md-12">
                <div class="flash-message">
                   <div class="alert alert-success">
                        Feedback Deleted Successfully
						<script language="javascript">
							window.setTimeout(function(){window.location.href = "{{asset('/admin/feedback_list/')}}";}, 1000);
						</script>
                  </div>
                </div>
				</div>
              @endif
			  
			   <div class="tile-body">

              <table id="example1" class="table table-custom table-striped dt-responsive">
                <thead>
					<tr>
						<th>Name</th>
						<th>Type</th>
						<th>E-mail</th>
						<th>Subject</th>
						<th>Rating</th>
						<th>Created On</th>
						<th>Action</th>
					</tr>
                </thead>
                <tbody>
                 @if(isset($feedlist))
                 	@foreach ($feedlist as $data)
                <tr>
					<td>
						@if(isset($data['feed_type']))
							@if($data['feed_type']==1)
								General Feedback
							@elseif($data['feed_type']==2)
								Ticket Feedback
							@endif
						@endif
					</td>
					<td>
						@if(isset($data['feed_name']))
							{{ $data['feed_name']}}
						@endif
					</td>
					<td>
						@if(isset($data['feed_email']))
							{{ $data['feed_email']}}
						@endif
					</td>
					<td>
						@if(isset($data['feed_subject']))
							{{ $data['feed_subject']}}
						@endif
					</td>
					<td>
						<?php
							//print"<pre>";
							//print_r($data);
						?>
						@if(isset($data['feed_rating']))
							@if($data['feed_rating']==1)
								Poor
							@elseif($data['feed_rating']==2)
								Not bad
							@elseif($data['feed_rating']==3)
								Moderate
							@elseif($data['feed_rating']==4)
								Good
							@elseif($data['feed_rating']==5)
								Excellent
							@endif
						@endif
					</td>
					<td>
						@if(isset($data['feed_created_on']))
							{{ $data['feed_created_on']}}
						@endif
					</td>
                  <td>
                  	@if(isset($data['feed_id']))
						<a class="btn btn-rounded-20 btn-default btn-sm bg-primary" style="width:30px;" href="{{asset('/admin/feedback_details/')}}/@if(isset($data['feed_id'])){{ $data['feed_id']}} @endif" title="user details">
							<i class="fa fa-eye" style="margin-left: -2px;"></i>
							</a>	
						<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/del_feedback/')}}/@if(isset($data['feed_id'])){{ $data['feed_id']}} @endif" title="delete">
								<i class="fa fa-times"></i>
							</a> &nbsp;&nbsp;
							
						<!--	<a href="{{asset('/admin/edit_user/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="edit">
								<i class="fa fa-edit"></i>
							</a> &nbsp;&nbsp;
							<a href="{{asset('/admin/user_details/')}}/@if(isset($data->userId))
								{{ $data->userId}}
								@endif" title="user details"><i class="fa fa-user-secret"></i>
							</a>-->
					@endif
                   </td>
                </tr>
                	@endforeach
                @endif
                </tbody>
                <!--<tfoot>
                  <tr>
                  <th>Name</th>
                  <th>E-mail</th>
                  <th>Type</th>
                  <th>Gender</th>
                  <th>Last Logged</th>
                  <th>Created On</th>
				  <th>Action</th>
                </tr>
                </tfoot>-->
              </table>
            </div>
			</section>
            <!-- /.box-body -->
        </div>

<script language="javascript">
	$(function(){
		$('#example1').DataTable({
			"aaSorting": [[ 5, "desc" ]],
			"aoColumnDefs" : [{
				'bSortable' : false,
				'aTargets' : [ 6 ]
			}]
		});
	});

	$(function(){
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});
	});
</script>
@endsection


