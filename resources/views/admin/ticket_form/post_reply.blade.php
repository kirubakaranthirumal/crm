@extends('admin.layouts.master')

@section('content')

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Post Reply</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="col-md-12">
           
                      <div class="form-group">
                      <label>Description  <span id="required">*</span></label>
                             <textarea class="form-control" rows="5" cols="45"></textarea>
                    </div>
            
                
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Post</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                  </div>
                </form>
              </div><!-- /.box -->
              </div>
              </div>
                    
        </section>
@endsection


