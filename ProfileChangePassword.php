<style>
    
    .box-ady{
-webkit-box-shadow: 6px 8px 61px 6px rgba(57,120,143,1);
-moz-box-shadow: 6px 8px 61px 6px rgba(57,120,143,1);
box-shadow: 4px 6px 11px 6px rgba(57,120,143,1);
    }
</style>
<?php 
include('header.php'); 
if(empty($_SESSION['g_UR_id']) || $_SESSION['g_UR_id'] == ""){
   echo"<script> window.location.href='Signout.php'</script>";
}

include('db_config.php');
//include('connect_db.php');
?>
<br><br><br><br><br><br>
<div class="container">
    <div class="col-md-4 col-md-offset-4">
        <div class="box-ady" style="border:1px solid #009688; padding:15px; border-radius:10px;">
<?php
 if(isset($_POST['Save']))
  {
     $data=$_POST;
    $new= $data['n_pass'];
    $old=$data['o_pass'];
     if(empty($data['o_pass']) || empty($data['n_pass']) || empty($data['cn_pass']) )
      {
         echo "<h4 style='color:red'>!! Sorry Please Enter Your Password</h4>";
      }
     else if($data['n_pass'] != $data['cn_pass'])
      {
         echo "<h4 style='color:red'>!! Sorry Your Confirm Password didnt match</h4>";
      }
     else
       {
         $count=  mysql_num_rows(mysql_query("SELECT UR_id FROM Users WHERE UR_id='".$_SESSION['g_UR_id']."' AND UR_Khufiya='".md5($data['o_pass'])."'"));
         if($count==1)
       {
      $upq="UPDATE Users SET UR_Khufiya='".md5($new)."',UR_RegistrationStatus ='C' WHERE UR_id='".$_SESSION['g_UR_id']."' AND UR_Khufiya='".md5($old)."'";
        if( mysql_query( $upq))
         {
       
  echo "<h4 style='color:green'>Your Password has been changed successfully.</h4><div style='color:red'>You'll be automatically redirected to the login page in <span id='count'>3</span> seconds. Please login again with your new password.</div>";
         echo "<script type='text/javascript'>
function countdown() {
    var i = document.getElementById('count');
    if (parseInt(i.innerHTML)==0) {
    
        location.href = 'Signout.php';
    }
    i.innerHTML = parseInt(i.innerHTML)-1;
}
setInterval(function(){ countdown(); },1000);
</script> ";

   
         }
         else{
             echo "<h4 style='color:red'>!! Sorry Please Try Again</h4>";
         }
         
       }
        else
        {
          echo "<h4 style='color:red'>!! Sorry Your Old Password didn't match</h4>";
        }
     }
 }
?>
<form action="" method="POST" >
        <div class="form-group">
              <label for="Cpassword">Old Password<span style="color:red">*</span></label>
               <input type="password" class="form-control" id="" name="o_pass">
        <div class="form-group">
        <p class="help-block"></p>
            <label for="Npassword">New Password<span style="color:red">*</span></label>
            <input type="password" class="form-control" id="user_password" name="n_pass">
        </div
        <div class="form-group">
        <p class="help-block"></p>
            <label for="Cpassword">Confirm New Password<span style="color:red">*</span></label>
            <input type="password" class="form-control" id="user_password_confirm" name="cn_pass">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-primary" name="Save" Value="Save">
        </div>
</form>
</div>
   </div>
    </div>
   <script>
   $( "form" ).submit(function( event ) {
     flag=true;
     $userType=$("#user_type");
     $userName=$("#user_name");
     $userId=$("#user_id");
     $user_email=$("#user_email");
     $user_psw=$("#user_password");
     $user_cpsw=$("#user_password_confirm");
   
   re0 = /[0-9]/;
     re1 = /[a-z]/;
     re2 = /[A-Z]/;
      if($user_psw.val() == "" || $user_psw.val().length < 6 || $user_psw.val().length > 18 || !re0.test($user_psw.val()) || !re1.test($user_psw.val()) || !re2.test($user_psw.val())  ){
    $user_psw.parent().find(".help-block").html('<span style="color:red"> Passwords must contain at least 6 characters maximum 18 characters,including uppercase, lowercase letters and numbers<span>');
         $user_psw.css('border','1px solid red');
         flag=false; 
     }
     else{
         $user_psw.css('border','');
         $user_psw.parent().find(".help-block").html('');
     }
     if(($user_cpsw.val() != $user_psw.val()) || $user_cpsw.val() == ""){
         $user_cpsw.css('border','1px solid red');
         $user_psw.parent().find(".help-block").html('<span style="color:red">Confirm password not matched.<span>');
         flag=false; 
     }
     else{
         $user_cpsw.css('border','');
     }
     if(flag == true){
         return true;
     }
     else{
         return false;
     }
    })
   </script>
<?php include('footer.php');?>  