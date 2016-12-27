<?php
    //////////////////////////////////////////////
    // Name            :PAHome
    // Project         :Projectory
    // Purpose         :Dasboad For Project admin
    // Called By       :Login
    // Calls           :PAprojects
    // Mod history:
    //////////////////////////////////////////////
 include ('header.php');
include ('db_config.php'); 
 ?>
<div class="row" style="padding:20px"></div>
<div class="container" >
<?php


$l_UR_id        = $_SESSION['g_UR_id'];  // For the Communications table we need the from id
$l_UR_Type     = $_SESSION['g_UR_Type']; 
//check the user id is empty and the User Type is not PA 
if(is_null($l_UR_id) || $l_UR_Type!='PA')
{
        $l_alert_statement =  ' <script type="text/javascript">
        window.alert("You have not logged in as the Adynor Admin. Please login correctly")
        window.location.href="Signout.php"; </script> ';

        print($l_alert_statement );
}

// For date and time 
//select the last login status of User
$l_LastLoginDate_query = 'select  UR_LastLogin from Users where UR_id = "'.$l_UR_id.'"' ;
$l_LastLoginDate = mysql_query($l_LastLoginDate_query) or die(mysql_error());
$l_Date=mysql_fetch_row($l_LastLoginDate);
$l_LoginDate_res=$l_Date[0];

$l_LoginDate_res= date("d-M-Y h:i A", strtotime($l_LoginDate_res));
//Select the Pending Projects
$queryNewUser='select PR_id FROM Projects where PR_Status="P"';
$result=mysql_query($queryNewUser) or die(mysql_error());
$NewUserCount=mysql_num_rows($result);
?>
   <div class="row alert alert-info" style="font-size: large;     margin-top: 14px;">
    <div class="col-md-5">
    </div>
    <div class="col-md-3"></div>
    <div class="col-md-4 ady-logged-in" >
   logged in at <?php echo $l_LoginDate_res;?>
    </div>
</div> 
 <table class="ady-row" border ="0" >
     <tr><td><a class="btn btn-primary ady-btn" href="PAProjectList.php">Pending Projects(<?php echo $NewUserCount ;?>)</a></td></tr>

</table>
</div>
<?php include('footer.php')?>