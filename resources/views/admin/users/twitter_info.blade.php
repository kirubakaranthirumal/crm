@extends('admin.layouts.master')
@section('content')
<div class="page page-forms-common">
	<div class="pageheader">
		<h2>Twitter</h2>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="#"><i class="fa fa-home"></i> CRM</a>
				</li>
				<li>
					<a href="#">Ticket Management</a>
				</li>
				<li>
					<a href="#">Social Media</a>
				</li>
				<li>
					<a href="#">Twitter</a>
				</li>
			</ul>
		</div>
		<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
	</div>

	<section class="tile">
		<div class="box-body">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs tabs-dark">
				  <li class="active"><a href="#active" data-toggle="tab">Home Line</a></li>
				  <li><a href="#inactive" data-toggle="tab">Notification</a></li>
				</ul>
				<div class="tab-content tile-body table-custom">
					<div class="active tab-pane table-responsive" id="active">
						
						{!! Form::open(array('route' => 'admin.social.store', 'class' => 'form')) !!}
						<section class="tile">
							<!-- tile header -->
							<div class="tile-header dvd dvd-btm">
								<h3 class="box-title">Compose New Tweet</h3>
							</div>
							<div class="tile-body">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="screen_name" id="screen_name" value="{!!$user_info->screen_name!!}">
								<input type="hidden" name="id" id="id" value="">
								<div class="col-md-12">
									<div class="form-group">
										<textarea name="status" id="status" class="form-control" cols="10" rows="4" required></textarea>
									</div>
								</div>
								<div class="box-footer">
									<button type="submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" value="Post" name="submit">Tweet<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
									<!-- <input type="submit" name="submit" value="Post" class="btn btn-primary"> -->
								</div>
							</div>
						</section>
						{!! Form::close() !!}
						<hr>
						<div class="social-chatbox" style="background-color: #fff; padding: 15px 0;">
							<section class="tile tile-simple no-bg col-md-8">						
								<div class="tile-body streamline p-0">
									<article class="streamline-post">
									@foreach($home_tweet_data as $home_key => $home_data)
										<aside>
											<div class="thumb thumb-sm">
												<img src="{!!$home_data->user->profile_image_url_https!!}">
											</div>
										</aside>
										<div class="post-container">
											<div class="panel panel-default">
												<div class="panel-heading bg-white">
													<strong>{!!$home_data->user->name!!}</strong>
													<span class="text-muted pull-right"><i class="fa fa-clock-o mr-5"></i>
													<?php echo date('d M y  H:i', strtotime($home_data->created_at)); ?>	
													</span>
												</div>
												<div class="panel-body">
													<p class="mt-10 mb-0">{!!$home_data->text!!}</p>
												</div>
												<ul style="list-style: none;">
													<li>&nbsp;</li>
												</ul>
											</div><!-- /.tab-pane -->
										</div><!-- /.tab-content -->
									@endforeach
										<div class="clearfix"></div>
									</article><!-- /.nav-tabs-custom -->
								</div>
							</section>
							<div class="clearfix"></div>
						</div>						
						
						
					</div>
					<div class="tab-pane" id="inactive">

						<div class="social-chatbox" style="background-color: #fff; padding: 15px 0;">
							<section class="tile tile-simple no-bg col-md-8">
								<div class="tile-body streamline p-0">
									<article class="streamline-post">
									@foreach($notify_tweet_data as $key => $data)
										<aside>
											<div class="thumb thumb-sm">
												<img src="{!!$data->user->profile_image_url_https!!}">
											</div>
										</aside>
										<div class="post-container">
											<div class="panel panel-default">
												<div class="panel-heading bg-white">											
													<strong><a id="modal-history-link{{$key}}" href="#modal-history{{$key}}" class="" data-toggle="modal">{!!$data->user->name!!}</a></strong>
													<span class="text-muted pull-right"><i class="fa fa-clock-o mr-5"></i>
														<?php echo date('d M y  H:i', strtotime($data->created_at)); ?>
													</span>
													<div class="panel-body">
														{!!substr(strstr($data->text," "), 1)!!}
														<p class="mt-10 mb-0">
														<a id="modal-reply-link{{$key}}" href="#modal-reply{{$key}}" role="button" class="modalButton" data-toggle="modal" data-message="">
															<!--<img height="42" width="42" title="reply" src="{{asset("images/reply-action.png")}}" class="img-circle" alt="Reply">-->
															<i class="fa fa-reply" aria-hidden="true"></i> Reply
														</a>
														</p>
													</div>
												</div>
												

											</div>
										</div>
										<ul style="list-style: none;">
											<li>&nbsp;</li>
										</ul>
												<div class="modal splash fade" style="background-color: #000000;opacity: 0.8;" id="modal-history{{$key}}" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
																<h4 class="modal-title" id="myModalLabel">Chat History</h4>
															</div>
															<div class="modal-body">
																{!! Form::open(array('route' => 'admin.social.store', 'class' => 'form')) !!}
																<div class="col-md-12">
																	<div class="box box-primary">
																		<div class="box-header with-border">
																			<h3 class="box-title">Reply</h3>
																		</div>
																		<div class="box-body">
																			<input type="hidden" name="_token" value="{{ csrf_token() }}">
																			<input type="hidden" name="screen_name" id="screen_name" value="{!! $data->user->screen_name!!}">
																			<input type="hidden" name="id" id="id" value="{!!$data->id!!}">
																			<div class="col-md-12">
																				<div class="form-group">
																					<textarea name="status" id="status" class="form-control" cols="10" rows="4" required></textarea>
																				</div>
																			</div>
																			<div class="box-footer">
																				<input type="submit" name="submit" value="Tweet" class="btn btn-primary">
																			</div>
																		</div>
																	</div>
																</div>
																{!! Form::close() !!}
																<div>&nbsp</div>
																@foreach($notify_tweet_data as $inline_data)
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
																@endif
																@endforeach
																<div class="clearfix"></div>
															</div>
														</div>
													</div>
												</div>

												<div class="modal splash fade" style="background-color: #000000;opacity: 0.8;" id="modal-reply{{$key}}" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
																<h4 class="modal-title" id="myModalLabel">Reply</h4>
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
													<div class="clearfix"></div>
												</div>
									@endforeach
									</article><!-- /.tab-pane -->
								</div><!-- /.tab-pane -->
							</section><!-- /.tab-pane -->
							<div class="clearfix"></div>
						</div>					
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection