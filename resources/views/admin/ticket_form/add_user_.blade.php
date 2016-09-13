@extends('admin.layouts.master')

@section('content')

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Create User</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST" id="user-form" class="form-horizontal" novalidate="novalidate">
                  <div class="box-body">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>First Name <span id="required">*</span></label>
                      <input type="text" class="form-control"  placeholder="First Name">
                    </div>
                    <div class="form-group">
						<label>Password <span id="required">*</span></label>
						<input type="text" class="form-control"  placeholder="Password">
                    </div>
                    <div class="form-group">
						<label>E-Mail <span id="required">*</span></label>
						<input type="text" class="form-control"  placeholder="E-Mail">
                    </div>
					   <div class="form-group">
                      <label>Type <span id="required">*</span></label>
                      <select class="form-control">
                       <option>Select Type</option>
                        <option>Admin</option>
                        <option>Employee</option>
                      </select>
                    </div>
                             <div class="form-group">
            <label>Status </label>
            <!--<select class="form-control">
            <option>Select Status</option>
            <option>Active</option>
            <option>In Active</option>
            </select>
            -->
            <div style="clear:both"></div>
            <input type="radio" value="1" name="status">&nbsp;Active
            &nbsp;
            <input type="radio" value="2" name="status" checked>&nbsp;In Active
          </div>

                        </div>
                    <div class="col-md-6">
                    <div class="form-group">
					  <label>Last Name </label>
					  <input type="text" class="form-control" placeholder="Last Name">
                    </div>
					<div class="form-group">
						<label>Confirm Password <span id="required">*</span></label>
						<input type="text" class="form-control" placeholder="Confirm Password">
                    </div>
                         <div class="form-group">
                      <label>Group <span id="required">*</span></label>
                      <select class="form-control">
                       <option>Select Group</option>
                        <option>Tech Support</option>
                        <option>Network Support</option>
                      </select>
                    </div>
					<div class="form-group">
					  <label>Gender <span id="required">*</span></label>
						<select class="form-control">
						<option>Select Gender</option>
						<option>Male</option>
						<option>Female</option>
					  </select>
                    </div>

                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                 <div style="clear:both">&nbsp;</div>

                  </div>
                </form>
              </div><!-- /.box -->
              </div>
              </div>

        </section>
@endsection


