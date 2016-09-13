@include('admin.partials.header')
<div style="margin-top: 10%;"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Follow On CRM Login</b></div>
                <div class="panel-body">
                   <!-- @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>{{ trans('quickadmin::auth.whoops') }}</strong> {{ trans('quickadmin::auth.some_problems_with_input') }}
                            <br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif-->
                        <div id="login_msg">
                            </div>
                            <?php
                            if (isset($_GET['js_var']))
                                $php_var = $_GET['js_var'];
        else $php_var = "<br />js_var is not set!";

        echo $php_var;
        ?>
        <?php
    if(isset($_POST['loginInputData']) && !empty($_POST['loginInputData'])) {
        echo json_encode(array("status"=>$variable));
    }
?>
                          <form role="form" action="">
        <div class="form-group">

          <label for="exampleInputEmail1">
            Email address
          </label>
          <input type="text" class="form-control" id="login_email" />
        </div>
        <div class="form-group">

          <label for="exampleInputPassword1">
            Password
          </label>
          <input type="password" class="form-control" id="login_password" maxlength="15" />
        </div>
        <center>
        <h5 class="btn btn-success" id="userlogin">Login</h5>
        </center>
        <!--<center>
        <button type="submit" id="userlogin" class="btn btn-default">
          Login
        </button></center>-->
      </form>

                   <!-- <form class="form-horizontal"
                          role="form"
                          method="POST"
                          action="{{ url('login') }}">
                        <input type="hidden"
                               name="_token"
                               value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('quickadmin::auth.login-email') }}</label>

                            <div class="col-md-6">
                                <input type="email"
                                       class="form-control"
                                       name="email"
                                       value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('quickadmin::auth.login-password') }}</label>

                            <div class="col-md-6">
                                <input type="password"
                                       class="form-control"
                                       name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <label>
                                    <input type="checkbox"
                                           name="remember">{{ trans('quickadmin::auth.login-remember_me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit"
                                        class="btn btn-primary"
                                        style="margin-right: 15px;">
                                    {{ trans('quickadmin::auth.login-btnlogin') }}
                                </button>
                            </div>
                        </div>
                    </form>-->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('#userlogin').click(function(){

      var l_email = $('#login_email').val();
    var l_password = $('#login_password').val();

         if(l_email=='' && l_password=='')
    {
       $("#login_msg").html('<h4 id="error_msg">Please fill out the blank fields</h4>');
      return false;

    }
        if(l_email=='')
    {
      $("#login_msg").html('<h4 id="error_msg">Email Address Required</h4>');
      return false;
    }
     if (!validateEmail_l(l_email)) {

              $("#login_msg").html('<h4 id="error_msg">Invalid Email Address</h4>');
      return false;
        }
      if(l_password=='')
      {
        $("#login_msg").html('<h4 id="error_msg">Password Required</h4>');
      return false;
      }

//Function Email
        function validateEmail_l(l_email) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(l_email)) {
      var validateEmailAddress=true;
    return true;
    }
    else {
    return false;
    }
    }
    //Password Function
function checkPassword_l(l_password){
    var pattern = /^[a-zA-Z0-15_-]{5,15}$/;
    if(pattern.test(l_password)){
        return true;
    }else{
        return false;
    }
}
     if(l_email!='' && l_password!='')
    {


    var loginInputData = JSON.stringify({"email":l_email,"password":l_password});

       //alert(loginInputData);

			$.ajax({

				url:'http://192.168.1.15:8080/cgwfollowon/crmlogin',
				//url : "http://192.168.1.95:8180/CricketNew/restservice/login",
				type:"GET",
				/* url:"http://192.168.1.95:8088/DemoSpring/login",*/
				contentType: "application/json; charset=utf-8",
				data:  loginInputData,
				// async: false,
				success : function(response){
					try{
						// $('#login_msg').html('<h4 id="error_msg">Login Failure</h4>');
						console.log(response.status);
					}
					catch(err){
						alert(err.errorMessage);
					}
				},
				error : function(response){
					//$('#login_msg').html('<h4 id="error_msg">Login Failure</h4>');
					$("#login_msg").html('<h4 id="error_msg">Server not found<h4>');
					$('input').val("");
					//$('#login_msg').html('<h4 style="color:red;">Server Not Found</h4>');
					//return false;
				}
			});
			}
		});
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
    <strong>Copyright © 2016 <a href="#">Follow On CRM</a>.</strong> All rights reserved.
    </div>
    </div>
    </div>

