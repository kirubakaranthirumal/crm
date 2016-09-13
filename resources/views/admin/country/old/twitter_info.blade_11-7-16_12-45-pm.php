@extends('admin.layouts.master')

@section('content')
<style>
#active{
	margin-top:20px;
}
</style>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Twitter</h3>
				</div>
				<div class="box-body">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs tabs-dark">
							<li  class="active"><a href="#inactive" data-toggle="tab">Home</a></li>
							<li><a href="#active" data-toggle="tab">Notification</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane" id="active">
								@foreach($notify_tweet_data as $key => $data)
								<div style="border:0px solid red;float:left;width:100%;">
								<div style="border:0px solid red;float:left;width:5%;">
									&nbsp;
								</div>
								<div style="border:0px solid red;float:left;width:5%;">
									<img src="{!!$data->user->profile_image_url_https!!}">
								</div>
								<div style="border:0px solid red;float:left;width:80%;">
								<ul style="list-style: none;">
									<li>
										<b><a id="modal-message" href="#modal-message{{$key}}" class="" data-toggle="modal">{!!$data->user->name!!}</a></b>

										<div class="modal fade" id="modal-message{{$key}}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
													</div>
													<div class="modal-body">
														@foreach($notify_tweet_data as $key => $inline_data)
														@if($inline_data->user->id == $data->user->id)
														<div style="border:0px solid red;float:left;width:100%;">
															<div style="border:0px solid red;float:left;width:6%;">
																<img src="{!!$data->user->profile_image_url_https!!}">
															</div>
															<div style="border:0px solid red;float:left;width:90%;">
																<ul style="list-style: none;">
																	<li>{!!$inline_data->user->name!!}</li>
																	<!--<li>{!!$data->text!!}</li>-->
																	<li>{!!substr(strstr($inline_data->text," "), 1)!!}</li>
																	<li><?php echo date('d M y  H:i', strtotime($inline_data->created_at)); ?></li>
																</ul>
															</div>
														</div>
														<ul style="list-style: none;">
															<li>&nbsp;</li>
														</ul>
														@endif
														@endforeach
													</div>
												</div>
											</div>
										</div>

									</li>
									<!--<li>{!!$data->text!!}</li>-->
									<li>{!!substr(strstr($data->text," "), 1)!!}</li>
									<li>
									<!--<a id="modal-department" href="#modal-container-department{{$key}}" role="button" class="btn btn-primary modalButton" data-toggle="modal" data-message="" >Reply - {!!$data->user->name!!}</a>-->
									<div style="float:left;width:10%;">
									<a id="modal-department" href="#modal-container-department{{$key}}" role="button" class="modalButton" data-toggle="modal" data-message="">
										<!--<img height="42" width="42" title="reply" src="{{asset("images/reply-action.png")}}" class="img-circle" alt="Reply">-->
										<i class="fa fa-reply" aria-hidden="true"></i>
									</a>
									</div>
									<div style="float:left;width:50%;">
										<?php echo date('d M y  H:i', strtotime($data->created_at)); ?>
									</div>
									<div class="modal fade" id="modal-container-department{{$key}}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
													<h4 class="modal-title" id="myModalLabel">
														Reply
													</h4>
												</div>
												<div class="modal-body">

													{!! Form::open(array('route' => 'admin.social.store', 'id'=>'contentmanage-form{{$key}}', 'class' => 'form')) !!}
														<input type="hidden" name="_token" value="{{ csrf_token() }}">
														<input type="hidden" name="screen_name" id="screen_name" value="{!!$data->user->screen_name!!}">
														<input type="hidden" name="id" id="id" value="{!!$data->id!!}">
														<div class="col-md-12">
															<div class="form-group">
																<textarea name="status" id="status" class="form-control" required></textarea>
															</div>
														</div>
														<div class="box-footer">
															<input type="submit" name="submit" value="Tweet" class="btn btn-primary">
														</div>
													{!! Form::close() !!}
												</div>
											</div>
										</div>
									</div>
									</li>
								</ul>
								</div>
								</div>
								<ul style="list-style: none;">
									<li>&nbsp;</li>
								</ul>
								@endforeach
							</div><!-- /.tab-pane -->
							<div class="active tab-pane" id="inactive">
								{!! Form::open(array('route' => 'admin.social.store', 'class' => 'form')) !!}
									<div class="col-md-12">
										<div class="box box-primary">
											<div class="box-header with-border">
												<h3 class="box-title">Post Tweet</h3>
											</div>
											<div class="box-body">
												<input type="hidden" name="_token" value="{{ csrf_token() }}">
												<input type="hidden" name="screen_name" id="screen_name" value="{!!$user_info->screen_name!!}">
												<input type="hidden" name="id" id="id" value="">

												<div class="col-md-12">
													<div class="form-group">
														<textarea name="status" id="status" class="form-control" cols="10" rows="4" required></textarea>
													</div>
												</div>
												<div class="box-footer">
													<input type="submit" name="submit" value="Post" class="btn btn-primary">
												</div>
											</div>
										</div>
									</div>
								{!! Form::close() !!}
								@foreach($home_tweet_data as $home_key => $home_data)

								<div style="border:0px solid red;float:left;width:100%;">

									<div style="border:0px solid red;float:left;width:3%;">
										&nbsp;
									</div>
									<div style="border:0px solid red;float:left;width:5%;">
										<img src="{!!$home_data->user->profile_image_url_https!!}">
									</div>
									<div style="border:0px solid red;float:left;width:80%;">
										<?php
											//print"<pre>";
											//print_r($home_data);
											//exit;
										?>
										<ul style="list-style: none;">
											<li><b>{!!$home_data->user->name!!}</b></li>
											<li>{!!$home_data->text!!}</li>
											<li><?php echo date('d M y  H:i', strtotime($home_data->created_at)); ?></li>
											<!--<li>{!!substr(strstr($home_data->text," "), 1)!!}</li>-->
										</ul>

									</div>
								</div>
								<ul style="list-style: none;">
									<li>&nbsp;</li>
								</ul>
								<!--<ul style="list-style: none;">
									<li>{!!$home_data->user->name!!}</li>
									<li>{!!$home_data->text!!}</li>
									<li>{!!substr(strstr($home_data->text," "), 1)!!}</li>
								</ul>-->
								@endforeach

							</div><!-- /.tab-pane -->
						</div><!-- /.tab-content -->
					</div><!-- /.nav-tabs-custom -->
				</div>
			</div>
            <!-- /.box-body -->
		</div>
	</div>
@endsection