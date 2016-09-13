@extends('admin.layouts.master')

@section('content')
<div class="page">
<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
</div>
<div class="page page-tables-datatables">						
			 @if (session('DeleteEventSuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
						{{session('DeleteEventSuccess')}}
						<?php
							$page_app_id="";
							if(!empty($app_id)){
								$page_app_id = $app_id;
							}
						?>
              <script>
              window.setTimeout(function(){window.location.href = "{{asset('/admin/event_list/')}}/<?=$page_app_id?>";}, 1000);
             </script>
                  </div>
                </div>
              @endif
                @if (session('DeleteEvent1Error'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Update ticket
                    </div>
                  </div>
                @endif
<section class="tile">

	<!-- tile header -->
	<div class="tile-header dvd dvd-btm">
		<h1 class="custom-font"><strong>Event List</strong> Table</h1>
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
              <table id="example1" class="table table-custom table-striped dt-responsive">
                <thead>
                <tr>
                  <th>Event Name</th>
                  <!--<th>Description</th>-->
                  <th>Status</th>
                  <th>Created By</th>
                  <th>Create On</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 @if(isset($appdata))
                 	@foreach ($appdata as $data)
                <tr>
                  <td>
                  		@if(isset($data->eventName))
                  			{{ $data->eventName}}
                  		 @endif
                  		</td>
                  <!--<td>
                   @if(isset($data->eventDesc))
					{{ $data->eventDesc}}
                   @endif
                  </td>-->
				      <td>
                   @if(isset($data->eventStatus))
					   @if($data->eventStatus==1)
						<span style="color:green;">Active</span>
						@elseif($data->eventStatus==0)
						<span style="color:red;">In-Active</span>
						@endif
                   @endif
                  </td>
				   <td>
					@if(isset($data->firstName))
					  {{$data->firstName}}
					@else
					  -
                  	@endif
                  </td>
                  <td>
                  	@if(isset($data->creationDate))
                  		{{ $data->creationDate }}
                  	@endif
                  </td>
                  <td>
                  	<?php

						$event_edit_show = $event_delete_show = $service_list_show = "";

						$event_edit_show = session()->get('eventEdit');
						$event_delete_show = session()->get('eventDelete');
						$service_list_show = session()->get('serviceView');

						//echo "eventEdit".$event_edit_show;
						//echo "eventDelete".$event_delete_show;
						//exit;
						$usertype = session()->get('userType');
						//echo $usertype;
						//echo $service_list_show;
					?>
					@if(isset($data->eventId))
						<?php
							if((!empty($usertype)) && ($usertype==1)){
						?>
								<a class="btn btn-rounded-20 btn-default btn-sm bg-primary" style="width:30px;" href="{{asset('/admin/service_list/')}}/@if(isset($data->eventId)){{ $data->eventId}}
									@endif" title="Service List">
									<i class="fa fa-eye" style="margin-left: -2px;"></i>
								</a> &nbsp;&nbsp;
								<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-greensea" style="width:30px;" href="{{asset('/admin/event_edit/')}}/@if(isset($data->eventId))
									{{ $data->eventId}}
									@endif" title="edit">
									<i class="fa fa-pencil"></i>
									<!--?app_id=@if(isset($appid)){{$appid}} @endif-->
								</a> &nbsp;&nbsp;
								<a class="btn btn-rounded-20 btn-default btn-sm mr-5 bg-danger" style="width:30px;" href="{{asset('/admin/delete_event/')}}/@if(isset($data->eventId)){{ $data->eventId}} @endif?app_id=@if(isset($appid)){{$appid}} @endif" title="delete">
									<i class="fa fa-times"></i>
								</a> &nbsp;&nbsp;
						<?php
							}
							else{
						?>

								<?php
									if(!empty($service_list_show)){
								?>
										<a href="{{asset('/admin/service_list/')}}/@if(isset($data->eventId)){{ $data->eventId}}
											@endif" title="Service List">
											<i class="fa fa-user-secret"></i>
										</a> &nbsp;&nbsp;
								<?php
									}
								?>

								<?php
									if(!empty($event_edit_show)){
								?>
										<a href="{{asset('/admin/event_edit/')}}/@if(isset($data->eventId))
											{{ $data->eventId}}
											@endif" title="edit">
											<i class="fa fa-edit"></i>
											<!--?app_id=@if(isset($appid)){{$appid}} @endif-->
										</a> &nbsp;&nbsp;
								<?php
									}
								?>

								<?php
									if(!empty($event_delete_show)){
								?>
										<a href="{{asset('/admin/delete_event/')}}/@if(isset($data->eventId)){{ $data->eventId}} @endif?app_id=@if(isset($appid)){{$appid}} @endif" title="delete">
											<i class="fa fa-remove"></i>
										</a> &nbsp;&nbsp;
								<?php
									}
								?>

						<?php
							}
						?>

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
            <!-- /.box-body -->
          </section>
                </div>
<script language="javascript">

  $(function(){
  	$('#example1').DataTable( {
  		"aaSorting": [[ 3, "desc" ]],
  		"aoColumnDefs" : [{
  		'bSortable' : false,
  			'aTargets' : [ 4 ]
  		}]
  	});
  });


  /*
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
  */
</script>
@endsection



