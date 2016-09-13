@extends('admin.layouts.master')
@section('content')
	<section class="content">
		<div class="row">
			<!-- left column -->
			<div class="col-md-12">
				@if(session('DeleteUserSuccess'))
					<div class="flash-message">
						<div class="alert alert-success">
							User Deleted Successfully
							<script language="">
								window.setTimeout(function(){window.location.href = "{{asset('/admin/view_user/')}}";}, 1000);
							</script>
						</div>
					</div>
				@endif
				@if (session('DeleteUserError'))
					<div class="flash-message">
						<div class="alert alert-danger">
							Cannot Update ticket
						</div>
					</div>
				@endif
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Twitter</h3>
					</div><!-- /.box-header -->
				<div class="box-body">
				<!-- /.box-header -->
				<div class="box-body">
					<div class="twitter-timeline" href="https://twitter.com/cricketgateway" data-widget-id="590165192777969664">Tweets by @cricketgateway</a>
						<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script> </div>
					</div>
					<!--<script type="text/javascript" id="tcws_15160529">(function(){function async_load(){var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src='http://twittercounter.com/remote/?v=2&twitter_id=15160529&width=180&nr_show=10&hr_color=666666&a_color=709cb2&bg_color=ffffff';x=document.getElementById('tcws_15160529'); x.parentNode.insertBefore(s,x);}if(window.attachEvent){window.attachEvent('onload',async_load);}else{window.addEventListener('load',async_load,false);}})(); </script>
						<noscript><a href="http://twittercounter.com/thecounter">TheCounter on Twitter Counter.com</a></noscript>
					<div id="tcw_15160529"></div>-->


					<!--<div class="twitter-timeline">
						<a class="twitter-timeline" href="https://twitter.com/kirubakarannu">Tweets by kirubakarannu</a>
						<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
					</div>-->

					<!--
					<div class="ad"><div id="fb-root"></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=1419054521739515";
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>
					<div class="fb-page" data-href="https://www.facebook.com/cricketgateway/" data-tabs="timeline" data-width="300" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/cricketgateway/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/cricketgateway/">CricketGateway</a></blockquote></div>
					</div>
					</center>
					</div>
					-->

				</div>
				<!-- /.box-body -->
			</div>
		</div>
	</div>
@endsection


