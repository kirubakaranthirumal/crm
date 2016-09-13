<?php
//start session
session_start();

include_once("header.php");

// Include config file and twitter PHP Library by Abraham Williams (abraham@abrah.am)
include_once("config.php");
include_once("inc/twitteroauth.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Login with Twitter using PHP by CodexWorld</title>
    <style type="text/css">
	.wrapper{width:600px; margin-left:auto;margin-right:auto;}
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
</head>
<body>
<?php
	if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified')
	{
		//Retrive variables
		$screen_name 		= $_SESSION['request_vars']['screen_name'];
		$twitter_id			= $_SESSION['request_vars']['user_id'];
		$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
		$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];

		//Show welcome message
		echo '<div class="welcome_txt">Welcome <strong>'.$screen_name.'</strong> (Twitter ID : '.$twitter_id.'). <a href="logout.php?logout">Logout</a>!</div>';
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);

		//If user wants to tweet using form.
		if(isset($_POST["updateme"]))
		{
			//Post text to twitter
			$my_update = $connection->post('statuses/update', array('status' => $_POST["updateme"]));

			//print"<pre>";
			//print_r($my_update);
			//exit;
			die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
		}

		//show tweet form
		echo '<div class="tweet_box">';
		echo '<form method="post" action="index.php"><table width="200" border="0" cellpadding="3">';
		echo '<tr>';
		echo '<td><textarea name="updateme" cols="60" rows="4"></textarea></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><input type="submit" value="Tweet" /></td>';
		echo '</tr></table></form>';
		echo '</div>';

		//Get latest tweets
		$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $screen_name, 'count' => 20));

		echo '<div class="tweet_list"><strong>Latest Tweets : </strong>';
		echo '<ul>';
		foreach ($my_tweets  as $my_tweet) {
			echo '<li>'.$my_tweet->text.' <br />-<i>'.$my_tweet->created_at.'</i></li>';
		}
		echo '</ul></div>';

	}else{
		//Display login button
		echo '<a href="process.php"><img src="images/sign-in-with-twitter.png" width="151" height="24" border="0" /></a>';
	}
?>




<?php
	include_once("footer.php");
?>

</body>
</html>




@include('admin.partials.header')
@include('admin.partials.topbar')
<div class="clearfix"></div>
 <body class="hold-transition skin-blue sidebar-mini">
<div class="page-container">

    @include('admin.partials.sidebar')

      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <!-- <section class="content-header">
      <h1>

                {{ preg_replace('/([a-z0-9])?([A-Z])/','$1 $2',str_replace('Controller','',explode("@",class_basename(app('request')->route()->getAction()['controller']))[0])) }}

      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>-->

    <!-- Main content -->
    <section class="content">
            <div class="row">
                    @if (Session::has('message'))
                        <div class="note note-info">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif

                    @yield('content')
            </div>

    </section>
    <!-- /.content -->
  </div>
</div>

<div class="scroll-to-top"
     style="display: none;">
    <i class="fa fa-arrow-up"></i>
</div>
@include('admin.partials.javascripts')

@yield('javascript')
@include('admin.partials.footer')


