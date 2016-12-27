<<<<<<< HEAD
<?php session_start();
=======
<?php
//echo "<h1 style='color:red; text-align:center;'>The server is under maintenance, please visit again few hours later</h1>";
//exit();
 session_start();
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
// echo $_COOKIE["user_id"];
  //      echo $_COOKIE["user_psw"];
   //     echo "set";
         ?>
 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <title>Zaire Projectory</title>
     
     <link href="assets/css/bootstrap.min.css" rel="stylesheet">
     <link href="assets/css/login.css" rel="stylesheet">
     
     <!--  fb login begin -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css" />
  <title>jQuery Example</title>
  <script>
    $(document).ready(function() {
      // Execute some code here
    });
    
  </script>
  
  
     <!--  fb login end -->
     
 </head>
 <!--Start of Tawk.to Script-->
<script type="text/javascript">
var $_Tawk_API={},$_Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/576bb4c53c4eb124077f0251/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!--  ending -->
=======
     <link rel="shortcut icon" href="assets/images/favicon.ico">
     
     <link rel="shortcut icon" href="https://zaireprojects.com/assets/images/favicon.ico" type="image/x-icon" />
    <title>Zaire Projectory</title>
    
     <link href="assets/css/bootstrap.min.css" rel="stylesheet">
     <link href="assets/css/login.css" rel="stylesheet">
 
 </head>
<body>
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
<div class="container">
        <div class="card card-container">
       <img id="profile-img" class="profile-img-card" src="assets/images/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
             <?php echo $_SESSION['error']; 
<<<<<<< HEAD
            $_SESSION['error']="";
            
            if($_REQUEST['msg']== true){
            echo '<div class="alert alert-success" style="color: #673AB7;
    background-color: #e2dfed;
    border-color: #acb1dc;">Please login to view the projects</div>';
            }
            ?>
            
=======
            $_SESSION['error']="";?>
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
            <form class="form-signin" method="POST" action="logincheck.php">
                <span id="reauth-email" class="reauth-email"></span>
               
              <div class="form-group has-feedback has-feedback-left">
             <input type="text" name="user_id" id="inputEmail" class="form-control" placeholder="User id / Email" required autofocus>
             <i class="form-control-feedback glyphicon glyphicon-user"></i>
              </div>
               <div class="form-group has-feedback has-feedback-left">    
                <input type="password" name="user_psw" id="inputPassword" class="form-control" placeholder="Password" required >
                <i class="form-control-feedback glyphicon glyphicon-lock"></i>
              </div>

                   <!-- <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" name="remember_me" value="1"> Remember me
                    </label>
                </div>-->
<<<<<<< HEAD
                
                 <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="true"></div>
               
                <button class="btn btn-lg btn-primary btn-block btn-signin" name="login" value="logincheck" type="submit">Sign in</button>
            </form>
            
           
            <!-- /form -->
=======
                <button class="btn btn-lg btn-primary btn-block btn-signin" name="login" value="logincheck" type="submit">Sign in</button>
            </form><!-- /form -->
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
            <a href="ForgotPassword01.php" class="forgot-password">
                Forgot the password?
            </a>
            <button class="btn btn-lg btn-primary btn-block btn-signin" onclick="window.location.href ='signup.php'"  >Sign Up</button>
        </div><!-- /card-container -->
    </div><!-- /container -->
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/login.js"></script>
     </body>
</html>