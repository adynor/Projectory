<?php 
session_start();
include ('db_config.php');

 $URid_encode=$_GET['UR_id'];
 $ORGid_encode=$_GET['ORG_id'];
 $OR_URid=base64_decode(str_replace(md5(162).'==','@@',$URid_encode));
 $OR_Orgid=base64_decode(str_replace(md5(162).'==','@@',$ORGid_encode));
 
$timezone = new DateTimeZone("Asia/Kolkata" );
$date = new DateTime();
$date->setTimezone($timezone );
$l_CM_DateTime = $date->format( 'YmdHi' );

$l_query_user_check=mysql_query('select UR.UR_id from  Users as UR where UR.UR_id="'.$OR_URid.'" AND UR.Org_id="'.$OR_Orgid.'"')  or die(mysql_error());
$l_user_rowcount=mysql_num_rows($l_query_user_check);
    if($l_user_rowcount==1){
        
$l_query_user_details=mysql_query('select UR.UR_id,UR.UR_Type,UR.Org_id from  Users as UR where UR.UR_id="'.$OR_URid.'" AND UR.Org_id="'.$OR_Orgid.'" AND UR.UR_RegistrationStatus="C"');
        $l_row_users=mysql_fetch_array($l_query_user_details);
  $_SESSION['g_UR_id']=$l_row_users['UR_id'];
  
  $_SESSION['g_UR_Type']=$l_row_users['UR_Type'];
 
  $_SESSION['g_Org_id']=$l_row_users['Org_id'];
  $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp 
        
        mysql_query('update Users set UR_LastLogin ='.$l_CM_DateTime.' where UR_id="'.$l_row_users['UR_id'].'" AND Org_id="'.$l_row_users['Org_id'].'" ');
 
       if($_SESSION['g_UR_Type']=='S' && $_SESSION['g_PR_id']!=NULL){
            echo "<script> window.location.href = 'SHome.php'</script>";
        }
        else if($_SESSION['g_UR_Type']=='S' && $_SESSION['g_PR_id']==NULL){
            echo '<h3 style="color:red">Apologies!!! Some error occured. Please Try Again </h3>';
        }
        else if($_SESSION['g_UR_Type'] == 'G') {
            //check for Guide
            echo "<script> window.location.href = 'GHome.php'</script>";  
        }
        else if($_SESSION['g_UR_Type'] == 'M') {
            //check for Mentor
            echo "<script> window.location.href = 'MHome.php'</script>";  
        }
        else{
            echo '<h3 style="color:red">Sorry Please Try Again!!!</h3>';
        }
      } else{
            echo '<h3 style="color:red">Sorry Please Try Again!!! </h3>';
      }
            ?>