<?php
include('db_config.php');

if(isset($_REQUEST['psid'])){
   $query='SELECT PS_DocTemplate,PS_Doc_Name,PS_Doc_Size,PS_Doc_Type FROM ProjectDocument_Sequence where PS_id='.$_REQUEST['psid'].' and Org_id="'.$_SESSION['g_Org_id'].'"';
}
else if(isset($_GET['prid']))
    {
    $l_PR_id=$_GET['prid']; 
    $query='SELECT PR_Synopsis_Data,PR_Synopsis_Name,PR_Synopsis_Size,PR_Synopsis_Type FROM Project_Synopsis where PR_id='.$l_PR_id.' and Org_id="'.$_SESSION['g_Org_id'].'"';

    }
else if(isset($_GET['pdid']))
    {
    $l_PD_id=$_GET['pdid']; 
    $query='SELECT PD_Data,PD_Name,PD_Data_Size,PD_Data_Type FROM Project_Documents where PD_id='.$l_PD_id.' and Org_id="'.$_SESSION['g_Org_id'].'"';
    }
<<<<<<< HEAD
else if(isset($_GET['ALid']))
    {
    echo $l_AL_id=$_GET['ALid']; 
    echo $query='SELECT AL_Template,AL_Desc,AL_Templatec_Size,AL_Template_Type FROM Access_Level
 where AL_id='.$l_AL_id.'';
 }
=======
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
    else{      
   echo "<script>window.location.href='".$_SERVER['HTTP_REFERER']."'</script>";
        }
$gotten = mysql_query($query);
$row = mysql_fetch_row($gotten);
<<<<<<< HEAD
//row[1]=$row[1].'.pdf';
=======
>>>>>>> 40f4b6de6733a4252df2a8fc67e6dfbdbf3e99ac
header("Content-disposition: attachment; filename= $row[1]");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Content-length:  $row[2]");
header("Content-type:  $row[3]");
echo $row[0];
?>