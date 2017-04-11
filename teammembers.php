<?php
session_start();
include('db_config.php');
$_POST = json_decode(file_get_contents('php://input'), true);

$itid=$_SESSION['g_IT_id'];
$l_TM_id=$_POST['tmid']; 
$l_PR_id=$_POST['prid'];

$l_proj_query = 'select DISTINCT UR.UR_FirstName,PR.PR_Name from Teams as TM,Projects as PR,Users as UR where UR.TM_id = '.$l_TM_id.' and PR.PR_id ='.$l_PR_id.'' ;

$l_proj_res = mysql_query($l_proj_query) or die(mysql_error());
$l_count = mysql_num_rows($l_proj_res);
if($l_count>0)
{ 
$run=mysql_query($l_proj_query);

$data = array();
while ($row = mysql_fetch_assoc($run)) {

$data[] = $row;
    }
}
 print json_encode($data);

?>