@extends('admin.layouts.master')

@section('content')

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Create a Ticket</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Requester Name <span id="required">*</span></label>
                      <input type="text" class="form-control"  placeholder="Requester Name">
                    </div>
                    <div class="form-group">
                      <label>Subject <span id="required">*</span></label>
                      <input type="text" class="form-control" placeholder="Subject">
                    </div>
                       <div class="form-group">
                      <label>Type <span id="required">*</span></label>
                      <select class="form-control">
                       <option>Select Type</option>
                        <option>Question</option>
                        <option>Indicent</option>
                        <option>Problem</option>
                        <option>Feature Request</option>
                      </select>
                    </div>
                        <div class="form-group">
                      <label>Ticket source <span id="required">*</span></label>
                              <select class="form-control">
                              <option>Select Source</option>
                        <option>Portal</option>
                        <option>Email</option>
                        <option>Social Media</option>
                        <option>Live Chat</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Category <span id="required">*</span></label>
                              <select class="form-control">
                              <option>Select Category</option>
                        <option>Network Issue</option>
                        <option>Payment</option>
                        <option>Browser</option>
                        <option>Streaming</option>
                      </select>
                    </div>
                        <div class="form-group">
                      <label>Status <span id="required">*</span></label>
                              <select class="form-control">
                              <option>Select Status</option>
                        <option>Open</option>
                        <option>Assigned</option>
                        <option>InProgress</option>
                        <option>Closed</option>
                        <option>Waiting On Customer</option>
                        <option>Waiting On 3rd Party</option>
                      </select>
                    </div>
                        </div>
                    <div class="col-md-6">
                  <div class="form-group">
                      <label>Priority <span id="required">*</span></label>
                              <select class="form-control">
                              <option>Select Priority</option>
                        <option>Low</option>
                        <option>Medium</option>
                        <option>High</option>
                        <option>Urgent</option>
                      </select>
                    </div>
                 <div class="form-group">
                      <label>Group <span id="required">*</span></label>
                              <select class="form-control">
                                   <option>Select Group</option>
                        <option>Techical Support</option>
                        <option>Network Support</option>
                      </select>
                    </div>
                     <div class="form-group">
                      <label>Assign Employee <span id="required">*</span></label>
                              <select class="form-control">
                              <option>Select Employee Name</option>
                        <option>Employee_Name 1</option>
                        <option>Employee_Name 2</option>
                      </select>
                    </div>
                     <div class="form-group">
                      <label>Description <span id="required">*</span></label>
                             <textarea class="form-control" rows="5" cols="45"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Attachment</label>
                      <input type="file" id="exampleInputFile">
                      
                    </div>
                    </div>
                
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit New</button>
                     &nbsp;<button type="button" class="btn btn-primary">Submit Close</button>
                      &nbsp;<button type="reset" class="btn btn-primary">Reset</button>
                  </div>
                 <div style="clear:both">&nbsp;</div>
                    
                  </div>
                </form>
              </div><!-- /.box -->
              </div>
              </div>
                    
        </section>
@endsection


