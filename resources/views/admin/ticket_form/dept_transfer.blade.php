@extends('admin.layouts.master')

@section('content')

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Dept Transfer</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="col-md-12">
                    <div class="form-group">
                      <label>Dept</label>
                      <select class="form-control">
                       <option>Select Dept</option>
                        <option>Tech Support</option>
                        <option>Network Support</option>
                      </select>
                    </div>
                        <div class="form-group">
                      <label>Assign Staff</label>
                      <select class="form-control">
                       <option>Select By Staff</option>
                        <option>Johnson</option>
                        <option>Anderson</option>
                        <option>Michale</option>
                      </select>
                    </div>
                      <div class="form-group">
                      <label>Reason for transfers</label>
                             <textarea class="form-control" rows="5" cols="45"></textarea>
                    </div>
                 
                
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Transfer</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                  </div>
                </form>
              </div><!-- /.box -->
              </div>
              </div>
                    
        </section>
@endsection