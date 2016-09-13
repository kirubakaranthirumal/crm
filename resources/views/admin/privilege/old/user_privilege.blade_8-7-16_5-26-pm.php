@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
           <div class="col-md-12">
  <div class="box">


                <div class="box-header">
                  <h3 class="box-title">Users Privilege</h3>
                </div><!-- /.box-header -->


            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
						<th>Name</th>
                        <th>Email Address</th>
                        <th>Action</th>
                </tr>
                </thead>
                <tbody>
                 @if(isset($userdata))
                 	@foreach ($userdata as $data)
                <tr>
                  <td>
                  		@if(isset($data->firstName))
                  			{{ $data->firstName}}
                  		 @endif
                  		 @if(isset($data->lastName))
						    {{ $data->lastName}}
                  		 @endif
                  		</td>
                  <td>
                   @if(isset($data->email))
					{{ $data->email}}
                   @endif
                  </td>
                  <td>
                  	@if(isset($data->userId))

							<a class="btn btn-success" href="{{asset('/admin/assign_privilege/')}}/@if(isset($data->userId)){{ $data->userId}} @endif" title="Set Privilege">
								Set Privilege
							</a>
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


