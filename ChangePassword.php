<?php
    //////////////////////////////////////////////
    // Name :   Changepassword
    // Purpose: Allows the user to change his/her login password
    // Called By: forgotpassword02
    // Calls: login
    //////////////////////////////////////////////
    
    //check if session is on or not
    include('header_signup.php');
   include ('db_config.php');
    ?>
    <br/>
    <div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">
<?php
    //check if the user id whose password is to be changed is set
    if(!isset($_SESSION['UR_id_temp']))
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not entered a valid email id!! Please try again!!")
        window.location.href="ForgotPassword01"; </script> ';
        
        print($l_alert_statement );
    }
    if(!isset($_SESSION['verify_code']))
    {
    $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not entered Verification code !! Please try again!!")
        window.location.href="ForgotPassword02"; </script> ';
        
        print($l_alert_statement );
    }
    //if change password is pressed
    if(isset($_POST['Submit']))
    {
        $l_pass = $_POST['l_UR_Khufiya'];
        $l_cpass = $_POST['l_UR_Khufiya_check'];
        
        //check if the password text fields is empty
        if (empty($l_pass) || empty($l_cpass)) {
            echo "<font color=red>Password is missing.</font>";
        }
        //check if the password and confirm password do not match
        else if ($l_pass != $l_cpass) {
            // error matching passwords
            echo '<font color=red>Your passwords do not match. Please try again!!</font>';
        }
        //check if the password length is >4 and <15
        else if(strlen($l_pass)>15 || strlen($l_pass)<4)
        {
            echo"<font color=red>Password must be between 4 and 15 characters</font>";
        }
        else
        {
            $l_UR_id_temp = $_SESSION['UR_id_temp'];
            
            //update the user password
            $l_update_password_query = 'Update Users set UR_Khufiya ="'.md5($l_pass).'" where Org_id="'.$_SESSION['g_Org_id'].'" and UR_id="'.$l_UR_id_temp.'"';
            mysql_query($l_update_password_query);
            session_destroy();
            header("Location:login.php");
            
        }
    }
	print('<br><br><div class="panel panel-primary">');
                        print('<div class="panel-heading" ><h4 style="    text-align: center;
    font-size: 23px;
    padding: 0px;
    margin: 2px 0px;
    font-family: monospace;">Change Password</h4></div>');
                      print('<div style=align:center; class="panel-body table-responsive table">'); 
    print('<form action="" method="POST">');
    //form to change the password
    print ('<table>');
    print('<tr><td>New Password:</td><td><input type="password" class="form form-control" size= 20 name="l_UR_Khufiya" /></td></tr>');
    print('<tr><td>Confirm Password:</td><td><input type="password" class="form form-control" size= 20 name="l_UR_Khufiya_check" /></td></tr>');
    print('<tr><td  colspan =10><input type=submit  class="btn btn-primary" name="Submit" value="Change Password"</td></tr>');
    print('</table>');
    print('</form>');
?>
               </div></div></div> 
                              </div></div></div> 
<?php include('footer.php')?>  