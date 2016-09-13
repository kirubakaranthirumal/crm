<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Cricket Gateway | CRM</title>
	<link rel="icon" type="image/ico" href="assets/images/favicon.ico" />
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<!-- ============================================
	================= Stylesheets ===================
	============================================= -->
	<!-- vendor css files -->
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/css/vendor/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/css/vendor/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/css/vendor/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/animsition/css/animsition.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/daterangepicker/daterangepicker-bs3.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/morris/morris.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/owl-carousel/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/owl-carousel/owl.theme.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/rickshaw/rickshaw.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/datatables/css/jquery.dataTables.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/datatables/datatables.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/chosen/chosen.css') }}">
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/js/vendor/summernote/summernote.css') }}">
	
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/css/vendor/formValidation.css') }}">
	
	<!-- project main css files -->
	<link rel="stylesheet" href="{{ asset('/admin-lte/assets/css/main.css') }}">
	<!--/ stylesheets -->

	<!-- ==========================================
	================= Modernizr ===================
	=========================================== -->
	<script src="{{ asset('/admin-lte/assets/js/vendor/modernizr/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
	<!--/ modernizr -->

<script>
	$(window).ready(function() {
	$('#loading').hide();

	});
</script>
	</head>
<body id="minovate" class="appWrapper" ng-app="myapp">
<div id="loading" >
	<div style="width:100%; height: 100%; margin:250px auto; text-align:center; top:25%;">
		<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
		<span class="sr-only">Loading...</span>
		<h2>Loading...</h2>
	</div>
</div>
<div id="wrap" class="animsition">
<!--<script type="text/javascript">
	function unload(){
    	alert('close');
		/*
		if(document.getElementById('HdnisSave').value =='0'){
			event.returnValue = "UNSAVED DATA WILL BE LOST!!";
		}
		*/
	}
</script>
<body onbeforeunload="unload()">-->

<!--
<script language="javascript">
	var goingAway = true;
	// assume the worst

	function sayGoodbye(){
	    if(goingAway)alert("Leaving so soon?  Sorry to see you go.");
	}
</script>
<body onunload="sayGoodbye();">
<a href="www.google.com">visit google</a>
<form action="anotherPageOnThisSite.html" onsubmit="goingAway=false; return true;">
	Give me your name: <input name="name">
	<input type=submit value="Log in">
</form>
-->

<script type="text/javascript">
	jQuery(document).ready(function() {
	  var validNavigation = false;

		// Attach the event keypress to exclude the F5 refresh
		$(document).bind('keypress', function(e) {
			if (e.keyCode == 116){
				validNavigation = true;
			}
		});

		// Attach the event click for all links in the page
		$("a").bind("click", function() {
			validNavigation = true;
		});

		// Attach the event submit for all forms in the page
		$("form").bind("submit", function() {
			validNavigation = true;
		});

		// Attach the event click for all inputs in the page
		$("input[type=submit]").bind("click", function(){
			validNavigation = true;
		});

		window.onbeforeunload = function(){
			if(!validNavigation){
				var status = 'abandoned';
				$.ajax({
					type: "POST",
					url: "{{asset('user_logout')}}",
					data: "status=" + status,
					success: function(res) {
					},
				});
			}
		};
	});
</script>

<script type="text/javascript">
    function update(){
    }
    window.unload = update();
</script>