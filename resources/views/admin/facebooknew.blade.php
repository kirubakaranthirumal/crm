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
              window.setTimeout(function(){
window.location.href = "{{asset('/admin/view_user/')}}";
               }, 1000);
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


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=608576362649569";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="fb-page" data-href="https://www.facebook.com/Nutech-1554415078197358/" data-tabs="timeline, events, messages" data-width="700" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Nutech-1554415078197358/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Nutech-1554415078197358/">Nutech</a></blockquote></div>

</div>



            </div>
            <!-- /.box-body -->
          </div>
                </div>
                  </div>

@endsection


