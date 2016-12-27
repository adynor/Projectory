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
        if( mysql_query("UPDATE Users SET UR_Khufiya='".md5($data['n_pass'])."' WHERE UR_id='".$_SESSION['g_UR_id']."' AND UR_Khufiya='".md5($data['o_pass'])."'"))
         {
            echo "<h4 style='color:green'>!! Sucessfully Changed Your Password</h4>";
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
            <label for="Npassword">New Password<span style="color:red">*</span></label>
            <input type="password" class="form-control" id="" name="n_pass">
        </div
        <div class="form-group">
            <label for="Cpassword">Confirm New Password<span style="color:red">*</span></label>
            <input type="password" class="form-control" id=""name="cn_pass">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control btn btn-primary" name="Save" Value="Save">
        </div>
</form>
</div>
   </div>
    </div>
<?php include('footer.php');?>  