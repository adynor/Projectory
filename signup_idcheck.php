<?php 
include ('db_config.php');
if(isset($_GET['UserId'])){
 $user_id=$_GET['UserId'];
 $sql=mysql_query('SELECT UR_id FROM Users WHERE UR_id="'.$user_id.'"');
 } else if(isset($_GET['UserEmail'])){
 $user_Email=$_GET['UserEmail'];
 $array_Email=explode('@',$user_Email);
 $UserEmailid =$array_Email[0];
 $UserEmailidDomain = $array_Email[1];
 $sql=mysql_query("select UR_id from Users where CONCAT(UR_Emailid,UR_EmailidDomain)='".$UserEmailid.$UserEmailidDomain."'");
 }
$count=mysql_num_rows($sql);
$c=array(q=>$count);
echo json_encode($c);
?>