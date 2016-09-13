@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
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
              window.setTimeout(function(){window.location.href = "{{asset('/admin/event_all_list/')}}";}, 1000);
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
  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">ALL Event List</h3>
                </div><!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
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
                 @if(isset($eventlist))
                 	@foreach ($eventlist as $data)
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
						@elseif($data->eventStatus==2)
						<span style="color:red;">In-Active</span>
						@else
						<span style="color:red;">In-Active</span>
						@endif
                   @endif
                  </td>
				   <td>
				    <?php
				    	//print"<pre>";
				    	//print_r($data);
				    ?>
                  	@if(isset($data->createdBy))
					   @if($data->createdBy==1)
						Admin
						@elseif($data->createdBy==2)
						Yeshwanth
						@else
						 Sam
						@endif
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
							<a href="{{asset('/admin/event_edit/')}}/@if(isset($data->eventId))
								{{ $data->eventId}}
								@endif" title="edit">
								<i class="fa fa-edit"></i>
								<!--?app_id=@if(isset($appid)){{$appid}} @endif-->
							</a> &nbsp;&nbsp;
							<a href="{{asset('/admin/event_delete/')}}/@if(isset($data->eventId)){{ $data->eventId}} @endif" title="delete">
								<i class="fa fa-remove"></i>
							</a> &nbsp;&nbsp;
						<?php
							}
							else{
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
										<a href="{{asset('/admin/event_delete/')}}/@if(isset($data->eventId)){{ $data->eventId}} @endif" title="delete">
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
          </div>
                </div>
                  </div>
<script>
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
</script>
@endsection



