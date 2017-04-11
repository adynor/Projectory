<?php
ob_start();
include('db_config.php');
$l_PR_id=$_GET['prid']; 
$query='SELECT PR_Synopsis_Data,PR_Synopsis_Name FROM Project_Synopsis where PR_id='.$l_PR_id.'';

$gotten = mysql_query($query);

$row =mysql_fetch_row($gotten);

 echo $file  = $row[0];
 $filename = 'Synopsis.pdf';
file_put_contents($filename, $file);
header('Content-type: application/pdf');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Content-Disposition: inline;filename='".$filename."'");
header("Content-length: ".strlen($file));
echo $file;
  
ob_flush();
?>