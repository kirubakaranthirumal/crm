<?php
	session_start();

	include_once("header.php");
	include_once("topbar.php");
?>
<style type="text/css">
	//.wrapper{width:600px; margin-left:auto;margin-right:auto;}
	.welcome_txt{
		margin: 20px;
		background-color: #EBEBEB;
		padding: 10px;
		border: #D6D6D6 solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_box{
		margin: 20px;
		background-color: #FFF0DD;
		padding: 10px;
		border: #F7CFCF solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_box textarea{
		width: 500px;
		border: #F7CFCF solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_list{
		margin: 20px;
		padding:20px;
		background-color: #E2FFF9;
		border: #CBECCE solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_list ul{
		padding: 0px;
		font-family: verdana;
		font-size: 12px;
		color: #5C5C5C;
	}
	.tweet_list li{
		border-bottom: silver dashed 1px;
		list-style: none;
		padding: 5px;
	}
	</style>
	<div class="clearfix"></div>
		<body class="hold-transition skin-blue sidebar-mini">
			<div class="page-container">
				<?php
					include_once("sidebar.php");
				?>
				<div class="content-wrapper">
				<!-- Main content -->
				<section class="content">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Facebook</h3>
						</div><!-- /.box-header -->
						<div class="box-body"><!-- /.box -->
						<!-- /.box-header -->
						<div class="box-body">

							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) return;
							js = d.createElement(s); js.id = id;
							js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=608576362649569";
							fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="600" data-numposts="5"></div>


						</div>
					</div>

					<div class="row">

					</div>
				</section>
				<!-- /.content -->
			</div>
		</div>
		<div class="scroll-to-top" style="display: none;">
			<i class="fa fa-arrow-up"></i>
		</div>
		<?php
			include_once("javascripts.php");
			include_once("footer.php");
		?>


