<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
    Cricket Gateway | CRM


    </title>

    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport"/>
    <meta http-equiv="Content-type"
          content="text/html; charset=utf-8">
          <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
     <link href="{{ asset('/admin-lte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/admin-lte/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="{{ asset('/admin-lte/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
     <link href="{{ asset('/admin-lte/dist/css/skins/skin-blue.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- iCheck -->
    <link href="{{ asset('/admin-lte/plugins/iCheck/flat/blue.css') }}" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="{{ asset('/admin-lte/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="{{ asset('/admin-lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="{{ asset('/admin-lte/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="{{ asset('/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('/admin-lte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>
         <link href="{{ asset('/admin-lte/dist/css/CustomCRM.css') }}" rel="stylesheet" type="text/css" />
</head>
<style>
  thead
  {
   background-color: #337ab7 !important;
   color: #fff !important;
  }
  .nav-tabs-custom>.nav-tabs>li {
   / border-top: 3px solid transparent; /
   border-top:none !important;
   margin-bottom: -2px !important;
   border-right: 2px solid rgba(0, 67, 255, 0.12)!important;
   margin-right: 5px;
  }
  .table-striped>tbody>tr:nth-of-type(odd) {
   background-color: rgba(99, 102, 107, 0.22) !important;
  }
 </style>

 <body class="hold-transition skin-blue sidebar-mini">
<?php
	//print"<pre>";
	//print_r(session::all());
	//exit;
?>