<?php
    include('header_signup.php');
    include ('db_config.php');
    ?>
    <br/>
    <div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">
<?php
    //if the user id whose password change request is set
    if(!isset($_SESSION['UR_id_temp']))
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not entered a valid email id!! Please try again!!")
        window.location.href="ForgotPassword01.php"; </script> ';
        
        print($l_alert_statement );
    }
    //retrieve the random string which is to verify the email id
    $l_random_str         = $_SESSION['g_random_str'];
    
    
    //check if the submit button is checked
    if(isset($_POST['Submit']))
    {
        
        $l_input_number		    =  trim($_POST['l_input_number']);
        $_SESSION['verify_code']=$l_input_number;
         $l_random_str               =  $_POST['l_random_str'];
        
        if ($l_input_number == $l_random_str)  // if the verification passes
        {
            
            header("Location:ChangePassword.php");
            
            
        }
        else
        {
            echo "Your validation code is incorrect. Please verify the email and try again";
        }
    }
    print('<br><br><div class="panel panel-primary">');
                        print('<div class="panel-heading" ><h4 style="    text-align: center;
    font-size: 23px;
    padding: 0px;
    margin: 2px 0px;
    font-family: monospace;">Confirm Email</h4></div>');
                      print('<div style=align:center; class="panel-body table-responsive table">'); 
    print('<form action="" method="POST">');
    print ('<table>');
    print('<th colspan=2>An email with a verification code is sent to you. Please enter the same here to complete the verification</th>');
    print('<tr><td>Verify Code:</td><td><input type="text" class="form form-control" size= 20 name="l_input_number" /><input type="hidden" name="l_random_str" value="' .$l_random_str.'"  /><tr><td  colspan =10><input type=submit class="btn btn-primary" name="Submit" value=Submit></td>');
    print('</tr></table>');
    print('</form>');
    print('</div></div></div>');
    
    
?>
               </div></div></div> 
<?php include('footer.php')?>  