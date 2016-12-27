<?php
    
        include('header_signup.php');
include ('db_config.php');
    ?>
    <br/>
    <div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">
<?php
if(isset($_POST['submit']) )
{
    $l_Emailid=$_POST['l_Emailid'];
    $array_Email=explode('@',$l_Emailid);
    $l_UR_Emailid = $array_Email[0];
    $l_UR_EmailidDomain = $array_Email[1]; 


$l_query_users='select UR.UR_id from Users as UR where UR.UR_Emailid = "'.$l_UR_Emailid.'" and UR.UR_EmailidDomain = "'.$l_UR_EmailidDomain.'" and UR.Org_id="'.$_SESSION['g_Org_id'].'"';
$l_result_users = mysql_query($l_query_users);
$l_result_users_rowcount=mysql_num_rows($l_result_users);


if(empty($l_UR_Emailid )&&empty($l_UR_EmailidDomain))
{
 $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not typed a email id. Please try again.")
        window.location.href="ForgotPassword01.php"; </script> ';

        print($l_alert_statement );

}
else if($l_result_users_rowcount==0)
{
$l_alert_statement =  ' <script type="text/javascript">
        window.alert("Sorry! The email id entered does not exist! Please try again.")
        window.location.href="ForgotPassword01.php"; </script> ';

        print($l_alert_statement );
}
else
{
  $l_row_Users = mysql_fetch_row($l_result_users);
  $_SESSION['UR_id_temp'] = $l_row_Users[0];

  $l_webMaster                 = 'support@zaireprojects.com';
   $l_random_number = rand(100000,999999);
        $l_random_str = strval( $l_random_number) ;                     ///convert the random number to alfa (string)
        print('<input type=hidden name=l_random_str  value="'. $l_random_str.'">');
        
         $l_message = "<br>Your Verification Code is:".$l_random_str." <br><br>Sincerely, <br>Zaireprojects Support Team";
         $l_subject = "Change Password";
       $l_headers2 = "From: $l_webMaster\r\n";
        $l_headers2 .= "Content-type:  text/html\r\n";
       mail( $l_UR_Emailid.'@'.$l_UR_EmailidDomain, $l_subject, $l_message, $l_headers2);

        
        $_SESSION['g_random_str']             = $l_random_str;
                
      header("Location:ForgotPassword02.php");
}
 }     
 
  print('<br><br><div class="panel panel-primary">');
                        print('<div class="panel-heading" ><h4 style="    text-align: center;
    font-size: 23px;
    padding: 0px;
    margin: 2px 0px;
    font-family: monospace;">Forgot Password</h4></div>');
                      print('<div style=align:center; class="panel-body table-responsive table">'); 
print('<form action="" method="POST">');   
 print('<table>');
    
    print('<tr><td>Email id :<font color=red>*</font></td>   <td><input type=text class="form form-control" style="width:100%" name=l_Emailid></td></tr>');

    print('<tr><td><input type=submit class="btn btn-primary" name=submit value="Send"></td></tr>');


    print('</table>');

print('</form>');
?>

               </div></div></div> </div></div>
<?php include('footer.php')?>  