@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
			 @if (session('DeleteEvent1Success'))
                <div class="flash-message">
                   <div class="alert alert-success">
                        Event Deleted Successfully
              <!--<script>
              window.setTimeout(function(){
			window.location.href = "{{asset('/admin/event_list/')}}";
               }, 1000);
             </script>-->
                  </div>
                </div>
              @endif
                @if (session('DeleteEvent1Error'))
                  <div class="flash-message">
                     <div class="alert alert-danger">
                      Cannot Delete Event
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
                  <th>Description</th>
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
                  <td>
                   @if(isset($data->eventDesc))
					{{ $data->eventDesc}}
                   @endif
                  </td>
				      <td>
                   @if(isset($data->status))
					   @if($data->status==1)
						<span style="color:green;">Active</span>
						@elseif($data->status==0)
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

						$event_edit_show = $event_delete_show = "";

						$event_edit_show = session()->get('eventEdit');
						$event_delete_show = session()->get('eventDelete');

						//echo "eventEdit".$event_edit_show;
						//echo "eventDelete".$event_delete_show;
						//exit;
					?>
                  	@if(isset($data->eventId))

                  			<?php
								if(!empty($event_edit_show)){
							?>
									<a href="{{asset('/admin/event_edit/')}}/@if(isset($data->eventId))
										{{ $data->eventId}}
										@endif" title="edit">
										<i class="fa fa-edit"></i>
									</a>
							<?php
								}
							?>
							&nbsp;&nbsp;
							<?php
								if(!empty($event_delete_show)){
							?>
								<a href="{{asset('/admin/delete_pevent/')}}/@if(isset($data->eventId)){{ $data->eventId}} @endif" title="delete">
									<i class="fa fa-remove"></i>
								</a> &nbsp;&nbsp;
							<?php
								}
							?>
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



