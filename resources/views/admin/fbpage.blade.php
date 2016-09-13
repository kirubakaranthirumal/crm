@extends('admin.layouts.master')
@section('content')
<div class="page page-forms-common">
	<div class="pageheader">
		<h2>Facebook</h2>
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
					<a href="#">Facebook</a>
				</li>
			</ul>
		</div>
		<div style="float: right;margin-top:6px"><a href="{{ URL::previous() }}">Back</a></div>
	</div>
	
	<div class="box-body">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs tabs-dark">
				<li class="active"><a href="#inactive" data-toggle="tab">Cricketgateway</a></li>
				<!--<li><a href="#active" data-toggle="tab">Notification</a></li>-->
			</ul>
			<div class="tab-content">
				{!! Form::open(array('url' => action('FbPageController@addpost'), 'class' => 'form')) !!}
				 <section class="tile">

					<!-- tile header -->
					<div class="tile-header dvd dvd-btm">
						<h1 class="custom-font"><strong>Post</strong></h1>
					</div>
					<div class="tile-body">
						<!--<input type="hidden" value="kumarscst" id="screen_name" name="screen_name">
						<input type="hidden" value="" id="id" name="id">-->
						<div class="col-md-12">
							<div class="form-group">
								<textarea required="" rows="4" cols="10" class="form-control" id="message" name="message"></textarea>
							</div>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-cyan btn-ef btn-ef-3 btn-ef-3c mb-10" value="Post" name="submit">Post<i class="fa fa-paper-plane" aria-hidden="true"></i></button>
						</div>
					</div>
				</section>
				{!! Form::close() !!}
			</div>

			<div class="social-chatbox" style="background-color: #fff; padding: 15px 0;">
			<section class="tile tile-simple no-bg col-md-8">

					<!-- tile body -->
					<div class="tile-body streamline p-0">

					<article class="streamline-post">
				@foreach($fbpage as $key => $fbpost)
				
							<aside>
								<div class="thumb thumb-sm">
									<img src="https://graph.facebook.com/{!!$fbpost->from->id!!}/picture?access_token={!!$access_token!!}">
								</div>
							</aside>
							<div class="post-container">

							<div class="panel panel-default">
								<div class="panel-heading bg-white">
									@if(!empty($fbpost->from->name))
										<strong>{!!$fbpost->from->name!!}</strong>
									@endif
									<span class="text-muted pull-right"><i class="fa fa-clock-o mr-5"></i>
										@if(!empty($fbpost->created_time))
											{!!date("d M Y h:i A",strtotime($fbpost->created_time))!!}
										@endif
									</span>
								</div>

			
							<div class="panel-body">
								@if(!empty($fbpost->message))
									{!!$fbpost->message!!}
								@endif

								@if(!empty($fbpost->picture))
									<img src="{!!$fbpost->picture!!}">
								@endif
								
								 <p class="mt-10 mb-0">
									@if(isset($fblike[$fbpost->id]))
										<i class="fa fa-thumbs-o-up" aria-hidden="true"></i>{!!count($fblike[$fbpost->id]->data)!!} Likes &nbsp; &nbsp;
									@endif
									
									@if(!empty($fbpost->message))
										<a class="btn btn-default btn-xs modalButton" id="modal-comment-link{{$key}} " href="#modal-comment{{$key}}" role="button" data-toggle="modal" data-message="">
											<i class="fa fa-comment-o" aria-hidden="true" title="comment"></i> Comment
										</a>
									@elseif(!empty($fbpost->story))
										&nbsp;
									@endif
									
								</p>
								
							</div>
						</div>
								<div class="modal splash fade" id="modal-comment{{$key}}" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog" style="border:solid;">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												<h4 class="modal-title" id="myModalLabel">
													Reply
												</h4>
											</div>
											<div class="modal-body">
												{!! Form::open(array('route' => 'admin.fbpage.store', 'id'=>'contentmanage-form{{$key}}', 'class' => 'form')) !!}
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="post_id" name="post_id" value="{{$fbpost->id}}">
													<div class="col-md-12">
														<div class="form-group">
															<textarea name="message" id="message" class="form-control" required></textarea>
														</div>
													</div>
													<div class="box-footer">
														<input type="submit" name="submit" value="Comment" class="btn btn-primary">
													</div>
												{!! Form::close() !!}
											</div>
										</div>
									</div>
								</div>									

			
				

				@if(!empty($fbpost->id))
					@if(!empty($fbcomment[$fbpost->id]) && isset($fbcomment[$fbpost->id]->data))
						@foreach($fbcomment[$fbpost->id]->data as $commentVal)
						<ul class="list-unstyled post-replies">
							<li>
								<aside>
									<div class="thumb thumb-sm">
										<img src="https://graph.facebook.com/{!!$commentVal->from->id!!}/picture?access_token={!!$access_token!!}">
									</div>
								</aside>
								
								<div class="reply-container">
									<div class="panel panel-default">
										<div class="panel-body">
											<p>
											<strong>
												@if(!empty($commentVal->from->name))
													<strong>{!!$commentVal->from->name!!}</strong>
												@endif
											</strong>
											<span class="text-muted pull-right"><i class="fa fa-clock-o mr-5"></i>
											<?php
												if(!empty($commentVal->created_time)){
													echo date("d M Y h:i A",strtotime($commentVal->created_time));
												}
											?>
											</span>
											</p>
											<p class="mb-0 text-small">
												@if(!empty($commentVal->message))
													{!!$commentVal->message!!}
												@endif
											</p>
										</div>
									</div>
								</div>
							</li>
						</ul>
						@endforeach
					@endif
				@endif
				</div>

				@endforeach
				</article>

		</div><!-- /.tab-content -->
	</section><!-- /.nav-tabs-custom -->
	<div class="clearfix"></div>
	</div>
	</div>
						

@endsection