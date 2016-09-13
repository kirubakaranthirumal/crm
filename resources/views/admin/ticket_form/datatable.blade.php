@extends('admin.layouts.master')

@section('content')

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">DataTable</h3>
                </div><!-- /.box-header -->
                	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
                <script>
                $(document).ready(function() {
    		$('#example').DataTable( {
        		"processing": true,
        		"serverSide": true,
        		"ajax": "server_processing.blade.php"
   			 } );
		} );
                </script>
                <!-- form start -->
                <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>
                
              </div><!-- /.box -->
              </div>
              </div>

        </section>
@endsection


