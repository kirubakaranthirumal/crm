@extends('admin.layouts.master')

@section('content')
    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
			 @if (session('DeleteUserSuccess'))
                <div class="flash-message">
                   <div class="alert alert-success">
						User Deleted Successfully
						<script>
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
                  <h3 class="box-title">Facebook</h3>
                </div><!-- /.box-header -->
           <div class="box-body">

            <!-- /.box-header -->
            <div class="box-body">

            <?php
            	//$face_book_data  = file_get_contents("https://graph.facebook.com/573948779291487/feed?access_token=467434073446625");
				//$face_book_data = json_decode($data, true);

				//print"<pre>";
				//print_r($face_book_data);
            ?>


            <!--<iframe src="https://www.facebook.com/plugins/feedback.php?api_key=484473465030288&channel_url=http%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D42%23cb%3Df674ecb8bb80c%26domain%3Dlocalhost%26origin%3Dhttp%253A%252F%252Flocalhost%253A93%252Ff17e7929523d25c%26relation%3Dparent.parent&href=https%3A%2F%2Fwww.facebook.com%2FRelaxplzz%2Fphotos%2Fa.346737135376622.94281.346727412044261%2F1174405252609802%2F%3Ftype%3D3%26theater&locale=en_US&numposts=2&sdk=joey&version=v2.6&width=600&ret=optin&order_by=time&hash=AQBCFC-hCDqarzvS" width="900" height="900"></iframe>-->

			<!--
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=484473465030288";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<div class="fb-comments" data-href="https://www.facebook.com/Relaxplzz/photos/a.346737135376622.94281.346727412044261/1174405252609802/?type=3&amp;theater" data-width="600" data-numposts="5"></div>
			-->

				<!--<div class="fb-like" data-share="true" data-width="450" data-show-faces="true"></div>
				<script>
				  window.fbAsyncInit = function() {
					FB.init({
					  appId      : '467434073446625',
					  xfbml      : true,
					  version    : 'v2.6'
					});
				  };

				  (function(d, s, id){
					 var js, fjs = d.getElementsByTagName(s)[0];
					 if (d.getElementById(id)) {return;}
					 js = d.createElement(s); js.id = id;
					 js.src = "//connect.facebook.net/en_US/sdk.js";
					 fjs.parentNode.insertBefore(js, fjs);
				   }(document, 'script', 'facebook-jssdk'));
				</script>-->


<!--<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=608576362649569";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="fb-comments" data-href="https://www.facebook.com/kirubakaran.srm?ref=bookmarks" data-width="600" data-numposts="5"></div>-->


				<!--
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=608576362649569";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

				<div class="fb-page" data-href="https://www.facebook.com/fashoinhunt.df/" data-tabs="timeline" data-width="900" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/fashoinhunt.df/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/fashoinhunt.df/">Dealzfactory</a></blockquote></div>-->


				                          <div class="ad"><div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=484473465030288";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

				<div class="fb-page" data-href="https://www.facebook.com/fashoinhunt.df/" data-tabs="timeline" data-width="900" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/fashoinhunt.df/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/fashoinhunt.df/">FashionHunt</a></blockquote></div>  </div>
				                        </center>
				                        </div>



            </div>
            <!-- /.box-body -->
          </div>
                </div>
                  </div>

@endsection


