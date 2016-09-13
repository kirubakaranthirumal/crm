@extends('admin.layouts.master')

@section('content')
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
              <?php
              	/*
              	print"<pre>";
              	print_r($email_template);
              	exit;
              	*/
              ?>
               <i class="fa fa-user" aria-hidden="true"></i> <span><b>Template :</b>
               	@if(isset($email_template['templateId']))
					{{$email_template['templateId']}}
				@endif
               </span>


              </h2>

            </div><!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-6 invoice-col">
              <span><b>Name :</b>

				@if(isset($email_template['templateName']))
					{{$email_template['templateName']}}
				@endif
              						</span><br>
              <span><b>Status :</b>
              						@if(isset($email_template['templateStatus']))
              							@if($email_template['templateStatus']==1)
              								Active
              							@elseif($email_template['templateStatus']==2)
              								In-Active
              							@endif
              						@endif
              </span><br>
              <span><b>Created By :</b>
              	@if(isset($email_template['templateCreatedByFirstName']))
					{{$email_template['templateCreatedByFirstName']}}
              	@endif
              	@if(isset($email_template['templateCreatedByLastName']))
					{{$email_template['templateCreatedByLastName']}}
              	@endif
              </span><br>
              <span><b>Modified By :</b>
              	@if(isset($email_template['templateCreatedByFirstName']))
					{{$email_template['templateCreatedByFirstName']}}
				@endif
				@if(isset($email_template['templateCreatedByLastName']))
					{{$email_template['templateCreatedByLastName']}}
              	@endif
              </span><br>

            </div><!-- /.col -->
    <!-- /.col -->
            <div class="col-sm-6 invoice-col">
              <span><b>Description :</b>
             						@if(isset($email_template['templateDescription']))
			 			        		{{$email_template['templateDescription']}}
              						@endif
              </span><br>
              <span><b>Created On :</b>
              @if(isset($email_template['templateCreatedOn']))
			  	{{$email_template['templateCreatedOn']}}
			  @endif
			  </span><br>
			  <span><b>Modified On :</b>
			                @if(isset($email_template['templateModifiedOn']))
			  			  	{{$email_template['templateModifiedOn']}}
			  			  @endif
			  </span><br>
              <!--<span><b>Modified By :</b> Smith</span><br>-->
            </div><!-- /.col -->
                      </div><!-- /.row -->

                 <br>
          <div class="row">
          <div class="col-sm-8">
          	<!--<a class="btn btn-success" href="{{ url(config('quickadmin.route').'/dept_transfer') }}">Dept Transfer</a>-->
			</div>
          	</div>

          </div>
          </section>


@endsection