<?php
    //////////////////////////////////////////////
    // Name : CHome01
    // Purpose: main  menu for Company
    // Called By: login
    // Calls: multiple php's
    //////////////////////////////////////////////
    
    
include ('db_config.php');
include ('header.php');
?>
<br><br>
<div class="container" >
       <div class="row" style="padding:20px 0px">
           <div class="col-md-12  ady-row">
               
 <?php 
    
    // select last login date and time
    $l_LastLoginDate_query = 'select  UR_LastLogin from Users where UR_id = "'.$l_UR_id.'" and Org_id = "'.$_SESSION['g_Org_id'].'" ' ;
    $l_LastLoginDate = mysql_query($l_LastLoginDate_query) or die(mysql_error());
    $l_Date=mysql_fetch_row($l_LastLoginDate);
    $l_LoginDate_res=$l_Date[0];
    
    $l_LoginDate_res= date("d-M-Y h:i A", strtotime($l_LoginDate_res));
    
    //display the last login date and time
    print('<div class="alert alert-info"><font color="#4682b4">Last logged in on ' .$l_LoginDate_res. '</font></div>');
 
    
    //session id to local variables
    $l_UR_Name             = $_SESSION['g_UR_Name'];
    
    $l_UR_id = $_SESSION['g_UR_id'];
    $l_UR_Type = $_SESSION['g_UR_Type'];
    
    //Check if the user is loggged in and if is a company type
    if(is_null($l_UR_id) || $l_UR_Type!='C')
    {
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as a company. Please login correctly")
        window.location.href="'.$l_filehomepath.'/login"; </script> ';
        
        print($l_alert_statement );
    }
    
    //show all the options
    print('<table class="ady-row" border ="0">');
    print('<tr><th style="text-align:center">Projectory</th></tr>');
    print('<tr><td><a class="btn btn-primary ady-btn" role="button"  href="CMentorList01.php">View your Mentors</a></td></tr>');
    print('<tr><td><a class="btn btn-primary ady-btn" role="button"  href="CProjList01.php">View your Projects</a></td></tr>');
    print('</table>');

?>
</div></div></div>
<?php include('footer.php')?>