<?php
//echo "<h1 style='color:red; text-align:center;'>The server is under maintenance, please visit again few hours later</h1>";
//exit();
 session_start();
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
     <link rel="shortcut icon" href="assets/images/favicon.ico">
     
     <link rel="shortcut icon" href="https://zaireprojects.com/assets/images/favicon.ico" type="image/x-icon" />
    <title>Zaire Projectory</title>
    
     <link href="assets/css/bootstrap.min.css" rel="stylesheet">
     <link href="assets/css/login.css" rel="stylesheet">
 
 </head>
<body>
<div class="container">
        <div class="card card-container">
       <img id="profile-img" class="profile-img-card" src="assets/images/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
             <?php echo $_SESSION['error']; 
            $_SESSION['error']="";?>
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
                <button class="btn btn-lg btn-primary btn-block btn-signin" name="login" value="logincheck" type="submit">Sign in</button>
            </form><!-- /form -->
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