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
  <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Event List</h3>
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
                  	@if(isset($data->eventId))
					<a href="{{asset('/admin/service_list/')}}/@if(isset($data->eventId)){{ $data->eventId}}
								@endif" title="Service List">
								<i class="fa fa-user-secret"></i>
							</a> &nbsp;&nbsp;
							<a href="{{asset('/admin/event_edit/')}}/@if(isset($data->eventId))
								{{ $data->eventId}}
								@endif" title="edit">
								<i class="fa fa-edit"></i>
								<!--?app_id=@if(isset($appid)){{$appid}} @endif-->
							</a> &nbsp;&nbsp;
								<a href="{{asset('/admin/delete_event/')}}/@if(isset($data->eventId)){{ $data->eventId}} @endif?app_id=@if(isset($appid)){{$appid}} @endif" title="delete">
								<i class="fa fa-remove"></i>
							</a> &nbsp;&nbsp;
							<!--<a href="{{asset('/admin/user_details/')}}/@if(isset($data->appId))
								{{ $data->appId}}
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



